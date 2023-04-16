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
