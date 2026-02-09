<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    /** Case: Customer can login and redirect to user home */
    public function test_user_can_login_and_redirect_to_home()
    {
        $user = User::factory()->create(['role' => 'user', 'password' => bcrypt('password123')]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123'
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('user#home'));
    }

    /** Case: Placing order successfully */
    public function test_customer_can_place_order()
    {
        Storage::fake('public');
        $user = User::factory()->create(['role' => 'user']);
        $product = Product::factory()->create();

        // Session ထဲတွင် TempCart ထည့်သွင်းခြင်း
        session(['TempCart' => [[
            "user_id" => $user->id,
            "product_id" => $product->id,
            "count" => 2,
            "status" => 0,
            "order_code" => 'ORD-TEST-1',
        ]]]);

        $payslip = UploadedFile::fake()->create('slip.jpg', 100);

        $response = $this->actingAs($user)->post(route('user#addOrder'), [
            'name' => 'Test Customer',
            'phone' => '09123456789',
            'address' => 'Mandalay',
            'paymentType' => 'KPay',
            'orderCode' => 'ORD-TEST-1',
            'totalAmount' => 7000,
            'payslipImage' => $payslip,
            'confirmed' => true
        ]);

        $this->assertDatabaseHas('orders', ['order_code' => 'ORD-TEST-1']);
        $this->assertDatabaseHas('payment_histories', ['order_code' => 'ORD-TEST-1']);
    }
}
