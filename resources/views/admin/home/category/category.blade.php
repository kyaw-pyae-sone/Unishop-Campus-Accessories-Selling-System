@extends("admin.layouts.master");

@section("title", "Category")

@section("content")
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Category List</h1>
        </div>

        <div class="">
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-body shadow">
                            <form action="{{ route("category#create") }}" method="post" class="p-3 rounded">
                                @csrf
                                <div>
                                    <input type="text" name="categoryName" value="{{ old("categoryName") }}" class=" form-control @error("categoryName") is-invalid @enderror"
                                    placeholder="Category Name...">
                                    @error("categoryName")
                                        <small class="text-danger ivalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                                <input type="submit" value="Create" class="btn btn-outline-primary mt-3">
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col ">
                    <table class="table table-hover shadow-sm ">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Created Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ( $categories as $category )
                            <tr>
                                <td>{{ $category -> id }}</td>
                                <td>{{ $category -> name }}</td>
                                <td>{{ $category -> created_at }}</td>
                                <td>
                                    <a href="{{ route("category#edit", $category -> id) }}" class="btn btn-sm btn-outline-secondary"> <i
                                            class="fa-solid fa-pen-to-square"></i> </a>
                                    <button type="button" href="" class="btn btn-sm btn-outline-danger" onclick="showAlert({{ $category -> id }})" > <i
                                            class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach


                        </tbody>
                    </table>

                    {{ $categories -> links() }}
                    <span class=" d-flex justify-content-end"></span>

                </div>
            </div>
        </div>

    </div>
@endsection

@section("js-script")
<script>
    function showAlert($id){
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = '/admin/category/delete/' + $id;
            }
        });
    }
</script>
@endsection
