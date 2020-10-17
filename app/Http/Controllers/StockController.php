<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stock;
use Response;
use App\Location;
use App\Log;
use Validator;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stocks = Stock::leftjoin('locations','locations.id','stocks.location_id')->select('stocks.id', 'locations.location_name','stocks.stock_quantity','stocks.product')->get();

        if(count($stocks) > 0){
            return sendResponse('stocks', 200, 'Success', $stocks->toArray());
        }
        else{
            $res['status_code'] = 404;
            $res['status_message'] = "Not Found";
            return response($res);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach ($request->all() as $key) {
            $stock = Stock::leftjoin('locations','locations.id','stocks.location_id')->select('stocks.id', 'locations.location_name','stocks.stock_quantity','stocks.product')->where('stocks.location_id', $key['location_id'])->first();
            $barang = array(
                'product' => $key['product'],
                'adjustment' => $key['adjustment'],
                'stock_quantity' => $stock->stock_quantity + $key['adjustment'],
                'location_id' => $key['location_id']
            );

            if($key['product'] != $stock->product){
                $failed = array(
                    'status' => 'Failed',
                    'error_message' => 'Invalid Product',
                    'updated_at' => date("y-m-d H:i:s", strtotime('now')),
                    'location_id' => $key['location_id']
                );
                $result[] = $failed;
            }else{
                $adjusted[] = Stock::where('location_id', $key['location_id'])->update($barang);
                $succes = array(
                    'status' => 'Success',
                    'updated_at' => date("y-m-d H:i:s", strtotime('now')),
                    'location_id' => $key['location_id'],
                    'location_name' => $stock->location_name,
                    'product' => $key['product'],
                    'adjustment' => $key['adjustment'],
                    'stock_quantity' => $stock->stock_quantity + $key['adjustment'],
                    
                );
                $result[] = $succes;
            }
            if( $key['adjustment'] > 0 ){
                $logs = New Log;
                $logs->id_product = $stock->id;
                $logs->type = 'Inbound';
                $logs->save();                
            }else{
                $logs = New Log;
                $logs->id_product = $stock->id;
                $logs->type = 'Outbound';
                $logs->save();
            }
            
        }
        return response([
            'status_code' => 200,
            'requests' => sizeof($request->all()),
            'adjusted' => sizeof($adjusted),
            'results' => $result
        ], 200);

        // foreach ($request->all() as $key) {
        //     $stock = Stock::find($key['location_id']);
        //     $stock->product = $key['product'];
        //     $stock->adjustment = $key['adjustment'];
        //     $stock->stock_quantity = $stock->stock_quantity + $key['adjustment'];
        //     $stock->location_id = $key['location_id'];
        //     $stock->save();

        //     if( $key['adjustment'] > 0 ){
        //         $logs = New Log;
        //         $logs->id_product = $stock->id;
        //         $logs->type = 'Inbound';
        //         $logs->save();                
        //     }else{
        //         $logs = New Log;
        //         $logs->id_product = $stock->id;
        //         $logs->type = 'Outbound';
        //         $logs->save();
        //     }
        //     $data[] = $stock;
            
        // }
        // return response([
        //     'message' => 'Success!',
        //     'results' => $data
        // ], 200);

        // $req = $request->all();
        // $rules =  ['location_id'  => 'required' , 'product' => 'required', 'adjustment' => 'required'];
        // $atributname = [
        //   'location_id.required' => 'The location id field is required.',
        //   'product.required' => 'The product field is required.',
        //   'adjustment.required' => 'The product field is required.',
        // ];
     
        // $validator = Validator::make($req, $rules, $atributname);
        // if($validator->fails()){
        //   return $validator->errors();
        // }else{

            
            


        //     // $stock = Stock::find($request->location_id);
        //     // if($stock->product != $request->product){
        //     //     return response([
        //     //         'status' => 'Failed',
        //     //         'error_message' => 'Invalid Product',
        //     //         'updated_at' =>  date("y-m-d H:i:s", strtotime('now')),
        //     //         'location_id' => $request->location_id
        //     //     ], 200);
        //     // }else{
        //     //     $stock->product = $request->product;
        //     //     $stock->adjustment = $request->adjustment;
        //     //     $stock->stock_quantity = $stock->stock_quantity + $request->adjustment;
        //     //     $stock->location_id = $request->location_id;
        //     //     $stock->save();

        //     //     if( $request->adjustment > 0 ){
        //     //         $logs = New Log;
        //     //         $logs->id_product = $stock->id;
        //     //         $logs->type = 'Inbound';
        //     //         $logs->save();                
        //     //     }else{
        //     //         $logs = New Log;
        //     //         $logs->id_product = $stock->id;
        //     //         $logs->type = 'Outbound';
        //     //         $logs->save();
        //     //     }


                
        //     //     return response([
        //     //         'message' => 'Success!',
        //     //         'results' => $stock
        //     //     ], 200);
        //     // }            
            
        // }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($location_id)
    {
        
        $logs = Log::leftjoin('stocks','stocks.id','id_product')
        ->where('stocks.location_id', $location_id)
        ->select('logs.id', 'logs.type','logs.created_at','stocks.adjustment','stocks.stock_quantity as quantity')
        ->orderBy('logs.id', 'DESC')
        ->get();
        
        if(count($logs) > 0){
            $stocks = Stock::leftjoin('locations','locations.id','stocks.location_id')->select('stocks.id', 'locations.location_name','stocks.stock_quantity','stocks.product')->where('stocks.location_id', $location_id)->first();
            
            $log_data= array();
            foreach ($logs as $key) {
                $data['id'] = $key->id;
                $data['type'] = $key->type;
                $data['created_at'] = date('Y-m-d H:i:s', strtotime($key->created_at));
                $data['adjustment'] = $key->adjustment;
                $data['quantity'] = $key->quantity;
                array_push($log_data, $data);
            }

            return response([
                'status_code' => 200,
                'status' => 'Success, logs found',
                'location_id' => $location_id,
                'location_name' => $stocks->location_name,
                'product' => $stocks->product,
                'current_qty' => $stocks->stock_quantity,
                'logs' => $log_data,
            ], 200);

            // return sendResponse('logs', 200, 'Success', $logs->toArray());
        }
        else{
            $res['status_code'] = 404;
            $res['status_message'] = "Not Found";
            return response($res);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
