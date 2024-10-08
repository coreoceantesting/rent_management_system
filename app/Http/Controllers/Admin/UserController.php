<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\Admin\AssignUserRoleRequest;
use App\Http\Requests\Admin\ChangeUserPasswordRequest;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\Department;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Ward;
use App\Models\Region;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->roles->pluck('name')[0] == 'Developer' )
        {
            // $users = User::where('id', Auth::user()->id)->latest()->get();
            $users = User::where('users.id', Auth::user()->id)
                            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                            ->select('users.*', 'roles.name as role_name')
                            ->latest()
                            ->get();
        }else{
            // $users = User::whereNot('id', Auth::user()->id)->latest()->get();
            $users = User::whereNot('users.id', Auth::user()->id)
                            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                            ->select('users.*', 'roles.name as role_name')
                            ->latest()
                            ->get();
        }
        $roles = Role::orderBy('id', 'DESC')->whereNot('name', 'like', '%super%')->get();
        $wards = Ward::latest()->get();
        $areas = Region::latest()->get();

        return view('admin.users')->with(['users'=> $users, 'roles'=> $roles, 'wards' => $wards, 'areas' => $areas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try
        {
            DB::beginTransaction();
            $input = $request->validated();
            $input['password'] = Hash::make($input['password']);
            $input['ward'] = implode(',', $input['ward']);
            $input['area'] = implode(',', $input['area']);
            $user = User::create( Arr::only( $input, Auth::user()->getFillable() ) );
            DB::table('model_has_roles')->insert(['role_id'=> $input['role'], 'model_type'=> 'App\Models\User', 'model_id'=> $user->id]);
            DB::commit();
            return response()->json(['success'=> 'User created successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'creating', 'User');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::whereNot('name', 'like', '%super%')->get();
        $user->loadMissing('roles');

        if ($user)
        {

            $roleHtml = '<span>
                <option value="">--Select Role --</option>';
                foreach($roles as $role):
                    $is_select = $role->id == $user->roles[0]->id ? "selected" : "";
                    $roleHtml .= '<option value="'.$role->id.'" '.$is_select.'>'.$role->name.'</option>';
                endforeach;
            $roleHtml .= '</span>';


            $response = [
                'result' => 1,
                'user' => $user,
                'roleHtml' => $roleHtml,
            ];
        }
        else
        {
            $response = ['result' => 0];
        }
        return $response;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try
        {
            DB::beginTransaction();
            $input = $request->validated();
            $input['ward'] = implode(',', $input['ward']);
            $input['area'] = implode(',', $input['area']);
            $user->update( Arr::only( $input, Auth::user()->getFillable() ) );
            $user->roles()->detach();
            DB::table('model_has_roles')->insert(['role_id'=> $input['role'], 'model_type'=> 'App\Models\User', 'model_id'=> $user->id]);
            DB::commit();

            return response()->json(['success'=> 'User updated successfully!']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'updating', 'User');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function toggle(Request $request, User $user)
    {
        $current_status = DB::table('users')->where('id', $user->id)->value('active_status');
        try
        {
            DB::beginTransaction();
            if($current_status == '1')
            {
                User::where('id', $user->id)->update([ 'active_status' => '0' ]);
            }
            else
            {
                User::where('id', $user->id)->update([ 'active_status' => '1' ]);
            }
            DB::commit();
            return response()->json(['success'=> 'User status updated successfully']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'changing', 'User\'s status');
        }
    }

    public function retire(Request $request, User $user)
    {
        try
        {
            DB::beginTransaction();
                $user->delete();
            DB::commit();
            return response()->json(['success'=> 'Employee retired successfully']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'changing', 'Employee\'s retirement status');
        }
    }

    public function changePassword(ChangeUserPasswordRequest $request, User $user)
    {
        $input = $request->validated();
        try
        {
            DB::beginTransaction();
            $user->update([ 'password' => Hash::make($input['new_password']) ]);
            DB::commit();
            return response()->json(['success'=> 'Password updated successfully']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'changing', 'User\'s password');
        }

    }


    public function getRole(User $user)
    {
        $user->load('roles');
        if ($user)
        {
            $roles = Role::orderBy('id', 'DESC')->get();
            $roleHtml = '<span>
                <option value="">--Select Role--</option>';
                foreach($roles as $role):
                    $is_select = $role->id == $user->roles[0]->id ? "selected" : "";
                    $roleHtml .= '<option value="'.$role->id.'" '.$is_select.'>'.$role->name.'</option>';
                endforeach;
            $roleHtml .= '</span>';

            $response = [
                'result' => 1,
                'user' => $user,
                'roleHtml' => $roleHtml,
            ];
        }
        else
        {
            $response = ['result' => 0];
        }
        return $response;
    }


    public function assignRole(User $user, AssignUserRoleRequest $request)
    {
        try
        {
            DB::beginTransaction();
            $user->roles()->detach();
            DB::table('model_has_roles')->insert(['role_id'=> $request->edit_role, 'model_type'=> 'App\Models\User', 'model_id'=> $user->id]);
            DB::commit();
            return response()->json(['success'=> 'Role updated successfully']);
        }
        catch(\Exception $e)
        {
            return $this->respondWithAjax($e, 'changing', 'User\'s role');
        }
    }
}
