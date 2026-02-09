<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SuperadminTest extends TestCase
{
    use RefreshDatabase;

    /** Case: Superadmin can add a new payment method */
    public function test_superadmin_can_add_payment_method()
    {
        $superadmin = User::factory()->create(['role' => 'superadmin']);

        $response = $this->actingAs($superadmin)->post(route('payment#create'), [
            'accountName' => 'U Ba',
            'accountNumber' => '09123456789',
            'accountType' => 'KBZPay'
        ]);

        $this->assertDatabaseHas('payments', ['account_name' => 'U Ba']);
        $response->assertStatus(302); // Redirect back or to list
    }

    /** Case: Superadmin can create a new Admin account */
    public function test_superadmin_can_add_new_admin()
    {
        // ၁။ Exception နဲ့ Middleware တွေကို ပိတ်ထားမယ်
        // $this->withoutMiddleware();
        // $this->withoutExceptionHandling();

        $superadmin = User::factory()->create(['role' => 'superadmin']);

        // ၂။ route() function မသုံးဘဲ URL အတိုင်း အတိအကျ ရေးပါ (prefix စာလုံးပေါင်း သေချာပါစေ)
        $response = $this->actingAs($superadmin)->post('/admin/account/store/newAdmin', [
            'name' => 'New Admin',
            'email' => 'admin@gmail.com',
            'password' => 'password123',
            'confirmPassword' => 'password123',
            'role' => 'admin'
        ]);

        // ၃။ Database ထဲ ရောက်၊ မရောက် စစ်မယ်
        $this->assertDatabaseHas('users', [
            'email' => 'admin@gmail.com',
            'role' => 'admin'
        ]);
    }
}

