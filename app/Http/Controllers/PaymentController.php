<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Carbon\Carbon;
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


    // payment edit
    public function PaymentEdit($id){
        // get edit data
        $edit_payment = Payment::find($id);

        // return response
        return response()->json([
            'status'        => 200,
            'message'       => 'Payment edit information',
            'data'          => $edit_payment
        ]);
    }

    // payment update
    public function PaymentUpdate($id, Request $request){

        // validation checking
        $this->Validation($request);

        // date or time
        $time = date("g:i a");   
        $date= date("Y-m-d");  

        // get edit data
        $update_payment = Payment::find($id);
        $update_payment -> name         = $request->name;
        $update_payment -> amount       = $request->amount;
        $update_payment -> payment_recevier = $request->payment_recevier;
        $update_payment -> payment_type = $request->payment_type;
        $update_payment -> description  = $request->description;
        $update_payment -> date         = $date;
        $update_payment -> time         = $time;
        if($update_payment->status== 'CashIn'){
            $update_payment -> status   = 'CashIn';
        }else {
            $update_payment -> status   = 'CashOut';
        }
        $update_payment -> update();

        // return response
        return response()->json([
            'status'        => 200,
            'message'       => 'Payment updated successfully',
        ]);
    }

    // payment delete
    public function PaymentDelete($id){
        // payment delete
        Payment::find($id)->delete();

        // return response
        return response()->json([
            'status'        => 200,
            'message'       => 'Payment deleted successfully',
        ]);
    }


    // payment cashIn or cashOut calculation 
    public function PaymentCalculation(){

        // total payment information
        $payment = Payment::all();
        $cashIn = $payment->where('status', 'CashIn')->sum('amount');
        $cashOut = $payment->where('status', 'CashOut')->sum('amount');

        // balance calculation
        $balance = $cashIn - $cashOut;
        $balanch_sheet = [
            'cashIn'    => $cashIn,
            'cashOut'   => $cashOut,
            'balance'   => $balance
        ];

        // return response
        return response()->json([
            'status'        => 200,
            'message'       => 'Payment balance calculation',
            'data'          => $balanch_sheet
        ]);

    }

    // payment item search
    public function PaymentSearch($search){

        // payment item searching
        $search = Payment::where('name', 'LIKE', '%'.$search.'%')
        ->orWhere('description', 'LIKE', '%'.$search.'%')
        ->orWhere('payment_type', 'LIKE', '%'.$search.'%')
        ->orWhere('payment_recevier', 'LIKE', '%'.$search.'%')
        ->get();

        // return response
        return response()->json([
            'status'        => 200,
            'message'       => 'Payment search result',
            'data'          => $search
        ]);

    }

    
    // payment item search
    public function PaymentSearchDateWise($date){

        // date wise payment searching
        if($date == 'today'){
            $today = date('Y-m-d',strtotime("today"));
            $date_wise_search= Payment::whereBetween('created_at', [$today.' 00:00:00', $today.' 23:59:59'])->get();

        }else if($date == 'yesterday'){
            $yesterday = date('Y-m-d',strtotime("yesterday"));
            $date_wise_search= Payment::whereBetween('created_at', [$yesterday.' 00:00:00', $yesterday.' 23:59:59'])->get();

        }else if($date == 'week'){
            // $dt = Carbon::now();
            $date_wise_search= Payment::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();

        }else if($date == 'month'){
            $date_wise_search= Payment::whereMonth('created_at', date('m'))->get();

        }
       

        // return response
        return response()->json([
            'status'        => 200,
            'message'       => 'Payment search result',
            'data'          => $date_wise_search
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
