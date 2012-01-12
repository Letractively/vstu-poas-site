<?php // Отобразить все направления?>

<?php
echo '<div class="scientific-activity">';
foreach ($directions as $direction)
{
	echo '<div class="direction">';
    // Вывод изображения проекта или его заглушки 'noimage.jpg'
    if (!isset($direction->image) || $direction->image === null)
            $direction->image = NOIMAGE;
    echo div('image').anchor('/about/scientific/directions/'.$direction->id, img($direction->image)).'</div>';

	echo heading(anchor('/about/scientific/directions/'.$direction->id, $direction->name), 3);
    echo $direction->short;
	echo '</div>';
    echo br();
}
echo '</div>';
/* End of file directions_view.php */
/* Location: ./application/views/directions_view.php */