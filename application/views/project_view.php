<?php // Отобразить проект?>

<?php
echo '<div class="project">';
echo heading($project->name, 3);
if (isset($project->url))
	{
		// Так не работает на английской версии страницы, перед http:\\ добавляется en
		// echo anchor($project->url, $this->lang->line('visit_site'), array('class'=>'link'));
		echo "<a href='$project->url'>" . $this->lang->line('visit_site') . "</a>";
	}
echo br(2);
echo $project->description;
echo br(2);

if (count($members) > 0) 
{
	echo heading($this->lang->line('project_members'), 3);
	foreach($members as $member)
	{
		echo anchor('/users/'.$member->id, $member->first_name . ' '. $member->last_name).br();
	}
}
echo '</div>';
?>

<?php
/* End of file project_view.php */
/* Location: ./application/views/project_view.php */