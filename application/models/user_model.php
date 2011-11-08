<?php
/**
 * @class User_model
 * Модель пользователей. 
 * Все пользователи поделены на группы - от гостей до администраторов (смотрите константы группы USER_GROUP)
 */
require_once('super_model.php');
class User_model extends Super_model {
	
	/**
	 * Попытаться залогиниться, используя данные, отправленные методом POST
	 * @return int group - группа пользователя (если залогиниться не удалось, то это USER_GROUP_GUEST)
	 */
	function validate_from_post()
	{
		$this->db->select('group');
		$this->db->where('login', $this->input->post('form_login_username'));
		$this->db->where('password', $this->input->post('form_login_password'));
		$query = $this->db->get('users');
		
		if($query->num_rows != 1)
		{
			return FALSE;
		}
		
		$result = $query->result();
		$user_group = $result[0]->group;
		
		if($user_group)
		{
			$this->load->library('session');
			$data = array(
				'username' => $this->input->post('form_login_username'),
				'group' => $user_group
			);
			$this->session->set_userdata($data);
		}
		return $user_group;
	}	
	
	
	
	/**
	 * Получить основную информацию о всех пользователях (или об одном пользователе)
	 * 
	 * @param [in] $id - id пользователя, необязательный параметр
	 * @return array(int[0..n] => User)|FALSE
	*/
	function get_short($id = null)
	{
        // Родительский метод не годится, он опирается на язык
		if (isset($id))
		{
			$records = $this->db
							 ->select('id, name, surname, patronymic')
							 ->get_where(TABLE_USERS, array('id' => $id), 1)
							 ->result();
			if( !$records)
			{
				return FALSE;
			}
			return $records[0];
		}
	
		return $this->db
					->select('id, name, surname, patronymic')
					->order_by('surname, name, patronymic')
					->get(TABLE_USERS)
					->result();
	}
	
	/**
	 * Получить данные о пользователе из базы для просмотра на сайте
	 * 
	 * @param $id идентификатор пользователя
	 * @param $page страница, для которой требуются данные
	 * @return данные или FALSE
	 */
	function get_user_info($id, $page)
	{		
		//@todo данные из базы
		$data = FALSE;
		switch ($page)
		{
			case 'contacts':
				//@todo FIO, room, phone, email, site, skype
				$records = $this->db->select('email,')->get_where(TABLE_USERS, array('id'=>$id))->result();
				count($records) == 1 ? $data = $records[0] : FALSE;
				break;
            case 'interest':
                $directions = $this->get_user_directions($id);
                if ($directions)
				{
					// выбрать имя для отображения на сайте в зависимости от языка
					$namefield = 'name_' . lang();
					foreach ($directions as $direction)
					{						
						if (isset($direction->$namefield) && $direction->$namefield !== '')
						{
							$direction->name = $direction->$namefield;
						}
						else 
						{
							$direction->name = $direction->name_ru;
						}
						// ни к чему передавать лишние данные
						unset($direction->name_ru);
						unset($direction->name_en);
					}
				}
                $data = $directions;
                break;
            case 'publications':
                $publications = $this->get_user_publications($id);
                if ($publications)
				{
                    $this->load->model(MODEL_PUBLICATION);
					// выбрать имя для отображения на сайте в зависимости от языка
					$namefield = 'name_'.lang();
					foreach ($publications as $publication)
					{
						
						if (isset($publication->$namefield) && $publication->$namefield !== '')
						{
							$publication->name = $publication->$namefield;
						}
						else 
						{
							$publication->name = $publication->name_ru;
						}
						// ни к чему передавать лишние данные
						unset($publication->name_ru);
						unset($publication->name_en);
                        $publication->authors = $this->{MODEL_PUBLICATION}->get_authors($publication->publicationid);
					}
				}
                $data = $publications;
                break;
			case 'projects':
				
				$projects = $this->get_user_projects($id);
				if ($projects)
				{
					// выбрать имя для отображения на сайте в зависимости от языка
					$namefield = 'name_'.lang();
					foreach ($projects as $project)
					{
						
						if (isset($project->$namefield) && $project->$namefield !== '')
						{
							$project->name = $project->$namefield;
						}
						else 
						{
							$project->name = $project->name_ru;
						}
						// ни к чему передавать лишние данные
						unset($project->name_ru);
						unset($project->name_en);
						
						if (isset($project->url) && $project->url == '')
						{
							unset($project->url);
						}
					}
				}
				$data = $projects;
				break;
				
		}
		return $data;
	}
	
    function get_user_publications($id)
    {
        $select = 'publicationid,'.
                  'year,'.
                  'fulltext_ru,'.
                  'fulltext_en,'.
                  'abstract_ru,'.
                  'abstract_en,'.
                  'info_ru,'.
                  'info_en,'.
                  TABLE_PUBLICATIONS . '.name_ru,'.
                  TABLE_PUBLICATIONS . '.name_en';
                   
        $data = $this->db->select($select)
						 ->from(TABLE_USERS)
						 ->join(TABLE_PUBLICATION_AUTHORS, TABLE_USERS . '.id = userid')
 						 ->join(TABLE_PUBLICATIONS, TABLE_PUBLICATIONS. '.id = publicationid')
						 ->where('userid = ' . $id)
						 ->get()
						 ->result();
		return count($data) > 0 ? $data : FALSE; 
    }
    function get_user_directions($id)
    {
        $data = $this->db->select('directionid,' . TABLE_DIRECTIONS . '.name_ru,' . TABLE_DIRECTIONS . '.name_en, ishead')
						 ->from(TABLE_USERS)
						 ->join(TABLE_DIRECTION_MEMBERS, TABLE_USERS . '.id = userid')
 						 ->join(TABLE_DIRECTIONS, TABLE_DIRECTIONS . '.id = directionid')
						 ->where('userid = ' . $id)
						 ->get()
						 ->result();
		return count($data) > 0 ? $data : FALSE; 
    }
	/**
	 * Получить данные о проектах, в которых принимает участие пользователь
	 * @param $id идентификатор пользователя
	 * @return массив проектов или FALSE
	 */
	function get_user_projects($id) 
	{
		$data = $this->db->select('projectid,' . TABLE_PROJECTS . '.name_ru,' . TABLE_PROJECTS . '.name_en,' . TABLE_PROJECTS . '.url')
						 ->from(TABLE_USERS)
						 ->join(TABLE_PROJECT_MEMBERS, TABLE_USERS . '.id = userid')
 						 ->join(TABLE_PROJECTS, TABLE_PROJECTS . '.id = projectid')
						 ->where('userid = ' . $id)
						 ->get()
						 ->result();
		return count($data) > 0 ? $data : FALSE; 
	}
	
	/**
	 * Проверить данные, введенные на форме edit_user_view на корректность
	 * @return массив с ошибками
	 */
	function get_errors() {
        // Не использовать родительский метод
		$errors = null;
        
        // Пароли разные?
		if ($this->input->post('user_password2') !== $this->input->post('user_password'))
			$errors->differentpasswords = TRUE;
        
        $login = $this->input->post('user_login');
        
        if ($this->input->post('user_id'))
        {
            // Если кто-то меняет логин на чужой - атата
            if ($this->input->post('user_login'))
                if ($this->get_id_by_login($login) != $this->input->post('user_id'))
                    $errors->loginused = TRUE;
        }
        else
        {
            // Если кто-то создает запись с существующим логином - атата
            if ($this->input->post('user_login'))
                if ($this->is_login_exist($this->input->post('user_login')))
                    $errors->loginused = TRUE;
        }        
		
        // Пароль не забыли?
        if ($this->input->post('user_password') === '') 
        {
            $errors->passwordforgotten = TRUE;
            unset($errors->differentpasswords);
        }
        
        // А повторно ввести?
        if ($this->input->post('user_password2') === '') 
        {
            $errors->password2forgotten = TRUE;
            unset($errors->differentpasswords);
        }
        
        // Логин
        if ($this->input->post('user_login') === '')
            $errors->loginforgotten = TRUE;
        // Имя
        if ($this->input->post('user_name') === '')
            $errors->nameforgotten = TRUE;
        // Фамилия
        if ($this->input->post('user_surname') === '')
            $errors->surnameforgotten = TRUE;
        // Отчество
        if ($this->input->post('user_patronymic') === '')
            $errors->patronymicforgotten = TRUE;
        
		return $errors;
	}
	
    /**
	 * Добавить нового пользователя, используя данные, отправленные методом POST
	 * @return int id - идентификатор добавленого пользователя | FALSE
	 */
	function add_from_post()
	{
        $user = $this->get_from_post();
        // При создании записи хэшируем пароль
        $user->password = md5($user->password);
        return $this->_add(TABLE_USERS, $user);		
	}
	
	/**
	 * Проверить, есть ли пользователь с данным именем логина в базе данных (занят ли логин) 
	 * @param string $login - проверяемое имя логина
	 */
	function is_login_exist($login, $id = null)
	{
        $this->db->from(TABLE_USERS)->where('login', $login);
        return $this->db->count_all_results() > 0;
	}
    
    /**
     * Получить идентификатор пользователя по логину
     * @param $login логин
     * @return id или -1
     */
    function get_id_by_login($login)
    {
        $records = $this->db
                        ->select('id')
                        ->get_where(TABLE_USERS,array('login' => $login))
                        ->result();
        if ($records)
            return $records[0]->id;
        else
            return '-1';
    }
	
	/**
	 * Проверить, есть ли пользователь с таким адресом почты в базе данных
	 * @param string $email
	 */
	function is_email_exist( $email )
	{
		$this->db->from(TABLE_USERS)->where('email', $email);
		return $this->db->count_all_results();
	}
	
	/**
	 * Определить, к какой группе принадлежит текущий пользователь
	 * @return int - идентификатор группы (см. константы группы USER_GROUP)
	 */
	function logged_group()
	{
		$logged_group = $this->session->userdata('group');
		
		if( !isset($logged_group) ) return FALSE;
		return $logged_group;
	}
	
	/**
	 * @return bool - TRUE, если текущий пользователь принадлежит к группе администраторов
	 */
	function is_admin()
	{
		return $this->logged_group() == USER_GROUP_ADMIN;
	}
	
	/**
	 * Проверить, является ли текущий пользователь администратором.
	 * Если нет - остановить сценарий и открыть страницу с запросом логина и пароля администратора.
	 * 
	 * param [in] Array data - данные для вьювера с запросом логина и пароля администратора
	 */
	function check_admin( $data = NULL )
	{
		if( !$this->is_admin() )
		{
			$data['content'] = $this->load->view('/admin/login_view', $data, TRUE);
			echo $this->load->view('templates/main_view', $data, TRUE);
			//redirect('/');
			die();
		}
		return TRUE;
	}
    
    /**
	 * Удалить пользователя по его идентификатору
     * 
     * Удаляет пользователя из проектов, направлений, публикаций.
	 * @param $id - идентификатор удаляемого пользователя
	 */
    function delete($id)
    {
        $result = $this->_delete(TABLE_USERS, $id);
        $message = $this->message;
        $projects = $this->_delete(TABLE_PROJECT_MEMBERS, $id, 'userid');
        $directions = $this->_delete(TABLE_DIRECTION_MEMBERS, $id, 'userid');
        $publications = $this->_delete(TABLE_PUBLICATION_AUTHORS, $id, 'userid');
        $this->message = $message;
        return $result && $projects && $directions && $publications;
    }
    function edit_from_post() 
    {        
        $user = $this->get_from_post();
        return $this->_edit(TABLE_USERS, $user);
    }
    function get_detailed($id) 
    {
    }
    function get_user($id){
        return $this->_get_record($id, TABLE_USERS);
    }
    function get_from_post() 
    {
        $fields = array(
            'login'     => 'user_login',
            'password'     => 'user_password',
            'surname' => 'user_surname',
            'name' => 'user_name',
            'patronymic' => 'user_patronymic'
        );
        $nulled_fields = array();
        return $this->_get_from_post('user', $fields, $nulled_fields);
    }
}