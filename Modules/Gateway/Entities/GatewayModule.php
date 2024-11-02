<?php

namespace Modules\Gateway\Entities;

use Nwidart\Modules\Exceptions\ModuleNotFoundException;
use Nwidart\Modules\Facades\Module;

class GatewayModule extends Module
{
    private $nameOnly = false;

    private $enabledOnly = false;

    /**
     * Sets enabledOnly attribute
     *
     * @return this
     */
    public function setEnabledOnly($enabled = true)
    {
        $this->enabledOnly = $enabled;

        return $this;
    }

    /**
     * Sets nameOnly attribute
     *
     * @return this
     */
    public function setNameOnly($name = true)
    {
        $this->nameOnly = $name;

        return $this;
    }

    /**
     * Returns all the payment gateways based on conditions
     *
     * @return array
     */
    public function paymentGateways()
    {
        $addons = $this->enabledOnly ? parent::allEnabled() : parent::all();
        $gateways = [];

        foreach ($addons as $addon) {
            if ($addon->get('gateway')) {
                $gateways[] = $this->nameOnly ? $addon->getName() : $addon;
            }
        }

        return $gateways;
    }

    /**
     * Returns all offline the payment gateways based on conditions
     */
    public function offlinePaymentGateways(): array
    {
        $addons = $this->enabledOnly ? parent::allEnabled() : parent::all();
        $gateways = [];

        foreach ($addons as $addon) {
            if ($addon->get('offline')) {
                $gateways[] = $this->nameOnly ? $addon->getName() : $addon;
            }
        }

        return $gateways;
    }

    /**
     * Returns all the payable payment gateways
     *
     * @return array
     */
    public function payableGateways()
    {
        $modules = $this->setNameOnly()->setEnabledOnly()->paymentGateways();
        $gateways = Gateway::active()->get();

        $payableGateways = [];

        foreach ($gateways as $gateway) {
            if (in_array($gateway->name, $modules)) {
                $payableGateways[] = $gateway;
            }
        }

        return $payableGateways;
    }

    /**
     * Returns all offline the payable payment gateways
     */
    public function offlinePayableGateways(): array
    {
        $modules = $this->setNameOnly()->setEnabledOnly()->offlinePaymentGateways();
        $gateways = Gateway::active()->get();

        $payableGateways = [];

        foreach ($gateways as $gateway) {
            if (in_array($gateway->name, $modules)) {
                $payableGateways[] = $gateway;
            }
        }

        return $payableGateways;
    }

    /**
     * Find Module
     *
     * @param  string  $name
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findModule($name)
    {
        $module = GatewayModule::findOrFail($name);
        if ($module->get('gateway')) {
            return $module;
        }

        throw new ModuleNotFoundException(__(':name payment gateway module not found.', ['name' => ucfirst($name)]));
    }

    /**
     * Returns all recurring the payable payment gateways
     */
    public function recurringPayableGateways(): array
    {
        $modules = $this->setNameOnly()->setEnabledOnly()->recurringPaymentGateways();
        $gateways = Gateway::active()->get();

        $payableGateways = [];

        foreach ($gateways as $gateway) {
            if (in_array($gateway->name, $modules)) {
                $payableGateways[] = $gateway;
            }
        }

        return $payableGateways;
    }

    /**
     * Returns all recurring the payment gateways based on conditions
     */
    public function recurringPaymentGateways(): array
    {
        $addons = $this->enabledOnly ? parent::allEnabled() : parent::all();
        $gateways = [];

        foreach ($addons as $addon) {
            if ($addon->get('recurring')) {
                $gateways[] = $this->nameOnly ? $addon->getName() : $addon;
            }
        }

        return $gateways;
    }

    /**
     * Returns all single the payable payment gateways
     */
    public function singlePayableGateways(): array
    {
        $modules = $this->setNameOnly()->setEnabledOnly()->singlePaymentGateways();
        $gateways = Gateway::active()->get();

        $payableGateways = [];

        foreach ($gateways as $gateway) {
            if (in_array($gateway->name, $modules)) {
                $payableGateways[] = $gateway;
            }
        }

        return $payableGateways;
    }

    /**
     * Returns all recurring the payment gateways based on conditions
     */
    public function singlePaymentGateways(): array
    {
        $addons = $this->enabledOnly ? parent::allEnabled() : parent::all();
        $gateways = [];

        foreach ($addons as $addon) {
            $moduleJson = $addon->json();
            if (
                $moduleJson->gateway == true &&
                ! $moduleJson->offline &&
                ! $moduleJson->recurring
            ) {
                $gateways[] = $addon;
            }
        }

        return $gateways;
    }
}
