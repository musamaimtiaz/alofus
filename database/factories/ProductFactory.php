<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Vendor;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $vendor = Vendor::all()->pluck('id');
        $brand = Brand::all()->pluck('id');
        $price = $this->faker->numberBetween($min = 300, $max = 3000);
        $discount = $this->faker->numberBetween($min = 5, $max = 50);

        return [
            'code' => $this->faker->randomDigit(),
            'name' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'description' => $this->faker->randomHtml(2, 3),
            'summary' => $this->faker->address(),
            'video_url' => $this->faker->url(),
            'review_count' => $this->faker->numberBetween(1, 5),
            'review_average' => null,
            'available_from' => $this->faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now', $timezone = null),
            'available_to' =>  date('Y-m-d', strtotime('+15 days')),
            'vendor_id' => $this->faker->randomElement($vendor),
            'shop_id' => null,
            'brand_id' => $this->faker->randomElement($brand),
            'status' => 'Active',
            'total_wish' =>  $this->faker->numberBetween($min = 3, $max = 30),
            'regular_price' => $price,
            'discount_amount' => $discount,
            'discount_type' => 'Flat',
            'discounted_price' => $price - $discount,
            'discount_from' => null,
            'discount_to' => null,
            'maximum_discount_amount' => $discount,
            'minimum_order_for_discount' => null,
            'sku' => $this->faker->name(),
            'is_inventory_enabled' => 0,
            'item_quantity' => null,
            'stock_availability' => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'updated_at' => null,
            ];
        });
    }
}
