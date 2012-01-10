<?php
if( !isset($error_singup_admin)) $error_singup_admin = "";
?>
<div id="form_login" class="form_login_admin">
	<span id="form_login_title"><?=$this->lang->line('authorizate')?></span>
	<?php

	echo form_label($this->lang->line('login'), 'login_username');
	echo form_input('login');
	echo form_label($this->lang->line('password'), 'login_password');
	echo form_password('password');
	echo anchor('#none', $this->lang->line('send'), array('id' => 'login_send_button'));
	echo '<p id="error_login_admin">'.$error_singup_admin.'</p>';
	?>
</div>

<?php
/* End of file login.php */
/* Location: ./application/views/login_view.php */