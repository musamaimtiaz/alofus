<?php
/**
 * @author tehcvillage <support@techvill.org>
 *
 * @contributor A.H. Millat <[millat.techvill@gmail.com]>
 * @contributor Sakawat Hossain <[sakawat.techvill@gmail.com]>
 *
 * @created 16-05-2022
 */

namespace App\Http\Resources;

use App\Models\AttributeValue;
use App\Models\Category;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ProductFilterResource
{
    /**
     * resource
     *
     * @var mixed
     */
    protected $resource = [];

    /**
     * categories
     *
     * @var mixed
     */
    protected $categories;

    /**
     * brands
     *
     * @var mixed
     */
    protected $brands;

    /**
     * price_range
     *
     * @var array
     */
    protected $price_range = [0, 0];

    /**
     * attributes
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * product single collection
     *
     * @var mixed
     */
    protected $collection;

    /**
     * default of filterable, applied_filter, toArray
     *
     * @var array
     */
    protected $default = [
        'categories' => [],
        'brands' => [],
        'price_range' => [],
        'rating' => [],
        'attributes' => [],
        'keyword' => null,
        'sort_by' => null,
        'showing' => null,
        'b2b' => null,
    ];

    /**
     * query
     *
     * @var mixed
     */
    protected $query;

    /**
     * category path
     *
     * @var null
     */
    public $categoryPath = [];

    /**
     * __construct
     *
     * @param  mixed  $resource
     * @return void
     */
    public function __construct($resource)
    {
        $this->resource = $this->setResource($resource);

        $this->categories = $this->brands = new Collection();

        $this->iterateCollection();
    }

    /**
     * setResource
     *
     * @param  mixed  $resource
     * @return void
     */
    protected function setResource($resource)
    {
        if ($resource instanceof Builder) {

            $this->query = $resource;

            return $resource->get();
        }

        return $resource;
    }

    /**
     * iterateCollection
     *
     * @return void
     */
    protected function iterateCollection()
    {
        $this->resource->each(function ($collection) {
            $this->collection = $collection;
            $this->setFilters();
        });
    }

    /**
     * set possible filters
     * Like: categoreis, brands, price range etc
     *
     * @return void
     */
    protected function setFilters()
    {
        $this->filterCategories();
        $this->filterBrands();
        $this->filterPriceRange();
        $this->filterAttributes();
    }

    /**
     * get model collection
     *
     * @return void
     */
    public function getCollection()
    {
        return $this->resource;
    }

    /**
     * query
     *
     * @return object
     */
    public function query()
    {
        if (! isset($this->query)) {
            throw new Exception('Collection passed, query not found');
        }

        return $this->query;
    }

    /**
     * get all filterable
     *
     * @return void
     */
    public function getFilters()
    {
        $filterable = [
            'categories' => $this->categories->makeHidden(['pivot'])->pluck('name')->toArray(),
            'category_slug' => $this->categories->makeHidden(['pivot'])->pluck('slug')->toArray(),
            'brands' => $this->brands->pluck('name')->toArray(),
            'price_range' => $this->price_range,
            'rating' => 5,
            'attributes' => $this->attributes,
        ];

        // merge filterable with the default array
        return array_merge($this->default, $filterable);
    }

    /**
     * filterable categories from the resource
     *
     * @return void
     */
    protected function filterCategories()
    {
        return $this->categories = $this->categories->merge($this->collection->category);
    }

    /**
     * filterable brands from the resource
     *
     * @return void
     */
    protected function filterBrands()
    {
        if (is_null($this->collection->brand)) {
            return;
        }

        if ($this->brands->isEmpty()) {
            return $this->brands->push($this->collection->brand);
        }

        // If brand not exist on the $this->brand, then push
        if (! $this->brands->contains('id', $this->collection->brand->id)) {
            return $this->brands->push($this->collection->brand);
        }
    }

    /**
     * filterable price range from the resource
     *
     * @return void
     */
    protected function filterPriceRange()
    {
        $price = ! is_null($this->collection->getSalePrice() && ($this->collection->getSalePrice() <= 0))
            ? $this->collection->getPrice() : $this->collection->getSalePrice();

        $min = is_array($price) && isset($price[0]) ? $price[0] : $price;
        $max = is_array($price) && isset($price[1]) ? $price[1] : $price;

        if ($this->price_range[0] == 0 && ! is_null($min) || $min < $this->price_range[0] && ! is_null($min)) {
            $this->price_range[0] = ! is_array($min) ? $min : $this->price_range[0];
        }

        if ($max > $this->price_range[1] && ! is_null($max)) {
            $this->price_range[1] = $max;
        }
    }

    /**
     * filterable attributes from the resource
     *
     * @return void
     */
    protected function filterAttributes()
    {
        foreach ($this->collection->getProductAttributes() as $atr) {
            if ($atr['attribute_id']) {

                // get attribute value using attribute_id
                $attributeValues = AttributeValue::getAll()
                    ->whereIn('id', $atr['value'])
                    ->pluck('value', 'id')->toArray();
            } else {
                $attributeValues = $atr['value'];
            }

            if (isset($this->attributes[$atr['name']])) {

                $formatData = $this->attributes[$atr['name']];

                foreach ($attributeValues as $key => $val) {
                    $formatData[$key] = $val;
                }

                $this->attributes[$atr['name']] = $formatData;
            } else {
                $this->attributes[$atr['name']] = $attributeValues;
            }
        }

        return $this->attributes;
    }

    /**
     * applied filters from request queries
     *
     * @return void
     */
    public function getAppliedFilters()
    {
        $appliedFilterQueries = [];

        foreach (request()->query() as $key => $value) {

            // skip loop if query param not filterable
            // only filterable params $this->default
            if (! array_key_exists($key, $this->default)) {
                continue;
            }

            if ($key == 'attributes') {
                $appliedFilterQueries['attributes'] = $this->appliedAttributeFormat($value);
            } elseif ($key == 'categories') {
                $appliedFilterQueries[$key] = explode(',', $value);
                $category = Category::getAll()->where('name', $value)->where('status', 'Active')->first();
                $parent = null;
                if (! empty($category)) {
                    $parent[] = ['name' => $category->name, 'slug' => $category->slug];
                }

                while (1) {
                    if (! empty($category) && ! empty($category->category)) {
                        $category = $category->category;
                        $parent[] = ['name' => $category->name, 'slug' => $category->slug];
                    } else {
                        break;
                    }
                }

                $this->categoryPath = $parent != null ? array_reverse($parent) : $parent;
            } else {
                $appliedFilterQueries[$key] = explode(',', xss_clean($value));
            }
        }

        return array_merge($this->default, $appliedFilterQueries);
    }

    /**
     * attributes from request query formatter
     *
     * @param  mixed  $value
     * @return void
     */
    protected function appliedAttributeFormat($value)
    {
        $formattedAttribute = [];
        $attributes = explode(';', $value);

        foreach ($attributes as $attribute) {
            $attr = explode(':', $attribute);

            if (isset($attr[0]) && isset($attr[1])) {
                $formattedAttribute[$attr[0]] = explode('_', $attr[1]);
            }
        }

        return $formattedAttribute;
    }

    /**
     * products, filterable, filter_applied in array formatted
     *
     * @return void
     */
    public function toArray()
    {
        return [
            'products' => $this->resource->makeHidden(['category', 'brand', 'metas'])->toArray(),
            'filterable' => $this->getFilters(),
            'filter_applied' => $this->getAppliedFilters(),
        ];
    }
}
