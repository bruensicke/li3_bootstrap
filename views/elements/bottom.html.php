<script type="text/javascript" charset="utf-8">
head.js(
	"<?php echo $this->url('/js/jquery.min.js'); ?>",
	"<?php echo $this->url('/js/icanhaz.min.js'); ?>",
	"<?php echo $this->url('/js/bootstrap.min.js'); ?>",
	"<?php echo $this->url('/js/bootbox.min.js'); ?>",
	"<?php echo $this->url('/js/moment.min.js'); ?>",
	"<?php echo $this->url('/js/app.js'); ?>",
	function() {
		ich.grabTemplates();
	}
);
</script>
<?php /*
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-XXXXX-Y']);
_gaq.push(['_trackPageview']);
(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>
*/ ?>
