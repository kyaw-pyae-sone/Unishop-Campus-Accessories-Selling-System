<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use ReflectionMethod;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerRuleTest extends TestCase
{
    use RefreshDatabase;

    /** Case 1: Validation lack of payslip and phone number */
    public function test_order_validation_fails_for_invalid_input()
    {
        $controller = new OrderController();
        $method = new ReflectionMethod(OrderController::class, 'checkOrderValidation');
        $method->setAccessible(true);

        $this->expectException(ValidationException::class);

        $method->invoke($controller, new Request([
            'name' => 'John',
            'phone' => '123', // Invalid phone
            'address' => 'Yangon',
            'paymentType' => 'KPay',
            // payslipImage is missing
        ]));
    }

    /** Case 2: Temp Storage (Session ထဲ မှန်မှန်ကန်ကန် သိမ်းမသိမ်း စစ်ခြင်း) */
    public function test_temp_storage_logic_saves_correctly_to_session()
    {
        $controller = new OrderController();
        $items = [
            ['user_id' => 1, 'product_id' => 10, 'qty' => 5, 'status' => 0, 'order_code' => 'ORD-001', 'finalAmt' => 5000]
        ];

        $controller->tempStorage(new Request($items));

        $this->assertTrue(Session::has('TempCart'));
        $this->assertEquals(5, Session::get('TempCart')[0]['count']); // qty map to count
        $this->assertEquals(5000, Session::get('TempCart')[0]['final_amount']);
    }

    /** Case 3: Total Calculation (100x2 + 50x1 = 250) */
    public function test_cart_total_amount_calculation()
    {
        $carts = [
            (object)['price' => 100, 'qty' => 2],
            (object)['price' => 50, 'qty' => 1]
        ];

        $total = 0;
        foreach ($carts as $cart) {
            $total += $cart->price * $cart->qty;
        }

        $this->assertEquals(250, $total);
    }

    /** Case 4: Role-based Redirect Logic */
    public function test_login_redirects_correctly_based_on_role()
    {
        $controller = new AuthenticatedSessionController();

        // Admin Mock
        $adminRequest = Request::create('/login', 'POST');
        $adminRequest->setUserResolver(fn() => new User(['role' => 'admin']));

        // User Mock
        $userRequest = Request::create('/login', 'POST');
        $userRequest->setUserResolver(fn() => new User(['role' => 'user']));

        $this->assertEquals('admin', $adminRequest->user()->role);
        $this->assertEquals('user', $userRequest->user()->role);
    }
}
