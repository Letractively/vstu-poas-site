<?php // Отобразить проект?>

<?php
echo '<div class="project">';
echo heading($project->name, 3);
if (isset($project->image))
{
    echo br().img($project->image).br();
}
if (isset($project->url))
{
    // Так не работает на английской версии страницы, перед http:\\ добавляется en
    // echo anchor($project->url, $this->lang->line('visit_site'), array('class'=>'link'));
    echo "<a href='$project->url'>" . $this->lang->line('visit_site') . "</a>";
}
echo br(2);
echo $project->short;
echo br(2);
echo $project->full;
echo br(2);

if (count($members) > 0)
{
	echo heading($this->lang->line('project_members'), 3);
	foreach($members as $member)
	{
		echo anchor('/users/'.$member->id, $member->name . ' '. $member->surname).br();
	}
}
echo '</div>';


/* End of file project_view.php */
/* Location: ./application/views/project_view.php */