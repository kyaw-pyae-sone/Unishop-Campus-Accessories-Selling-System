<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Http\Request;
use ReflectionMethod;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminRuleTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Case 1: Testing Payment Method Validation Works Correctly
     */
    public function test_payment_validation_rules_are_defined_correctly(){
        $paymentController = new PaymentController();
        $validationMethod = new ReflectionMethod(PaymentController::class, "checkPaymentValidation");
        $validationMethod -> setAccessible(true);

        $this -> expectException(\Illuminate\Validation\ValidationException::class);

        $request = new Request([]);

        $validationMethod -> invoke($paymentController, $request);

    }

    // Case 2: Testing Account Input Validation Require Corrrectly
    public function test_admin_validation_fails_if_inputs_are_empty(){
        $accountController = new AccountController();
        $validationMethod = new ReflectionMethod(AccountController::class, 'checkAccountValidation');
        $validationMethod -> setAccessible(true);

        $this->expectException(ValidationException::class);
        $validationMethod->invoke($accountController, new Request([]));
    }

    // Case 3: Testing matching password and confirm password
    public function test_admin_validation_fails_if_passwords_do_not_match()
    {
        $accountController = new AccountController();
        $validationMethod = new ReflectionMethod(AccountController::class, 'checkAccountValidation');
        $validationMethod->setAccessible(true);

        $this->expectException(ValidationException::class);
        $validationMethod->invoke($accountController, new Request([
            'name' => 'Aung Aung',
            'email' => 'aung@gmail.com',
            'password' => 'password123',
            'confirmPassword' => 'wrongpassword'
        ]));
    }

    // Case 4: Testing if price < 1000, will reject
    public function test_product_validation_fails_if_price_is_less_than_1000(){
        $productController = new ProductController();
        $validationMethod = new ReflectionMethod(ProductController::class, 'checkValidation');
        $validationMethod -> setAccessible(true);

        $this->expectException(ValidationException::class);
        $validationMethod->invoke($productController, new Request([
            'name' => 'New Item',
            'categoryId' => 1,
            'price' => 900, // lower than 1000
            'stock' => 10,
            'description' => 'This is a long enough description for the test.'
        ]), 'create');
    }

    // Case 5: Testing whether the system validate stock is negative
    public function test_product_validation_fails_if_stock_is_negative(){
        $controller = new ProductController();
        $method = new ReflectionMethod(ProductController::class, 'checkValidation');
        $method->setAccessible(true);

        $this->expectException(ValidationException::class);
        $method->invoke($controller, new Request([
            'stock' => -5, // negative value
        ]), 'create');
    }

    // Case 6, Testing unique name category
    public function test_category_validation_rules_exist(){
        $controller = new CategoryController();
        $method = new ReflectionMethod(CategoryController::class, 'checkCategoryValidation');
        $method->setAccessible(true);

        // အနည်းဆုံးတော့ 'required' rule ကြောင့် error တက်ရမယ်
        $this->expectException(ValidationException::class);
        $method->invoke($controller, new Request(['categoryName' => '']));
    }
}
