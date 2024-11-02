<?php

namespace Modules\Gateway\Contracts;

interface RecurringCancelInterface
{
    /**
     * Recurring cancel method
     *
     * @return response
     */
    public function execute(string $subscriptionId, ?string $customerId = null);
}
