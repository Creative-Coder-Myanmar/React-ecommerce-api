<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $images = [
            'https://fakestoreapi.com/img/81fPKd-2AYL._AC_SL1500_.jpg',
            'https://fakestoreapi.com/img/71-3HjGNDUL._AC_SY879._SX._UX._SY._UY_.jpg',
            'https://fakestoreapi.com/img/71li-ujtlUL._AC_UX679_.jpg',
            'https://fakestoreapi.com/img/71YXzeOuslL._AC_UY879_.jpg',
            'https://fakestoreapi.com/img/71pWzhdJNwL._AC_UL640_QL65_ML3_.jpg',
            'https://fakestoreapi.com/img/71YAIFU48IL._AC_UL640_QL65_ML3_.jpg'
        ];
        return [
            'url' => fake()->randomElement($images),
            'product_id' => Product::factory()
        ];
    }
}
