<?php

namespace Modules\Gateway\Entities;

class GatewayHandler
{
    /**
     * @var array
     */
    private $methods = [];

    /**
     * @var array
     */
    private $views = [];

    /**
     * @var array
     */
    private $recurringCancelMethods = [];

    /**
     * Register method for pay
     *
     * @param  mixed  $name
     * @param  mixed  $class
     * @return void
     */
    public function registerMethodProcessor($name, $class)
    {
        $this->methods[$name] = $class;
    }

    /**
     * Register method for recurring cancel
     *
     * @param  mixed  $name
     * @param  mixed  $class
     * @return void
     */
    public function registerRecurringMethodProcessor($name, $class)
    {
        $this->recurringCancelMethods[$name] = $class;
    }

    /**
     * Register method for view
     *
     * @param  mixed  $name
     * @param  mixed  $class
     * @return void
     */
    public function registerMethodViews($name, $class)
    {
        $this->views[$name] = $class;
    }

    /**
     * Register payment method
     *
     * @return void
     */
    public function registerAllMethods()
    {
        $allMethods = (new GatewayModule())->paymentGateways();
        foreach ($allMethods as $method) {
            $processor = 'Modules\\' . $method->getName() . '\\Processor\\' . $method->getName() . 'Processor';
            $recurringProcessor = 'Modules\\' . $method->getName() . '\\RecurringCancelProcessor\\' . $method->getName() . 'CancelProcessor';
            $view = 'Modules\\' . $method->getName() . '\\Views\\' . $method->getName() . 'View';

            $this->registerMethodProcessor($method->getAlias(), $processor);
            $this->registerRecurringMethodProcessor($method->getAlias(), $recurringProcessor);
            $this->registerMethodViews($method->getAlias(), $view);
        }
    }

    /**
     * Get payment processor object
     *
     * @param  mixed  $name
     * @return object
     */
    public function getProcessor($name)
    {
        return new $this->methods[$name]();
    }

    /**
     * Get recurring cancel processor object
     *
     * @param  mixed  $name
     * @return object
     */
    public function getRecurringCancelProcessor($name)
    {
        return new $this->recurringCancelMethods[$name]();
    }

    /**
     * Get payment view object
     *
     * @param  mixed  $name
     * @return object
     */
    public function getView($name)
    {
        return new $this->views[$name]();
    }
}
