<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 16-01-2024
 */

namespace App\Services\Product;

use App\Models\Preference;
use Milon\Barcode\DNS1D;
use Milon\Barcode\DNS2D;

class BarcodeGenerator
{
    protected $collection;

    protected $option = [
        'barcode_text' => 0,
        'barcode_type' => 'C128',
        'barcode_color' => '[0,0,0]',
        'barcode_width' => 1,
        'barcode_height' => 33,
    ];

    protected $barcodeData = [];

    protected $regard = '';

    public function __construct($collection, $option, $regard)
    {
        $this->collection = $collection;

        $this->option = array_merge($this->option, $option);
        $this->regard = $regard;

        $this->getDefaultSettings();

        $this->barcodeCollection();
    }

    /**
     * barcode collection
     *
     * @return void
     */
    protected function barcodeCollection()
    {
        $this->collection->each(function ($collection) {
            if ($this->option['barcode_type'] == 'QRCODE' || $this->option['barcode_type'] == 'PDF417' || $this->option['barcode_type'] == 'DATAMATRIX') {
                $barcode = (new DNS2D())->getBarcodePNG((string) $collection->{$this->option['link_to']}, $this->option['barcode_type'], $this->option['barcode_width'], $this->option['barcode_height'], json_decode($this->option['barcode_color'], true), $this->option['barcode_text'] == 1);
            } else {
                $barcode = DNS1D::getBarcodePNG((string) $collection->{$this->option['link_to']}, $this->option['barcode_type'], $this->option['barcode_width'], $this->option['barcode_height'], json_decode($this->option['barcode_color'], true), $this->option['barcode_text'] == 1);
            }

            $this->regradingData($collection, $barcode);
        });

    }

    /**
     * sperate data operation based on regard
     *
     * @return void
     */
    protected function regradingData($collection, $barcode)
    {
        switch ($this->regard) {
            case 'product':
                $this->barcodeData[$collection->id] = [
                    'barcode' => $barcode,
                    'vendor' => $this->option['show_vendor_name'] ? $collection->vendor?->name : null,
                    'name' => $this->option['show_product_name'] == '1' ? $collection->name : null,
                    'image' => $this->option['show_product_image'] == '1' ? $collection->getFeaturedImage('medium') : null,
                    'qty' => request()->product_qty[$collection->id] ?? 1,
                ];
                // no break
            default:
                break;
        }
    }

    /**
     * get barcode data
     *
     * @return array|mixed
     */
    public function getCollection()
    {
        return $this->barcodeData;
    }

    /**
     * default setings
     *
     * @return void
     */
    protected function getDefaultSettings()
    {
        $productPreference = Preference::where('category', 'barcode')->pluck('value', 'field')->toArray();
        $this->option = array_merge($this->option, $productPreference);
    }
}
