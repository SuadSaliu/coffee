<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Bussiness;

class BussinessController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'bussiness' => Bussiness::paginate(10),
        ];

        return view('backend.bussiness.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.bussiness.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param App\Http\Requests $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\StoreBussiness $request)
    {
        $form = $request->all();

        $form['id'] = abs( crc32( uniqid() ) );

        $bussiness = Bussiness::create($form);
		
        return redirect('bussiness')
            ->with('message-success', 'Bussiness created!');
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
        $bussiness = Bussiness::findOrFail($id);

        $data = [
            'bussiness'  => $bussiness
        ];

        return view('backend.bussiness.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param App\Http\Requests $request
     * @param int               $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\UpdateBussiness $request, $id)
    {
        $form = $request->all();

        $bussiness = Bussiness::findOrFail($id);
        $bussiness->update($form);
		
        return redirect('bussiness')
            ->with('message-success', 'Bussiness updated!');
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
        $bussiness = Bussiness::findOrFail($id);
        $bussiness->delete();

        return redirect('bussiness')
            ->with('message-success', 'Bussiness account deleted!');
    }

}
