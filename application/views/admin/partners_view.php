<?php
echo anchor('/admin/partners/add', 'Добавить партнера');
echo br(2);

foreach($partners as $partner)
{
	$button_delete = anchor('/admin/partners/delete/' . $partner->id,
	img( '/images/admin/buttons/delete.png'),
		array(	'class' => 'button_delete',
				'title' => 'Удалить партнера ' . $partner->name)
	);
	echo anchor('admin/partners/edit/' . $partner->id, 
					$partner->name, 
					array('class' => 'partner_short_view')) . $button_delete.br();
}
