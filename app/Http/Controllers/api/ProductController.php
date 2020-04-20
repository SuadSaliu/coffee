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
            Product::orderBy('name', 'asc')->paginate(8) :
            Product::where('category_id', $catQuery)->orderBy('name', 'asc')->paginate(8);

        return Response::json($products, 200);
     }

     /**
     * Getting All Categories
     */
     public function categories()
    {
        $categories = Categories::all(['id', 'name'])->where("is_delete" , 0)->orderBy("name" , "ASC");

        return Response::json($categories, 200);
    }

}
