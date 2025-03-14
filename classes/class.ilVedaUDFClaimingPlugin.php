<?php

/* Copyright (c) 1998-2009 ILIAS open source, Extended GPL, see docs/LICENSE */

declare(strict_types=1);

/**
 * Class ilVedaUDFClaiming
 * @author Stefan Meyer <smeyer.ilias@gmx.de>
 */
class ilVedaUDFClaimingPlugin extends \ilUDFClaimingPlugin
{
    /** @var int */
    public const UD_FIELD_TYPE_TEXT = 1;

    /** @var string */
    public const PLUGIN_ID = 'vedaudfclaiming';

    /** @var string */
    public const PLUGIN_NAME = 'VedaUDFClaiming';

    /** @var string */
    public const SETTINGS_MODULE = 'vedaudfclaiming';

    /** @var string */
    public const SETTINGS_FIELD_IDS = 'fields';

    protected ilLogger $logger;
    protected ilSetting $settings;
    protected array $fields;
    protected static ?ilUDFClaimingPlugin $instance = null;

    public function __construct(ilDBInterface $db, ilComponentRepositoryWrite $component_repository, string $id)
    {
        parent::__construct($db, $component_repository, $id);
        $this->settings = new ilSetting(self::SETTINGS_MODULE);
        $this->fields = unserialize($this->settings->get(self::SETTINGS_FIELD_IDS, serialize([])));
        $this->logger = ilLoggerFactory::getLogger(self::PLUGIN_ID);
    }

    public static function getInstance(): \ilVedaUDFClaimingPlugin
    {
        global $DIC;

        if (self::$instance instanceof self) {
            return self::$instance;
        }
        return self::$instance = new self(
            $DIC->database(),
            $DIC["component.repository"],
            self::PLUGIN_ID
        );
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    public function getPluginName(): string
    {
        return self::PLUGIN_NAME;
    }

    public function checkPermission(
        int $a_user_id,
        int $a_context_type,
        int $a_context_id,
        int $a_action_id,
        int $a_action_sub_id
    ): bool {
        return true;
    }

    /**
     * @return int[]
     */
    public function getUsersForTutorId(?string $tutor_oid): array
    {
        return $this->getUserIdsForFieldAndOId($tutor_oid, VedaUDFClaimingFields::TUTOR_ID);
    }

    /**
     * @return int[]
     */
    public function getUsersForCompanionId(?string $companion_oid): array
    {
        return $this->getUserIdsForFieldAndOId($companion_oid, VedaUDFClaimingFields::COMPANION_ID);
    }

    /**
     * @return int[]
     */
    public function getUsersForSupervisorId(?string $supervisor_oid): array
    {
        return $this->getUserIdsForFieldAndOId($supervisor_oid, VedaUDFClaimingFields::SUPERVISOR_ID);
    }

    /**
     * @return int[]
     */
    protected function getUserIdsForFieldAndOId(
        ?string $oid,
        VedaUDFClaimingFields $field
    ): array {
        $query = 'select usr_id from udf_text ' .
            'where field_id = ' . $this->db->quote($this->fields[$field->value], ilDBConstants::T_INTEGER) . ' ' .
            'and value = ' . $this->db->quote($oid, ilDBConstants::T_TEXT);
        $res = $this->db->query($query);
        $user_ids = [];
        while ($row = $res->fetchRow(ilDBConstants::FETCHMODE_OBJECT)) {
            $user_ids[] = $row->usr_id;
        }
        return $user_ids;
    }
}
