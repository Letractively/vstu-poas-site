<?php // Форма авторизации
if( !isset($error_login)) $error_login = ""; 
?>
<div id="form_login" class="form_login">
	<span id="form_login_title">Войти</span>
	<?php
	echo form_input('login_username', 'Логин');
	echo form_password('login_password', 'Пароль');
	echo anchor('#', "Отправить", array('id' => 'login_send_button'));
	echo anchor('/user/signup', 'Создать профиль');
	echo '<p id="error_login" ></p>';
	echo '<p id="error_login" class="error">'.$error_login.'</p>'; 
	?>
</div>  