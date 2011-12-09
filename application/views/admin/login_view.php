<?php
if( !isset($error_singup_admin)) $error_singup_admin = ""; 
?>
<div id="form_login" class="form_login_admin">
	<span id="form_login_title">Войти в панель управления</span>
	<?php

	echo form_input('login_username', 'Логин');
	echo form_password('login_password', 'Пароль');
	echo anchor('#none', "Отправить", array('id' => 'login_send_button'));
	//echo anchor('user/signup', 'Создать профиль'); 
	echo '<p id="error_login_admin">'.$error_singup_admin.'</p>';
	?>
</div>  


<?php
/* End of file login.php */
/* Location: ./application/views/admin/login.php */