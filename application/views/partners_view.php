<?php
echo div('partners-list');
foreach ($partners as $partner)
{
	echo '<div class="partner">';

    // Вывод изображения партнера или его заглушки 'noimage.jpg'
    if (!isset($partner->image) || $partner->image === null)
        $partner->image = NOIMAGE;
    echo div('image').anchor('/partners/' . $partner->id, img($partner->image)).'</div>';

    echo div('partner-card');
    // Вывод названия партнера-ссылки на его страничку на сайте
	echo anchor('/partners/'.$partner->id, $partner->name).br();

    // Вывод ссылки на сайт партнера, если есть
	if (isset($partner->url))
	{
		echo "<a href='$partner->url'>" . $this->lang->line('visit_site') . "</a>".br();
	}

    echo br();
    // Вывод краткой информации о партнере
    echo $partner->short.br();


    echo '</div>';
	echo '</div>';
	echo br();
}
echo '</div>';
?>