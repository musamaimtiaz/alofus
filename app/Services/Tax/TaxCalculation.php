<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain <[sakawat.techvill@gmail.com]>
 *
 * @created 29-09-2022
 */

namespace App\Services\Tax;

class TaxCalculation
{
    /**
     * store data for applicable tax
     *
     * @var array
     */
    protected $applicableRate = [];

    /**
     * store productized data for taxRates
     *
     * @var array
     */
    protected $taxRates = [];

    /**
     * store data for all taxes
     */
    protected $taxes = null;

    /**
     * store price
     *
     * @var null
     */
    protected $price = null;

    /**
     * store comparable address
     *
     * @var null
     */
    protected $compareAddress = null;

    /**
     * store for is tax productized or not
     *
     * @var bool
     */
    protected $isProductized = false;

    /**
     * store data from shipping charge
     *
     * @var int
     */
    protected $shipping = 0;

    /**
     * store quantity
     *
     * @var int
     */
    protected $qty = 1;

    /**
     * store shipping tax class
     *
     * @var null
     */
    protected $shippingTaxClass = null;

    public function __construct($taxes, $price, $compareAddress, $isProductized, $shipping, $qty, $shippingTaxClass)
    {
        $this->setTaxes($taxes);
        $this->price = $price;
        $this->compareAddress = $compareAddress;
        $this->isProductized = $isProductized;
        $this->shipping = $shipping;
        $this->qty = $qty;
        $this->shippingTaxClass = $shippingTaxClass;
    }

    /**
     * calculate tax
     *
     * @return float|int|null
     */
    public function calculateTax()
    {
        $taxes = $this->taxes->sortBy([
            ['compound', 'asc'],
            ['priority', 'asc'],
        ]);
        $qty = $this->qty;
        $price = $this->price * $qty;
        $compareAddress = $this->compareAddress;
        $isProductized = $this->isProductized;
        $shipping = $this->shipping;
        $shippingTaxClass = $this->shippingTaxClass;
        $tempPrice = $price;
        $priority = [];
        $compoundPrice = $price;
        $fixPrice = $price;

        foreach ($taxes as $tax) {
            $flag = $this->checkApplicableAddress($tax, $compareAddress);

            if ($flag && ! in_array($tax->priority, $priority)) {
                $taxRate = $tax->tax_rate;

                if ($tax->compound == 1) {
                    $calPrice = ($taxRate * $compoundPrice) / 100;
                    $compoundPrice += $calPrice;
                    $price = $compoundPrice;
                } else {
                    $calPrice = ($taxRate * $price) / 100;
                    $compoundPrice += $calPrice;
                }

                if ($tax->shipping == 1 && $shippingTaxClass == 'shipping tax class base on cart items') {
                    $shippingTaxRate = $tax->tax_rate;
                    $shipTax = ($shippingTaxRate * $shipping) / 100;
                    $calPrice += $shipTax;
                }

                $tempPrice += $calPrice;

                if ($isProductized) {
                    $this->taxRates[$tax->name] = isset($this->taxRates[$tax->name]) ? $this->taxRates[$tax->name] + $calPrice : $calPrice;
                }

                $priority[] = $tax->priority;
            }
        }

        if ($isProductized) {
            return $this->taxRates;
        }

        return $tempPrice != $fixPrice ? $tempPrice - $fixPrice : 0;
    }

    /**
     * calculate shipping tax
     *
     * @return array|float|int
     */
    public function calculateShippingTax()
    {
        $this->taxRates = [];
        $this->applicableRate = [];
        $taxes = $this->taxes->sortBy([
            ['compound', 'asc'],
            ['priority', 'asc'],
        ]);
        $compareAddress = $this->compareAddress;
        $isProductized = $this->isProductized;
        $shipping = $this->shipping;
        $shippingTaxClass = $this->shippingTaxClass;
        $priority = [];
        $shipTax = 0;
        $taxResult = 0;

        foreach ($taxes as $tax) {
            $flag = $this->checkApplicableAddress($tax, $compareAddress);

            if ($flag && ! in_array($tax->priority, $priority) && $tax->shipping == 1) {

                if ($shippingTaxClass != 'shipping tax class base on cart items') {
                    $shippingTaxRate = $tax->tax_rate;
                    $taxResult = ($shippingTaxRate * $shipping) / 100;
                    $shipTax += $taxResult;
                }

                if ($isProductized) {
                    $this->taxRates[$tax->name] = isset($this->taxRates[$tax->name]) ? $this->taxRates[$tax->name] + $taxResult : $taxResult;
                }

                $priority[] = $tax->priority;
            }
        }

        if ($isProductized) {
            return $this->taxRates;
        }

        return $shipTax;
    }

    /**
     * check whether address applicable or not
     *
     * @return bool
     */
    public function checkApplicableAddress($taxAddress = null, $compareAddress = null)
    {
        $flag = true;
        if (! is_null($taxAddress->country)) {
            if (! is_null($compareAddress)) {
                if (strtolower($taxAddress->country) != strtolower($compareAddress->country)) {
                    $flag = false;
                }
            } else {
                $flag = false;
            }
        }

        if (! is_null($taxAddress->state)) {
            if (! is_null($compareAddress)) {
                if ($taxAddress->state != $compareAddress->state) {
                    $flag = false;
                }
            } else {
                $flag = false;
            }
        }

        if (! is_null($taxAddress->city)) {
            if (! is_null($compareAddress)) {
                if ($taxAddress->city != $compareAddress->city) {
                    $flag = false;
                }
            } else {
                $flag = false;
            }
        }

        if (! is_null($taxAddress->postcode)) {
            if (! is_null($compareAddress)) {
                if ($taxAddress->postcode != $compareAddress->post_code) {
                    $flag = false;
                }
            } else {
                $flag = false;
            }
        }

        return $flag;
    }

    /**
     * set all taxes
     *
     * @return void
     */
    public function setTaxes($taxes)
    {
        $this->taxes = $taxes;
        $collectionTaxesNotNull = collect($this->taxes)->where('country', '!=', null)->groupBy('country');
        $collectionTaxesNull = collect($this->taxes)->where('country', null)->groupBy('country');
        $collectionTaxes = $collectionTaxesNotNull->merge($collectionTaxesNull);
        $data = [];

        foreach ($collectionTaxes as $allTaxes) {
            $uniquePriority = [];

            foreach ($allTaxes as $allTax) {

                if (! in_array($allTax->priority, $uniquePriority)) {
                    $maxSort = $allTaxes->where('priority', $allTax->priority)->max('sort_by');
                    $data[] = $allTaxes->where('priority', $allTax->priority)->where('sort_by', $maxSort)->first();
                    $uniquePriority[] = $allTax->priority;
                }
            }

        }

        $this->taxes = collect($data);
    }
}
