<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Review::class;

    private $reviewStart = 2;

    private $reviewEnd = 5;

    private $reviewUserIds = [];

    private $userIds = [];

    /**
     * Define random digit starting and ending point.
     *
     * @param  int  $start
     * @param  int  $end
     * @return object $this
     */
    public function setPoint($start, $end)
    {
        $this->reviewStart = $start;
        $this->reviewEnd = $end;

        return $this;
    }

    /**
     * Find unique user id for a product.
     *
     * @return int $userId
     */
    public function uniqueUserId()
    {
        $userId = $this->userIds->random();
        if (in_array($userId, $this->reviewUserIds)) {
            return $this->uniqueUserId();
        }

        $this->reviewUserIds[] = $userId;

        return $userId;
    }

    /**
     * Define the model's default state.
     *
     * @return array $reviewData
     */
    public function definition()
    {
        $productIds = Product::select('id')->where('status', 'Published')->whereNotNull('slug')->get()->pluck('id');
        $this->userIds = User::select('id')->get()->pluck('id');
        $status = ['Active', 'Active', 'Inactive', 'Active', 'Active'];
        $reviewData = [];

        if (count($this->userIds) < $this->reviewEnd) {
            $this->reviewEnd = count($this->userIds);
        }

        foreach ($productIds as $id) {
            for ($i = 1; $i <= mt_rand($this->reviewStart, $this->reviewEnd); $i++) {
                $reviewData[] = [
                    'comments' => $this->generateRandomProductComment(),
                    'rating' => mt_rand(1, 5),
                    'reviewed_by' => null,
                    'user_id' => $this->uniqueUserId(),
                    'product_id' => $id,
                    'is_public' => 1,
                    'status' => $status[mt_rand(0, 4)],
                    'created_at' => randomDateBefore(30),
                ];
            }
            $this->reviewUserIds = [];
        }

        return $reviewData;
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

    /**
     * Generate random product comment.
     *
     * @return string $comment
     */
    public function generateRandomProductComment()
    {
        $adjectives = ['Great', 'Awesome', 'Fantastic', 'Amazing', 'Excellent'];
        $nouns = ['product', 'item', 'purchase', 'buy', 'choice'];
        $verbs = ['loved', 'enjoyed', 'appreciated', 'liked', 'admired'];
        $comments = [
            'The {adjective} {noun} is {verb}!',
            'I {verb} this {noun}! {adjective} experience.',
            '{adjective} choice. I {verb} it!',
            'Highly recommend this {noun}. {adjective} product.',
            'I {verb} the {noun}. {adjective} value for money.',
        ];

        $adjective = $adjectives[array_rand($adjectives)];
        $noun = $nouns[array_rand($nouns)];
        $verb = $verbs[array_rand($verbs)];
        $commentTemplate = $comments[array_rand($comments)];

        $comment = str_replace(['{adjective}', '{noun}', '{verb}'], [$adjective, $noun, $verb], $commentTemplate);

        return ucfirst($comment); // Capitalize the first letter
    }
}
