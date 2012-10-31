<?php use \lithium\core\Environment; ?>

	<?php echo $this->html->charset();?>

	<title><?php echo $this->title(); ?></title>
	<meta name="keywords" http-equiv="keywords" content="<?= Environment::get('App.keywords'); ?>" />
	<meta name="description" http-equiv="description" content="<?= Environment::get('App.description'); ?>" />
	<meta name="author" http-equiv="author" content="<?= Environment::get('App.author'); ?>">

	<?php echo $this->html->style(array('bootstrap.min', 'bootstrap-responsive.min', 'custom', 'app')); ?>
	<?php echo $this->html->script('head.js'); ?>
	<?php echo $this->head(); ?>
	<?php echo $this->scripts(); ?>
	<?php echo $this->html->link('Icon', null, array('type' => 'icon')); ?>

	<meta name="MSSmartTagsPreventParsing" content="true" />
	<meta http-equiv="imagetoolbar" content="no" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- <link rel="apple-touch-icon" href="<?= $this->url('img/apple-touch-icon.png'); ?>"> -->
