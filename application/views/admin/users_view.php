<?php
echo anchor('/admin/users/add', 'Добавить пользователя');
echo br(2);
$data['rows'] = array();
$data['classes'] = array('users', '');
foreach($users as $user)
{
    $tablerow = array();
	$button_delete = anchor('/admin/users/delete/'.$user->id,
	img( '/images/admin/buttons/delete.png'),
		array(	'class' => 'button_delete',
				'title' => 'Удалить пользователя '.$user->username)
	);
    $tablerow[] = anchor('admin/users/edit/'.$user->username, $user->username);
    $tablerow[] = $button_delete;
    $data['rows'][] = $tablerow;
}
$this->load->view('admin/table_view', $data);
/* End of file cities_view.php */
/* Location: ./application/views/admin/cities_view.php */