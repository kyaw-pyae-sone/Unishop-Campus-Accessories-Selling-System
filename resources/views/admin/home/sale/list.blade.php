@extends("admin.layouts.master")

@section("title", "Order List")

@section("content")
    <div class="container">
        <div class=" d-flex justify-content-between my-2">
            <div class="">
                <button disabled class=" btn btn-secondary rounded shadow-sm"> <i class="fa-solid fa-database"></i>
                    Product Count ({{ count($orderList) }}) </button>
                <a href="{{ route("sale#list") }}" class=" btn btn-outline-primary  rounded shadow-sm">All Sale</a>
                <a href="{{ route("sale#list", 1) }}" class=" btn btn-outline-success  rounded shadow-sm">Accept</a>
                <a href="{{ route("sale#list", 2) }}" class=" btn btn-outline-danger  rounded shadow-sm">Reject</a>
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
        <div class="row mt-3">
            <div class="col" >
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    You can click order code to click order detail
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <table class="table table-hover shadow-sm">
                    <thead class="bg-primary text-white">
                    <tr>
                        <th>Created At</th>
                        <th>Order Code</th>
                        <th>Customer Name</th>
                        <th>Order Status</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($orderList as $order)

                        @if($order -> status == 1 || $order -> status = 2)
                            <tr>
                                <td>{{ $order -> created_at -> format("j-F-Y") }}</td>
                                <td><a href="{{ route("order#detail", $order -> order_code) }}" class="orderCode">{{ $order -> order_code }}</a></td>
                                <td>{{ $order -> name }}</td>
                                <td>
{{--                                    <select name="" id="" class="form-select statusChange" @if($order -> status != 0) disabled @endif>--}}
{{--                                        <option value="0" @if($order -> status == 0) selected @endif>Pending</option>--}}
{{--                                        <option value="1" @if($order -> status == 1) selected @endif>Accept</option>--}}
{{--                                        <option value="2" @if($order -> status == 2) selected @endif>Reject</option>--}}
{{--                                    </select>--}}
                                    @switch($order -> status)
                                        @case(1)
                                            <span class="text-info font-weight-bold">Accept</span>
                                        @break
                                        @case(2)
                                            <span class="text-danger font-weight-bold">Reject</span>
                                        @break
                                    @endswitch
                                </td>
                                <td>
                                    @switch($order -> status)
                                        @case(0)
                                            <i class="fa-solid fa-clock-rotate-left text-warning"></i>
                                            @break
                                        @case(1)
                                            <i class="fa-solid fa-check text-success"></i>
                                            @break
                                        @default
                                            <i class="fa-solid fa-ban text-danger"></i>
                                    @endswitch
                                </td>
                            </tr>
                        @endif

                    @endforeach

                    </tbody>
                </table>
                {{ $orderList -> links() }}

            </div>
        </div>
    </div>
@endsection

@section("js-script")
    <script type="text/javascript">
        $(document).ready(function() {
            $(".statusChange").change(function() {
                let status = $(this).val();
                let orderCode = $(this).parents("tr").find(".orderCode").text();

                // console.log(status, orderCode);

                let data = {
                    "status": status,
                    "order_code": orderCode
                }

                $.ajax({
                    type: "get",
                    url: "/admin/order/reject/change",
                    data: data,
                    dataType: "json",
                    success : function (res){
                        res.status === "success" ? location.href="/admin/order/list" : "";
                    }
                })
            });
        });
    </script>
@endsection
