<?php
/**
 * @class User_model
 * Модель пользователей.
 * Все пользователи поделены на группы - от гостей до администраторов (смотрите константы группы USER_GROUP)
 */
require_once('super_model.php');
class User_model extends Super_model {

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
							 ->select('id, name_'.lang().' as name, surname_'.lang().' as surname, patronymic_'.lang().' as patronymic')
							 ->get_where(TABLE_USERS, array('id' => $id), 1)
							 ->result();
			if( !$records)
			{
				return FALSE;
			}
            $record[0]->groups = $this->ion_auth->get_users_groups($id);
			return $records[0];
		}

		return $this->db
					->select(TABLE_USERS.'.id, name_'.lang().' as name, surname_'.lang().' as surname, patronymic_'.lang().' as patronymic, group_id')
                    ->from(TABLE_USERS)
                    ->join(TABLE_USERS_GROUPS, TABLE_USERS.'.id = '.TABLE_USERS_GROUPS.'.user_id', 'LEFT')
					->order_by('surname, name_'.lang(),', patronymic')
					->get()
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
		$data = FALSE;
		switch ($page)
		{
			case 'contacts':
				$records = $this->db
                        ->select(   'email,'.
                                    'surname_'.lang().' as surname,'.
                                    'name_'.lang().' as name,'.
                                    'patronymic_'.lang().' as patronymic,'.
                                    'address_'.lang().' as address,'.
                                    'cabinet,'.
                                    'phone,'.
                                    'url,'.
                                    'skype,'.
                                    'rank_'.lang().' as rank,'.
                                    'post_'.lang().' as post'
                                )
                        ->get_where(TABLE_USERS, array('id'=>$id))
                        ->result();
				count($records) == 1 ? $data = $records[0] : FALSE;
                foreach($records as $record)
                {
                    $record->photo = $this->get_photo($id);
                    $record->groups = $this->get_user_groups($id);
                }
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
           case 'cv':
                $records = $this->db->select('cv_'.lang().' as cv')->get_where(TABLE_USERS, array('id'=>$id))->result();
				count($records) == 1 ? $data = $records[0] : FALSE;
				break;
           case 'links':
                $records = $this->db->select('info_'.lang().' as info')->get_where(TABLE_USERS, array('id'=>$id))->result();
				count($records) == 1 ? $data = $records[0] : FALSE;
                break;
           case 'teaching':
                $records = $this->db->select('teaching_'.lang().' as teaching')->get_where(TABLE_USERS, array('id'=>$id))->result();
				count($records) == 1 ? $data = $records[0] : FALSE;
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
                  TABLE_PUBLICATIONS . '.info_ru,'.
                  TABLE_PUBLICATIONS . '.info_en,'.
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
    function get_user_interests($id)
    {
        $data = $this->db->select(TABLE_INTERESTS.'.short, '.TABLE_INTERESTS.'.full')
						 ->from(TABLE_USERS)
						 ->join(TABLE_INTERESTS, TABLE_USERS . '.id = userid')
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
	 * Добавить нового пользователя, используя данные, отправленные методом POST
	 * @return int id - идентификатор добавленого пользователя | FALSE
	 */
	function add_from_post()
	{
        $user = $this->get_from_post();
        $username = $user->username;
        $password = $user->password;
        $email = $user->email;
        unset($user->username);
        unset($user->password);
        unset($user->email);
        $id = $this->ion_auth->register(
                $username,
                $password,
                $email,
                (array)$user,
                array($this->input->post('user_group')));
        if ($id !== FALSE)
        {
            $this->message = 'Запись была успешно внесена в базу данных';
            $this->add_interests_from_post($id);
        }
        else
        {
            $this->message = 'Ошибка! Запись не удалось добавить';
        }
        return $id;
	}

    function add_interests_from_post($id)
    {
        $this->db->delete(TABLE_INTERESTS, array('userid' => $id));
        for($i = 0; $i < 5; $i++)
        {
            $short = $this->input->post('user_interest_short_'.$i);
            $full = $this->input->post('user_interest_full_'.$i);
            $has_short = isset($short) && $short != '';
            $has_full = isset($full) && $full != '';
            if($has_short && $has_full)
            {
                $interest = new stdClass();
                $interest->userid = $id;
                $interest->short = $short;
                $interest->full = $full;
                $this->db->insert(TABLE_INTERESTS, $interest);
            }
        }
    }

    function update_group($id)
    {
        $result = $this->db
                            ->select('id, group_id')
                            ->from(TABLE_USERS_GROUPS)
                            ->where('user_id = ' . $id)
                            ->get()
                            ->result();
        if ($result)
        {
            if($result[0]->group_id != $this->input->post('user_group'))
            {
                if ($this->input->post('user_group') >= 1 && $this->input->post('user_group') <= 3)
                {
                    $record->group_id = $this->input->post('user_group');
                    $this->db->update(TABLE_USERS_GROUPS,$record, array('id' => $result[0]->id));
                }
            }
        }
        else
        {
            if ($this->input->post('user_group') >= 1 && $this->input->post('user_group') <= 3)
            {
                $record->group_id = $this->input->post('user_group');
                $record->user_id = $id;
                $this->db->insert(TABLE_USERS_GROUPS, $record);
            }
        }
    }

	/**
	 * Проверить, есть ли пользователь с данным именем логина в базе данных (занят ли логин)
	 * @param string $username - проверяемое имя логина
	 */
	function is_username_exist($username, $id = null)
	{
        $this->db->from(TABLE_USERS)->where('username', $username);
        return $this->db->count_all_results() > 0;
	}

    /**
     * Получить идентификатор пользователя по логину
     * @param $username логин
     * @return id или -1
     */
    function get_id_by_username($username)
    {
        $records = $this->db
                        ->select('id')
                        ->get_where(TABLE_USERS,array('username' => $username))
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
	 * Удалить пользователя по его идентификатору
     *
     * Удаляет пользователя из проектов, направлений, публикаций.
	 * @param $id - идентификатор удаляемого пользователя
	 */
    function delete($id)
    {
        $result = $this->_delete(TABLE_USERS, $id);
        $message = $this->message;

        $groups = $projects = $this->_delete(TABLE_USERS_GROUPS, $id, 'user_id');
        $projects = $this->_delete(TABLE_PROJECT_MEMBERS, $id, 'userid');
        $directions = $this->_delete(TABLE_DIRECTION_MEMBERS, $id, 'userid');
        $publications = $this->_delete(TABLE_PUBLICATION_AUTHORS, $id, 'userid');
        $interests = $this->_delete(TABLE_INTERESTS, $id, 'userid');
        $this->message = $message;
        //@todo удалять файлы
        return $result && $projects && $directions && $publications && $interests;
    }
    function edit_from_post()
    {
        $user = $this->get_from_post();
        // При редактировании записи создается новый пароль
        // только если пароль изменился
        $record = $this->_get_record($user->id, TABLE_USERS);
        $password = $user->password;
        $this->add_interests_from_post($user->id);
        $this->update_group($user->id);
        unset($user->password);
        $result = $this->_edit(TABLE_USERS, $user);
        // Обновить пароль пользователя, если он был изменен
        if ($record->password != $password)
        {
            $this->force_change_password($user->id, $password);
        }
        $this->message .= '. '.$this->ion_auth->messages();
        return $result;
    }
    function get_user($id){
        $record = $this->db
                            ->select(TABLE_USERS.'.*, '.TABLE_FILES.'.name as photo_name')
                            ->from(TABLE_USERS)
                            ->join(TABLE_FILES, TABLE_USERS.'.photo='.TABLE_FILES.'.id','left')
                            ->where(TABLE_USERS.'.id', $id)
                            ->get()
                            ->result();
		if (!$record)
		{
			return NULL;
		}
        $record[0]->interests = $this->get_user_interests($id);
        $record[0]->groups = $this->get_user_groups($id);
		return $record[0];
    }
    function get_detailed($id)
    {}
    function get_user_groups($id)
    {
        // В нашей системе пользователь может быть только в одной группе
        $result = $this->db
                            ->select('group_id')
                            ->from(TABLE_USERS_GROUPS)
                            ->where('user_id ='.$id)
                            ->get()
                            ->result();
        return $result ? $result[0] : FALSE;
    }
    function get_from_post()
    {
        $fields = array(
            'username'     => 'user_username',
            'password'     => 'user_password',
            'surname_ru' => 'user_surname_ru',
            'name_ru' => 'user_name_ru',
            'patronymic_ru' => 'user_patronymic_ru',
            'surname_en' => 'user_surname_en',
            'name_en' => 'user_name_en',
            'patronymic_en' => 'user_patronymic_en',
            'email' => 'user_email',
            'address_ru' => 'user_address_ru',
            'address_en' => 'user_address_en',
            'cv_ru' => 'user_cv_ru',
            'cv_en' => 'user_cv_en',
            'cabinet' => 'user_cabinet',
            'skype' => 'user_skype',
            'phone' => 'user_phone',
            'url' => 'user_url',
            'rank_ru' => 'user_rank_ru',
            'rank_en' => 'user_rank_en',
            'post_ru' => 'user_post_ru',
            'post_en' => 'user_post_en',
            'info_ru' => 'user_info_ru',
            'info_en' => 'user_info_en',
            'teaching_ru' => 'user_teaching_ru',
            'teaching_en' => 'user_teaching_en',
        );
        $nulled_fields = array(
            'email' => '',
            'address_ru' => '',
            'address_en' => '',
            'cv_ru' => '',
            'cv_en' => '',
            'cabinet' => '',
            'skype' => '',
            'phone' => '',
            'url' => '',
            'rank_ru' => '',
            'rank_en' => '',
            'post_ru' => '',
            'post_en' => '',
            'info_ru' => '',
            'info_en' => '',
            'teaching_ru' => '',
            'teaching_en' => ''
        );
        $result = $this->_get_from_post('user', $fields, $nulled_fields);
        return $result;
    }

    function exists($id)
    {
        return $this->_record_exists(TABLE_USERS, $id);
    }

    function get_photo($id)
    {
        $record = $this->db
                        ->select(TABLE_FILES.'.name as photo_name')
                        ->from(TABLE_USERS)
                        ->join(TABLE_FILES, TABLE_USERS.'.photo='.TABLE_FILES.'.id','left')
                        ->where(TABLE_USERS.'.id', $id)
                        ->get()
                        ->result();
        if (!$record)
            return null;
        return $record[0]->photo_name;
//        if ($user = $this->get_user($id))
//        {
//            return $user->photo_name;
//        }
//        return null;
    }

    public function force_change_password($id, $new)
	{
		$this->ion_auth->trigger_events('pre_change_password');

	    $this->ion_auth->trigger_events('extra_where');

	    $query = $this->db->select('id, password, salt')
			      ->where('id', $id)
			      ->limit(1)
			      ->get(TABLE_USERS);

	    $result = $query->row();

	    $db_password = $result->password;
	    $new	     = $this->ion_auth->hash_password($new, $result->salt);

        //store the new password and reset the remember code so all remembered instances have to re-login
        $data = array(
                'password' => $new,
                'remember_code' => NULL,
                 );

        $this->ion_auth->trigger_events('extra_where');
        $this->db->update(TABLE_USERS, $data, array('id' => $id));

        $return = $this->db->affected_rows() == 1;
        if ($return)
        {
            $this->ion_auth->trigger_events(array('post_change_password', 'post_change_password_successful'));
            $this->ion_auth->set_message('password_change_successful');
        }
        else
        {
            $this->ion_auth->trigger_events(array('post_change_password', 'post_change_password_unsuccessful'));
            $this->ion_auth->set_error('password_change_unsuccessful');
        }
        return $return;
	}

    /**
     * Вернуть массив данных преподавателей для карточки
     * @return массив преподавателей
     */
    function get_staff_cards()
    {
        $users = $this->db
                            ->select('name_'.lang().' as name,'.
                                    'surname_'.lang().' as surname,'.
                                    'patronymic_'.lang().' as patronymic,'.
                                    'rank_'.lang().' as rank,'.
                                    'post_'.lang().' as post,'.
                                    'email,'.
                                    TABLE_USERS.'.id')
                            ->from(TABLE_USERS)
                            ->join(TABLE_USERS_GROUPS, TABLE_USERS.'.id = '.TABLE_USERS_GROUPS.'.user_id')
                            ->where('group_id', ION_USER_LECTURER)
                            ->get()
                            ->result();
        if (!$users)
            return null;
        else
        {
            foreach ($users as $user)
            {
                $interests = $this->get_user_interests($user->id);
                if(is_array($interests))
                {
                    foreach ($interests as $interest)
                    {
                        // на всякий случай, если в базе не достает метки или расшифровки
                        if ($interest->short == '' || $interest->short == null)
                            $interest->short = $interest->full;
                        if ($interest->full == '' || $interest->full == null)
                            $interest->full = $interest->short;
                        $user->interests[$interest->short] = $interest->full;
                    }
                }
                else
                    $user->interests = array();
                $user->photo = $this->get_photo($user->id);
            }
            return $users;
        }

    }
}