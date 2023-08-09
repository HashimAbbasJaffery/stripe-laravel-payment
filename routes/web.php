<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get("/addCustomer", function(Request $request, User $user) {


    Auth::attempt([
        "email" => "danish2121@kaka.com",
        "password" => "kaka"
    ]);
    $user = $user->where("stripe_id", "cus_OQ7PJEHqV7orJ5")->first();
    

    // GIiving credit and fetching the balance

    // $user->debitBalance(500, "Good");
    // dd( $user->balance() );

    // Retrieve all transactions

    // $transactions = $user->balanceTransactions();
    
    // foreach($transactions as $transaction) {
    //     echo $transaction->amount() . "<br>";
    //     echo $transaction->invoice() . "<br>";
    // }

    // Fetching taxIDS

    // $user->createTaxId("eu_vat", "BE0123456789");
    // $taxIds = $user->taxIds();
    // dd($taxIds);


    // Passing payment intent

    $intent = $user->createSetupIntent();
    return view("index", compact("user", "intent"));
});
Route::post("subscribe", function(Request $request, User $user) {
    $paymentMethodId = $request->get("paymentMethodId");
    try {
        $request->user()->newSubscription(
            'basic', "price_1NdIlQSJ0DwCQcRrCsWziMJM"
        )->create($paymentMethodId);
    } catch(\Exception $e) {
        return $e->getMessage();
    }
});
Route::get('/', function () {
    return view('welcome');
});
