<?php

namespace App\Contract;

interface SmsInterface
{
    public function send(array $data): void;
}
