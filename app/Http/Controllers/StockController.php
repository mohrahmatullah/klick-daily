<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stock;
use Response;
use App\Location;
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
            return sendResponse(200, 'Success', $stocks->toArray());
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
        $req = $request->all();
        $rules =  ['location_id'  => 'required' , 'product' => 'required', 'adjustment' => 'required'];
        $atributname = [
          'location_id.required' => 'The location id field is required.',
          'product.required' => 'The product field is required.',
          'adjustment.required' => 'The product field is required.',
        ];
     
        $validator = Validator::make($req, $rules, $atributname);
        if($validator->fails()){
          return $validator->errors();
        }else{
            // foreach ($request->location_id as $location_id) {
            //     $data[]['location_id'] = $location_id;
            // }
            // foreach ($request->product as $product) {
            //     $data[]['product'] = $product;
            // }
            // foreach ($request->adjustment as $adjustment) {
            //     $data[]['adjustment'] = $adjustment;
            // }
            // $y = array($data[]['location_id'], $data[]['product'], $data[]['adjustment']);
            // $st = Stock::firstWhere('location_id', $request->location_id);
            // $stock = array('product'  =>  $request->product , 'adjustment' => $request->adjustment, 'stock_quantity' => $st->stock_quantity + $request->adjustment);        

                // foreach ($request->location_id as $location_id) {
                //     // Stock::where('location_id', $location_id)->delete();
                //     $stock[] = array('product'  =>  'kopi', 'adjustment' => 96, 'stock_quantity' => 230, 'location_id' => $location_id);
                //     // $data = Stock::insert($product);
                //     // $data = Stock::where('location_id', $location_id)->update(array('product' =>  'kopi', 'adjustment' => $adjustment, 'stock_quantity' => 230));
                // }    

            

            return response([
                'message' => 'Success!',
                'results' => $req
            ], 200);
            
        }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
