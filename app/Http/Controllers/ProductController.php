<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Product;
use App\Category;
use App\BussinessUser;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Intervention\Image\ImageManagerStatic as Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->get('q', '');

        $bussUserId = BussinessUser::find(Auth::id());

        $products = !$bussUserId ?
            Product::searchByKeyword($keyword)->orderBy("id" , "DESC")->paginate(15) :
            Product::searchByKeyword($keyword)->orderBy("id" , "DESC")->where('bussiness_id', $bussUserId->bussiness_id)->paginate(15);

        $products = !empty($keyword) ? $products->appends(['q' => $keyword]) : $products;

        $data = [
            'products' => $products,
            'keyword'  => $keyword,
        ];

        return view('backend.products.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bussUserId = BussinessUser::find(Auth::id());

        $categories = !$bussUserId ?
            Category::get() :
            Category::where('bussiness_id', $bussUserId->bussiness_id)->get();

        return view('backend.products.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param App\Http\Requests $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bussUserId = BussinessUser::find(Auth::id());

        $form = $request->all();
        $price = $request->input("price");
        $titles = $request->input("title");
        unset($form['price']);
        unset($form['title']);
        unset($form['price_counter']);
        $form['prices'] = json_encode($price);
        $form['titles'] = json_encode($titles);
        if ($bussUserId) {
            $form['bussiness_id'] = $bussUserId->bussiness_id;
        }

        $product = Product::create($form);
        $name = $product->id;
        
        if ($bussUserId) {
            if (file_exists("uploads/products/" . $bussUserId->bussiness_id . "/temp.jpg")) {
                rename("uploads/products/" . $bussUserId->bussiness_id . "/temp.jpg", "uploads/products/" . $bussUserId->bussiness_id . "/$name.jpg");
                rename("uploads/products/" . $bussUserId->bussiness_id . "/thumb/temp.jpg", "uploads/products/" . $bussUserId->bussiness_id . "/thumb/$name.jpg");
            }
        } else {
            if (file_exists("uploads/products/temp.jpg")) {
                rename("uploads/products/temp.jpg", "uploads/products/$name.jpg");
                rename("uploads/products/thumb/temp.jpg", "uploads/products/thumb/$name.jpg");
            }
        }

        return redirect('products')
            ->with('message-success', 'Product created!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bussUserId = BussinessUser::find(Auth::id());

        $product = !$bussUserId ?
            Product::findOrFail($id) :
            Product::findOrFail($id)->where('bussiness_id', $bussUserId->bussiness_id);

        $categories = !$bussUserId ?
            Category::get() :
            Category::where('bussiness_id', $bussUserId->bussiness_id)->get();

        if (
            !$product->bussiness_id ||
            $product->bussiness_id != $bussUserId->bussiness_id
        ) {
            return redirect('products')
                ->with('message-danger', 'There is no product with that id');
        }

        return view('backend.products.show', compact('product', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bussUserId = BussinessUser::find(Auth::id());

        $product = !$bussUserId ?
            Product::findOrFail($id) :
            Product::findOrFail($id)->where('bussiness_id', $bussUserId->bussiness_id);

        $categories = !$bussUserId ?
            Category::get() :
            Category::where('bussiness_id', $bussUserId->bussiness_id)->get();

            
        if (
            !$product->bussiness_id ||
            $product->bussiness_id != $bussUserId->bussiness_id
        ) {            
            return redirect('products')
                ->with('message-danger', 'There is no product with that id');
        }

        return view('backend.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param App\Http\Requests $request
     * @param int               $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\UpdateProduct $request, $id)
    {
        $bussUserId = BussinessUser::find(Auth::id());

        $form = $request->all();
        $price = $request->input("price");
        $titles = $request->input("title");
        unset($form['price']);
        unset($form['title']);
        unset($form['price_counter']);
        $form['prices'] = json_encode($price);
        $form['titles'] = json_encode($titles);

        if ($bussUserId) {
            $form['bussiness_id'] = $bussUserId->bussiness_id;
        }
        
        $product = Product::findOrFail($id);
        $product->update($form);
        $name = $product->id;
        

        return redirect('products')
            ->with('message-success', 'Product updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bussUserId = BussinessUser::find(Auth::id());
      
        $product = Product::findOrFail($id);
        
        if (
            !$product->bussiness_id ||
            $product->bussiness_id != $bussUserId->bussiness_id
        ) {
            return redirect('products')
                ->with('message-danger', 'There is no product with that id');
        }

        $product->delete();

        return redirect('products')
            ->with('message-success', 'Product deleted!');
    }
    
    public function uploadPhoto(Request $request) 
    { 
        $bussUserId = BussinessUser::find(Auth::id());

        $relPath = "uploads/products/" . $bussUserId->bussiness_id;
        $relThumbPath = "uploads/products/" . $bussUserId->bussiness_id . "/thumb";
        if (!file_exists(public_path($relPath))) {
            mkdir(public_path($relPath), 777, true);
        }
        if (!file_exists(public_path($relThumbPath))) {
            mkdir(public_path($relThumbPath), 777, true);
        }

        $file = Input::file('croppedImage');

        if (Input::hasFile('croppedImage')) {

            $file_name = "temp.jpg";
            $extension = $file->getClientOriginalExtension();
            $path = !$bussUserId ?
                $file->storeAs("uploads/products/", $file_name) :
                $file->storeAs("uploads/products/" . $bussUserId->bussiness_id . "/", $file_name);

            $img = Image::make($file->getRealPath());
            if($img->exif('Orientation')) { 
                $img = orientate($img, $img->exif('Orientation'));
            }

            $path2 = !$bussUserId ?
                public_path("storage/products/$file_name") : 
                public_path("storage/products/" . $bussUserId->bussiness_id . "/$file_name"); 

            $img->fit(250)->save($path2);
                
            echo url(!$bussUserId ?
                "storage/products/" . $file_name :
                "storage/products/" . $bussUserId->bussiness_id . "/" . $file_name
            );
        }
    }
    
    ////// User upload photo and resize to 145x145 to Thumb
    public function updatePhotoCrop(Request $request) 
    {
        $bussUserId = BussinessUser::find(Auth::id());

        $relPath = "uploads/products/" . $bussUserId->bussiness_id;
        $relThumbPath = "uploads/products/" . $bussUserId->bussiness_id . "/thumb";
        if (!file_exists(public_path($relPath))) {
            mkdir(public_path($relPath), 777, true);
        }
        if (!file_exists(public_path($relThumbPath))) {
            mkdir(public_path($relThumbPath), 777, true);
        }

        $cropped_value = $request->input("cropped_value"); 
        $image_edit = $request->input("image_edit"); 
        $cp_v = explode(",", $cropped_value);
            
        $file = Input::file('file');
        $file_name = $image_edit . ".jpg";
        if(empty($image_edit)) { 
            $file_name = "temp.jpg";
        }
            
        if (Input::hasFile('file')) {
                
            $extension = $file->getClientOriginalExtension();
            $store_path = public_path(
                !$bussUserId ?
                "uploads/products" :
                "uploads/products/" . $bussUserId->bussiness_id
            ); 
            $path = $file->move($store_path, $file_name); 
            $img = Image::make($store_path . "/$file_name"); 
            if($img->exif('Orientation')) { 
                $img = orientate($img, $img->exif('Orientation'));
            }
                
            $path2 = public_path(
                !$bussUserId ?
                "uploads/products/thumb/$file_name" :
                "uploads/products/" . $bussUserId->bussiness_id . "/thumb/$file_name"
            ); 
            $img->rotate($cp_v[4] * -1);
            $img->crop($cp_v[0], $cp_v[1], $cp_v[2], $cp_v[3]);
            $img->fit(250)->save($path2);
                
            echo url(
                !$bussUserId ?
                "uploads/products/thumb/$file_name" :
                "uploads/products/" . $bussUserId->bussiness_id . "/thumb/$file_name"
            ); exit;
        }
            
        if($image_edit != "") {
            $path = public_path(
                !$bussUserId ?
                "uploads/products/$file_name" :
                "uploads/products/" . $bussUserId->bussiness_id . "/$file_name"
            );
            $img = Image::make($path);
            $path2 = public_path(
                !$bussUserId ?
                "uploads/products/thumb/$file_name" :
                "uploads/products/" . $bussUserId->bussiness_id . "/thumb/$file_name"
            );
            $img->rotate($cp_v[4] * -1);                
            $img->crop($cp_v[0], $cp_v[1], $cp_v[2], $cp_v[3]);
            $img->fit(250)->save($path2);
            echo url(
                !$bussUserId ?
                "uploads/products/thumb/$file_name" :
                "uploads/products/" . $bussUserId->bussiness_id . "/thumb/$file_name"
            ); exit;
        }
        
    }
	
	
	 public function addToArchive(Request $request) {
        $id = $request->input("product_id");
        $product = Product::find($id);
        if ($product->is_delete == 1) {
            $value = 0;
        }

        if ($product->is_delete == 0) {
            $value = 1;
        }
        Product::where("id", $id)->update(array('is_delete' => $value));
    }

    
}
