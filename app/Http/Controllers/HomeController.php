<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\Page;
use App\Sale;
use DB,
    Auth,
    Mail;
use App\Mail\Test;
use App\Mail\Contact;
use Config;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() 
    {
        // $this->middleware('auth');
    }

    public function index() 
    {
        $categories = Category::get();
        return view('home', compact('categories'));
    }

    public function about() 
    {
        $page = Page::find(3);
        return view('pages.about', ['page' => $page]);
    }

    public function faqs() 
    {
        $page = Page::find(2);
        return view('pages.dynamic', ['page' => $page]);
    }

    public function termsCondition() 
    {
        $page = Page::find(1);
        return view('pages.dynamic', ['page' => $page]);
    }

    public function contact() 
    {
        return view('pages.contact');
    }

    public function contactSave(Request $request) 
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $message = $request->input('message');
        $content = array(
            "name" => $name,
            "email" => $email,
            "message" => $message
        );
        Mail::to(Config::get('constants.mail_email'))->send(new Contact($content));
        Mail::to($email)->send(new Contact($content));
        echo "success";
    }

    public function ourMenu() 
    {
        $categories = Category::get();
        return view('pages.menu', compact('categories'));
    }

    public function testMail() 
    {
        $content = array(
            "name" => Config::get('constants.mail_name')
        );

        //return view("emails.booking");
        Mail::to(Config::get('constants.mail_email'))->send(new Test($content));

        echo 'Mail Sent!';
    }
	
	// public function import() { 
	// 	$sales = Sale::get();
	// 	foreach($sales as $sale) { 
	// 		$items = DB::table("sale_items")->where("sale_id" , $sale->id)->get();
	// 		$amount = 0;
	// 		foreach($items as $item) { 
	// 			$amount = $item->quantity * $item->price;
	// 		}
	// 	 Sale::where("id" , $sale->id)->update(array("amount" => $amount));
	// 	}
	// 	echo "Done";
	// 	//DB::unprepared(file_get_contents('db/pos.sql'));
	// }

}
