<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Md. Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 05-09-2022
 */

namespace App\Traits\Order;

use App\Models\OrderMeta;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

trait OrderTrait
{
    /**
     * Access meta data directly from the model object
     *
     * OVERRIDING 'Model' default '__get()' method
     *
     * @param  string  $name
     * @return mixed
     */
    public function __get($name)
    {
        if (! isset($this->attributes['id'])) {
            return parent::__get($name);
        }
        $val = parent::__get($name);

        if ($val != null) {
            return $val;
        }

        if (! $this->metaFetched) {
            $this->getMeta();
        }
        if (isset($this->metaArray[$name])) {
            return $this->metaArray[$name];
        }
        if (isset($this->metaArray['meta_' . $name])) {
            return $this->metaArray['meta_' . $name];
        }

        return null;
    }

    /**
     * Get value attribute mutator
     *
     * @return array|string $value
     */
    public function getValueAttribute()
    {
        $value = $this->attributes['value'];
        if ($this->attributes['type'] == 'array') {
            return json_decode($value, 1);
        }

        return $value;
    }

    /**
     * Get metadata array
     *
     * @return array
     */
    public function getMeta()
    {
        if (! isset($this->relations['metadata'])) {
            $this->relations['metadata'] = $this->getMetaCollection();
        }
        $this->metaArray = $this->relations['metadata']->pluck('value', 'key')->toArray();
        $this->metaFetched = true;

        return $this->metaArray;
    }

    /**
     * Return metadata collection of the product
     *
     * @return Collection
     */
    public function getMetaCollection()
    {
        if (! isset($this->relations['metadata'])) {
            $this->relations['metadata'] = $this->metadata()->get();
        }

        return $this->relations['metadata'];
    }

    /**
     * Format order address
     *
     * @param  object  $order
     * @param  string  $prefix
     * @return object address
     */
    private function formatAddress($prefix)
    {
        return $this->metadata()->where('key', 'like', $prefix . '%')
            ->get()
            ->map(function ($order) use ($prefix) {
                $order->key = str_replace($prefix, '', $order->key);

                return $order;
            })->pluck('value', 'key');
    }

    /**
     * Get specific order shipping address
     *
     * @return collection
     */
    public function getShippingAddress()
    {
        return miniCollection($this->formatAddress('shipping_address_')->toArray());
    }

    /**
     * Get specific order billing address
     *
     * @return collection
     */
    public function getBillingAddress()
    {
        return miniCollection($this->formatAddress('billing_address_')->toArray());
    }

    public function updateOrderDownloadData($data = [])
    {
        OrderMeta::updateOrCreate(
            ['order_id' => $this->id, 'key' => 'download_data'],
            ['type' => 'array', 'value' => $data]
        );
    }

    /**
     * grant access
     *
     * @return array|int[]
     */
    public function grantAccess($request = null)
    {
        $downloadData = $this->download_data;
        $orderDownloadData = [];
        $lastId = 1;

        if (! empty($downloadData)) {
            foreach ($downloadData as $data) {
                $orderDownloadData[] = [
                    'id' => $data['id'],
                    'download_limit' => $data['download_limit'],
                    'download_expiry' => $data['download_expiry'],
                    'link' => $data['link'],
                    'download_times' => $data['download_times'],
                    'is_accessible' => $data['is_accessible'],
                    'vendor_id' => $data['vendor_id'],
                    'name' => $data['name'],
                    'f_name' => $data['f_name'],
                ];
                $lastId = (int) $data['id'];
            }
        }

        if (isset($request->product_ids) && is_array($request->product_ids)) {
            foreach ($request->product_ids as $productId) {
                $product = Product::where('id', $productId)->first();
                $downloadable = [];
                $downloadableJs = [];
                if ($product->meta_downloadable == 1) {
                    foreach ($product->meta_downloadable_files as $files) {
                        if (isset($files['url']) && ! empty($files['url'])) {
                            $url = urlSlashReplace($files['url'], ['\/', '\\']);
                            $lastId++;
                            $downloadable[] = [
                                'id' => $lastId,
                                'download_limit' => $product->meta_download_limit,
                                'download_expiry' => $product->meta_download_expiry,
                                'link' => $url,
                                'download_times' => 0,
                                'is_accessible' => 1,
                                'vendor_id' => $product->vendor_id,
                                'name' => $product->name,
                                'f_name' => $files['name'],
                            ];
                            $downloadableJs[] = [
                                'id' => $lastId,
                                'download_limit' => $product->meta_download_limit,
                                'download_expiry' => $product->meta_download_expiry,
                                'link' => route('site.downloadProduct', ['link' => \Crypt::encrypt($url), 'file' => $lastId . ',' . $this->id]),
                                'download_times' => 0,
                                'is_accessible' => 1,
                                'vendor_id' => $product->vendor_id,
                                'name' => $product->name,
                                'f_name' => $files['name'],
                            ];
                        }
                    }
                }

                $downloadable = (array_merge($orderDownloadData, $downloadable));
                $downloadableJs = (array_merge($orderDownloadData, $downloadableJs));

                $this->updateOrderDownloadData($downloadable);
            }
        }

        if (isset($downloadableJs)) {
            return ['status' => 1, 'data' => $downloadableJs];
        }

        return ['status' => 0];
    }

    /**
     * revoke access
     *
     * @return mixed
     */
    public function revokeAccess($request = null)
    {
        $orderMeta = $this->metadata->where('key', 'download_data')->first();

        if (! empty($orderMeta)) {
            $data['status'] = 1;
            $data['message'] = __('The :x has been successfully saved.', ['x' => __('Data')]);
            $downloadArray = [];

            foreach ($orderMeta->value as $download) {
                $isAccessible = $download['is_accessible'];
                if ($download['id'] == $request->data['file_id']) {
                    $isAccessible = 0;
                }
                $downloadArray[] = [
                    'id' => $download['id'],
                    'download_limit' => $download['download_limit'],
                    'download_expiry' => $download['download_expiry'],
                    'link' => $download['link'],
                    'download_times' => $download['download_times'],
                    'is_accessible' => $isAccessible,
                    'vendor_id' => $download['vendor_id'],
                    'name' => $download['name'],
                    'f_name' => $download['f_name'],
                ];
            }

            $this->updateOrderDownloadData($downloadArray);
        }

        return $data;
    }

    /**
     * merge data
     *
     * @return void
     */
    public function downloadDataMerge($ajaxData = [], $vendorId = null)
    {
        $downloadArray = [];
        $downloadData = $this->download_data;
        $orderDownloadData = [];

        foreach ($ajaxData as $key => $download) {
            $downloadArray[$download[0]->id] = [
                'id' => $download[0]->id,
                'download_limit' => $download[1]->download_limit,
                'download_expiry' => $download[2]->download_expiry,
                'link' => $download[3]->link,
                'download_times' => $download[4]->download_times,
                'is_accessible' => $download[5]->is_accessible,
                'vendor_id' => $download[6]->vendor_id,
                'name' => $download[7]->name,
                'f_name' => $download[8]->f_name,
            ];
        }

        if (! empty($downloadData)) {
            foreach ($downloadData as $data) {
                $orderDownloadData[] = [
                    'id' => $data['id'],
                    'download_limit' => isset($downloadArray[$data['id']]) ? $downloadArray[$data['id']]['download_limit'] : $data['download_limit'],
                    'download_expiry' => isset($downloadArray[$data['id']]) ? $downloadArray[$data['id']]['download_expiry'] : $data['download_expiry'],
                    'link' => $data['link'],
                    'download_times' => $data['download_times'],
                    'is_accessible' => $data['is_accessible'],
                    'vendor_id' => $data['vendor_id'],
                    'name' => $data['name'],
                    'f_name' => $data['f_name'],
                ];
            }
        }

        $this->updateOrderDownloadData($orderDownloadData);
    }

    /**
     * check valid file
     *
     * @return bool
     */
    public function checkValidFile($data = [])
    {
        $flag = false;
        $daysAfterCreate = $this->created_at->diffInDays(\Carbon\Carbon::now());

        if (
            $data['download_times'] < $data['download_limit'] && $daysAfterCreate <= $data['download_expiry']
            || $data['download_limit'] == '' && $daysAfterCreate <= $data['download_expiry']
            || $data['download_times'] < $data['download_limit'] && $data['download_expiry'] == ''
            || $data['download_times'] < $data['download_limit'] && $daysAfterCreate <= $data['download_expiry']
            || $data['download_limit'] == '' && $data['download_expiry'] == ''
            || $data['download_limit'] == '' && $daysAfterCreate <= $data['download_expiry']
            || $data['download_limit'] == '-1' && $data['download_expiry'] == ''
            || $data['download_limit'] == '-1' && $daysAfterCreate <= $data['download_expiry']
        ) {
            $flag = true;
        }

        return $flag;
    }
}
