<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Validator;

class RoleController extends Controller
{






    public function __construct()
    {
        $this->middleware(['permission:view roles'])->only(['index', 'show']);
        $this->middleware(['permission:create roles'])->only('create');
        $this->middleware(['permission:edit roles'])->only(['edit', 'update']);
        $this->middleware(['permission:delete roles'])->only('destroy');
    }












    public function index()
    {
        $roles = Role::orderBy("created_at", 'asc')
            ->paginate(5);



        // dd($roles);


        return view("role.index", ["roles" => $roles]);

    }

    public function create()
    {
        $permissions = Permission::orderBy("name", "asc")->get();

        return view("role.create", ["permissions" => $permissions]);
    }










    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|unique:roles|min:3",
        ]);

        if ($validator->passes()) {
            // dd($request->permissions);
            $role = Role::create([
                "name" => $request->name,
            ]);



            if (!empty($request->permissions)) {
                foreach ($request->permissions as $name) {
                    // insert in role_has_permissions table------
                    $role->givePermissionTo($name);
                    // insert in role_has_permissions table------
                }
            }


            return redirect()->route("role.index")->with("success", "Role created successfully..!!");
        } else {
            return redirect()->route("role-create")->withInput()->withErrors($validator);
        }
    }






















    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $hasPermission = $role->permissions->pluck("name");
        // dd($hasPermission);
        $permission = Permission::orderBy("name", "asc")->get();
        return view(
            "role.edit",
            [
                "role" => $role,
                "hasPermission" => $hasPermission,
                "permission" => $permission,


            ]
        );

    }
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);


        $validator = Validator::make($request->all(), [
            "name" => 'required|unique:roles,name,' . $id . ',id',
        ]);




        if ($validator->passes()) {
            $role->name = $request->name;
            $role->save();




            if (!empty($request->permissions)) {
                $role->syncPermissions($request->permissions);
            } else {
                $role->syncPermissions([]);
            }



            return redirect()->route("role.index")->with("success", "Role updates successfully..!!");
        } else {
            return redirect()->route("role-edit", $id)->withInput()->withErrors($validator);
        }
    }







    public function destroy(Request $request)
    {
        $role = Role::find($request->id);

        if ($role == null) {
            session()->flash('error', "Role not found..!!");

            return response()->json([
                "status" => false,
            ]);
        }


        $role->delete();
        session()->flash('success', "Role deleted successfully..!!");
        return response()->json([
            "status" => true,
        ]);


    }
}
