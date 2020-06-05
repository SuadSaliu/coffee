<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\BussinessUser;
use App\Sale;
use Session;
use Validator;
use App\Http\Requests;

class OrderController extends Controller
{

    public function __construct() 
    {
        $this->middleware('auth');
    }

    /**
     * Page Lisitng on admin.
     */
    public function index() 
    {
        $bussUserId = BussinessUser::find(Auth::id());

        $data['incomplete'] = !$bussUserId ?
            Sale::where("type", "order")->where("status", 2)->orderBy("id", "DESC")->limit(10)->get() :
            Sale::where("type", "order")->where("status", 2)->where('bussiness_id', $bussUserId->bussiness_id)->orderBy("id", "DESC")->limit(10)->get();
       
        $data['completed'] = !$bussUserId ?
            Sale::where("type", "order")->where("status", 1)->orderBy("id", "DESC")->limit(10)->get() :
            Sale::where("type", "order")->where("status", 1)->where('bussiness_id', $bussUserId->bussiness_id)->orderBy("id", "DESC")->limit(10)->get();
        
        $data['canceled'] = !$bussUserId ?
            Sale::where("type", "order")->where("status", 0)->orderBy("id", "DESC")->limit(10)->get() :
            Sale::where("type", "order")->where("status", 0)->where('bussiness_id', $bussUserId->bussiness_id)->orderBy("id", "DESC")->limit(10)->get();
        
        $data['title'] = "Orders";

        return view('backend.orders.index', $data);
    }

    public function orders() 
    {
        $bussUserId = BussinessUser::find(Auth::id());

        $orders = !$bussUserId ?
            Sale::select("*" , "sales.id as id")->where("type", "order")->leftJoin("sale_items as s" , "s.sale_id" , '=', "sales.id" )->orderBy("sales.id", "DESC")->paginate(25) :
            Sale::select("*" , "sales.id as id")->where("type", "order")->leftJoin("sale_items as s" , "s.sale_id" , '=', "sales.id" )->where('sales.bussiness_id', $bussUserId->bussiness_id)->orderBy("sales.id", "DESC")->paginate(25);
        
        return view('backend.orders.allorders', ["orders" => $orders, "title" => "Orders"]);
    }

    public function ChangeStatus(Request $request) 
    {
        $bussUserId = BussinessUser::find(Auth::id());

        $incomplete = $request->input('incomplete');
        $canceled = $request->input('canceled');
        $completed = $request->input('completed');
        $IncompleteIds = array();
        $canceledIds = array();
        $CompletedIds = array();
        if (!empty($incomplete)) {
            foreach ($incomplete as $todo) {
                $IncompleteIds[] = $todo;
            }
        }
        if (!empty($completed)) {
            foreach ($completed as $inp) {
                $CompletedIds[] = $inp;
            }
        }
        if (!empty($canceled)) {
            foreach ($canceled as $com) {
                $canceledIds[] = $com;
            }
        }

        if ($bussUserId) {
            Sale::whereIn('id', $IncompleteIds)->where('bussiness_id', $bussUserId->bussiness_id)->update(array("status" => 2));
            Sale::whereIn('id', $CompletedIds)->where('bussiness_id', $bussUserId->bussiness_id)->update(array("status" => 1));
            Sale::whereIn('id', $canceledIds)->where('bussiness_id', $bussUserId->bussiness_id)->update(array("status" => 0));
        } else {
            Sale::whereIn('id', $IncompleteIds)->update(array("status" => 2));
            Sale::whereIn('id', $CompletedIds)->update(array("status" => 1));
            Sale::whereIn('id', $canceledIds)->update(array("status" => 0));
        }
    }
	
	
	public function completeSale(Request $request)
    {
        $bussUserId = BussinessUser::find(Auth::id());

        $form = $request->all();
        // Set up the bussiness id
        if ($bussUserId) {
            $form['bussiness_id'] = $bussUserId->bussiness_id;
        }

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
		
		if($request->input("payment_with") == "card") { 
			$cc_number = $request->input("cc_number");
			$cc_month = $request->input("cc_month");
			$cc_year = $request->input("cc_year");
			$cc_code = $request->input("cc_code");
			$amount = $request->input("total_cost");
			$amount *= 100;
            \Stripe\Stripe::setApiKey(env("STRIPE_SECRET"));

			try {
                $token = \Stripe\Token::create(
                    array(
                        "card" => array(
                        "number" => $cc_number,
                        "exp_month" => $cc_month,
                        "exp_year" => $cc_year,
                        "cvc" => $cc_code
                    )
                )
                );
            } catch (\Stripe\Error\Card $e) {
                $token = $e->getJsonBody();
                $errors = array(
                    "error" => 1,
                    "message" => $token['error']['message']
                );

                echo  json_encode($errors);exit;
            }

            // Get the payment token submitted by the form:
            $stripeToken = $token['id'];

            // Create a Customer:
            $customer = \Stripe\Customer::create(
                array(
                    "email" => Auth::user()->email,
                    "source" => $token,
                )
            );

            // Charge the Customer instead of the card:
            $charge = \Stripe\Charge::create(
                array(
                    "amount" => round($amount),
                    "currency" => "USD",
                    "customer" => $customer->id
                )
            );
		}
		
        unset($form["cc_number"]);
        unset($form["cc_month"]);
        unset($form["cc_year"]);
        unset($form["cc_code"]);
        unset($form["total_cost"]);
        
        $form['show_waitress'] = 0;

        $sale = Sale::createAll($form);

        $errors = array(
            "error" => 0,
            "message" => "Thank you for your Order. We will contact you soon."
        );
        echo  json_encode($errors);exit;
    }
	

}
