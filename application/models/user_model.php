<?php
/**
 * @class User_model
 * Модель пользователей. 
 * Все пользователи поделены на группы - от гостей до администраторов (смотрите константы группы USER_GROUP)
 */

class User_model extends CI_Model {
	
	/**
	 * Попытаться залогиниться, используя данные, отправленные методом POST
	 * @return int group - группа пользователя (если залогиниться не удалось, то это USER_GROUP_GUEST)
	 */
	function validate_from_post()
	{
		$this->db->select('group');
		$this->db->where('username', $this->input->post('form_login_username'));
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
	 * Получить только username'ы, id групп, и идентификаторы пользователей (потребляет меньше ресурсов, чем простая функция {@link get()})
	 * @param [in] $id - id пользователя, необязательный параметр
	 * @return array(int[0..n] => User)|FALSE
	*/
	function get_short($id = null)
	{
		if( isset($id) )
		{
			$users = $this->db->select('id, username, group')->get_where(TABLE_USERS, array('id' => $id), 1)->result();
			if( ! $users)
			{
				return FALSE;
			}
			return $users[0];
		}
		
		return $this->db->select('id, username, group')->order_by('username')->get(TABLE_USERS)->result();
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
	function get_errors_add() {
		$errors = array();
		if ($this->input->post('user_password2') !== $this->input->post('user_password'))
		{
			$errors['passwordmessage'] = 'Введенные пароли не совпадают';
		}
		if ($this->is_username_exist($this->input->post('user_login')))
		{
			$errors['loginmessage'] = 'Данный логин уже используется';
		}
		// @todo обязательность заполнения всех полей
		return $errors;
	}
	/**
	 * Добавить нового пользователя, используя данные, отправленные методом POST
	 * @return int id - идентификатор добавленого пользователя | FALSE
	 */
	function add_from_post()
	{
		$data = array();
		$user = array(
			'username' => $this->input->post('user_login'),
			'password' => md5($this->input->post('user_password')),
			'email' => $this->input->post('user_email'),
			'first_name' => $this->input->post('user_name'),
			'last_name' => $this->input->post('user_surname'),
			'group' => USER_GROUP_GENERAL
		);
		
		if($this->db->insert('users', $user))
		{
			return $this->db->insert_id();
		}
		else
		{
			return FALSE;
		}
	}
	
	/**
	 * Удалить пользователя по его идентификатору
	 * @param $id - идентификатор удаляемого пользователя
	 */
	function delete_user($id) 
	{
		return $this->db->delete('users', array('id' => $id));	
	}
	
	/**
	 * Проверить, есть ли пользователь с данным именем логина в базе данных (занят ли логин) 
	 * @param string $username - проверяемое имя логина
	 */
	function is_username_exist( $username )
	{
		$this->db->from(TABLE_USERS)->where('username', $username);
		return $this->db->count_all_results() > 0;
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
}