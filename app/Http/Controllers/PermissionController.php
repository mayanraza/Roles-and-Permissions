<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Validator;

class PermissionController extends Controller
{




    public function __construct()
    {
        $this->middleware(['permission:view permissions'])->only(['index', 'show']);
        $this->middleware(['permission:create permissions'])->only('create');
        $this->middleware(['permission:edit permissions'])->only(['edit', 'update']);
        $this->middleware(['permission:delete permissions'])->only('destroy');
    }










    public function index()
    {
        $permissions = Permission::orderBy("created_at", 'asc')->paginate(20);
        return view("permissions.index", ["permissions" => $permissions]);

    }

    public function create()
    {
        return view("permissions.create");
    }










    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|unique:permissions|min:3",
        ]);

        if ($validator->passes()) {
            Permission::create([
                "name" => $request->name,
            ]);
            return redirect()->route("permission.index")->with("success", "Permission created successfully..!!");
        } else {
            return redirect()->route("permission-create")->withInput()->withErrors($validator);
        }
    }






















    public function edit($id)
    {
        $permissions = Permission::findOrFail($id);
        return view("permissions.edit", ["permissions" => $permissions]);

    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|unique:permissions,name,'.$id.',id",
        ]);

        $permissions = Permission::findOrFail($id);



        if ($validator->passes()) {
            $permissions->name = $request->name;
            $permissions->save();
            return redirect()->route("permission.index")->with("success", "Permission updates successfully..!!");
        } else {
            return redirect()->route("permission-edit", $id)->withInput()->withErrors($validator);
        }
    }






    public function destroy(Request $request)
    {
        $permissions = Permission::find($request->id);

        if ($permissions == null) {
            session()->flash('error', "Permission not found..!!");

            return response()->json([
                "status" => false,
            ]);
        }


        $permissions->delete();
        session()->flash('success', "Permission deleted successfully..!!");
        return response()->json([
            "status" => true,
        ]);


    }
}
