<?php

namespace CrisisTextLine\UserProfileBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CrisisTextLineUserProfileBundle extends Bundle
{
    const FIELD_TYPE_BOOLEAN = 0;
    const FIELD_TYPE_TEXT = 1;
    const FIELD_TYPE_STRING = 1;
    const FIELD_TYPE_SERIES = 2;

    static public function getHumanReadableFieldTypes() {
        return array(
            self::FIELD_TYPE_BOOLEAN  => 'Boolean',
            self::FIELD_TYPE_TEXT     => 'Text',
            self::FIELD_TYPE_SERIES   => 'Serial Data'
        );
    }
}
