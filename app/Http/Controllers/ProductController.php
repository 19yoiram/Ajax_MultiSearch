<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function index(Request $request)
    {
        $products = Product::latest()->paginate(12);

        return view('products.index', compact('products'));
    }

    public function search(Request $request)
    {
        $products = Product::with(['brand', 'category', 'attributes'])->filter($request->all())->paginate(12);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('products.list', compact('products'))->render(),
            ]);
        }

        return view('products.index', compact('products'));
    }
}
