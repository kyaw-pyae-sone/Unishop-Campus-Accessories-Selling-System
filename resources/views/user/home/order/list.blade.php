@extends("user.layouts.master");

@section("title", "Order List");

@section("content")
    <div class="container " style="margin-top: 150px">
        <div class="row">
            <table class="table table-hover shadow-sm ">
                <thead class="bg-primary text-white">
                <tr>
                    <th>Date</th>
                    <th>Order Code</th>
                    <th>Order Status</th>
                </tr>
                </thead>
                <tbody>

                @foreach($orderList as $order)
                    <tr>
                        <td>{{ $order -> created_at -> format("j-F-Y") }}</td>
                        <td><a href="{{ route("user#detailOrder", $order -> order_code) }}">{{ $order -> order_code }}</a></td>
                        <td>
                            @if($order -> status == 0)
                                <i class="fas fa-hourglass-half btn btn-sm btn-warning rounded shadow-sm me-3" ></i> <span class="text-warning">Pending</span>
                            @elseif($order -> status == 1)
                                <i class="fa-solid fa-thumbs-up btn btn-sm btn-success rounded shadow-sm me-3" ></i> <span class="text-success">Accept</span>
                            @else
                                <i class="fas fa-times-circle btn btn-sm btn-danger rounded shadow-sm me-3" ></i> <span class="text-danger">Reject</span>
                            @endif
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection

