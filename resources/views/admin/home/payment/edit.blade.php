@extends("admin.layouts.master");

@section("title", "Edit Payment")

@section("content")
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Payment</h1>
        </div>

        <div class="">
            <div class="row">
                <div class="col-4 offset-4">
                    <a href="{{ route("payment#list") }}" class="btn"><i class="fa-solid fa-arrow-left"></i> Back</a>
                    <div class="card">
                        <div class="card-body shadow">
                            <form action="{{ route("payment#update") }}" method="post" class="p-3 rounded">
                                @csrf
                                <div class="mb-3">
                                    <input type="hidden" name="id" value="{{ $payment -> id }}">
                                    <input type="text" name="accountNumber" value="{{ old("accountNumber", $payment -> account_number) }}" class=" form-control @error("accountNumber") is-invalid @enderror"
                                           placeholder="Account Number...">
                                    @error("accountNumber")
                                    <small class="text-danger invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <input type="text" name="accountName" value="{{ old("accountName", $payment -> account_name) }}" class=" form-control @error("accountName") is-invalid @enderror"
                                           placeholder="Account Name...">
                                    @error("accountName")
                                    <small class="text-danger invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <input type="text" name="accountType" value="{{ old("accountType", $payment -> account_type) }}" class=" form-control @error("accountType") is-invalid @enderror"
                                           placeholder="Account Type...">
                                    @error("accountType")
                                    <small class="text-danger invalid-feedback">{{ $message }}</small>
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
