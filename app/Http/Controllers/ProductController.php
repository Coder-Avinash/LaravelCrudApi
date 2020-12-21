<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\DataTables\ProductDataTable;
use DB;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index(ProductDataTable $dataTable)
    // {
    //     return $dataTable->render('products');
        
        
    //     // $products = Product::all();
    //     // return view('show_products',['products'=>$products]);
    //  }

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
        $product = new Product;
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->type = $request->type;
        $result = $product->save();
        if($result)
        {
            return ["result"=> "record has been saved"];
        }
        else
        {
            return ["result"=> "record failed to save"];
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
        $products = $id?Product::find($id):Product::all();
        return view('filter_products',['products'=>$products]);
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
        $product = Product::find($id);
        $product->title=$request->title;
        $product->description=$request->description;
        $product->price=$request->price;
        $product->title=$request->title;
        $product->type=$request->type;
        $product->save();
        return response()->json($product);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $product = Product::find($id);
        $product->delete(); 
        return response()->json($product);
    }

    //search product using title

    public function search($title=null)
    {

        // $products = QueryBuilder::for(Product::class)->allowedFilters(['title'])->get();

        $products = Product::where(["title"=>$title])->orWhere(["description"=>$title])->orWhere(["type"=>$title])->get();
        return view('show_products',['products'=>$products]);
    }

    //search product using filters price low to high and hogh to low 

    public function filter($valA=null,$valB=null)
    {
        if($valA == "lth")
        {
            $products=Product::orderBy('price','asc')->get();
            return view('show_products',['products'=>$products]);
        }
        elseif($valA == "htl")
        {
            $products=Product::orderBy('price','desc')->get();
            return view('show_products',['products'=>$products]);
        }
        else
        {
            $products = Product::whereBetween('price', [$valA, $valB])
            ->orderBy('price','asc')
            ->get();
            return view('show_products',['products'=>$products]);
        }   
        
    }


    function index(Request $request)
    {
        if(request()->ajax())
        {
            if(!empty($request->from_price))
            {
                
                $data = Product::whereBetween('price', array($request->from_price, $request->to_price))->get();
            }
            else
            {
                $data = Product::all();
            }
            return datatables()->of($data)->make(true);
           
        }
        return view('range');
    }



}
