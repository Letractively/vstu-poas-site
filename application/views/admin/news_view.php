<?php
echo anchor('/admin/news/add', 'Добавить новость');
echo br(2);
$data['classes'] = array('news', 'delete');
$data['rows'] = array();
foreach($news as $curr_news)
{
    $tablerow = array();
	$button_delete = anchor('/admin/news/delete/'.$curr_news->id,
	img( '/images/admin/buttons/delete.png'), 
		array(	'class' => 'button_delete',
				'title' => 'удалить статью ['.$curr_news->name.']')
	);
    $tablerow[] = anchor('admin/news/edit/'.$curr_news->url, $curr_news->name);
    $tablerow[] = $button_delete;
    $data['rows'][] = $tablerow;
}
$this->load->view('admin/table_view', $data);
/* End of file articles_view.php */
/* Location: ./application/views/admin/articles_view.php */