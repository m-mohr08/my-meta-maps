<?php

return [
	'route' => 'auth.social',
	'opauth' => [
		'callback_transport' => 'post',
		'path' => '/auth/social/',
		'callback' => '/auth/social/callback',
		'debug' => false,
		'proxy' => Config::get('remote.proxy.host'),
		'Strategy' => [
			'Facebook' => array(
				'app_id' => '',
				'app_secret' => ''
			),
			'Google' => array(
				'client_id' => '',
				'client_secret' => ''
			),
			'GitHub' => array(
				'client_id' => '',
				'client_secret' => ''
			),
			'Twitter' => array(
				'key' => '',
				'secret' => ''
			)
		]
	]
];
