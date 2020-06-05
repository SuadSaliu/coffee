<?php

namespace App\Http\Controllers;

use App\Adjustment;
use Auth;
use App\BussinessUser;

class AdjustmentController extends Controller
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
            'adjustments' => !$bussUserId ?
                Adjustment::all() :
                Adjustment::all()->where('bussiness_id', $bussUserId->bussiness_id),
        ];

        return view('inventories.adjustments.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventories.adjustments.create');
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
        //
    }
}
