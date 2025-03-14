<?php

/* Copyright (c) 1998-2009 ILIAS open source, Extended GPL, see docs/LICENSE */

declare(strict_types=1);

enum VedaUDFClaimingFields: string
{
    case SUPERVISOR = 'supervisor';
    case SUPERVISOR_EMAIL = 'supervisor_mail';
    case MEMBER_ID = 'member_id';
    case TUTOR_ID = 'tutor_id';
    case COMPANION_ID = 'companion_id';
    case SUPERVISOR_ID = 'supervisor_id';
}
