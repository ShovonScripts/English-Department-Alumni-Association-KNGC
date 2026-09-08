<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\HomeSliderImage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HomeSliderImage>
 */
class HomeSliderImageFactory extends Factory
{
    protected $model = HomeSliderImage::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'image_path' => 'slider/' . $this->faker->uuid() . '.jpg',
            'alt_text' => $this->faker->sentence(4),
            'sort_order' => $this->faker->numberBetween(0, 100),
            'is_active' => true,
        ];
    }
}
