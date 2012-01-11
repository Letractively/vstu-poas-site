<?php // Форма регистрации, нигде не используется ?>
<div id="form_login" class="with_fieldset">
	<span id="form_login_title">Создание нового аккаунта</span>
	<fieldset>
		<legend>Персональная информация</legend>
		<?php
		echo form_open('user/ajax_create');
		echo form_input('login_first_name', set_value('login_first_name', 'Имя'));
		echo form_input('login_last_name', set_value('login_last_name', 'Фамилия'));
		echo form_input('login_email', set_value('login_email', 'Электронная почта'));
		?>
	</fieldset>
	<fieldset>
		<legend>Информация о профиле</legend>
		<?php 
		echo form_input('login_username', set_value('login_username', 'Логин'));
		echo form_password('login_password', 'Пароль');
		echo form_password('login_password_confirm', 'Пароль');
		//echo form_submit('login_submit', 'Отправить');
		echo anchor_js('#', "Отправить", array('id' => 'singup_send_button'));
		
		echo '<p id="error_singup" class="error"></p>';
		?>
	</fieldset>
</div>