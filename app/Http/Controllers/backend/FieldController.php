<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\backend\Field;
use App\Models\User;
use App\Models\backend\Group;
use App\Models\backend\Application;
use Illuminate\Support\Facades\Log;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $rules = [
            'name' => 'required',
            'type' => 'required',
            'status' => 'required',
        ];

        $custommessages = [];

        $this->validate($request, $rules, $custommessages);
        try {
            //code...
            $data = $request->all();
            unset($data['_token']);
            $data['access'] = 'public';
            // dd($data);
            $application = Application::find($request->application_id);
            $applicationfields = Field::where('application_id', $application->id)->get();
            $data['forder'] = count($applicationfields) + 1;
            $field = Field::create($data);
            Log::channel('custom')->info('Field Created by ' . auth()->user()->name . ' ' . auth()->user()->lastname . ' Field Name -> ' . $field->name);

            // dd($field, $field->id);
            if ($application->fields == null) {
                # code...
                $fieldid = [];
                array_push($fieldid, $field->id);
                $application->fields = json_encode($fieldid);
                $application->save();
            } else {
                # code...
                $fieldid = json_decode($application->fields);
                array_push($fieldid, $field->id);
                $application->fields = json_encode($fieldid);
                $application->save();
            }

            return redirect()
                ->back()
                ->with(['success' => 'Field Created.', 'field' => 'active']);
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
            $field = Field::find($id);
            $groups = Group::where(['status' => 1])
                ->latest()
                ->get();

            $users = User::where('status', 1)
                ->latest()
                ->get();

            $selectedgroups = [];
            if ($field->groups != null) {
                $groupids = json_decode($field->groups);
                # code...
                for ($i = 0; $i < count($groupids); $i++) {
                    # code...
                    $group = Group::find($groupids[$i]);
                    array_push($selectedgroups, $group);
                }
            }

            if ($field->user_list != null) {
                # code...
                $userid = json_decode($field->user_list);
                $userlist = [];
                for ($i = 0; $i < count($userid); $i++) {
                    # code...
                    $user = User::find($userid[$i]);
                    array_push($userlist, $user);
                }
            } else {
                $userlist = null;
            }

            // dd($userlist);

            if ($field->group_list != null) {
                # code...
                $groupid = json_decode($field->group_list);
                $grouplist = [];
                for ($i = 0; $i < count($groupid); $i++) {
                    # code...
                    $group = Group::find($groupid[$i]);
                    array_push($grouplist, $group);
                }
            } else {
                $grouplist = null;
            }
            // dd($userlist, $grouplist);
            return view('backend.field.edit', compact('userlist', 'grouplist', 'field', 'groups', 'selectedgroups', 'users'));
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
            $rules = [
                'name' => 'required',
                // 'forder' => 'required',
                'type' => 'required',
                'status' => 'required',
            ];

            $custommessages = [
                'forder' => 'Order is required',
            ];

            $this->validate($request, $rules, $custommessages);

            $data = $request->all();

            unset($data['_token']);
            unset($data['_method']);
            unset($data['groups']);

            if ($request->valuelistvalue) {
                # code...
                unset($data['valuelistvalue']);
                $data['valuelistvalue'] = json_encode($request->valuelistvalue);
            }

            if ($request->user_list) {
                # code...
                unset($data['user_list']);
                $data['user_list'] = json_encode($request->user_list);
            }

            if ($request->group_list) {
                # code...
                unset($data['group_list']);
                $data['group_list'] = json_encode($request->group_list);
            }

            // dd($data);
            if ($request->groups) {
                # code...
                if (count($request->groups) > 0) {
                    // dd($request->groups);
                    # code...
                    $data['groups'] = json_encode($request->groups);
                }
            }

            if ($request->access == 'public') {
                # code...
                $data['groups'] = null;
            }
            // dd($data);
            $field = Field::find($id);
            $field->update($data);
            Log::channel('custom')->info('Field Edited by ' . auth()->user()->name . ' ' . auth()->user()->lastname . ' Field Name -> ' . $field->name);

            return redirect()
                ->back()
                ->with(['success' => 'Successfully Field Edit.']);
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
            // dd($id);
            $field = Field::find($id);
            $application = Application::find($field->application_id);
            $fieldid = json_decode($application->fields);
            // dd($fieldid, $fieldid[0]);
            for ($i = 0; $i < count($fieldid); $i++) {
                # code...
                if ($fieldid[$i] == $id) {
                    # code...
                    unset($fieldid[$i]);
                }
            }
            // dd($fieldid);
            $application->fields = json_encode($fieldid);
            $application->save();
            Log::channel('custom')->info('Field Deleted by ' . auth()->user()->name . ' ' . auth()->user()->lastname . ' Field Name -> ' . $field->name);
            Field::destroy($id);
            return redirect()
                ->back()
                ->with('success', 'Successfully Field Delete.');
            // dd($audit);
        } catch (\Exception $th) {
            //throw $th;
            return redirect()
                ->back()
                ->with('error', $th->getMessage());
        }
    }
}
