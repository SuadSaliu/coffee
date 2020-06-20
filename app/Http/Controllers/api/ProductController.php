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
        $bussUserId = $request->query('bussinessId');

        if (!$bussUserId) {
            return Response::json([
                'error' => 'There missing bussiness id'
            ], 400);
        }

        $products = (!$catQuery) ?
            Product::orderBy('name', 'asc')->where('bussiness_id', $bussUserId)->paginate(10) :
            Product::where('category_id', $catQuery)->where('bussiness_id', $bussUserId)->orderBy('name', 'asc')->paginate(10);

        return Response::json($products, 200);
    }

    /**
     * Getting All Categories
     */
    public function categories(Request $request)
    {
        $bussUserId = (int)$request->query('bussinessId');

        if (!$bussUserId) {
            return Response::json([
                'error' => 'There missing bussiness id'
            ], 400);
        }

        $categories = Category::where('bussiness_id', $bussUserId)->select(['id', 'name'])->orderBy('name', 'asc')->get();

        return Response::json($categories, 200);
    }

    /**
     * Getting All Categories
     */
    public function order(Request $request)
    {
        $bussUserId = (int)$request->query('bussinessId');

        if (!$bussUserId) {
            return Response::json([
                'error' => 'There missing bussiness id'
            ], 400);
        }
        
        $form = $request->all();

        $form['bussiness_id'] = $bussUserId;
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
    public function receiptTicket(Request $request, $id) {
        $bussUserId = (int)$request->query('bussinessId');

        if (!$bussUserId) {
            return Response::json([
                'error' => 'There missing bussiness id'
            ], 400);
        }

        try {
            $image = \QrCode::format('png')
                    ->size(200)
                    ->generate(Config::get('constants.qrCodeUrl'),
                                public_path('uploads/qr/qr' . $id . '.png'));

            $data = [
                'sale' => Sale::findOrFail($id),
                'qr_path' => "uploads/qr". $id .".png"
            ];

            if (
                !$data['sale']->bussiness_id ||
                $data['sale']->bussiness_id != $bussUserId
            ) {
                return Response::json(["error" => 2], 403);
            }

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
            $bussUserId = (int)$request->query('bussinessId');
    
            if (!$bussUserId) {
                return Response::json([
                    'error' => 'There missing bussiness id'
                ], 400);
            }

            $orders = DB::table('sales')
                ->join('tables', 'sales.table_id', '=', 'tables.id')
                ->leftJoin('customers', 'sales.customer_id', '=', 'customers.id')
                ->select('sales.id', 'tables.table_name', 'customers.name', 'sales.updated_at')
                ->where("sales.show_waitress", 0)
                ->where('sales.bussiness_id', $bussUserId)
                ->paginate(10);

            return Response::json($orders, 200);
        } catch (\Throwable $th) {
            return Response::json(["error" => 1], 400);
        }
    }

    /**
     * Getting All Orders with status available
     */
    public function holdWaitingOrders(Request $request) 
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
