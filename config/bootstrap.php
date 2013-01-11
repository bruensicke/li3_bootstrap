<?php

use lithium\core\Libraries;
use lithium\action\Dispatcher;
use lithium\action\Response;

use li3_less\core\Less;

/**
 * Here we check, if there is a library called `li3_less`
 *
 * If that is the case, we can directly work with the
 * less files, that is much more flexible. To get this
 * up and running, you need to add li3_less as a library
 * and load it _before_ the li3_bootstrap library like this:
 *
 *     Libraries::add('li3_less');
 *     Libraries::add('li3_bootstrap');
 *
 */
if (is_null($config = Libraries::get('li3_less'))) {
	return; // what a pity - it is not.
}

define('LI3_BOOTSTRAP_PATH', dirname(__DIR__));

Dispatcher::applyFilter('run', function($self, $params, $chain) {

	if(!strstr($params['request']->url, '.css')) {
		return $chain->next($self, $params, $chain);
	}

	// look for a matching less file
	$basename = basename($params['request']->url);
	$less_path =  LI3_BOOTSTRAP_PATH.'/webroot/less';
	$less_file = str_replace('.css', '.less', "$less_path/$basename");
	if(!file_exists($less_file)) {
		return $chain->next($self, $params, $chain);
	}

	// found, so we parse this file
	$output = Less::file($less_file, array('cache' => true));
	return new Response(array(
		'body' => $output,
		'headers' => array('Content-type' => 'text/css')
	));
});

