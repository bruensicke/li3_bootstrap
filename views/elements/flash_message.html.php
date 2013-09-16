<div class="flash-message alert <?php if(!empty($class)): echo sprintf('alert-%s %s', $class); endif; ?>">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<?= $message; ?>
</div>