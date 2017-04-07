<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div style="border:1px solid red;">
	<p>
		Excessive Login Attempts
	</p>
	<p>
		You have exceeded the maximum number of failed login<br />
		attempts that this website will allow.
	<p>
	<p>
		Your access to login and account recovery has been blocked for <?php echo ( (int) config_item('seconds_on_hold') / 60 ); ?> minutes.
	</p>
	<p>
		Please allow <?php ( (int) config_item('seconds_on_hold') / 60 ) ?> minutes for your account to unlock.<br />
		Contact us if you require assistance gaining access to your account.
	</p>
</div>