<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    /** Case: Admin can add a new category */
    public function test_admin_can_add_category()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post(route('category#create'), [
            'categoryName' => 'Beverages'
        ]);

        $this->assertDatabaseHas('categories', ['name' => 'Beverages']);
    }

    /** Case: Admin can upload a product with image */
    public function test_admin_can_add_product()
    {
        Storage::fake('public');
        $admin = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create();

        $image = UploadedFile::fake()->create('coffee.jpg', 100);

        $response = $this->actingAs($admin)->post(route('product#add'), [
            'name' => 'Espresso',
            'categoryId' => $category->id,
            'price' => 3500,
            'stock' => 50,
            'description' => 'Strong and dark coffee espresso.',
            'image' => $image
        ]);

        $this->assertDatabaseHas('products', ['name' => 'Espresso']);
    }
}
