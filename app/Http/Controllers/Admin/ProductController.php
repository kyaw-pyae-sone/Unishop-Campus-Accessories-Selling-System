<?php

// declare namespace
namespace App\Http\Controllers\Admin;

// models namespace
use App\Models\Category;
use App\Models\Product;

// controller namespaces
use App\Http\Controllers\Controller;

// return type namespace
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    //create
    public function create(): Factory|View
    {
        $categories = Category::select('id', 'name')->get();
        return view("admin.home.product.create", compact("categories"));
    }

    //add
    public function add(Request $request): RedirectResponse
    {
        $this -> checkValidation($request, "create");

        $data = $this -> getData($request);

        if($request -> hasFile("image")){
            $fileName = uniqid() . $request->file("image")->getClientOriginalName();
            $request->file("image")->move(public_path() . "/productImage/", $fileName);

            $data["photo"] = $fileName;
        }

        Product::create($data);

        Alert::success("Success", "Product Created Successfully!!!");

//        dd($request -> file("image") -> getClientOriginalName());

        return back();
    }

    //list
    public function list($action = "default"): Factory|View
    {
//        dd($action);

        $products = Product::select("products.id", "photo", "products.name", "price", "stock", "description", "categories.name as category_name" )
                            -> leftJoin("categories", "categories.id", "=", "products.category_id")
                            -> when( $action == "low", function ($query) {
                                $query -> where("stock", "<=", "3");
                            })
                            -> when( request("searchKey"), function($query) {
                                $query -> whereAny(["products.name", "products.price", "categories.name"], "like", "%" . request("searchKey") . "%");
                            })
                            -> orderby("products.created_at", "DESC")
                            -> paginate(5);

        return view("admin.home.product.list", compact("products"));
    }

    //detail
    public function detail($id): Factory|View
    {
        $product = Product::where("id", $id)->first();
        $categories = Category::select('id', 'name')->get();

        return view("admin.home.product.detail", compact("product", "categories"));
    }

    //edit
    public function edit($id): Factory|View
    {
        $product = Product::where("id", $id)->first();
        $categories = Category::select('id', 'name')->get();

        return view("admin.home.product.edit", compact("product", "categories"));
    }

    //update
    public function update(Request $request): RedirectResponse
    {
        $this -> checkValidation($request, "update");

        $data = $this -> getData($request);

        if( $request -> hasFile("image")){
            $oldImage = $request -> oldImage;

            if(file_exists(public_path("productImage/" . $oldImage))){
                unlink(public_path( "productImage/" . $oldImage));
            }

            $fileName = uniqid() . $request->file("image")->getClientOriginalName();
            $request -> file("image")->move(public_path() . "/productImage/", $fileName);
            $data["photo"] = $fileName;
        }

        Product::where("id", $request -> productId) -> update($data);

        Alert::success("Done", "Product Updated Successfully!!!");

        return to_route("product#list");
    }

    //delete
    public function delete($id): RedirectResponse
    {
        $product = Product::where("id", $id);
        $oldImage = $product -> value("photo");

        if(file_exists(public_path("productImage/" . $oldImage))){
            unlink(public_path( "productImage/" . $oldImage));
        }

        try {
            $product -> delete();

            Alert::success("Done", "Product Deleted Successfully!!!");
        }catch (Exception){
            Alert::error('Sorry', 'Something Went Wrong!!!');
        }

        return back();
    }

    //validation
    private function checkValidation($request, $task): void
    {
        $rules = [
            "name" => [ "required",
                        "min:3",
                        "max:150",
                        "unique:products,name,".$request->productId],
            "categoryId" => ["required"],
            "price" => ["required",
                        "numeric",
                        "gt:1000",],
            "stock" => ["required",
                        "integer",
                        "min:0",],
            "description" => ["required",
                              "string",
                              "min:20",
                              "max:1000",],
        ];

        $rules["image"] = $task == "update" ? ["file", "image", "mimes:jpeg,png,jpg,gif,svg"] : ["required", "file", "image", "mimes:jpeg,png,jpg,gif,svg"];

        $request -> validate($rules);
    }

    //get data
    private function getData($request): array
    {
        return [
            "name" => $request-> name,
            "price" => $request -> price,
            "category_id" => $request -> categoryId,
            "description" => $request -> description,
            "stock" => $request -> stock
        ];
    }

}
