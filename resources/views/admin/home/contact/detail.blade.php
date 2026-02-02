@extends("admin.layouts.master");

@section("title", "Messages");

@section("content")
    <div class="container py-4">
        <!-- Back Button & Page Title -->
        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="{{ route("message#list") }}" class="btn btn-white bg-white shadow-sm rounded-circle border p-2 leading-none">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h2 class="h4 mb-0 fw-bold">Feedback Details</h2>
        </div>

        <div class="row g-4 justify-content-center">
            <div class="col-12 col-lg-9">

                <!-- User Information Section -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-3">

                                <img src="{{ asset( $user -> profile != null ? "user/profile/" . $user -> profile : "user/img/avatar.jpg" ) }}" class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center border border-primary border-opacity-25"
                                     style="width: 50px; height: 50px;">
                            <div>
                                <h5 class="mb-0 fw-bold">{{ $user -> name }}</h5>
                                <p class="text-muted mb-0 small text-break">{{ $user -> email }}</p>
                            </div>
                        </div>
                        <button class="btn btn-outline-danger px-4 rounded-3 fw-bold btn-sm" onclick="showAlert({{ $message -> id }})">
                            <i class="fa-solid fa-trash-can"></i> Delete Feedback
                        </button>
                    </div>
                </div>

                <!-- Feedback Message Section -->
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <span class="text-uppercase fw-bold text-muted small">Feedback Message</span>
                        <span class="badge bg-light text-secondary border fw-bold">{{ $message -> created_at }}</span>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <div class="border-start border-4 border-primary ps-4">
                            <p class="fs-5 text-dark lh-base font-italic mb-0">
                                {{ $message -> message }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Status Management Section -->
{{--                <div class="row">--}}
{{--                    <div class="col-md-6">--}}
{{--                        <div class="card border-0 shadow-sm rounded-4 h-100">--}}
{{--                            <div class="card-body p-4">--}}
{{--                                <h6 class="fw-bold text-dark mb-4">Update Management Status</h6>--}}
{{--                                <div class="d-grid gap-2">--}}
{{--                                    <!-- Pending -->--}}
{{--                                    <button class="btn btn-light border text-start d-flex align-items-center justify-content-between p-3 rounded-3 transition-all">--}}
{{--                                        <div class="d-flex align-items-center gap-3">--}}
{{--                                            <div class="rounded-circle bg-warning shadow-sm" style="width: 10px; height: 10px;"></div>--}}
{{--                                            <span class="fw-semibold">Pending</span>--}}
{{--                                        </div>--}}
{{--                                    </button>--}}

{{--                                    <!-- In Progress (Highlighted) -->--}}
{{--                                    <button class="btn btn-primary bg-opacity-10 text-primary border-primary p-3 rounded-3 d-flex align-items-center justify-content-between">--}}
{{--                                        <div class="d-flex align-items-center gap-3">--}}
{{--                                            <div class="rounded-circle bg-primary shadow-sm" style="width: 10px; height: 10px;"></div>--}}
{{--                                            <span class="fw-bold">In Progress</span>--}}
{{--                                        </div>--}}
{{--                                        <i class="bi bi-check-circle-fill"></i>--}}
{{--                                    </button>--}}

{{--                                    <!-- Resolved -->--}}
{{--                                    <button class="btn btn-light border text-start d-flex align-items-center justify-content-between p-3 rounded-3 transition-all">--}}
{{--                                        <div class="d-flex align-items-center gap-3">--}}
{{--                                            <div class="rounded-circle bg-success shadow-sm" style="width: 10px; height: 10px;"></div>--}}
{{--                                            <span class="fw-semibold">Resolved</span>--}}
{{--                                        </div>--}}
{{--                                    </button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

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
