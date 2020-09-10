<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Roles;
use App\Status;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        $this->update_user_info();
        $users = User::leftJoin('status', 'status.status_id', '=', 'users.status')
            ->leftJoin('roles', 'roles.id', '=', 'users.role')
            ->select('users.*', 'status.status_title', 'roles.role_name')
            ->orderby('users.id')
            ->get();

        return view('users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $roles = Roles::all();
        $status = Status::all();
        return view('users.create', ['roles' => $roles, 'status' => $status]);
    }

    /**
     * Store a newly created user in storage
     *
     * @param  \Illuminate\Http\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request, User $model)
    {
        $model->create($request->merge(['password' => Hash::make($request->get('password'))])->all());
        return redirect()->route('user.index');
    }

    /**
     * Display the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified user
     *
     * @param  \App\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        $roles = Roles::all();
        $status = Status::all();
        return view('users.edit', compact('user', 'roles', 'status'));
    }

    /**
     * Update the specified user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, User $user)
    {
        $except = [
            $request->get('password') ? '' : 'password'
        ];

        $user->update(
            $request->merge(['password' => Hash::make($request->get('password'))])
                ->except($except)
        );

        return redirect()->route('user.index')->withStatus(__('User successfully updated.'));
    }

    public function updateStatus(Request $request)
    {
        $id = $request->input("id");
        $status = $request->input("status");

        $data = User::where('id', $id)->first();
        $data->status = !$status;
        $result = $data->save();

        return response()->json(['result'=> $result]);

    }

    /**
     * Remove the specified user from storage
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('user.index')->withStatus(__('User successfully deleted.'));
    }


    /**
     * Delete User function
     *
     * @param Request $request
     * @return Json
     */
    public function delete_user(Request $request)
    {
        $user_id = $request->input('id');
        $data = User::where('id', $user_id)->first();

        $result = $data->delete();

        return response()->json(['result' => $result]);

    }


    /**
     * update user active status
     *
     */
    public function update_user_info()
    {
        $current_date = date('Y-m-d');

        $users = User::where('role', '!=', 1)->get();
        foreach ($users as $user) {
            if(!$user->active_due_date && $user->active_due_date < $current_date){
                $user->status = 0;
                $user->save();
            }
        }
    }
}
