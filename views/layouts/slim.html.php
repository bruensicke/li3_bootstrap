<!DOCTYPE html>
<html class="<?= \lithium\core\Environment::get(); ?>">
<head>
	<?= $this->_render('element', 'head'); ?>
</head>
<body class="app slim" data-spy="scroll">
	<?= $this->_render('element', 'topnav'); ?>
	<div class="container-narrow">
		<header id="header">
			<?= $this->_render('element', 'header'); ?>
		</header>
		<div id="content">
			<?= $this->content(); ?>
		</div>
		<footer id="footer">
			<?= $this->_render('element', 'footer'); ?>
		</footer>
	</div>
	<?= $this->_render('element', 'bottom'); ?>
</body>
</html>