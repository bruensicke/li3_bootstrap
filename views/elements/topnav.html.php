<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">

			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>

			<a href="<?=$this->url('/'); ?>" class="pull-left">
				<?=$this->html->image('logo.png', array('style' => 'padding-right: 10px')); ?>
			</a>

			<a href="<?=$this->url('/'); ?>" class="brand">
				<span><?= $this->app->name(); ?></span>
			</a>

			<div class="nav-collapse">
				<ul class="nav">
					<li><?php echo $this->html->link('Start', '/'); ?></li>
				</ul>
			</div>

		</div>
	</div>
</div>