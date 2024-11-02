<?php
/**
* @author TechVillage <support@techvill.org>
*
* @contributor Muhammad AR Zihad <[zihad.techvill@gmail.com]>
* @contributor Al Mamun <[almamun.techvill@gmail.com]>
*
* @created 19-04-2022
*/

namespace App\Services\Reports;

trait ReportHelperTrait
{
    /**
     * Stores processed value for return
     */
    private $return = null;

    /**
     * Stores temporary key for the first value which gets stored in $return
     */
    private $tempKey;

    /**
     * Limit of taking data
     */
    private $limit = 5;

    /**
     * Get date of certain offset / Today
     *
     * @param  string | null  $offset  Offset is how many days you want to differ from current date
     * @return string
     */
    private function offsetDate($offset = null)
    {
        if ($offset) {
            return date('Y-m-d', strtotime($offset . ' day'));
        }

        return date('Y-m-d');
    }

    /**
     * Get the last weeks first & last day
     *
     * @return array
     */
    private function lastWeek()
    {
        return [
            'start' => now()->startOfWeek()->subWeek()->toDateString(),
            'end' => now()->endOfWeek()->subWeek()->toDateString(),
        ];
    }

    /**
     * Get the last months
     *
     * @return array
     */
    private function lastMonth()
    {
        return [
            'start' => now()->startOfMonth()->subMonth()->toDateString(),
            'end' => now()->endOfMonth()->subMonth()->toDateString(),
        ];
    }

    /**
     * Get the last months
     *
     * @return array
     */
    private function lastYear()
    {
        return [
            'start' => now()->startOfYear()->subYear()->toDateString(),
            'end' => now()->endOfYear()->subYear()->toDateString(),
        ];
    }

    /**
     * Get the last weeks first & last day
     *
     * @return array
     */
    private function currentWeek()
    {
        return [
            'start' => now()->startOfWeek()->toDateString(),
            'end' => now()->endOfWeek()->toDateString(),
        ];
    }

    /**
     * Get the current month
     *
     * @return array
     */
    private function currentMonth()
    {
        return [
            'start' => now()->startOfMonth()->toDateString(),
            'end' => now()->endOfMonth()->toDateString(),
        ];
    }

    /**
     * Get the current year
     *
     * @return array
     */
    private function currentYear()
    {
        return [
            'start' => now()->startOfYear()->toDateString(),
            'end' => now()->endOfYear()->toDateString(),
        ];
    }

    /**
     * Arraying the processed data
     *
     * @return array
     */
    public function getArray()
    {
        if (! $this->return) {
            return [];
        } elseif (is_array($this->return)) {
            return $this->return;
        }

        if ($this->tempKey) {
            return [
                $this->tempKey => $this->return,
            ];
        }

        return [
            'value' => $this->return,
        ];
    }

    /**
     * Updates the $return property
     *
     * @param  mixed  $value
     * @param  string  $key
     * @return void
     */
    private function setReturn($value, $key)
    {
        if ($this->return === null) {
            $this->tempKey = $key;
            $this->return = $value;
        } elseif (is_array($this->return)) {
            $this->return[$key] = $value;
        } else {
            $tempVal = $this->return;
            $this->return = [];
            $this->return[$this->tempKey] = $tempVal;
            $this->return[$key] = $value;
        }
    }

    /**
     * Returns the final processed value
     *
     * @return mixed
     */
    public function get()
    {
        return $this->return;
    }

    /**
     * Returns data as API response
     *
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response($this->get());
    }

    /**
     * First day of the current month
     *
     * @return string
     */
    private function firstDayOfTheMonth()
    {
        return date('m-01-Y');
    }

    /**
     * Last day of the current month
     *
     * @return string
     */
    private function lastDayOfTheMonth()
    {
        return date('m-t-Y');
    }

    /**
     * Tomorrow date
     *
     * @return string
     */
    private function tomorrow()
    {
        return $this->offsetDate('+1');
    }

    /**
     * 1-31 day from date
     *
     * @param  string  $date
     * @return int
     */
    private function getDay($date)
    {
        return (int) date('d', strtotime($date));
    }

    /**
     * Get Month from date
     *
     * @param  string  $date
     * @return int
     */
    private function getMonth($date)
    {
        return (int) date('m', strtotime($date));
    }

    /**
     * Processes return value and return itself
     *
     * @param  mixed  $data
     * @param  string  $key
     * @return mixed
     */
    private function complete($data, $key, $returnThis = true)
    {
        $this->setReturn($data, $key);
        if ($returnThis) {
            return $this;
        }

        return $data;
    }

    /**
     * Calculates growth rates
     *
     * @param  float  $start
     * @param  float  $end
     * @return mixed
     */
    private function growthRate($present, $past)
    {
        if (! $present && ! $past) {
            return null;
        } elseif ($past == 0) {
            return '&#8734;';
        }

        return round(($present - $past) / $past * 100);
    }

    /**
     * Returns value from the array
     *
     * @param  string  $key
     * @return mixed
     */
    private function getValue($key)
    {
        if ($key && $key != '' && isset($this->return[$key])) {
            return $this->return[$key];
        }

        return null;
    }

    /**
     * Get the limit
     *
     * @return int
     */
    private function getLimit()
    {
        return $this->limit;
    }

    /**
     * Get vendor id
     *
     * @return int
     */
    private function getVendorId()
    {
        if (! $this->vendorId) {
            $this->vendorId = auth()->user()->vendor()->vendor_id ?? auth()->user()->id;
        }

        return $this->vendorId;
    }
}
