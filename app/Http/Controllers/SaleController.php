<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Sale;
use App\Category;
use App\Product;
use Auth;
use App\BussinessUser;

use Validator;
use DB;
use App\User;
use Config;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $bussUserId = BussinessUser::find(Auth::id());

        $keyword = $request->get('q', '');
        $data["q"] = $keyword;
        $ids = array();
        if ($keyword) {
            $users = User::where("role_id", "!=", 4)->where("name", "like", "%$keyword%")->get();
            foreach ($users as $user) {
                $ids[] = $user->id;
            }
        }

        if (Auth::user()->role_id == 1) {
            if (!empty($ids)) {
                $sales = !$bussUserId ?
                    Sale::select("*", "sales.id as id")->leftJoin("sale_items as s", "s.sale_id", '=', "sales.id")->whereIn("cashier_id", $ids)->groupBy("sales.id")->orderBy("sales.id", "DESC")->paginate(25) :
                    Sale::select("*", "sales.id as id")->leftJoin("sale_items as s", "s.sale_id", '=', "sales.id")->whereIn("cashier_id", $ids)->where('sales.bussiness_id', $bussUserId->bussiness_id)->groupBy("sales.id")->orderBy("sales.id", "DESC")->paginate(25);
            } else {
                $sales = !$bussUserId ?
                    Sale::select("*", "sales.id as id")->leftJoin("sale_items as s", "s.sale_id", '=', "sales.id")->groupBy("sales.id")->orderBy("sales.id", "DESC")->paginate(25) :
                    Sale::select("*", "sales.id as id")->leftJoin("sale_items as s", "s.sale_id", '=', "sales.id")->groupBy("sales.id")->where('sales.bussiness_id', $bussUserId->bussiness_id)->orderBy("sales.id", "DESC")->paginate(25);
            }

            $sales = !empty($keyword) ? $sales->appends(['q' => $keyword]) : $sales;
            $data['sales'] = $sales;

        } else {
            $data['sales'] = !$bussUserId ?
                Sale::where("cashier_id", Auth::user()->id)->leftJoin("sale_items as s", "s.sale_id", '=', "sales.id")->orderBy("sales.id", "DESC")->paginate(25) :
                Sale::where("cashier_id", Auth::user()->id)->leftJoin("sale_items as s", "s.sale_id", '=', "sales.id")->where('sales.bussiness_id', $bussUserId->bussiness_id)->orderBy("sales.id", "DESC")->paginate(25);
        }

        return view('backend.sales.index', $data);
        
        // if(Auth::user()->role_id == 1) { 
        //     $data['sales'] = Sale::select("*" , "sales.id as id")->where("type", "pos")->leftJoin("sale_items as s" , "s.sale_id" , '=', "sales.id" )->orderBy("sales.id", "DESC")->paginate(25);
        // } else { 
        //     $data['sales'] = Sale::where("cashier_id", Auth::user()->id)->leftJoin("sale_items as s" , "s.sale_id" , '=', "sales.id" )->orderBy("sales.id", "DESC")->paginate(25);
        // }
        
        // return view('backend.sales.index', $data);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bussUserId = BussinessUser::find(Auth::id());

        $data['categories'] = !$bussUserId ?
                                Category::get() :
                                Category::where('bussiness_id', $bussUserId->bussiness_id)->get();
        $data['products'] = !$bussUserId ?
                                Product::get() :
                                Product::where('bussiness_id', $bussUserId->bussiness_id)->get();

        $data['tables'] = !$bussUserId ? 
                                DB::table("tables")->get() :
                                DB::table("tables")->where('bussiness_id', $bussUserId->bussiness_id)->get();
        
        return view('backend.sales.create', $data);
    }

    public function receipt($id)
    {
        $bussUserId = BussinessUser::find(Auth::id());

        $image = \QrCode::format('png')
                    ->size(200)
                    ->generate(Config::get('constants.qrCodeUrl'),
                                public_path('uploads/qr/qr' . $id . '.png'));

        $data = [
            'sale' => Sale::findOrFail($id),
            'qr_path' => "qrcode". $id .".png"
        ];

        if (
            !$data['sale']->bussiness_id ||
            $data['sale']->bussiness_id != $bussUserId->bussiness_id
        ) {
            return redirect('sales')
                ->with('message-danger', 'There is no recipt with that id');
        }

        return view('backend.sales.receipt', $data);
    }
    
    public function completeSale(Request $request)
    {
        $bussUserId = BussinessUser::find(Auth::id());

        $form = $request->all();
        
        if ($bussUserId) {
            $form['bussiness_id'] = $bussUserId->bussiness_id;
        }
        
        $form['show_waitress'] = 0;

		$items = $request->input('items');
		$amount = 0;
		foreach($items as $item) { 
			$amount += $item['price'] * $item['quantity'];
		}	
		$amount += $request->input('vat') + $request->input('delivery_cost') - $request->input('discount');
		$form['amount'] = $amount;
		
        $rules = Sale::$rules;
        $rules['items'] = 'required';

        $validator = Validator::make($form, $rules);

        if ($validator->fails()) {
            return response()->json(
                [
                'errors' => $validator->errors()->all(),
                ], 400
            );
        }
        $sale = Sale::createAll($form);

        return url("sales/receipt/".$sale->id);
    }
    
    public function cancel($id)
    {
        Sale::where("id", $id)->update(array("status" => 0));
        return redirect("sales");
    }


    public function holdOrder(Request $request)
    {
        $bussUserId = BussinessUser::find(Auth::id());

        $id = $request->input("id");
        $form = [
            "table_id" => (int)$request->input("table_id"),
            "cart" => json_encode($request->input("cart")),
            "comment" => $request->input("comment"),
            "user_id" => Auth::user()->id
        ];

        if ($bussUserId) {
            $form['bussiness_id'] = $bussUserId->bussiness_id;
        }
        
        if ($id) {
            DB::table("hold_order")->where("id", $id)->update($form);
            exit;
        }

        $table = !$bussUserId ?
            DB::table("hold_order")->where("table_id", $table_id)->where("status" , 0)->count() :
            DB::table("hold_order")->where('bussiness_id', $bussUserId->bussiness_id)->where("table_id", $form['table_id'])->where("status" , 0)->count();
        
        if ($table > 0) {
            echo "Table already on Hold";
            exit;
        }
        DB::table("hold_order")->insert($form);

    }

    public function viewHoldOrder(Request $request)
    {
        $bussUserId = BussinessUser::find(Auth::id());

        $id = $request->input("id");
        $order = DB::table("hold_order")->where("id", $id)->first();
        
        if (
            !$order->bussiness_id ||
            $order->bussiness_id != $bussUserId->bussiness_id
        ) {            
            return redirect('sales/create')
                ->with('message-danger', 'There is no id of hold order');
        }

        echo $order->cart;
    }

    public function holdOrders(Request $request)
    {
        $bussUserId = BussinessUser::find(Auth::id());

        $orders = !$bussUserId ?
            DB::table("hold_order")->where("status", 0)->get() :
            DB::table("hold_order")->where("status", 0)->where('bussiness_id', $bussUserId->bussiness_id)->get();
        
        foreach ($orders as $order) {
            $user = User::find($order->user_id);
            $table = !$bussUserId ?
                DB::table("tables")->where("id", $order->table_id)->first() :
                DB::table("tables")->where('bussiness_id', $bussUserId->bussiness_id)->where("id", $order->table_id)->first();
            
            $order->username = "";
            if (!empty($user)) {
                $order->username = $user->name;
                $order->table = "No Table Found";
                if(!empty($table))
                $order->table = $table->table_name;
            }
        }
        echo json_encode($orders);
    }

    public function removeHoldOrder(Request $request)
    {
        $id = $request->input("id");
        DB::table("hold_order")->where("id", $id)->update(array("status" => 1));
    }
	
    
}
