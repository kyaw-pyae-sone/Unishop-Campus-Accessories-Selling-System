<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Faker\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    // Category List
    public function list(): Factory|View {
        $categories = Category::select("id","name", "created_at") -> orderby("created_at", "desc") -> paginate(5);

        return view("admin.home.category.category", compact("categories"));
    }

    // Payment Create
    public function create(Request $request): RedirectResponse {

        $this -> checkCategoryValidation($request);
        $data = $this -> getData($request);

        try{
            Category::create($data);
            Alert::success("Done", "Category Added Successfully!!!");
        }catch (\Exception $exception){
            Alert::error("Fail", "Something Went Wrong!!!");
        }

        return back();
    }

    // Payment Delete
    public function delete($id): RedirectResponse{

        try {
            Category::destroy($id);

            Alert::success("Done", "Category Deleted Successfully!!!");
        }catch (\Exception $exception){
            Alert::error("Fail", "Something Went Wrong!!!");
        }

        return back();
    }

    // Payment Edit
    public function edit($id, Request $request): Factory|View {
        $category = Category::where("id", $id)->first();

        return view("admin.home.category.edit", compact("category"));
    }

    // Payment update
    public function update(Request $request): RedirectResponse {
        $this -> checkCategoryValidation($request);
        $data = $this -> getData($request);

        try {
            Category::where("id", $request -> categoryId) -> update($data);

            Alert::success("Done", "Payment Updated Successfully!!!");
        }catch (\Exception $exception){
            Alert::error("Fail", "Something Went Wrong!!!");
        }

        return back();
    }

    // Validation
    private function checkCategoryValidation($request): void {
        $rules = [
            "categoryName" => ["required", "string", "unique:categories,name,".$request -> categoryId],
        ];

        $request->validate($rules);
    }

    // Get Data
    private function getData($request): array{
        return [
            "name" => $request["categoryName"]
        ];
    }
}
