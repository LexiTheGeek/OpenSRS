<!DOCTYPE html>
<html lang="en">
  <head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
	<!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<!--Import Meta From Config Files-->
	<?php echo $this->template->meta; ?>

	<!-------------------------------------------------------------------------------------------------------------->
	
	<!--Import Title From Config-->
    <title><?php echo $this->template->title ?></title>
	
	<!-------------------------------------------------------------------------------------------------------------->

    <!-- Bootstrap -->
    <link href="<?php echo asset_url() . 'vendors/bootstrap/dist/css/bootstrap.min.css'; ?>" rel="stylesheet">
    
	<!-- Font Awesome -->
    <link href="<?php echo asset_url() . 'vendors/font-awesome/css/font-awesome.min.css'; ?>" rel="stylesheet">
    
	<!-- Custom Theme Style -->
    <link href="<?php echo asset_url() . 'gentallela/css/custom/custom.css'; ?>" rel="stylesheet">
	
	<!--Import Page-Specific Styles From Config-->
	<?php echo $this->template->stylesheet; ?>
	
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.html" class="site_title"><i class="<?php echo $this->template->site_icon_class; ?>"></i> <span><?php echo $this->template->site_header; ?></span></a>
            </div>

            <div class="clearfix"></div>

			<!---User Profile - Quick Access--->
            <?php echo $this->template->widget("user_profile", 'gentallela'); ?>

            <br />
			
			 <!-- sidebar menu -->
			<?php echo $this->template->widget("side_nav", 'gentallela'); ?>

          </div>
        </div>

        <!-- top navigation -->
        <?php echo $this->template->widget("top_nav", 'gentallela'); ?>

        <!-- page content -->
        <div class="right_col" role="main">
			<!---Display Page Content--->
			<?php echo $this->template->content;?>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

	<!--------------------------------------------------------------------------------------------------------------->
	
    <!-- jQuery -->
    <script src="<?php echo asset_url(); ?>vendors/jquery/dist/jquery.min.js"></script>
    
	<!-- Bootstrap -->
    <script src="<?php echo asset_url(); ?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    
	<!-- FastClick -->
    <script src="<?php echo asset_url(); ?>vendors/fastclick/lib/fastclick.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?php echo asset_url(); ?>gentallela/js/custom/custom.min.js"></script>

	<!--Import Page-Specific Scripts From Config-->
	<?php echo $this->template->javascript; ?>


  </body>
</html>