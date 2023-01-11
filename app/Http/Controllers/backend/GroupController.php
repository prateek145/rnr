<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\backend\Group;
use App\Models\User;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        try {
            //code...
            $groups = Group::latest()->get();
            $users = User::all();
            return view('backend.group.index', compact('groups', 'users'));
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
        try {
            //code...
            return view('backend.applications.create');
        } catch (\Exception $th) {
            //throw $th;
            return redirect()
                ->back()
                ->with('error', $th->getMessage());
        }
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
            // dd($request->all());
            $rules = [
                'name' => 'required',
                // 'attachments' => 'required|mimes:pdf,jpg,png|min:5|max:2048',
                'userids' => 'required',
                'user_id' => 'required',
                'status' => 'required',
                // 'description' => 'required',
            ];

            $custommessages = [];

            $this->validate($request, $rules, $custommessages);
            //code...
            $data = $request->all();
            // dd($data);
            unset($data['_token']);
            unset($data['userids']);

            $data['userids'] = json_encode($request->userids);
            // dd($data);
            Group::create($data);
            return redirect()
                ->route('group.index')
                ->with('success', 'Group Created.');
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
        try {
            //code...
            $group = Group::find($id);
            // dd($application->attachments);
            $users = User::all();
            $userids = json_decode($group->userids);
            return view('backend.group.edit', compact('group', 'users', 'userids'));
            // dd($audit);
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
            // dd($request->all(), $request->application_id);

            $rules = [
                'name' => 'required',
                // 'attachments' => 'required|mimes:pdf,jpg,png|min:5|max:2048',
                'userids' => 'required',
                'user_id' => 'required',
                'status' => 'required',
            ];

            $custommessages = [];

            $this->validate($request, $rules, $custommessages);
            $data = $request->all();
            unset($data['_token']);
            unset($data['_method']);
            unset($data['userids']);

            $data['userids'] = json_encode($request->userids);
            // dd($data);
            $group = Group::find($id);
            $group->update($data);
            // dd($group);
            # code...
            return redirect()
                ->back()
                ->with('success', 'Successfully Group Updated.');
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
        try {
            //code...
            $audit = Group::destroy($id);
            return redirect()
                ->back()
                ->with('success', 'Successfully Group Delete.');
            // dd($audit);
        } catch (\Exception $th) {
            //throw $th;
            return redirect()
                ->back()
                ->with('error', $th->getMessage());
        }
    }
}
