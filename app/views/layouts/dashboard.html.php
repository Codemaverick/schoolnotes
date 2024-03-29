<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2011, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="author" content="SchoolNotes - Profiles">

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le styles -->
	<?php echo $this->html->charset();?>
	<title>Dashboard - <?php echo $this->title(); ?></title>
	<?php echo $this->html->style(array('bootstrap','notestyle')); ?>
	<?php echo $this->scripts(); ?>
	<?php echo $this->html->link('Icon', null, array('type' => 'icon')); ?>
</head>
<body class="app">
	<div class="masthead" id="profile_main">
		<div class="container row">
			<div id="" class="span3 alpha">
				 <?php echo $this->html->link("SchoolNotes", '/'); ?>
			</div>
			<div class="span9">
				<ul class="nav">
		            <li class="active"><a href="#">Home</a></li>
		            <li><a href="#about">About</a></li>
		            <li><a href="#contact">Contact</a></li>
		        </ul>
		     </div>
		     <div class="span4 login_status">
		     	<?php echo $this->_render('element', 'login_status'); ?>
		     </div>	
       	</div>
	</div>
	<div class="container profiles_container">
		
		<?php echo $this->content(); ?>
		
	</div> <!-- /container -->
	
	<footer>
	<div class="container" id="footer">
			<p>&copy; Copyrights <?= date('Y'); ?> - SchoolNotes</p>
			<p>Powered by <?php echo $this->html->link('Lithium', 'http://lithify.me/'); ?>.</p>
	</div>
	</footer>

</body>
</html>




      

   