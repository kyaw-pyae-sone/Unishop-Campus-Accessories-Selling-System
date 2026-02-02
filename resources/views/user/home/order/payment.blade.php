@extends("user.layouts.master");

@section("title", "Payment");

@section("content")
    <div class="container " style="margin-top: 150px">
        <div class="row">
            <div class="card col-12 shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <h5 class="mb-4">Payment methods</h5>


                            @foreach($paymentAcc as $payment)
                                <div class="">
                                    <b>{{ $payment -> account_type }}</b> ( Name : {{ $payment -> account_name }})
                                </div>

                                Account : {{ $payment -> account_number }}

                                <hr>
                            @endforeach

                        </div>
                        <div class="col">
                            <div class="card shadow-sm">
                                <div class="card-header">
                                    Payment Info
                                </div>
                                <div class="card-body">
                                    <div class="">
                                        <form id="orderForm" action="{{ route("user#addOrder") }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row mt-4">
                                                <div class="col">
                                                    <input type="text" name="name" id="" readonly value="{{ Auth::user() -> name }}"
                                                           class="form-control " placeholder="User Name...">
                                                </div>
                                                <div class="col">
                                                    <input type="text" name="phone" id="" value="{{ old("phone") }}" class="form-control @error("phone") is-invalid @enderror"
                                                           placeholder="09xxxxxxxx">
                                                    @error("phone")
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col">
                                                    <textarea name="address" id="order_address" cols="30" rows="10" class="form-control @error("address") is-invalid @enderror" placeholder="Enter Address...">{{ old("address") }}</textarea>
                                                    @error("address")
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col">
                                                    <select name="paymentType" id="" class=" form-select @error("paymentType") is-invalid @enderror">
                                                        <option disabled selected>Choose Payment methods...</option>
                                                        @foreach( $paymentMethods as $payment)
                                                            <option value="{{ $payment -> account_type }}" @if($payment -> account_type == old("paymentType")) selected @endif>{{ $payment -> account_type }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error("paymentType")
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col">
                                                    <input type="file" name="payslipImage" id="" class="form-control @error("payslipImage") is-invalid @enderror">
                                                    @error("payslipImage")
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mt-4">
                                                <div class="col">
                                                    <input type="hidden" name="orderCode" value="{{ $orderTemp[0]["order_code"] }}">
                                                    Order Code : <span class="text-info fw-bold @error("orderCode") is-invalid @enderror">{{ $orderTemp[0]["order_code"] }}</span>
                                                </div>
                                                @error("orderCode")
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                                <div class="col">
                                                    <input type="hidden" name="totalAmount" value="{{ $orderTemp[0]["final_amount"] }}">
                                                    Total amt : <span class=" fw-bold @error("phone") is-invalid @enderror">{{ $orderTemp[0]["final_amount"] }} mmk</span>
                                                </div>
                                            </div>

                                            <div class="row mt-4 mx-2">
                                                <button type="submit" id="orderBtn" class="btn btn-outline-success w-100"><i
                                                        class="fa-solid fa-cart-shopping me-3"></i> Order
                                                    Now...</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("js-script")
    <script type="text/javascript">
        $(document).ready(function(){
            // $("#orderBtn").click(function() {
            //     let formData = new FormData();
            //     $.ajax({
            //         type: "get",
            //         url: "/user/order/add",
            //
            //         dataType: "json",
            //         beforeSend: function() {
            //             Swal.fire({
            //                 title: 'Processing...',
            //                 didOpen: () => {
            //                     Swal.showLoading()
            //                 }
            //             });
            //         },
            //
            //         success:function (){
            //             Swal.fire({
            //                 title: "Are you sure?",
            //                 text: "You won't be able to revert this!",
            //                 icon: "warning",
            //                 showCancelButton: true,
            //                 confirmButtonColor: "#d33",
            //                 cancelButtonColor: "#3085d6",
            //                 confirmButtonText: "Yes, Reject it!"
            //             });
            //         }
            //     });
            // });

            $("#orderForm").on("submit", function(event) {
                event.preventDefault();

                let data = new FormData(this);

                function sendOrder(data) {
                    $.ajax({
                        url: "/user/order/add",
                        method: "POST",
                        data: data,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.status === 'confirm') {
                                Swal.fire({
                                    title: 'Are you sure?',
                                    text: response.message,
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'Yes, Save it!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        data.append("confirmed", "true")
                                        sendOrder(data);
                                    }
                                });
                            } else if (response.status === 'success') {
                                Swal.fire({
                                    title: 'Saved!',
                                    text: response.message,
                                    icon: 'success',
                                    confirmButtonText: 'Yes',
                                    allowOutsideClick: false // Alert box အပြင်ကို နှိပ်လို့မရအောင် ပိတ်ထားမယ်
                                }).then((result) => {

                                    if (result.isConfirmed) {

                                        let orderCode = $('input[name="orderCode"]').val();

                                        if(orderCode) {
                                            location.href = `/user/order/detail/${orderCode}`;
                                        } else {
                                            alert("Order Code value is missing!");
                                        }
                                    }
                                });
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                let errors = xhr.responseJSON.errors;
                                let errorString = "";


                                $.each(errors, function(key, value) {
                                    errorString += value[0] + "<br>";
                                });


                                Swal.fire({
                                    icon: 'error',
                                    title: 'Validation Error',
                                    html: errorString,
                                });
                            } else {
                                Swal.fire('Error', 'Something went wrong!', 'error');
                            }
                        }
                    });
                }

                sendOrder(data);
            });
        });
    </script>
@endsection
