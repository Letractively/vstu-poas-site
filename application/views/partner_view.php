<?php
echo '<div class="partner-personal">';

// Вывод названия партнера
echo heading($partner->name, 3);

// Вывод изображения партнера или его заглушки 'noimage.jpg'
    if (!isset($partner->image) || $partner->image === null)
        $partner->image = NOIMAGE;
    echo div('image').anchor('/partners/' . $partner->id, img($partner->image)).'</div>';

// Вывод ссылки на сайт партнера, если есть
if (isset($partner->url))
{
    echo "<a href='$partner->url'>" . $this->lang->line('visit_site') . "</a>";
}
echo br(2);

// Вывод краткой информации о партнере
echo $partner->short;
echo br(2);

// Вывод полной информации о партнере
echo $partner->full;
echo '</div>';
?>