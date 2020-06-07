<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Table;
use Config;
use PDF;
use Auth;
use App\BussinessUser;
use App\Bussiness;
use App\Category;

class TableController extends Controller
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
            'tables' => !$bussUserId ?
                Table::all() :
                Table::where('bussiness_id', $bussUserId->bussiness_id)->get()
        ];

        return view('backend.tables.index', $data);
    }

    /**
     * Display the menu.
     *
     * @return \Illuminate\Http\Response
     */
    public function tableMenu(Request $request)
    {
        $pathUri = $request->getPathInfo();
        $splitedUri = explode('/', $pathUri);

        $data = [
            'table_id' => (int)$splitedUri[2], 
            'bussiness_id' => (int)$splitedUri[3], 
        ];

        $checkTableId = Table::findOrFail($data['table_id']);
        $checkBussinessId = Bussiness::findOrFail($data['bussiness_id']);

        if (!$checkTableId || !$checkBussinessId) {
    		echo "Error: Please try again later.";
            return;
        }

        // return redirect()->route('menu', $data);
        return redirect()->route('menu/' . $data[bussiness_id]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.tables.create');
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
        $data = $request->all();
		unset($data['_token']);
        unset($data['id']);
        
        $bussUserId = BussinessUser::find(Auth::id());
        if ($bussUserId) {
            $data['bussiness_id'] = $bussUserId->bussiness_id;
        }

		 if($request->input("id")) { 
            Table::where("id", $request->input("id"))->update($data);
			return redirect('tables')
            ->with('message-success', 'Table updated!');
        } else { 
            Table::insert($data);

            $lastId = Table::latest()->first()->id;
            $url = $request->root() . '/table/' . $lastId;

            if ($bussUserId) {
                $url .= '/' . $bussUserId->bussiness_id;
            }
            
            $path = !$bussUserId ?
                'uploads/qr/' :
                'uploads/qr/' . $bussUserId->bussiness_id . '/';

            if (!file_exists(public_path($path))) {
                mkdir(public_path($path), 777, true);
            }

            \QrCode::format('png')
                ->size(200)
                ->generate($url,
                        public_path($path . 'table-' . $lastId . '.png'));

			return redirect('tables')
            ->with('message-success', 'Table created!');
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
        $bussUserId = BussinessUser::find(Auth::id());
        $table = !$bussUserId ?
                Table::findOrFail($id) :
                Table::findOrFail($id)
                    ->where('bussiness_id', $bussUserId->bussiness_id);

        if (
            !$table->bussiness_id ||
            $table->bussiness_id != $bussUserId->bussiness_id
        ) {
            return redirect('expenses')
                ->with('message-danger', 'There is no table with that id');
        }

        return view('backend.tables.show', compact('table'));
    }

     public function get(Request $request) 
    { 
        $id = $request->input("id");
        $expnese = Table::where("id", $id)->first();
        echo json_encode($expnese);
    }


    public function delete(Request $request)
    {
        $id = $request->input("id");
        $expnese = Table::where("id", $id)->delete();
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

        $expense = !$bussUserId ?
                    Table::findOrFail($id) :
                    Table::findOrFail($id)
                        ->where('bussiness_id', $bussUserId->bussiness_id);
        
        if (
            !$table->bussiness_id ||
            $table->bussiness_id != $bussUserId->bussiness_id
        ) {
            return redirect('expenses')
                ->with('message-danger', 'There is no table with that id');
        }

        $expense->delete();

        return redirect('expenses')
            ->with('message-success', 'Table deleted!');
    }

    public function tablePDF()
    {
        $bussUserId = BussinessUser::find(Auth::id());

        $tableAll = !$bussUserId ?
                        Table::all() :
                        Table::where('bussiness_id', $bussUserId->bussiness_id)->get();

        $data = [
            'title' => "Tables",
            'tables' => $tableAll
        ];

        // Send data to the view using loadView function of PDF facade
        $pdf = PDF::loadView('backend.tables.table-pdf', $data);
        // If you want to store the generated pdf to the server then you can use the store function
        // $pdf->save(storage_path().'_filename.pdf');
        // Finally, you can download the file using download function

        set_time_limit(300); // Extends to 5 minutes.
        return $pdf->download('table.pdf');
    }
}
