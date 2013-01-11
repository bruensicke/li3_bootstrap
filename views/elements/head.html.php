<?php echo $this->html->charset();?>
<title><?php echo $this->title(); ?></title>
<?php echo $this->html->style(array(
	'/li3_bootstrap/css/bootstrap.min',
	'/li3_bootstrap/css/font-awesome',
	'custom',
	'app',
	'/li3_bootstrap/css/bootstrap-responsive.min',
)); ?>
<?php echo $this->html->script('/li3_bootstrap/js/head.js'); ?>
<?php echo $this->head(); ?>
<?php echo $this->scripts(); ?>
<?php echo $this->html->link('Icon', null, array('type' => 'icon')); ?>

<meta name="MSSmartTagsPreventParsing" content="true" />
<meta http-equiv="imagetoolbar" content="no" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="apple-touch-icon" href="<?= $this->url('img/apple-touch-icon.png'); ?>">
