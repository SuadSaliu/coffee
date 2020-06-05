<?php

namespace App\Http\Controllers;

use App\Customer;
use App\BussinessUser;
use Auth;
use App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class CustomerController extends Controller
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
            'customers' => !$bussUserId ?
                Customer::paginate(20) :
                Customer::where('sales.bussiness_id', $bussUserId->bussiness_id)->paginate(20),
        ];

        return view('customers.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param App\Http\Requests $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\StoreCustomer $request)
    {
        $bussUserId = BussinessUser::find(Auth::id());

        $form = $request->all();

        if ($bussUserId) {
            $form['bussiness_id'] = $bussUserId->bussiness_id;
        }

        $customer = Customer::create($form);

        return redirect('customers')
            ->with('message-success', 'Customer created!');
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

        $customer = Customer::findOrFail($id);

        if (
            !$customer->bussiness_id ||
            $customer->bussiness_id != $bussUserId->bussiness_id
        ) {
            return redirect('customers')
                ->with('message-danger', 'There is no customer with that id');
        }

        return view('customers.show', compact('customer'));
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

        $customer = Customer::findOrFail($id);

        if (
            !$customer->bussiness_id ||
            $customer->bussiness_id != $bussUserId->bussiness_id
        ) {
            return redirect('customers')
                ->with('message-danger', 'There is no customer with that id');
        }

        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param App\Http\Requests $request
     * @param int               $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\UpdateCustomer $request, $id)
    {
        $form = $request->all();

        $customer = Customer::findOrFail($id);
        $customer->update($form);

        return redirect('customers')
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

        $customer = Customer::findOrFail($id);

        if (
            !$customer->bussiness_id ||
            $customer->bussiness_id != $bussUserId->bussiness_id
        ) {
            return redirect('customers')
                ->with('message-danger', 'There is no customer with that id');
        }

        $customer->delete();

        return redirect('customers')
            ->with('message-success', 'Customer deleted!');
    }
	
	public function findcustomer() { 
		$phone = Input::get('phone'); 
		$record = Customer::where("phone",$phone)->first();
		echo json_encode($record);
	}
    
	public function storeCustomer(Request $request) {
        $bussUserId = BussinessUser::find(Auth::id());

        $id = $request->input("id");
		$data_array = array();
		$data = array(
			"name" => $request->input("name"),
			"phone" => $request->input("phone"),
			"email" => $request->input("email"),
			"neighborhood" => $request->input("neighborhood"),
			"address" => $request->input("address"),
            "comments" => $request->input("comments"),
        );

        $checkEmail = Customer::where('email', $data['email'])->first();

        if ($checkEmail) {
            return response()->json(
                [ 'errors' => $validator->errors()->all()], 400
            );
        }

        if ($bussUserId) {
            $data['bussiness_id'] = $bussUserId->bussiness_id;
        }

		$data_array["message"] = "OK";
		if($id) {
			Customer::where("id" , $id)->update($data);
			$data_array["id"] = $id;
		} else { 
            $data["password"] = bcrypt($data["name"]);
			$insert_id = Customer::insertGetId($data);
			$data_array["id"] = $insert_id;
		}
		
		echo json_encode($data_array);
	}
}
