<?php // Отобразить пользователя

function get_value($value, $default)
{
    if($value == '' || $value == null || !isset($value))
        return $default;
    return $value;
}
echo '<div class="user_profile">';

$pages = array('contacts', 'cv', 'interest', 'publications', 'projects', 'links', 'teaching');
foreach($pages as $pagename)
{
	echo anchor('/users/' . $id . '/' . $pagename, $this->lang->line($pagename));
	if ($pagename !== 'teaching')
		echo ' :: ';
}
echo br(2);
switch($page)
{
	case 'contacts':
        echo '<div class="photo">';
        if ($info->photo == null || !isset($info->photo) || $info->photo == '')
                $info->photo = NOPHOTO;
        echo '<img src="'.$this->config->item('base_url').$info->photo.'">';
        echo '</div>';
        echo '<div class="contacts">';
        echo '<div class="fio">';
        echo $info->surname . ' ';
        echo $info->name . ' ';
        echo $info->patronymic . ' ';
        echo '</div>';

        if ($info->groups->group_id == ION_USER_LECTURER)
        {
            echo span($this->lang->line('rank'), 'field') . '::' .get_value($info->rank,'---').br();
            echo span($this->lang->line('post'), 'field') . '::' .get_value($info->post,'---').br();
        }
        echo span($this->lang->line('address'), 'field') . '::' .get_value($info->address,'---').br();
        echo span($this->lang->line('cabinet'), 'field') . '::' .get_value($info->cabinet,'---').br();
        echo span($this->lang->line('phone'), 'field') . '::' .get_value($info->phone,'---').br();
        echo span('Skype', 'field') . '::' .get_value($info->skype,'---').br();
        if (isset($info->url))
            echo span($this->lang->line('user_url'), 'field') . '::' .'<a href="' .$info->url.'">'.$info->url.'</a>'.br();
        else
            echo span($this->lang->line('user_url'), 'field') . '::' . '---'.br();
        if (isset($info->email))
            echo span($this->lang->line('email'), 'field') . '::' .'<a href="mailto:'.$info->email.'">'.$info->email.'</a>';
        else
            echo span($this->lang->line('email'), 'field') . '::' . '---'.br();
        echo '</div>';
		break;
    case 'interest':
        if ($info)
        {
            foreach ($info as $direction)
            {
                echo anchor('/about/scientific/directions/' . $direction->directionid, $direction->name);
                if ($direction->ishead)
                {
                    echo ' (' . $this->lang->line('ishead') . ')';
                }
                echo br(2);
            }
        }
        break;
    case 'publications':
        if ($info)
        {
            echo '<ol class="publications">';
            foreach($info as $publication)
            {
                echo '<li>';
                $data['publication'] = $publication;
                $this->load->view('publication_view', $data);
                echo '</li>'.br();
            }
            echo '</ol>';
        }
        break;
	case 'projects':
		if ($info)
		{
			foreach ($info as $project)
			{
				echo anchor('/about/scientific/projects/' . $project->projectid, $project->name);
				// anchor и внешние ссылки
				if (isset($project->url))
				{
					echo ' <a href = "' . $project->url . '">'.$this->lang->line('visit_site').'</a>';
				}
				echo br(2);
			}
		}
		break;
    case 'cv':
        if ($info)
		{
			echo '<div class="cv">'.$info->cv.'</div>';
		}
        break;
    case 'links':
        if ($info)
		{
			echo $info->info;
		}
        break;
    case 'teaching':
        if ($info)
		{
			echo $info->teaching;
		}
        break;
}
echo '</div>';
?>

<?php
/* End of file user_view.php */
/* Location: ./application/views/user_view.php */