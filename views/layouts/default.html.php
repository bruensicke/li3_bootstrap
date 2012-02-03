<!doctype html>
<html>
<head>
	<?php echo $this->html->charset();?>
	<title><?php echo $this->title(); ?></title>
	<?php echo $this->html->style(array('bootstrap.min', 'bootstrap-responsive.min', 'app')); ?>
	<?php echo $this->html->script('head.js'); ?>
	<?php echo $this->scripts(); ?>
	<?php echo $this->html->link('Icon', null, array('type' => 'icon')); ?>
</head>
<body class="app">
<?php echo $this->_render('element', 'topnav'); ?>
	<div class="container">
		<header id="header">
			<?php echo $this->_render('element', 'header'); ?>
		</header>
		<div id="content">
			<?php
			echo $this->sessionMessage->renderAll();
			?>
			<?php echo $this->content(); ?>
		</div>
		<footer id="footer">
			<?php echo $this->_render('element', 'footer'); ?>
		</footer>
	</div>
	<script type="text/javascript" charset="utf-8">
		head.js(
			"<?php echo $this->url('/js/jquery.min.js'); ?>",
			"<?php echo $this->url('/js/icanhaz.min.js'); ?>",
			"<?php echo $this->url('/js/bootstrap.min.js'); ?>",
			"<?php echo $this->url('/js/app.js'); ?>",
			function() {
				ich.grabTemplates(); //make sure, icanhaz bootstraps correctly.
			}
		);
	</script>
</body>
</html>