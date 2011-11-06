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
		// echo fio
		// echo room
		// echo phone
		
		//todo подумаль, надо ли видеть это гостю
		
		// снова anchor
		//if (isset($user->email)) echo anchor('mailto:'.$user->email, $user->email);

		if (isset($info->email))
		{
			echo $this->lang->line('email') 
				 . ' :: <a href="mailto:' 
			 	 . $info->email 
				 . '">' 
				 . $info->email 
				 . '</a>';
		}
		
		// echo site
		// echo skype
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
            foreach($info as $publication)
            {
                $data['publication'] = $publication;
                $this->load->view('publication_view', $data);
            }
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
}
echo '</div>';
?>

<?php
/* End of file user_view.php */
/* Location: ./application/views/user_view.php */