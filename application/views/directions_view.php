<?php // Отобразить все направления?>

<?php
foreach ($directions as $direction)
{
	echo '<div class="direction">';
	echo heading(anchor('/about/scientific/directions/'.$direction->id, $direction->name), 3);
	echo '</div>';
    echo br();
}
?>

<?php
/* End of file directions_view.php */
/* Location: ./application/views/directions_view.php */