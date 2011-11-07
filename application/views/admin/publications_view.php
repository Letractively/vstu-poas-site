<?php
echo anchor('/admin/publications/add', 'Добавить публикацию');
echo br(2);
$data['rows'] = array();
foreach($publications as $publication)
{
    $tablerow = array();
	$button_delete = anchor('/admin/publications/delete/' . $publication->id,
			img( '/images/admin/buttons/delete.png'),
			array(	'class' => 'button_delete',
					'title' => 'Удалить публикацию ' . $publication->name)
	);
    $tablerow[] = anchor('admin/publications/edit/' . $publication->id,$publication->name);
    $tablerow[] = $button_delete;
    $data['rows'][] = $tablerow;
}
$this->load->view('admin/table_view', $data);
/* End of file publications_view.php */
/* Location: ./application/views/admin/publications_view.php */
