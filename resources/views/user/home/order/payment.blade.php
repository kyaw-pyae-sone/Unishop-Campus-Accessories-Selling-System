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
                                        <form action="{{ route("user#addOrder") }}" method="post" enctype="multipart/form-data">
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
                                                    <textarea name="address" id="" cols="30" rows="10" class="form-control @error("address") is-invalid @enderror" placeholder="Enter Address...">{{ old("address") }}</textarea>
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
                                                <button type="submit" class="btn btn-outline-success w-100"><i
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
