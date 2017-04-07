<!-- Top Menu Items -->
<ul class="nav navbar-right top-nav">

	<!--
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i>Alerts<b class="caret"></b></a>
		<ul class="dropdown-menu alert-dropdown">
			<li>
				<a href="#">Alert Name <span class="label label-danger">Alert Badge</span></a>
			</li>
			<li class="divider"></li>
			<li>
				<a href="#">View All</a>
			</li>
		</ul>
	</li>
	
	
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> John Smith <b class="caret"></b></a>
		<ul class="dropdown-menu">
			<li>
				<a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
			</li>
			<li>
				<a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
			</li>
			<li class="divider"></li>
			<li>
				<a href="#"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
			</li>
		</ul>
	</li>
	-->
	
	<!--Determine if Logged In-->
	<?php $l_user = $this->authentication->check_login(1) ?>
	
	<li class="dropdown">
		<?php 
			if($l_user){
				echo '<a href="#">' . $l_user->username . '</a>';		
			}else{
				echo '<a href="' . site_url() . '/' . LOGIN_PAGE . '">Login</a>';
			}
		?>
	</li>
</ul>