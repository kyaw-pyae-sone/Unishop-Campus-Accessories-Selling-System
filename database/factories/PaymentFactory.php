<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }

    // public function definition(): array
    // {
    //     return [
    //         'account_name' => $this->faker->name(), // ပိုင်ရှင်အမည် အတု (ဥပမာ- U Ba)
    //         'account_number' => $this->faker->numerify('09#########'), // ဖုန်းနံပါတ် သို့မဟုတ် အကောင့်နံပါတ် အတု
    //         'account_type' => $this->faker->randomElement(['KPay', 'WavePay', 'CBPay', 'AYAPay']), // Payment အမျိုးအစား တစ်ခုခုကို ကျပန်းရွေးမည်
    //     ];
    // }
}
