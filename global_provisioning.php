<?php
//This file will set global variables in the automatic provisioning
//So these variables are set no matter which template you choose
//It also allows us to use some internal variables in the template thing
//Require this file on line 324 of /var/www/html/admin/modules/xepm/provisioners/yealink.php
//(Inside the generate function)
//Like so:
//require( __DIR__ . '/../../../../bdn/global_provisioning.php' );


//These are variables that will be set for every template.
//Yealink auto-provisioning guide: http://www.yealink.com/Upload/T2X/2014102/Yealink_SIP-T2_Series_T19P_T4_Series_IP_Phones_Auto_Provisioning_Guide_V72_1.pdf
$global_provisioning = array(
	'auto_provision.server.url' => 'http://phonesystem.bangordailynews.com/xepm-provision/',
	'autoprovision.1.url' => 'http://phonesystem.bangordailynews.com/xepm-provision/',
	'features.voice_mail_tone_enable' => 'disable',
	'voice.tone.stutter' => 0,
	'remote_phonebook.data.1.url' => 'http://phonesystem.bangordailynews.com/directory.php',
	'remote_phonebook.data.1.name' => 'BDN',
	'directory_setting.url' => 'http://phonesystem.bangordailynews.com/favorite_setting.xml',
	'super_search.url' => 'http://phonesystem.bangordailynews.com/favorite_setting.xml',
	'features.remote_phonebook.enable' => 1,
	'voice_mail.number.1' =>  '*97',
);

$settings = array_merge( $settings, $global_provisioning );


$variables = array();

//Variables we can use in the admin, like so: %account.1.account%
foreach ( $this->extensions() as $extension ) {
	$index = $extension->extension_index + 1;
	$variables[ 'account.' . $index . '.account' ] = $extension->account;
}

//Replace any variables with the value
foreach( $settings as $key => $value ) {
	foreach( $variables as $find => $replace ) {
		$settings[ $key ] = str_replace( '%' . $find . '%', $replace, $value );
	}
}