<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\backend\Group;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            //code...
            $users = User::latest()->get();
            // dd($users);
            return view('backend.users.index', compact('users'));
        } catch (\Exception $th) {
            //throw $th;
            return redirect()
                ->back()
                ->with('error', $th->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Group::Orderby('id', 'DESC')->get();
        // dd($groups);
        return view('backend.users.create', compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            //code...
            $rules = [
                'email' => 'required',
                'name' => 'required',
                'mobile_no' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                'password' => 'required|min:6',
                'repassword' => 'required',
            ];

            $custommessages = [];

            $this->validate($request, $rules, $custommessages);

            if ($request->password == $request->repassword) {
                # code...
                $data = $request->all();
                unset($data['_token']);
                unset($data['password']);
                unset($data['repassword']);
                // dd($data);
                unset($data['group_id']);
                $data['group_id'] = json_encode($request->group_id);
                $data['password'] = Hash::make($request->password);
                // dd($data);
                $user = User::create($data);
                Log::channel('custom')->info('User Created by ' . auth()->user()->name . ' ' . auth()->user()->lastname . ' User Name -> ' . $user->name);

                return redirect()
                    ->route('users.index')
                    ->with('success', 'User Created');
            } else {
                # code...
                throw new \Exception('Password Does Not Matched');
            }
        } catch (\Exception $th) {
            //throw $th;
            return redirect()
                ->back()
                ->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        // dd($id);
        $user = User::find($id);
        $groups = Group::Orderby('id', 'DESC')->get();
        $groupids = json_decode($user->group_id);
        // dd($groupids);
        return view('backend.users.edit', compact('user', 'groups', 'groupids'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            //code...
            // dd($request->all())
            $rules = [
                'email' => 'required',
                'name' => 'required',
                'mobile_no' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                'password' => 'required_with:password_confirmation|confirmed',
            ];

            $custommessages = [];

            $this->validate($request, $rules, $custommessages);

            $data = $request->all();
            unset($data['_token']);
            unset($data['password']);
            unset($data['password_confirmation']);
            // dd($data);
            if ($request->password) {
                # code...
                $data['password'] = Hash::make($request->password);
            }
            // dd($data);
            $user = User::find($id);
            $user->update($data);
            Log::channel('custom')->info('User Edited by ' . auth()->user()->name . ' ' . auth()->user()->lastname . ' User Name -> ' . $user->name);

            return redirect()
                ->back()
                ->with('success', 'User Updated.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()
                ->back()
                ->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            //code...
            $user = User::find($id);
            Log::channel('custom')->info('User Edited by ' . auth()->user()->name . ' ' . auth()->user()->lastname . ' User Name -> ' . $user->name);
            User::destroy($id);

            return redirect()
                ->back()
                ->with('success', 'Successfully User Delete.');
            // dd($audit);
        } catch (\Exception $th) {
            //throw $th;
            return redirect()
                ->back()
                ->with('error', $th->getMessage());
        }
    }
}
