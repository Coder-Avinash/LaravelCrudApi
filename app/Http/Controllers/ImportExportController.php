<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ProductExport;
use App\Imports\ProductImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Product;


use PDF;

class ImportExportController extends Controller
{


    public function importview()
    {
        return view('import');
        
    }
    
    public function import_excel() 
    {
        Excel::import(new ProductImport,request()->file('file'));
             
        return back();
    }


    public function export_excel() 
    {
        return Excel::download(new ProductExport, 'products.xlsx');
    }

    public function createPDF()
    {
        $products = Product::all();
        view()->share('products',$products);
        $pdf = PDF::loadView('show_products',$products);

        return $pdf->download('products_pdf.pdf');
    }
}
