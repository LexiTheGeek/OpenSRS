<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php echo form_open( $login_url, ['class' => 'std-form'] ); ?>
	<div>

		<label for="login_string" class="form_label">Username:</label>
		<input type="text" name="login_string" id="login_string" class="form_input" autocomplete="off" maxlength="255" />

		<br />

		<label for="login_pass" class="form_label">Password:</label>
		<input type="password" name="login_pass" id="login_pass" class="form_input password" autocomplete="off" readonly="readonly" onfocus="this.removeAttribute('readonly');" <?php if( config_item('max_chars_for_password') > 0 ) echo 'maxlength="' . config_item('max_chars_for_password') . '"';  ?>  />

		<br>
		<input type="submit" name="submit" value="Login" id="submit_button"  />

	</div>
</form>



