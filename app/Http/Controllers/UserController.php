<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Validator;

class UserController extends Controller
{







    public function __construct()
    {
        $this->middleware(['permission:view users'])->only(['index', 'show']);
        $this->middleware(['permission:create users'])->only('create');
        $this->middleware(['permission:edit users'])->only(['edit', 'update']);
        $this->middleware(['permission:delete users'])->only('destroy');
    }


















    public function index()
    {
        $users = User::orderBy("created_at", 'asc')
            ->paginate(5);
        // dd($roles);
        return view("user.index", ["users" => $users]);
    }






    public function create()
    {
        $roles = Role::orderBy("name", "asc")->get();
        return view("user.create", ["roles" => $roles]);
    }











    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required|unique:users,email",
            "password" => "required|min:8",
            "confirm-password" => "required|same:password"

        ]);

        if ($validator->passes()) {
            // dd($request->permissions);
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();


            // role assign to user-------
            if (!empty($request->role)) {
                $user->syncRoles($request->role);
            } else {
                $user->syncRoles([]);
            }
            // role assign to user-------


            return redirect()->route("user.index")->with("success", "User created successfully..!!");
        } else {
            return redirect()->route("user-create")->withInput()->withErrors($validator);
        }
    }






















    public function edit($id)
    {
        $user = User::findOrFail($id);
        $role = Role::orderBy("name", "asc")->get();
        $hasRole = $user->roles->pluck("id");

        return view(
            "user.edit",
            [
                "user" => $user,
                "role" => $role,
                "hasRole" => $hasRole,
            ]
        );

    }








    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);


        $validator = Validator::make($request->all(), [
            "name" => 'required',
            "email" => 'required|unique:users,email,' . $id . ',id',

        ]);




        if ($validator->passes()) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();



            // role assign to user-------
            if (!empty($request->role)) {
                $user->syncRoles($request->role);
            } else {
                $user->syncRoles([]);
            }
            // role assign to user-------



            return redirect()->route("user.index")->with("success", "User updates successfully..!!");
        } else {
            return redirect()->route("user-edit", $id)->withInput()->withErrors($validator);
        }
    }







    public function destroy(Request $request)
    {
        $user = User::find($request->id);

        if ($user == null) {
            session()->flash('error', "User not found..!!");

            return response()->json([
                "status" => false,
            ]);
        }


        $user->delete();
        session()->flash('success', "User deleted successfully..!!");
        return response()->json([
            "status" => true,
        ]);


    }
}
