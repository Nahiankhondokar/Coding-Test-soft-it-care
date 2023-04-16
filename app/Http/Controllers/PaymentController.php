<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // cashIn payment add 
    public function cashInPayment(Request $request){

        // validation checking
        $this->Validation($request);

        // date or time
        $time = date("g:i a");   
        $date= date("Y-m-d");   


        // data store to DB
        Payment::create([
            'name'              => $request->name,
            'amount'            => $request->amount,
            'payment_recevier'  => $request->payment_recevier,
            'payment_type'      => $request->payment_type,
            'description'       => $request->description,
            'date'              => $date,
            'time'              => $time,
            'status'            => 'CashIn'
        ]);

        // response to api
        return response()->json([
            'status'    => 200,
            'message'   => 'CashIn received successfully',
        ]);
    }

    // cashOut payment add 
    public function cashOutPayment(Request $request){

        // validation checking
        $this->Validation($request);

        // date or time
        $time = date("g:i a");   
        $date= date("Y-m-d");   

        // data store to DB
        Payment::create([
            'name'              => $request->name,
            'amount'            => $request->amount,
            'payment_recevier'  => $request->payment_recevier,
            'payment_type'      => $request->payment_type,
            'description'       => $request->description,
            'date'              => $date,
            'time'              => $time,
            'status'            => 'CashOut'
        ]);

        // response to api
        return response()->json([
            'status'    => 200,
            'message'   => 'CashOut received successfully',
        ]);
    }


    // all payment list show
    public function PaymentListShow(){

        // get all payment data
        $payment_list = Payment::all();

        // return response
        return response()->json([
            'status'        => 200,
            'message'       => 'All payment list',
            'data'          => $payment_list
        ]);
    }




    // validation checking function
    public function Validation($request){
        $request->validate([
            'name'              => 'required',
            'amount'            => 'required',
            'payment_recevier'  => 'required',
            'payment_type'      => 'required',
            'description'       => 'required'
        ]);

    }


}
