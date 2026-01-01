@extends("admin.layouts.master");

@section("content")
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Category</h1>
        </div>

        <div class="">
            <div class="row">
                <div class="col-4 offset-4">
                    <a href="{{ route("category#list") }}" class="btn"><i class="fa-solid fa-arrow-left"></i> Back</a>
                    <div class="card">
                        <div class="card-body shadow">
                            <form action="{{ route("category#update") }}" method="post" class="p-3 rounded">
                                @csrf
                                <div>
                                    <input type="hidden" name="categoryId" value="{{$category -> id}}" />
                                    <input type="text" name="categoryName" value="{{ old("categoryName", $category -> name) }}"
                                    class=" form-control @error('categoryName') is-invalid @enderror "
                                    placeholder="Category Name...">
                                    @error("categoryName")
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <input type="submit" value="Update" class="form-control btn btn-outline-primary mt-3">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

                    {{-- <span class=" d-flex justify-content-end">{{ $categories->links() }}</span> --}}

    </div>
@endsection
