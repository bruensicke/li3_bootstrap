<nav class="navbar navbar-default block" role="navigation">
	<div class="navbar-header">

		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>

		<a href="<?=$this->url('/'); ?>" class="pull-left">
			<?=$this->html->image('logo.png', array('style' => 'padding-right: 10px')); ?>
		</a>
		<a href="<?=$this->url('/'); ?>" class="brand">
			<span>Home</span>
		</a>

	</div>

	<div class="collapse navbar-collapse navbar-ex1-collapse">

		<div class="navbar-collapse">
			<ul class="nav navbar-nav">
				<li><?php echo $this->html->link('Start', '/'); ?></li>
			</ul>
		</div>

	</div>
</nav>
