<?php // Отобразить пользователя

echo '<div class="user_profile">';

$pages = array('contacts', 'interest', 'publications', 'cv', 'projects', 'links', 'teaching');
foreach($pages as $page)
{
	echo anchor('/users/' . $id . '/' . $page, $this->lang->line($page));
	if ($page !== 'teaching')
		echo ' :: ';
}
echo br(2);
echo $content;
echo '</div>';
?>

<?php
/* End of file user_view.php */
/* Location: ./application/views/user_view.php */