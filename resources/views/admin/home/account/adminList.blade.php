@extends("admin.layouts.master");

@section("title", "Admin List");

@section("content")
    <div class="container">
        <div class=" d-flex justify-content-between my-2">
            <a href="{{ route("account#listUser") }}"> <button class=" btn btn-sm btn-secondary  "> User List</button> </a>
            <div class="">
                <form action="" method="get">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="searchKey" value="{{ request("searchKey") }}" class=" form-control"
                               placeholder="Enter Search Key...">
                        <button type="submit" class=" btn bg-dark text-white"> <i
                                class="fa-solid fa-magnifying-glass"></i> </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-hover shadow-sm text-center">
                    <thead class="bg-primary text-white">
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Created Date</th>
                        <th>Platform</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                        @if( count($admins))
                            @foreach( $admins as $admin)
                                <tr class="">
                                    <td><img src="{{ asset($admin -> profile != null ? "admin/profile/" . $admin -> profile : "admin/img/undraw_profile.svg" ) }}" class="img-thumbnail w-50" alt="hello"></td>
                                    <td>{{ $admin -> name }}</td>
                                    <td>{{ $admin -> email }}</td>
                                    <td>{!! is_null($admin -> address) ? '<i class="fa-solid fa-circle-xmark text-danger"></i>' : e($admin -> address) !!}

                                    </td>
                                    <td>{!! $admin -> phone != null ? $admin -> phone : '<i class="fa-solid fa-circle-xmark text-danger"></i>'  !!}</td>
                                    <td><span class="btn btn-sm bg-danger text-white rounded shadow-sm">{{ $admin -> role }}</span></td>

                                    <td>{{ $admin -> created_at -> format('j F, Y') }}</td>
                                    <td>

                                        @switch($admin -> provider)
                                            @case("google")
                                                <i class="text-primary fa-brands fa-google"></i>
                                            @break

                                            @case("github")
                                                <i class="text-primary fa-brands fa-github"></i>
                                            @break

                                            @default
                                                <i class="text-primary fa-solid fa-right-to-bracket"></i>
                                        @endswitch
                                    </td>
                                    <td>
                                        @if($admin -> role != "superadmin")
                                            <button class="btn btn-outline-danger" onclick="showAlert({{ $admin -> id }})"><i class="fa-solid fa-trash-can"></i></button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8">
                                    <h5 class="text-muted text-center">There is no data <i class="text-primary fa-solid fa-face-frown"></i></h5>
                                </td>
                            </tr>
                        @endif

                    </tbody>
                </table>

                {{ $admins -> links() }}

                <span class=" d-flex justify-content-end"></span>

            </div>
        </div>
    </div>
@endsection

@section("js-script")
    <script>
        function showAlert(id){
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
                    location.href = "/admin/account/delete/" + id;
                }
            });
        }
    </script>
@endsection
