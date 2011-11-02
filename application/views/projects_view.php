<?php // Отобразить все проекты?>

<?php 
foreach ($projects as $project)
{
	echo '<div class="project">';
	echo '<h3>' . anchor($project->url, $project->name, array('class'=>'link')). '</h3>';
	echo $project->description;
	echo '</div>';
	echo br();
}
?>

<?php
/* End of file projects_view.php */
/* Location: ./application/views/projects_view.php */