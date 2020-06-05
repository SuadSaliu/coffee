<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\BussinessUser;
use App\Sale;
use App\Product;
use DB;
class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bussUserId = BussinessUser::find(Auth::id());
        
        if(Auth::user()->role_id == 2) { 
            return redirect("sales/create");
        }
        $now = date('Y-m-d 23:59:59');
        $yersterday = date('Y-m-d 00:00:00', strtotime('- 1 day'));
        $today_date = date('Y-m-d 00:00:00');
        $last_month = date('Y-m-d h:i:s', strtotime('- 1 month'));
        $last_2month = date('Y-m-d h:i:s', strtotime('- 2 month'));
        $this_month_start = date('Y-m-d h:i:s', strtotime('first day of this month'));
        $previous_month_start = date('Y-m-d h:i:s', strtotime('first day of previous month'));
        $last_week = date('Y-m-d h:i:s', strtotime('- 1 week'));
        $last_month = date('Y-m-d h:i:s', strtotime('- 1 month'));
        $total_date = date('Y-m-d h:i:s', strtotime('- 100 month'));


        $data['today'] = $this->getSalesPrice($bussUserId, $today_date, $now);
        $data['yesterday'] = $this->getSalesPrice($bussUserId, $yersterday, $today_date);
        $data['last_week'] = $this->getSalesPrice($bussUserId, $last_week, $now);
        $data['last_month'] = $this->getSalesPrice($bussUserId, $last_month, $now);
        $data['total_earning'] = $this->getSalesPrice($bussUserId, $total_date, $now);
        $data['total_sales'] = count(!$bussUserId ?
                                        Sale::get() :
                                        Sale::where('bussiness_id', $bussUserId->bussiness_id)->get());
        $data['total_sales_today'] = $this->getSalesTotal($bussUserId, $today_date, $now);
        $data['total_sales_yesterday'] = $this->getSalesTotal($bussUserId, $yersterday, $today_date);
        $data['total_sales_last_week'] = $this->getSalesTotal($bussUserId, $last_week, $now);
        $data['total_sales_last_month'] = $this->getSalesTotal($bussUserId, $last_month, $now);
		
        $data['transections_7_days'] = $this->getRevenueRransections($bussUserId, 7);
		$data['transections_30_days'] = $this->getRevenueRransections($bussUserId, 30);
        $data['get_orders_365'] = $this->getRevenueTransectionsYearly($bussUserId, 365);
		
		$data['transections_7_days_online'] = $this->getRevenueRransections($bussUserId, 7 , 'order');
		$data['transections_30_days_online'] = $this->getRevenueRransections($bussUserId, 30, 'order');
        $data['get_orders_365_online'] = $this->getRevenueTransectionsYearly($bussUserId, 365, 'order');
		
		//echo "<pre>"; print_r($data['get_revenue_transections_365']); exit;
       
       
        
        $sales_by_product = !$bussUserId ?
                            DB::select("SELECT  SUM(quantity) as total_sales,product_id FROM sale_items GROUP BY (product_id) ORDER BY total_sales DESC LIMIT 10") :
                            DB::select("SELECT  SUM(quantity) as total_sales,product_id FROM sale_items WHERE bussiness_id = " . $bussUserId->bussiness_id . " GROUP BY (product_id) ORDER BY total_sales DESC LIMIT 10");

        if(!empty($sales_by_product)) {
            foreach ($sales_by_product as $sale) {

                $product = !$bussUserId ?
                    DB::table("products")->where("id", $sale->product_id)->first() :
                    DB::table("products")->where("id", $sale->product_id)->where('bussiness_id', $bussUserId->bussiness_id)->first();
                
                $sale->product_name = "";
                if (!empty($product))
                    $sale->product_name = $product->name;

            }
		}
        $data["sales_by_product"] = $sales_by_product;
      
        $data['sales'] = !$bussUserId ?
            Sale::orderBy("sales.id", "DESC")->limit(10)->get() :
            Sale::where('bussiness_id', $bussUserId->bussiness_id)->orderBy("sales.id", "DESC")->limit(10)->get();
	
        return view('backend.dashboard.home', $data);
    }
    
    function sortBy($a, $b)
    {
        return strcmp($a->total_sales, $b->total_sales);
    }
    
    public function getSalesPrice($bussUserId, $start , $end) 
    {
        $query = !$bussUserId ?
            DB::table("sales")->where("created_at", ">=", $start)->where("created_at", "<=", $end)->where("status", 1)->sum("amount") :
            DB::table("sales")->where('bussiness_id', $bussUserId->bussiness_id)->where("created_at", ">=", $start)->where("created_at", "<=", $end)->where("status", 1)->sum("amount");
        
        return $query;
    } 
    
    public function getSalesTotal($bussUserId, $start , $end) 
    { 
        $query = !$bussUserId ?
            Sale::where("created_at", ">=", $start)->where("created_at", "<=", $end)->where("status", 1)->get() :
            Sale::where("created_at", ">=", $start)->where('bussiness_id', $bussUserId->bussiness_id)->where("created_at", "<=", $end)->where("status", 1)->get();
        
        return count($query);
    } 
    
   

    public function getRevenueRransections($bussUserId, $date_difference="" , $type="pos") {
        $where = "";
		$today='';
        if($today != ""){
            $where = "DATE(created_at) = '".date("Y-m-d")."'";
        } else {
            $where = "created_at BETWEEN NOW() - INTERVAL ".$date_difference." DAY AND NOW()";
        }
        $query = !$bussUserId ?
			DB::select("SELECT SUM(amount) as amount, DATE_FORMAT(created_at,'%W') as day, DATE_FORMAT(created_at,'%d') as dat, DATE_FORMAT(created_at,'%M') as mon, created_at as dated FROM `sales` WHERE type='$type' AND  ".$where." GROUP BY DATE(created_at) ORDER BY created_at DESC") :
			DB::select("SELECT SUM(amount) as amount, DATE_FORMAT(created_at,'%W') as day, DATE_FORMAT(created_at,'%d') as dat, DATE_FORMAT(created_at,'%M') as mon, created_at as dated FROM `sales` WHERE bussiness_id = " . $bussUserId->bussiness_id . " AND type='$type' AND  ".$where." GROUP BY DATE(created_at) ORDER BY created_at DESC");
        return $query;
    }
	
	public function getRevenueTransectionsYearly($bussUserId, $date_difference="" , $type="pos") {
        $where = "";
        if($date_difference != ""){
            $where = "created_at BETWEEN NOW() - INTERVAL ".$date_difference." DAY AND NOW()";
        }
		
		$query = !$bussUserId ?
			DB::select("SELECT SUM(amount) as amount, DATE_FORMAT(created_at,'%W') as day, DATE_FORMAT(created_at,'%d') as dat, DATE_FORMAT(created_at,'%M') as mon, created_at as dated FROM `sales` WHERE  type='$type' AND ".$where." GROUP BY MONTH(created_at) ORDER BY created_at DESC") : 
			DB::select("SELECT SUM(amount) as amount, DATE_FORMAT(created_at,'%W') as day, DATE_FORMAT(created_at,'%d') as dat, DATE_FORMAT(created_at,'%M') as mon, created_at as dated FROM `sales` WHERE  type='$type' AND bussiness_id = " . $bussUserId->bussiness_id . " AND ".$where." GROUP BY MONTH(created_at) ORDER BY created_at DESC");
        return $query;
    }

}
