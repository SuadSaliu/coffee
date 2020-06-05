<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Sale;
use App\Category;
use App\Product;
use App\BussinessUser;
use Auth;
use Validator;
use DB;
use App\User;
use Config;
use Response;

class WaitingOrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	

    public function orders()
    {
        $bussUserId = BussinessUser::find(Auth::id());

        try {
            $orders = !$bussUserId ?
                DB::table('sales')
                    ->join('tables', 'sales.table_id', '=', 'tables.id')
                    ->leftJoin('customers', 'sales.customer_id', '=', 'customers.id')
                    ->select('sales.id', 'tables.table_name', 'customers.name', 'sales.updated_at')
                    ->where("sales.show_waitress", 0)
                    ->get() :
                DB::table('sales')
                    ->join('tables', 'sales.table_id', '=', 'tables.id')
                    ->leftJoin('customers', 'sales.customer_id', '=', 'customers.id')
                    ->select('sales.id', 'tables.table_name', 'customers.name', 'sales.updated_at')
                    ->where("sales.show_waitress", 0)
                    ->where('sales.bussiness_id', $bussUserId->bussiness_id)
                    ->get();

            return Response::json($orders, 200);
        } catch (\Throwable $th) {
            return Response::json(["error" => 1], 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.waiting_orders.create');
    }

    public function holdOrders(Request $request)
    {
        $ids = $request->input("ids");
        $push_notif = $request->input("push_notif");

        $updated = Sale::whereIn('id', $ids)->update(array("show_waitress" => 1));

        if ($updated) {
            return Response::json([
                "ids" => $request->input("ids"),
                "status" => 'Successfully'
            ], 200);
        }
        
        return Response::json([
            "status" => 'Failed'
        ], 400);
    }

}
