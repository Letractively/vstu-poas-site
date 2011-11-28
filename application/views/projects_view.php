<?php // Отобразить все проекты?>

<?php
foreach ($projects as $project)
{
	echo '<div class="project">';
    //$count = ' (Участвует в проекте:' . $project->memberscount . ')';
	echo heading(anchor('/about/scientific/projects/'.$project->id,$project->name), 3);
	if (isset($project->url))
	{
		// Так не работает на английской версии страницы, перед http:\\ добавляется en
		// echo anchor($project->url, $this->lang->line('visit_site'), array('class'=>'link'));
		echo "<a href='$project->url'>" . $this->lang->line('visit_site') . "</a>";
	}
	echo '</div>';
	echo br();
}
?>

<?php
/* End of file projects_view.php */
/* Location: ./application/views/projects_view.php */