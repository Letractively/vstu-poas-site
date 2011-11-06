<?php
echo anchor('/admin/publications/add', 'Добавить публикацию');
echo br(2);
foreach($publications as $publication)
{
	$button_delete = anchor('/admin/publications/delete/' . $publication->id,
			img( '/images/admin/buttons/delete.png'),
			array(	'class' => 'button_delete',
					'title' => 'Удалить публикацию ' . $publication->name)
	);
	echo anchor('admin/publications/edit/' . $publication->id,
			$publication->name,
			array('class' => 'publication_short_view')) . $button_delete.br();
}
/* End of file publications_view.php */
/* Location: ./application/views/admin/publications_view.php */
