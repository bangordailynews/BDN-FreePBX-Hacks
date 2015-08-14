<?php
require_once('../admin/libraries/php-asmanager.php');

$astman 		= new AGI_AsteriskManager();
// attempt to connect to asterisk manager proxy


if ( !$res = $astman->connect( '127.0.0.1:5038', 'username', 'password', 'off')) {
	// couldn't connect at all
	unset( $astman );
	$_SESSION['ari_error'] =
	_("ARI does not appear to have access to the Asterisk Manager.") . " ($errno)<br>" .
	_("Check the ARI 'main.conf.php' configuration file to set the Asterisk Manager Account.") . "<br>" .
	_("Check /etc/asterisk/manager.conf for a proper Asterisk Manager Account") . "<br>" .
	_("make sure [general] enabled = yes and a 'permit=' line for localhost or the webserver.");
}

$extensions = array(
	8250, 8298, 12076605342, 12075052482, 12074162828, 12074781320
);

foreach( $extensions as $ext ) { 
	$inputs = array(
		'Channel' => 'local/' . $ext . '@from-internal', //Also SIP/8250 works
		'Exten' => $ext, //Self
		'Context' => 'from-internal',
		'Priority' => '1',
		'Timeout' => NULL,
		'CallerID' => 'OMG',
		'Variable' => '',
		'Account' => NULL,
		'Application' => 'playback',
		'Data' => 'hello-world',
		'Async' => 1,
	);

	/* Arguments to Originate: channel, extension, context, priority, timeout, callerid, variable, account, application, data */
	$status = $astman->Originate( $inputs );
	var_dump( $status );
}
