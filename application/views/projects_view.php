<?php // Отобразить все проекты?>

<?php 
foreach ($projects as $project)
{
	echo '<b>' . $project->name_ru . '</b>';
	echo br();
	echo $project->description_ru;
	echo br(2);
}
?>

<?php
/* End of file projects_view.php */
/* Location: ./application/views/projects_view.php */