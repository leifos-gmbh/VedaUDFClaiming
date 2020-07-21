<?php
/* Copyright (c) 1998-2009 ILIAS open source, Extended GPL, see docs/LICENSE */

/**
 * Class ilVedaUDFClaiming
 * @author Stefan Meyer <smeyer.ilias@gmx.de>
 */
class ilVedaUDFClaimingPlugin extends \ilUDFClaimingPlugin
{
	public const UD_FIELD_TYPE_TEXT = 1;

    /**
	 * @var null | \ilVedaUDFClaimingPlugin
	 */
	private static $instance = null;

	/**
	 * @var string
	 */
	public const PLUGIN_ID = 'vedaudfclaiming';


	/**
	 * @var string
	 */
	public const PLUGIN_NAME = 'VedaUDFClaiming';


	/**
	 * @var string
	 */
	public const SETTINGS_MODULE = 'vedaudfclaiming';


	/**
	 * @var string
	 */
	public const SETTINGS_FIELD_IDS = 'fields';


	/**
	 * @var string
	 */
	public const FIELD_SUPERVISOR = 'supervisor';

	/**
	 * @var string
	 */
	public const FIELD_SUPERVISOR_EMAIL = 'supervisor_mail';

	/**
	 * @var string
	 */
	public const FIELD_MEMBER_ID = 'member_id';

	/**
	 * @var string
	 */
	public const FIELD_TUTOR_ID = 'tutor_id';

	/**
	 * @var string
	 */
	public const FIELD_COMPANION_ID = 'companion_id';




	/**
	 * @var null | \ilLogger
	 */
	private $logger = null;

	/**
	 * @var null | \ilSetting
	 */
	private $settings = null;


	/**
	 * @var array
	 */
	private $fields = [];



	/**
	 * @return \ilVedaMDClaimingPlugin
	 */
	public static function getInstance() : \ilVedaMDClaimingPlugin
	{
		if(!self::$instance instanceof \ilVedaUDFClaimingPlugin) {
			self::$instance = \ilPluginAdmin::getPluginObject(
				IL_COMP_SERVICE,
				'User',
				'udfc',
				self::PLUGIN_NAME
			);
		}
		return self::$instance;
	}


	/**
	 * init plugin (records and fields)
	 */
	public function init()
	{
		$this->settings = new \ilSetting(self::SETTINGS_MODULE);
		$this->fields = unserialize($this->settings->get(self::SETTINGS_FIELD_IDS, serialize([])));
		$this->logger = \ilLoggerFactory::getLogger(self::PLUGIN_ID);
	}


	/**
	 * @return array
	 */
	public function getFields() : array
	{
		return $this->fields;
	}




	/**
	 * @inheritdoc
	 */
	public function getPluginName() : string
	{
		return self::PLUGIN_NAME;
	}

	/**
	 * Check permission
	 *
	 * @param int $a_user_id
	 * @param int $a_context_type
	 * @param int $a_context_id
	 * @param int $a_action_id
	 * @param int $a_action_sub_id
	 * @return bool
	 */
	public function checkPermission($a_user_id, $a_context_type, $a_context_id, $a_action_id, $a_action_sub_id) :bool
	{
		return true;
	}


	/**
	 * @param string|null $tutor_oid
	 * @return int[]
	 */
	public function getUsersForTutorId(?string $tutor_oid) : array
	{
		global $DIC;

		$db = $DIC->database();

		$query = 'select usr_id from udf_text ' .
			'where field_id = ' . $db->quote($this->fields[\ilVedaUDFClaimingPlugin::FIELD_TUTOR_ID], \ilDBConstants::T_INTEGER). ' ' .
			'and value = ' . $db->quote($tutor_oid, \ilDBConstants::T_TEXT);
		$res = $db->query($query);

		$user_ids = [];
		while($row = $res->fetchRow(\ilDBConstants::FETCHMODE_OBJECT)) {
			$user_ids[] = $row->usr_id;
		}
		return $user_ids;
	}

	/**
	 * @param string|null $tutor_oid
	 * @return int[]
	 */
	public function getUsersForCompanionId(?string $companion_oid) : array
	{
		global $DIC;

		$db = $DIC->database();

		$query = 'select usr_id from udf_text ' .
			'where field_id = ' . $db->quote($this->fields[\ilVedaUDFClaimingPlugin::FIELD_COMPANION_ID], \ilDBConstants::T_INTEGER). ' ' .
			'and value = ' . $db->quote($companion_oid, \ilDBConstants::T_TEXT);
		$res = $db->query($query);

		$user_ids = [];
		while($row = $res->fetchRow(\ilDBConstants::FETCHMODE_OBJECT)) {
			$user_ids[] = $row->usr_id;
		}
		return $user_ids;
	}
}
?>