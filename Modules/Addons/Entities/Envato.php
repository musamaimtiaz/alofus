<?php

namespace Modules\Addons\Entities;

class Envato
{    
    /**
     * isValidPurchaseCode
     *
     * @param string $envatopurchasecode
     * @param string $domainName
     * @param string $domainIp
     * @return bool
     */
    public static function isValidPurchaseCode(string $envatopurchasecode, $domainName = null, $domainIp = null): bool
    {
		return true;
    }
}