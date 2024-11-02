<?php

namespace Infoamin\Installer\Interfaces;

interface PurchaseInterface
{
    public function getPurchaseStatus($domainName, $domainIp, $envatopurchasecode, $envatoUsername);
}
