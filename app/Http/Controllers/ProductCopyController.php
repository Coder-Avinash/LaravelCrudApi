<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\DataTables\ProductDataTable;



class ProductController extends Controller
{

    public function index(ProductDataTable $dataTable)
    {
        return $dataTable->render('products');
     }

    function show_product($id=null)
    {

        
        return $id?Product::find($id):Product::all();
        // return view('show_products',['data'=>$data]);
    } 

    function add_product(Request $request)
    {
        $product = new Product();
        $product->title = $request->input('title');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->type = $request->input('type');
        $product->is_active = $request->input('is_active');
        $product->save();
        return response()->json($product);

        
    }
        
    

    function search_product($title=null)
    {
        return Product::where("title","like","%".$title."%")->get();
    }
    

    function delete_product(Request $request, $id)
    {
        $product = Product::find($id);
        $product->delete(); 
        return response()->json($product);

    }

    function update_product(Request $request, $id)
    {
        $product = Product::find($id);
        $product->title = $request->input('title');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->type = $request->input('type');
        $product->is_active = $request->input('is_active');
        $product->save();
        return response()->json($product);
    }
    
}
