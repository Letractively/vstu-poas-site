<?php
echo anchor('/conferences', 'Страница конференций на сайте');
echo br(2).anchor('/admin/conferences/add', 'Добавить конференцию');
echo br(2);
$data['classes'] = array('','conferences','','','');
$data['rows'] = array();
$data['headers'] = array('id', 'Название', 'Открытие', 'Закрытие', '');
foreach($conferences as $conference)
{
    $tablerow = array();
	$button_delete = anchor('/admin/conferences/delete/' . $conference->id,
        img( '/images/admin/buttons/delete.png'),
            array(	'class' => 'button_delete',
                    'title' => 'Удалить конференцию ' . $conference->name)
        );
    $tablerow[] = $conference->id;
    $tablerow[] = anchor('admin/conferences/edit/' . $conference->id, $conference->name);
    $tablerow[] = $conference->begin;
    $tablerow[] = $conference->end;
    $tablerow[] = $button_delete;

    $data['rows'][] = $tablerow;
}
$this->load->view('admin/table_view', $data);

/* End of file conferences_view.php */
/* Location: ./application/views/admin/conferences_view.php */