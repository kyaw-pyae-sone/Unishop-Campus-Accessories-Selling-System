@extends("admin.layouts.master");

@section("title", "Add Product");

@section("content")
<div class="container">
    <a href="{{ route("product#list") }}" class="btn btn-primary"><i class="fa-solid fa-arrow-left"></i> Back</a>
    <div class="row">
        <h3 class="col-8 offset-2">Product Detail</h3>
        <div class="col-8 offset-2 card p-3 shadow-sm rounded">
            <form action="{{ route("product#update")  }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <div class="text-center">
                            <img class="img-profile mb-1 w-25 text-center rounded shadow-sm" id="output" src="{{ asset("/productImage/" . $product -> photo) }}" alt="product_image">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" value="{{ $product -> name }}" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">Category Name</label>
                                    @foreach($categories as $category)
                                        @if( $product -> category_id == $category -> id )
                                            <input type="text" name="" value="{{ $category -> name }}" class="form-control" disabled>
                                        @endif
                                    @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">Price</label>
                                <input type="text" name="price" value="{{ $product -> price }}" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">Stock</label>
                                <input type="text" name="price" value="{{ $product -> stock }}" class="form-control" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" style="resize: none" rows="10" class="form-control" disabled>{{ $product -> description }}</textarea>
                    </div>

                </div>
            </form>


        </div>

    </div>
</div>
@endsection
