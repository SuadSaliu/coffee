<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Role;
use App\Bussiness;
use App\BussinessUser;
use App\User;
use DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

		foreach($users as $user) {
            try {
                $user->role = Role::find($user->role_id);
            } catch (\Throwable $th) {}
            try {
                $getBusRole = BussinessUser::findOrFail($user->id)->bussiness_role;
                $user->bussiness_role = $getBusRole == 1 ? 'Admin' : 'User'; 
            } catch (\Throwable $th) {
                $user->bussiness_role = '';
            }
		}
		
        $data['users'] = $users;

        return view('backend.users.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'roles' => Role::get(),
            'bussiness' => Bussiness::get()
        ];

        return view('backend.users.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param App\Http\Requests $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\StoreUser $request)
    {
        $form = $request->all();
        
        $user = User::create(
            array(
                "name" => $form['name'],
                "email" => $form['email'],
                "role_id" => $form['role_id'],
                "password" => $form['password']
            )
        );
		DB::table('role_user')->insert(
            array("role_id" => $form['role_id'] , 'user_id' => $user->id)
        );
		DB::table('bussiness_user')->insert(
            array(
                "user_id" => $user->id,
                'bussiness_id' => $form['bussiness_id'],
                'bussiness_role' => $form['bussiness_role']
            )
        );

        return redirect('users')
            ->with('message-success', 'User created!');
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
        $user = User::findOrFail($id);

        return view('backend.users.show', compact('user'));
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
        $user = User::findOrFail($id);

        $data = [
            'user'  => $user,
            'roles' => Role::get(),
            'bussiness' => Bussiness::get()
        ];

        try {
            $getBusRole = BussinessUser::findOrFail($id);
            $data['bussiness_id'] = $getBusRole->bussiness_id;
            $data['bussiness_role'] = $getBusRole->bussiness_role; 
        } catch (\Throwable $th) {
            $data['bussiness_role'] = '';
        }

        return view('backend.users.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param App\Http\Requests $request
     * @param int               $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\UpdateUser $request, $id)
    {
        $form = $request->all();

        $data = [
            "name" => $form['name'],
            "email" => $form['email'],
            "role_id" => $form['role_id']
        ];

        $user = User::findOrFail($id);
        $user->update($data);
		
		$role = DB::table('role_user')->where("user_id" , $id)->first();
		if($role) { 
			DB::table('role_user')->where("user_id" , $id)->update(array("role_id" => $form['role_id']));
		} else { 
			DB::table('role_user')->insert(array("role_id" => $form['role_id'] , "user_id" => $id));
        }
        
        try {
            $role = DB::table('bussiness_user')->where("user_id" , $id)->first();
            if($role) { 
                DB::table('bussiness_user')
                    ->where("user_id" , $id)
                    ->update(array(
                        "user_id" => $user->id,
                        'bussiness_id' => $form['bussiness_id'],
                        'bussiness_role' => $form['bussiness_role']
                    ));
            } else { 
                DB::table('bussiness_user')
                    ->insert(array(
                        "user_id" => $user->id,
                        'bussiness_id' => $form['bussiness_id'],
                        'bussiness_role' => $form['bussiness_role']
                    ));
            }
        } catch (\Throwable $th) { }

        return redirect('users')
            ->with('message-success', 'User updated!');
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
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('users')
            ->with('message-success', 'User deleted!');
    }
}
