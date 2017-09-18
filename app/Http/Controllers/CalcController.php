<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Session;
use View;
use DB;

class CalcController extends Controller
{

    public function calc_init(){
        //getting distinct values from bases and targets to pass them to calculator view
        $bases = DB::table('currencies')
            ->select('base','base_name')
            ->groupBy('base', 'base_name')
            ->get();

        $targets = DB::table('currencies')
           ->select('target','target_name')
           ->groupBy('target', 'target_name')
           ->get();

        //returns calculator view with the results from two quries
        return view('calculator')->with('bases',$bases)->with('targets',$targets);
    }

    public function get_all_currencies(){
        //getting all fields from currencies table
        $data = DB::table('currencies')->get();

        return view('allcurrencies')->with('data',$data);
    }

    //the function that gets the requested data and returns results in json
    public function ajaxcall() {
      //form data
      $the_data = $_POST['data'];
      //splitting input by symbols = and &
      //data come in this order: _token, base, target, value
	    $data_array = preg_split( "/(=|&)/", $the_data );
	    $base = $data_array[3];
	    $target = $data_array[5];
	    $value = $data_array[7];
   
      //retrieving data from database
	    $cur = DB::table('currencies')->where('base', $base)
       ->where('target', $target)
       ->first();

      //check if is empty
      //if the query finds results, we make the calculation
      if ( $cur ) {
 
        $currency = $cur->currency;

        $result = $value * $currency;
      }
      else {
        $currency = 0;
        $result = "Currency not found";
      }
   
      return response()->json(array('result'=> $result, 'base'=> $base, 'target' => $target, 'value' => $value, 'currency' => $currency), 200);
    }

    //functions responsible for the update of the currencies
    public function ajax_currency_update() {
      //submitted form data
      $the_data = $_POST['data'];
      //splitting input by symbols = and &
      //data come in this order: _token, base, target, value
      $data_array = preg_split( "/(=|&)/", $the_data );
      $base = $data_array[3];
      $target = $data_array[5];
      $currency = $data_array[7];
   
      //the query performing the update
      DB::table('currencies')
     ->where('base', $base)
       ->where('target', $target)
       ->update(['currency' => $currency]);

      //we get the updated field so we can return it to the update screen
      $cur = DB::table('currencies')->where('base', $base)
       ->where('target', $target)
       ->first();


      if ( $cur ) {
 
        $currency = $cur->currency;

        $message = "Currency updated";

      }
      else {
        $currency = 0;
      }

      return response()->json(array('currency' => $currency, 'message' => $message), 200);
    }

    //the function adding new currencies to the db
    public function store(){

        // validation of fields
        $rules = array(
            'base'       => 'required',
            'target'      => 'required',
            'base_name'       => 'required',
            'target_name'      => 'required',
            'currency' => 'required|numeric'
        );
        $validator = Validator::make(Input::all(), $rules);

        //if something goes wrong, the validator returns error message to the view
        if ($validator->fails()) {
            return Redirect::to('/addcurrency')
                ->withErrors($validator)
                ->withInput();
        } else {
            //getting values from input and passing to variables
            $base = Input::get('base');
            $base_name = Input::get('base_name');
            $target = Input::get('target');
            $target_name = Input::get('target_name');
            $currency = Input::get('currency');

            //store to db
            DB::table('currencies')->insert(
              ['base' => $base, 'base_name' => $base_name, 'target' => $target, 'target_name' => $target_name, 'currency' => $currency ]
            );

            // redirect with success message
            Session::flash('message', 'Currency successfully created.');
            return Redirect::back();
        }
    }
}


