<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Faker\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class PaymentController extends Controller
{
    // Payment List
    public function list(): Factory|View {
        $payments = Payment::select("id","account_number", "account_name", "account_type") -> orderby("account_type", "asc") -> paginate(5);

        return view("admin.home.payment.list", compact("payments"));
    }

    // Payment Create
    public function create(Request $request): RedirectResponse {

        $this -> checkPaymentValidation($request);
        $data = $this -> getData($request);

        try{
            Payment::create($data);
            Alert::success("Done", "Payment Added Successfully!!!");
        }catch (\Exception $exception){
            Alert::error("Fail", $exception->getMessage());
        }

        return back();
    }

    // Payment Delete
    public function delete($id): RedirectResponse{

        try {
            Payment::destroy($id);

            Alert::success("Done", "Payment Deleted Successfully!!!");
        }catch (\Exception $exception){
            Alert::error("Fail", "Something Went Wrong!!!");
        }

        return back();
    }

    // Payment Edit
    public function edit($id, Request $request): Factory|View {
        $payment = Payment::where("id", $id)->first();

        return view("admin.home.payment.edit", compact("payment"));
    }

    // Payment update
    public function update(Request $request): RedirectResponse {
        $this -> checkPaymentValidation($request);
        $data = $this -> getData($request);

        try {
            Payment::where("id", $request -> id) -> update($data);

            Alert::success("Done", "Payment Updated Successfully!!!");
        }catch (\Exception $exception){
            Alert::error("Fail", "Something Went Wrong!!!");
        }

        return back();
    }

    // Validation
    private function checkPaymentValidation($request): void {
        $rules = [
            "accountNumber" => ["required", "string", Rule::unique("payments", "account_number") -> where(function($query) use ($request) { return $query -> where("account_type", $request -> accountType); }) -> ignore($request->id) ],
            "accountName" => ["required", "string"],
            "accountType" => ["required", "string"]
        ];

        $messages = [
            "accountNumber.unique" => "This account number is already registered for the selected payment type.",
        ];

        $request->validate($rules, $messages);
    }

    // Get Data
    private function getData($request): array{
        return [
            "account_number" => $request -> accountNumber,
            "account_name" => $request -> accountName,
            "account_type" => $request -> accountType
        ];
    }
}
