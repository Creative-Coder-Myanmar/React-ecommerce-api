<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function store()
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors'  => $validator->errors()
            ]);
        }

        $role = Role::create([
            'name' => request('name')
        ]);

        return response()->json([
            'message' => 'new role created'
        ]);
    }

    public function delete(Role $role)
    {
        $role->delete();
        return response()->json([
            'message' => 'role deleted.'
        ], 200);
    }
}
