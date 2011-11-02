<?php // Отобразить проект?>

<?php
echo '<div class="project">';
echo heading($project->name, 3);
// Так не работает на английской версии страницы, перед http:\\ добавляется en
// echo anchor($project->url, $this->lang->line('visit_site'), array('class'=>'link'));
echo "<a href='$project->url' class='link'>" . $this->lang->line('visit_site') . "</a>";
echo br(2);
echo $project->description;
echo '</div>';
?>

<?php
/* End of file project_view.php */
/* Location: ./application/views/project_view.php */