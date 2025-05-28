<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Default product listing page
    public function index(Request $request)
    {
        $products = Product::with(['brand', 'category', 'attributes'])
            ->filter($request->all())
            ->get();

        $paginated = $products->forPage($request->page ?? 1, 12);

        return view('products.index', [
            'products' => $paginated,
            'allProducts' => $products
        ]);
    }


    public function search(Request $request)
    {

        $products = Product::with(['brand', 'category', 'attributes'])
            ->filter($request->all())
            ->get();


        if ($request->ajax()) {
            return response()->json([
                'html' => view('products.list', ['products' => $products])->render(),
                'filters' => view('products.filters', ['products' => $products])->render(),
            ]);
        }

        return view('products.index', [
            'products' => $products,
            'allProducts' => $products
        ]);
    }
}
