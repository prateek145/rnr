<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\backend\Application;
use App\Models\backend\Group;
use App\Models\backend\Role;
use App\Models\User;

class RoleController extends Controller
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
            $applications = Application::where('status', 1)
                ->latest()
                ->get();
            return view('backend.role.index', compact('applications'));
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        try {
            //code...
            $application = Application::find($id);
            $role = Role::where('application_id', $id)->first();
            if ($role != null) {
                # code...
                $applicationrole = $role;
            } else {
                # code...
                $applicationrole = null;
            }

            $selectedgroups = [];

            // dd($role->group_list);
            if ($role != null && $role->group_list != 'null') {
                $groupids = json_decode($role->group_list);
                # code...
                // dd($groupids);
                for ($i = 0; $i < count($groupids); $i++) {
                    # code...
                    $group = Group::find($groupids[$i]);
                    array_push($selectedgroups, $group);
                }
            }

            $selectedusers = [];
            if ($role != null && $role->user_list != null) {
                $userids = json_decode($role->user_list);
                # code...
                for ($i = 0; $i < count($userids); $i++) {
                    # code...
                    $user = User::find($userids[$i]);
                    array_push($selectedusers, $user);
                }
            }
            // dd($selectedusers);

            $users = User::where('status', 1)
                ->latest()
                ->get();
            $groups = Group::where('status', 1)
                ->latest()
                ->get();
            return view('backend.role.edit', compact('selectedgroups', 'selectedusers', 'application', 'applicationrole', 'users', 'groups'));
        } catch (\Exception $th) {
            //throw $th;
            return redirect()
                ->back()
                ->with('error', $th->getMessage());
        }
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
            // dd($request->all());
            $role = Role::where('application_id', $request->application_id)->first();
            // dd($role);
            if ($role) {
                # code...
                $data = $request->all();
                unset($data['_token']);
                unset($data['_method']);
                unset($data['user_list']);
                unset($data['group_list']);

                if (!$request->import) {
                    # code...
                    $data['import'] = 0;
                }

                if (!$request->create) {
                    # code...
                    $data['create'] = 0;
                }

                if (!$request->read) {
                    # code...
                    $data['read'] = 0;
                }

                if (!$request->update) {
                    # code...
                    $data['update'] = 0;
                }

                if (!$request->delete) {
                    # code...
                    $data['delete'] = 0;
                }

                if ($request->user_list) {
                    # code...
                    $data['user_list'] = json_encode($request->user_list);
                }

                if ($request->group_list) {
                    # code...
                    $data['group_list'] = json_encode($request->group_list);
                }
                // dd($data);
                $role->update($data);
                return redirect()
                    ->back()
                    ->with('success', 'Successfully Roles Updated.');
            } else {
                # code...
                if ($request->user_list == null && $request->group_list == null) {
                    # code...
                    throw new \Exception('Select Atleast User or Group.');
                } else {
                    # code...
                    $data = $request->all();
                    unset($data['_token']);
                    unset($data['_method']);
                    unset($data['user_list']);
                    unset($data['group_list']);

                    $data['user_list'] = json_encode($request->user_list);
                    $data['group_list'] = json_encode($request->group_list);
                    Role::create($data);
                    return redirect()
                        ->route('role.index')
                        ->with('success', 'Successfully Roles Created.');
                }
            }
        } catch (\Exception $th) {
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
        //
    }
}
