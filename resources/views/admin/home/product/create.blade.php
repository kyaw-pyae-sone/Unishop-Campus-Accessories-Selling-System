@extends("admin.layouts.master");

@section("title", "Add Product");

@section("content")
<div class="container">
    <div class="row">
        <h3 class="col-8 offset-2">Create Product</h3>
        <div class="col-8 offset-2 card p-3 shadow-sm rounded">
            <form action="{{ route("product#add")  }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <div class="text-center">
                            <img class="img-profile mb-1 w-25 text-center rounded shadow-sm" id="output" src="{{ asset("/admin/img/product-thumbnail.png") }}" alt="product_image">
                        </div>
                        <input type="file" name="image" id="" accept="image/*" class="form-control mt-1 @error("image") is-invalid @enderror" value="{{ old("image") }}" onchange="loadFile(event)">
                        @error("image")
                            <small class="text-danger invalid_feedback">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" value="{{ old("name") }}" class="form-control @error("name") is-invalid @enderror"
                                       placeholder="Enter Product Name...">
                                @error("name")
                                    <small class="text-danger invalid_feedback">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">Category Name</label>
                                <select name="categoryId" id="" class="form-control @error("categoryId") is-invalid @enderror ">
                                    <option value="{{ old("categoryId") }}" disabled selected>Choose Category...</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category -> id  }}" @if(old("categoryId") == $category -> id) selected @endif >{{ $category -> name }}</option>
                                    @endforeach
                                </select>
                                @error("categoryId")
                                    <small class="text-danger invalid_feedback">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">Price</label>
                                <input type="text" name="price" value="{{ old("price") }}" class="form-control @error("price") is-invalid @enderror"
                                       placeholder="Enter Price...">
                                @error("price")
                                    <small class="text-danger invalid_feedback">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">Stock</label>
                                <input type="text" name="stock" value="{{ old("stock") }}" class="form-control @error("stock") is-invalid @enderror"
                                       placeholder="Enter Stock...">
                                @error("stock")
                                    <small class="text-danger invalid_feedback">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="" cols="30" rows="10" class="form-control @error("description") is-invalid @enderror"
                                  placeholder="Tell Something About Product...">{{ old("description") }}</textarea>
                        @error("description")
                            <small class="text-danger invalid_feedback">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <input type="submit" value="Create Product"
                               class=" btn btn-primary w-100 rounded shadow-sm">
                    </div>
                </div>
            </form>


        </div>

    </div>
</div>
@endsection
