<?php
echo anchor('/admin/news/add', 'Добавить новость');
echo br(2);

foreach($news as $curr_news)
{
	$button_delete = anchor('/admin/news/delete/'.$curr_news->id,
	img( '/images/admin/buttons/delete.png'), 
		array(	'class' => 'button_delete',
				'title' => 'удалить статью ['.$curr_news->name.']')
	);
	echo anchor('admin/news/edit/'.$curr_news->url, $curr_news->name, array('class' => 'city_short_view')).$button_delete.br();
}

/* End of file articles_view.php */
/* Location: ./application/views/admin/articles_view.php */