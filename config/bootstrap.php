<?php

use lithium\core\Libraries;
use lithium\action\Dispatcher;
use lithium\action\Response;
use lithium\net\http\Media;

use li3_less\core\Less;

define('LI3_BOOTSTRAP_PATH', dirname(__DIR__));

/*
 * this filter allows automatic linking and loading of assets from `webroot` folder
 */
Dispatcher::applyFilter('_callable', function($self, $params, $chain) {
	list($tmp, $library, $asset) = explode('/', $params['request']->url, 3) + array("", "", "");
	if ($asset && $library == 'li3_bootstrap' && ($path = Media::webroot($library)) && file_exists($file = "{$path}/{$asset}")) {
		return function() use ($file) {
			$info = pathinfo($file);
			$media = Media::type($info['extension']);
			$content = (array) $media['content'];

			return new Response(array(
				'headers' => array('Content-type' => reset($content)),
				'body' => file_get_contents($file)
			));
		};
	}
	return $chain->next($self, $params, $chain);
});

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

