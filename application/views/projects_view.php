<?php // Отобразить все проекты?>

<div class="scientific-activity">
<?php
foreach ($projects as $project)
{
	echo '<div class="project">';

    // Вывод изображения проекта или его заглушки 'noimage.jpg'
    if (!isset($project->image) || $project->image === null)
            $project->image = NOIMAGE;
    echo div('image').anchor('/about/scientific/projects/'.$project->id, img($project->image)).'</div>';

    // Вывод названия проекта-ссылки на его страничку на сайте
	echo anchor('/about/scientific/projects/'.$project->id, $project->name);

    // Вывод краткого описания проекта
    echo br(2).$project->short;

    // Вывод ссылки на сайт проекта, если есть
	if (isset($project->url))
	{

		echo br(2)."<a href='$project->url'>" . $this->lang->line('visit_site') . "</a>";
	}
	echo '</div>';
	echo br();
}
?>
</div>
<?php
/* End of file projects_view.php */
/* Location: ./application/views/projects_view.php */