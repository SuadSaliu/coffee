<?php

namespace App\Http\Controllers;

use App\Category;
use App\BussinessUser;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Intervention\Image\ImageManagerStatic as Image;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bussUserId = BussinessUser::find(Auth::id());

        $data = [
            'categories' => 
                !$bussUserId ?
                    Category::paginate(50) :
                    Category::where('bussiness_id', $bussUserId->bussiness_id)->paginate(50),
        ];

        return view('backend.category.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.category.create');
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

        if ($bussUserId) {
            $form['bussiness_id'] = $bussUserId->bussiness_id;
        }

        $category = Category::create($form);
        $name = $category->id;

        if ($bussUserId) {
            if (file_exists("uploads/category/" . $bussUserId->bussiness_id . "/temp.jpg")) {
                rename("uploads/category/" . $bussUserId->bussiness_id . "/temp.jpg", "uploads/category/" . $bussUserId->bussiness_id . "/$name.jpg");
                rename("uploads/category/" . $bussUserId->bussiness_id . "/thumb/temp.jpg", "uploads/category/" . $bussUserId->bussiness_id . "/thumb/$name.jpg");
            }
        } else {
            if (file_exists("uploads/category/temp.jpg")) {
                rename("uploads/category/temp.jpg", "uploads/category/$name.jpg");
                rename("uploads/category/thumb/temp.jpg", "uploads/category/thumb/$name.jpg");
            }
        }

        return redirect('categories')
            ->with('message-success', 'Category created!');
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

        $category = Category::findOrFail($id);
        
        if (
            !$customer->bussiness_id ||
            $customer->bussiness_id != $bussUserId->bussiness_id
        ) {
            return redirect('customers')
                ->with('message-danger', 'There is no category with that id');
        }

        return view('backend.category.show', compact('category'));
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

        $category = Category::findOrFail($id);

        if (
            !$customer->bussiness_id ||
            $customer->bussiness_id != $bussUserId->bussiness_id
        ) {
            return redirect('customers')
                ->with('message-danger', 'There is no category with that id');
        }

        return view('backend.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param App\Http\Requests $request
     * @param int               $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $bussUserId = BussinessUser::find(Auth::id());

        $form = $request->all();

        if ($bussUserId) {
            $form['bussiness_id'] = $bussUserId->bussiness_id;
        }

        $customer = Category::findOrFail($id);
        $customer->update($form);

        return redirect('categories')
            ->with('message-success', 'Customer updated!');
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

        $customer = Category::findOrFail($id);
        
        if (
            !$customer->bussiness_id ||
            $customer->bussiness_id != $bussUserId->bussiness_id
        ) {
            return redirect('customers')
                ->with('message-danger', 'There is no category with that id');
        }

        $customer->delete();

        return redirect('categories')
            ->with('message-success', 'Category deleted!');
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
                    "uploads/category" : 
                    "uploads/category/" . $bussUserId->bussiness_id
            ); 
            $path = $file->move($store_path, $file_name); 
            $img = Image::make($store_path . "/$file_name"); 
            if($img->exif('Orientation')) { 
                $img = orientate($img, $img->exif('Orientation'));
            }
            
            $path2 = public_path(
                !$bussUserId ?
                "uploads/category/thumb/$file_name" :
                "uploads/category/" . $bussUserId->bussiness_id . "/thumb/$file_name"
            );
            $img->rotate($cp_v[4] * -1);
            $img->crop($cp_v[0], $cp_v[1], $cp_v[2], $cp_v[3]);
            $img->fit(265, 205)->save($path2);
            
            echo url(
                !$bussUserId ?
                "uploads/category/thumb/$file_name" :
                "uploads/category/" . $bussUserId->bussiness_id . "/thumb/$file_name"
            ); exit;
        }
        
        if($image_edit != "") {
            $path = public_path("uploads/category/$file_name");
            $img = Image::make($path);
            $path2 = public_path(
                !$bussUserId ?
                "uploads/category/thumb/$file_name" :
                "uploads/category/" . $bussUserId->bussiness_id . "/thumb/$file_name"
            );
            $img->rotate($cp_v[4] * -1);                
            $img->crop($cp_v[0], $cp_v[1], $cp_v[2], $cp_v[3]);
             $img->fit(265, 205)->save($path2);
            echo url(
                !$bussUserId ?
                "uploads/category/thumb/$file_name" :
                "uploads/category/" . $bussUserId->bussiness_id . "/thumb/$file_name"
            ); exit;
        }
    
    }

}
