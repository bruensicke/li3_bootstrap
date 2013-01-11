<?php

use lithium\net\http\Router;
use lithium\action\Response;

Router::connect('/li3_bootstrap/{:path:js|css|font}/{:file}.{:type}', array(), function($request) {
	$req = $request->params;
	$file = dirname(__DIR__) . "/webroot/{$req['path']}/{$req['file']}.{$req['type']}";

	if (!file_exists($file)) {
		return;
	}

	return new Response(array(
		'body' => file_get_contents($file),
		'headers' => array('Content-type' => str_replace(
			array('css', 'js', 'font'), array('text/css', 'text/javascript', "application/x-font-{$req['type']}"), $req['type']
		))
	));
});
