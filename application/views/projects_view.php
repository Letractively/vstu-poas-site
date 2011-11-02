<?php // Отобразить все проекты?>

<?php 
foreach ($projects as $project)
{
	echo '<div class="project">';
	echo heading($project->name, 3);
	// Так не работает на английской версии страницы, перед http:\\ добавляется en
	// echo anchor($project->url, $this->lang->line('visit_site'), array('class'=>'link'));
	echo "<a href='$project->url' class='link'>" . $this->lang->line('visit_site') . "</a>";
	echo br();
	echo $project->description;
	echo '</div>';
	echo br();
}
?>

<?php
/* End of file projects_view.php */
/* Location: ./application/views/projects_view.php */