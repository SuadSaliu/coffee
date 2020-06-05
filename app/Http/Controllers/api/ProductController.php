<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\PushNotificationTrait;

use App\Category;
use App\Product;
use App\BussinessUser;

use Response;
use Config;
use DB;

use App\Sale;
use Validator;
use Session;
use Stripe;

class ProductController extends Controller
{
    use PushNotificationTrait;

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

    /**
     * Getting All Categories
     */
    public function order(Request $request)
    {
        $form = $request->all();
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
            return Response::json(
                ['errors' => $validator->errors()->all()], 400
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
                return Response::json($errors, 400);
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
                 
        $sale = Sale::createAll($form);

        return Response::json([
            "error" => 0,
            "sale_id" => $sale->id,
            "message" => "Thank you for your Order. We will contact you soon."
        ], 201);
    }

    
    /**
     * Getting All Categories
     */
    public function receiptTicket($id) {
        return Response::json(["error" => 1], 400);
        try {
            $image = \QrCode::format('png')
                    ->size(200)
                    ->generate(Config::get('constants.qrCodeUrl'),
                                public_path('uploads/qr/qr' . $id . '.png'));

            $data = [
                'sale' => Sale::findOrFail($id),
                'qr_path' => "uploads/qr". $id .".png"
            ];

            return Response::json($data, 200);
        } catch (\Throwable $th) {
            return Response::json(["error" => 1], 400);
        }
    }

    
    /**
     * Getting All Orders with status available
     */
    public function waitingOrders(Request $request) 
    {
        try {
            $bussUserId = BussinessUser::find($request->user()->id);

            $orders = !$bussUserId ?
                DB::table('sales')
                    ->join('tables', 'sales.table_id', '=', 'tables.id')
                    ->leftJoin('customers', 'sales.customer_id', '=', 'customers.id')
                    ->select('sales.id', 'tables.table_name', 'customers.name', 'sales.updated_at')
                    ->where("sales.show_waitress", 0)
                    ->paginate(10) :
                DB::table('sales')
                ->join('tables', 'sales.table_id', '=', 'tables.id')
                ->leftJoin('customers', 'sales.customer_id', '=', 'customers.id')
                ->select('sales.id', 'tables.table_name', 'customers.name', 'sales.updated_at')
                ->where("sales.show_waitress", 0)
                ->where('sales.bussiness_id', $bussUserId->bussiness_id)
                ->paginate(10);

            return Response::json($orders, 200);
        } catch (\Throwable $th) {
            return Response::json(["error" => 1], 400);
        }
    }

    /**
     * Getting All Orders with status available
     */
    public function holdWaitingOrders() 
    {
        $ids = $request->input("ids");
        $push_notif = $request->input("push_notif");

        $updated = Sale::whereIn('id', $ids)->update(array("show_waitress" => 1));

        if ($updated) {
            if ($push_notif) {
                $this->send_notification_android();
            }

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
