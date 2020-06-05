<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expense;
use App\BussinessUser;
use Auth;

class ExpenseController extends Controller
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
            'expenses' => !$bussUserId ?
                Expense::paginate(20) :
                Expense::where('bussiness_id', $bussUserId->bussiness_id)->paginate(20),
        ];

        return view('backend.expenses.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.expenses.create');
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

        $data = $request->all();
		unset($data['_token']);
        unset($data['id']);

        if ($bussUserId) {
            $data['bussiness_id'] = $bussUserId->bussiness_id;
        }

        if($request->input("id")) {
            $expenses = Expense::where("id", $request->input("id"))->update($data);
			return redirect('expenses')
                ->with('message-success', 'Expense updated!');
        } else { 
            Expense::insert($data);
			return redirect('expenses')
                ->with('message-success', 'Expense created!');
        }
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
        $expense = Expense::findOrFail($id);

        if (
            !$expense->bussiness_id ||
            $expense->bussiness_id != $bussUserId->bussiness_id
        ) {
            return redirect('expenses')
                ->with('message-danger', 'There is no expense with that id');
        }

        return view('backend.expenses.show', compact('expense'));
    }

     public function get(Request $request) 
    { 
        $id = $request->input("id");
        $expnese = Expense::where("id", $id)->first();
        echo json_encode($expnese);
    }


    public function delete(Request $request)
    {
        $id = $request->input("id");
        $expnese = Expense::where("id", $id)->delete();
        echo json_encode($expnese);
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

        $expense = Expense::findOrFail($id);

        if (
            !$expense->bussiness_id ||
            $expense->bussiness_id != $bussUserId->bussiness_id
        ) {
            return redirect('expenses')
                ->with('message-danger', 'There is no expense with that id');
        }

        $expense->delete();

        return redirect('expenses')
            ->with('message-success', 'Expense deleted!');
    }
}
