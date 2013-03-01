var tools = {};
tools.array_values = function(input) {
	var tmp_arr = [],
		key = '';
	for (key in input) {
		tmp_arr[tmp_arr.length] = input[key];
	}
	return tmp_arr;
};
tools.prepare = function(obj) {
	jQuery.each(obj, function(name, item) {
		obj[name] = tools.array_values(item);
	});
	return obj;
};
tools.bytes = function() {
	$("[data-size]").each(function(){
		var bytes = $(this).data('size');
		if (bytes < 1) return $(this).html('n/a');
		var sizes = ['b', 'k', 'm', 'g', 't', 'p', 'e', 'z', 'y'],
			i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)), 10);
		return $(this).html(Math.round(bytes / Math.pow(1024, i), 2) + sizes[i]);
	});
};
tools.datetime = function() {
	$("[data-datetime]").each(function(){
		var $this = $(this),
			date = $this.data('datetime'),
			valid = ((date != undefined && date > 0)
				|| (date != undefined && typeof(date)=='string' && date.length > 0) );
		if (!valid) {
			return;
		}
		if (typeof(date)=='number') {
			mom = moment(date*1000);
		} else {
			mom = moment(date);
		}
		$this.html(mom.fromNow());
	});
};
tools.duration = function() {
	$("[data-duration]").each(function(){
		var seconds = $(this).data('duration');
		if (seconds < 1) return $(this).html('n/a');
		return $(this).html(seconds.toString().substr(0,4) + 's');
	});
};
tools.number = function(e) {
	var theEvent = e || window.event;
	var key = theEvent.keyCode || theEvent.which;
	if(key != 13 && key != 9 && key != 8 && key != 46) { //allow enter and tab, backspace and delete
		key = String.fromCharCode( key );
		var regex = /[0-9]|\./;
		if( !regex.test(key)) {
			theEvent.returnValue = false;
			if(theEvent.preventDefault) theEvent.preventDefault();
		}
	}
};
tools.numeric = function() {
	$("body").on("focus","input[type=text].numeric,.numeric", function(e){
		$(e.target).data('oldValue',$(e.target).val());
	});
	$("body").on("keypress","input[type=text].numeric,.numeric", function(e){
		e.target.oldvalue = e.target.value;
		tools.number(e);
	});
	$("body").on("change","input[type=text].numeric,.numeric", function(e){
		var t = e.target,
			min = $(t).attr("min"),
			max = $(t).attr("max"),
			val = parseInt($(t).val(), 10);
		if( val < min || max < val) {
			alert("Error!");
			$(t).val($(t).data('oldValue'));
		}
	});
};
tools.dataswitch = function() {
	$('body').on('change', '[data-switch]', function(e){
		var name = $(this).attr('data-switch'),
			val = $(this).val(),
			target = name + '_' + val;

		$('[class*="' + name + '_"]').hide();
		if (this.value !== '') {
			$('div.'+target).show();
		}
	});
	$('[data-switch]').trigger('change');
};
tools.tabs = function() {
	$('a[data-toggle="tab"]').on('shown', function (e) {
		window.location.hash = $(e.target).attr('href').replace('#', '');
	});
	if (current_mode = window.location.hash.replace('#', '')) {
		$('a[href="#'+current_mode+'"]').addClass('active').tab('show');
	}
};
tools.triggers = function() {
	tools.numeric();
	tools.dataswitch();
	tools.tabs();
	tools.duration();
	setInterval('tools.datetime', 5000);
};
tools.render = function() {
	tools.datetime();
	tools.bytes();
};
