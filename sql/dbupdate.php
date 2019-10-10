<#1>
<?php

$map = [];

$new_id = \ilVedaUDFClaimingPlugin::createDBField(
	\ilVedaUDFClaimingPlugin::UD_FIELD_TYPE_TEXT,
	'Aufsichtsperson',
	[
		'registration_visible' => 0,
		'export'               => 1,
		'visible'              => 1,
		'changeable'           => 0,
		'searchable'           => 1,
		'required'             => 0,
		'course_export'        => 1,
		'group_export'         => 1,
		'changeable_lua'       => 1,
		'visible_lua'          => 1
	],
	[]
);

$map[\ilVedaUDFClaimingPlugin::FIELD_SUPERVISOR] = $new_id;

$new_id = \ilVedaUDFClaimingPlugin::createDBField(
	\ilVedaUDFClaimingPlugin::UD_FIELD_TYPE_TEXT,
	'Aufsichtsperson e-Mail',
	[
		'registration_visible' => 0,
		'export'               => 1,
		'visible'              => 1,
		'changeable'           => 0,
		'searchable'           => 1,
		'required'             => 0,
		'course_export'        => 1,
		'group_export'         => 1,
		'changeable_lua'       => 1,
		'visible_lua'          => 1
	],
	[]
);

$map[\ilVedaUDFClaimingPlugin::FIELD_SUPERVISOR_EMAIL] = $new_id;

$new_id = \ilVedaUDFClaimingPlugin::createDBField(
	\ilVedaUDFClaimingPlugin::UD_FIELD_TYPE_TEXT,
	'Mitgliedsnummer',
	[
		'registration_visible' => 0,
		'export'               => 1,
		'visible'              => 1,
		'changeable'           => 0,
		'searchable'           => 1,
		'required'             => 0,
		'course_export'        => 1,
		'group_export'         => 1,
		'changeable_lua'       => 1,
		'visible_lua'          => 1
	],
	[]
);

$map[\ilVedaUDFClaimingPlugin::FIELD_MEMBER_ID] = $new_id;

$set = new \ilSetting(\ilVedaUDFClaimingPlugin::SETTINGS_MODULE);
$set->set(\ilVedaUDFClaimingPlugin::SETTINGS_FIELD_IDS, serialize($map));
?>

