<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Product;
use Response;

class ProductController extends Controller
{
    /**
     * Getting All Product
     */
    public function products(Request $request) {
        $catQuery = $request->query('category');

        $products = !$catQuery ?
            Product::orderBy('created_at', 'desc')->paginate(8) :
            Product::where('category_id', $catQuery)->orderBy('created_at', 'desc')->paginate(8);

        return Response::json($products, 200);
     }

     /**
     * Getting All Categories
     */
     public function categories()
    {
        $categories = Categories::all(['id', 'name']);

        return Response::json($categories, 200);
    }

}
