@extends("admin.layouts.master");

@section("title", "Messages");

@section("content")
    <div class="container">
        <div class=" d-flex justify-content-between my-2">
            <div class="">
                <button disabled class=" btn btn-secondary rounded shadow-sm"> <i class="fa-solid fa-database"></i>
                    Message Count ({{ count($messages) }}) </button>
                <a href="{{ route("message#list")  }}" class=" btn btn-outline-primary  rounded shadow-sm">All Messages</a>
                <a href="{{ route("message#list", "unread") }}" class=" btn btn-outline-danger  rounded shadow-sm">Unread Messages</a>
                <a href="{{ route("message#list", "read") }}" class=" btn btn-outline-success  rounded shadow-sm">Read Messages</a>
            </div>
            <div class="">
                <form action="" method="get">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="searchKey" value="{{ request("searchKey") }}" class=" form-control"
                               placeholder="Enter Search Key...">
                        <button type="submit" class=" btn bg-dark text-white"> <i
                                class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col" >
{{--                @if( count($messages))--}}
{{--                    @foreach( $messages as $message)--}}
{{--                        <div class="card px-3">--}}
{{--                            <div class="d-flex align-items-center">--}}
{{--                                <img src="{{ asset( $message -> profile != null ? "user/profile/" . $message -> profile : "user/img/avatar.jpg" ) }}" class="img-fluid rounded-circle p-3"--}}
{{--                                     style="width: 100px; height: 100px;">--}}
{{--                                <div class="d-flex justify-content-between align-items-center h-100 w-100">--}}
{{--                                    <h5 class="font-weight-bold">{{ is_null($message -> name) ? $message -> nickname : $message -> name  }}</h5>--}}
{{--                                    <p class="" style="font-size: 14px;">{{ $message -> created_at -> format("j-F-Y") }}</p>--}}
{{--
{{--                                </div>--}}
{{--                                --}}{{--                                <p class="text-muted">{{ $comment -> message }}</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <hr>--}}
{{--                    @endforeach--}}
{{--                @else--}}
{{--                    <h4 class="text-center my-5">There is No Comment!</h4>--}}

{{--                    <hr>--}}
{{--                @endif--}}
                <table class="table table-hover shadow-sm">
                    <thead class="bg-primary text-white">
                    <tr>
                        <th>Profile</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    @if(count($messages) !=0 )
                        @foreach( $messages as $message )
                            <tr class="">
                                <td>
                                    <img src="{{ asset( $message -> profile != null ? "user/profile/" . $message -> profile : "user/img/avatar.jpg" ) }}" class="img-fluid rounded-circle p-3"--}}
                                             style="width: 100px; height: 100px;">
                                </td>
                                <td class="">{{ $message -> name }}</td>
                                <td>{{ $message -> email }}</td>
                                <td class="col-2 fs-5">
{{--                                    <button type="button" class="btn btn-secondary position-relative">--}}
{{--                                        @if($message -> stock <= 3)--}}
{{--                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">--}}
{{--                                                    Low amt stock--}}
{{--                                            </span>--}}
{{--                                        @endif--}}
{{--                                    </button>--}}
                                    @if( $message -> status == "unread")
                                        <span class="badge text-bg-danger">{{ $message -> status }}</span>
                                    @else
                                        <span class="badge text-bg-success">{{ $message -> status }}</span>
                                    @endif
                                </td>
                                <td>{{$message -> created_at -> format("j-F-Y")}}</td>
                                <td>

                                    <a href="{{ route("message#detail", $message -> message_id) }}" class="btn btn-sm btn-outline-primary"> <i
                                            class="fa-solid fa-eye"></i> </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="showAlert({{ $message -> message_id }})"> <i
                                            class="fa-solid fa-trash"></i>
                                    </button>
                                </td>

                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7">
                                <h5 class="text-muted text-center">There is no feedbacks</h5>
                            </td>
                        </tr>
                    @endif

                    </tbody>
                </table>
                {{$messages -> links()}}


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
                    location.href = "/admin/message/delete/" + id;
                }
            });
        }
    </script>
@endsection

