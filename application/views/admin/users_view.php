<?php
echo anchor('/admin/users/add', 'Добавить пользователя');
echo br(2);

foreach($users as $user)
{
	$button_delete = anchor('/admin/users/delete/'.$user->id,
	img( '/images/admin/buttons/delete.png'),
		array(	'class' => 'button_delete',
				'title' => 'Удалить пользователя '.$user->username)
	);
	echo anchor('admin/users/edit/'.$user->username, $user->username, array('class' => 'user_short_view')).$button_delete.br();
}

/* End of file cities_view.php */
/* Location: ./application/views/admin/cities_view.php */