<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div style="border:1px solid red;">
	<p>
		Login Error # <?php $this->authentication->login_errors_count . '/' . config_item('max_allowed_attempts') ?> Invalid Username or Password.
	</p>
	<p>
		Passwords are case sensitive
	</p>
</div>