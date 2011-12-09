<?php // Отобразить пользователя

echo '<div class="user_profile">';

$pages = array('contacts', 'interest', 'publications', 'cv', 'projects', 'links', 'teaching');
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
        echo '<div>';
        echo $info->surname . ' ';
        echo $info->name . ' ';
        echo $info->patronymic . ' ';
        echo br();
        
        echo $this->lang->line('rank') . '::' .$info->rank.br();
        echo $this->lang->line('post') . '::' .$info->post.br();
        echo $this->lang->line('address') . '::' .$info->address.br();
        echo $this->lang->line('cabinet') . '::' .$info->cabinet.br();
        echo $this->lang->line('phone') . '::' .$info->phone.br();
        echo $this->lang->line('user_url') . '::' .$info->url.br();
        echo $this->lang->line('email') . '::' .'<a href="mailto:'.$info->email.'">'.$info->email.'</a>';
        echo '</div>';
		break;
    case 'interest':
        if ($info)
        {
            foreach ($info as $direction) 
            {
                echo anchor('/directions/' . $direction->directionid, $direction->name);
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
				echo anchor('/projects/' . $project->projectid, $project->name);
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
			echo $info->cv;
		}
        break;
}
echo '</div>';
?>

<?php
/* End of file user_view.php */
/* Location: ./application/views/user_view.php */