@extends("admin.layouts.master");

@section("title", "Order Detail");

@section("content")
    <!-- Begin Page Content -->
    <div class="container-fluid">


        <a href="{{ route("order#list") }}" class=" text-black m-3"> <i class="fa-solid fa-arrow-left-long"></i> Back</a>

        <!-- DataTales Example -->


        <div class="row">
            <div class="card col-5 shadow-sm m-4 p-0 col">
                <div class="card-header py-3">
                    <div class="d-flex justify-content-between">
                        <div class="">
                            <h6 class="m-0 font-weight-bold text-primary">Customer Information</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body ps-5">
                    <div class="row mb-3">
                        <div class="col-5">Name :</div>
                        <div class="col-7">{{ $orderList[0] -> username }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Phone :</div>
                        <div class="col-7">
                            {{ $orderList[0] -> phone }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Addr :</div>
                        <div class="col-7">
                            {{ $orderList[0] -> address == null? "..." : $orderList[0] -> address }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Order Code :</div>
                        <div class="col-7 text-primary fw-bold" id="orderCode">{{ $orderList[0] -> order_code }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Order Date :</div>
                        <div class="col-7">{{ $orderList[0] -> created_at -> format("j-F-Y") }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Total Price :</div>
                        <div class="col-7"> {{ $paymentHistory -> total_amt }}
                            mmk<br>
                            <small class=" text-danger ms-1">( Contain Delivery Charges )</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card col-5 shadow-sm m-4 p-0 col">
                <div class="card-header py-3">
                    <div class="d-flex justify-content-between">
                        <div class="">
                            <h6 class="m-0 font-weight-bold text-primary">Payment History Information</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body ps-5">
                    <div class="row mb-3">
                        <div class="col-5">Contact Phone :</div>
                        <div class="col-7">{{ $paymentHistory -> phone }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Payment Method :</div>
                        <div class="col-7 text-info font-weight-bold">{{ $paymentHistory -> payment_method }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Addr :</div>
                        <div class="col-7 text-info font-weight-bold">{{ $paymentHistory -> address }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5">Purchase Date :</div>
                        <div class="col-7">{{ $paymentHistory -> created_at -> format("j-F-Y") }}</div>
                    </div>
                    <div class="mb-3">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-outline-info p-0" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            <img style="width: 150px" src="{{ asset("payslipImage/" . $paymentHistory -> payslip_image) }}" class=" img-thumbnail">
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <div class="card shadow mb-4" >
            <div class="card-header py-3">
                <div class="d-flex justify-content-between">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-primary">Order Product List</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover shadow-sm" id="productTable">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="col-2">Image</th>
                                <th class="">Name</th>
                                <th >Order Count</th>
                                <th>Available Stock</th>
                                <th>Product Price (each)</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>

{{--                        <tr>--}}
{{--                            <input type="hidden" class="productId" value="">--}}
{{--                            <input type="hidden" class="productOrderCount" value="">--}}

{{--                            <td>--}}
{{--                                <img src="" class=" w-50 img-thumbnail">--}}
{{--                            </td>--}}
{{--                            <td></td>--}}
{{--                            <td></td>--}}
{{--                            <td></td>--}}
{{--                            <td>mmk</td>--}}
{{--                            <td> mmk</td>--}}
{{--                        </tr>--}}

                        @foreach($orderList as $list)
                            <tr>
                                <input type="hidden" class="productId" value="{{ $list -> product_id }}">
                                <input type="hidden" class="productOrderCount" value="{{ $list -> order_count }}">

                                <td>
                                    <img src="{{ asset("productImage/" . $list -> photo) }}" class=" w-50 img-thumbnail">
                                </td>
                                <td>{{ $list -> product_name }}</td>
                                <td>{{ $list -> order_count }} @if($list -> order_count > $list -> stock) <span class="text-danger">(Out Of Stock)</span> @endif</td>
                                <td>{{ $list -> stock }}</td>
                                <td>{{ $list -> price }} mmk</td>
                                <td>{{ $list -> price * $list -> order_count }} mmk</td>
                            </tr>
                        @endforeach

                        </tbody>

                    </table>

                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
                @if(!$isConfirmed)
                    <div class="">
                        @if($status)
                            <input type="button" id="btn-order-confirm" class="btn btn-success rounded shadow-sm" value="Confirm">
                        @endif

                        <input type="button" id="btn-order-reject" class="btn btn-danger rounded shadow-sm"
                               value="Reject">
                    </div>
                @endif
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Payslip</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img style="" src="{{ asset("payslipImage/" . $paymentHistory -> payslip_image) }}" class=" img-thumbnail">
                </div>
            </div>
        </div>
    </div>
@endsection

@section("js-script")
    <script type="text/javascript">
        $(document).ready(function() {
            $("#btn-order-confirm").click(function() {
                let orderCode = $("#orderCode").text();
                let orderList = [];

                $(".table tbody tr").each(function(idx, row) {
                    let productId = $(row).find(".productId").val();
                    let count = $(row).find(".productOrderCount").val();


                    console.log(productId);
                    console.log(count);

                    orderList.push({
                        "productId" : productId,
                        "count" : count,
                        "orderCode" : orderCode
                    });
                });

                console.log("hello");

                Swal.fire({
                    title: "Are you sure You want to Confirm?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#0ea5e9",
                    cancelButtonColor: "#9ca3af",
                    confirmButtonText: "Yes"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "get",
                            url: "/admin/order/confirm",
                            data: Object.assign({}, orderList),
                            dataType: "json",
                            beforeSend: function() {
                                Swal.fire({
                                    title: 'Processing...',
                                    didOpen: () => {
                                        Swal.showLoading()
                                    }
                                });
                            },
                            success : function (res){
                                Swal.fire(
                                    'Saved!',
                                    'Your Confirmation is Saved.',
                                    'success'
                                ).then(() => {
                                    res.status === "success" ? location.href="/admin/order/list" : "";
                                });

                            }
                        })
                    }
                });

            });

            $("#btn-order-reject").click(function() {
                let orderCode = $("#orderCode").text();

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, Reject it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "get",
                            url: "/admin/order/reject",
                            data: {"orderCode" : orderCode},
                            dataType: "json",
                            beforeSend: function() {
                                Swal.fire({
                                    title: 'Processing...',
                                    didOpen: () => {
                                        Swal.showLoading()
                                    }
                                });
                            },
                            success : function (res){
                                Swal.fire(
                                    'Saved!',
                                    'Your Reject is Saved.',
                                    'success'
                                ).then(() => {
                                    res.status === "success" ? location.href="/admin/order/list" : "";
                                });


                            }
                        })
                    }
                });

            });
        });
    </script>
@endsection
