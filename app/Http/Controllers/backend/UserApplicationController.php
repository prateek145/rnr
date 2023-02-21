<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\backend\Application;
use App\Models\backend\Field;
use App\Models\backend\Formdata;
use App\Models\User;
use App\Models\backend\Group;
use App\Models\backend\ApplicationIndexing;

class UserApplicationController extends Controller
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
            $loggedinuser = auth()->id();
            // dd($userid);
            $application = Application::where('status', 1)
                ->latest()
                ->get();

            $userapplication = [];
            $userid = [];
            // dd($loggedinuser);

            for ($i = 0; $i < count($application); $i++) {
                # code...
                // dd($application[0]->rolestable()->first()->group_list);
                // dd($application[1]->rolestable()->first() == null);
                if ($application[$i]->rolestable()->first() != 'null' && $application[$i]->rolestable()->first() != null) {
                    // echo is_null($application[$i]->rolestable()->first()->group_list);
                    if ($application[$i]->rolestable()->first()->group_list != 'null') {
                        # code...
                        array_push($userid, $this->findusers($application[$i]->rolestable()->first()->group_list));
                    }

                    if ($application[$i]->rolestable()->first()->user_list != 'null') {
                        # code...
                        array_push($userid, json_decode($application[$i]->rolestable()->first()->user_list));
                    }

                    $useridfound = 'false';
                    // dd(in_array(auth()->id(), $userid[2]));
                    for ($j = 0; $j < count($userid); $j++) {
                        if (in_array(auth()->id(), $userid[$j])) {
                            $useridfound = 'true';
                        }
                    }
                    // dd($useridfound);

                    if ($useridfound == 'true') {
                        array_push($userapplication, $application[$i]);
                    }
                }
            }
            $userapplication1 = Application::where(['access' => 'public', 'status' => 1])->get();

            // dd($userapplication, $userapplication1);
            return view('backend.userapplication.index', compact('userapplication', 'userapplication1'));
            // dd($application);
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
            $users = User::latest()->get();
            $groups = Group::latest()->get();
            $dbfields = Field::where(['application_id' => $application->id, 'status' => 1])
                ->orderBy('forder', 'ASC')
                ->get();

            //here on saturday code here find private access group view
            // dd($dbfields);
            // $fields = [];
            $fields = [];
            $userid = [];
            for ($i = 0; $i < count($dbfields); $i++) {
                # code...

                if ($dbfields[$i]->access == 'private') {
                    # code...
                    if ($dbfields[$i]->groups != 'null') {
                        array_push($userid, $this->findusers($dbfields[$i]->groups));
                        // if ($dbfields[$i]->rolestable()->first()->group_list != 'null') {
                        //     # code...
                        // }

                        // if ($dbfields[$i]->rolestable()->first()->user_list != 'null') {
                        //     # code...
                        //     array_push($userid, json_decode($dbfields[$i]->rolestable()->first()->user_list));
                        // }

                        $useridfound = 'false';
                        // dd(in_array(auth()->id(), $userid[2]));
                        for ($j = 0; $j < count($userid); $j++) {
                            if (in_array(auth()->id(), $userid[$j])) {
                                $useridfound = 'true';
                            }
                        }

                        if ($useridfound == 'true') {
                            array_push($fields, $dbfields[$i]);
                        }
                        // dd($fields);
                    }
                } else {
                    # code...
                    array_push($fields, $dbfields[$i]);
                }
            }

            return view('backend.userapplication.edit', compact('groups', 'users', 'application', 'fields'));
            // dd($application);
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
            $data = $request->all();
            unset($data['_token']);
            unset($data['_method']);
            // dd($data);
            $data1['data'] = json_encode($data);
            $data1['userid'] = $request->userid;
            $data1['application_id'] = $id;
            $data1['type123'] = json_encode($request->type123);
            // dd($data1);
            Formdata::create($data1);
            return redirect()
                ->route('user-application.index')
                ->with('success', 'Form Saved.');
            // dd($data1);
        } catch (\Exception $th) {
            //throw $th;
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
        try {
            //code...
            // dd($id);
            $audit = Formdata::destroy($id);
            return redirect()
                ->back()
                ->with('success', 'Successfully Deleted.');
            // dd($audit);
        } catch (\Exception $th) {
            //throw $th;
            return redirect()
                ->back()
                ->with('error', $th->getMessage());
        }
    }

    public function userapplication_list($id)
    {
        try {
            //code...

            $forms = Formdata::where(['userid' => auth()->id(), 'application_id' => $id])->get();
            $application = Application::find($id);
            $roles = $application->rolestable()->first();
            $dbfields = Field::where(['application_id' => $application->id, 'status' => 1])
                ->orderBy('forder', 'ASC')
                ->get();

            $fields = [];
            $userid = [];
            for ($i = 0; $i < count($dbfields); $i++) {
                # code...

                if ($dbfields[$i]->access == 'private') {
                    # code...
                    if ($dbfields[$i]->groups != 'null') {
                        array_push($userid, $this->findusers($dbfields[$i]->groups));
                        // if ($dbfields[$i]->rolestable()->first()->group_list != 'null') {
                        //     # code...
                        // }

                        // if ($dbfields[$i]->rolestable()->first()->user_list != 'null') {
                        //     # code...
                        //     array_push($userid, json_decode($dbfields[$i]->rolestable()->first()->user_list));
                        // }

                        $useridfound = 'false';
                        // dd(in_array(auth()->id(), $userid[2]));
                        for ($j = 0; $j < count($userid); $j++) {
                            if (in_array(auth()->id(), $userid[$j])) {
                                $useridfound = 'true';
                            }
                        }

                        if ($useridfound == 'true') {
                            array_push($fields, $dbfields[$i]);
                        }
                        // dd($fields);
                    }
                } else {
                    # code...
                    array_push($fields, $dbfields[$i]);
                }
            }

            $indexing = ApplicationIndexing::where(['userid' => auth()->id(), 'application_id' => $application->id])->first();
            if ($indexing) {
                # code...
                $index = json_decode($indexing->order);
            } else {
                # code...
                $index = null;
            }

            // dd($index, $fields);
            // dd($fields);
            // dd($application->rolestable()->get());
            return view('backend.userapplication.applicationlist', compact('forms', 'index', 'id', 'application', 'roles', 'fields'));
        } catch (\Exception $th) {
            //throw $th;
            //throw $th;
            return redirect()
                ->back()
                ->with('error', $th->getMessage());
        }
    }

    public function userapplication_edit($id)
    {
        try {
            //code...
            // dd($id);
            $form_data = Formdata::find($id);
            // dd($form_data);
            $application = Application::find($form_data->application_id);
            $users = User::latest()->get();
            $groups = Group::latest()->get();
            $dbfields = Field::where(['application_id' => $application->id, 'status' => 1])
                ->orderBy('forder', 'ASC')
                ->get();

            $fields = [];
            $userid = [];
            for ($i = 0; $i < count($dbfields); $i++) {
                # code...

                if ($dbfields[$i]->access == 'private') {
                    # code...
                    if ($dbfields[$i]->groups != 'null') {
                        array_push($userid, $this->findusers($dbfields[$i]->groups));
                        // if ($dbfields[$i]->rolestable()->first()->group_list != 'null') {
                        //     # code...
                        // }

                        // if ($dbfields[$i]->rolestable()->first()->user_list != 'null') {
                        //     # code...
                        //     array_push($userid, json_decode($dbfields[$i]->rolestable()->first()->user_list));
                        // }

                        $useridfound = 'false';
                        // dd(in_array(auth()->id(), $userid[2]));
                        for ($j = 0; $j < count($userid); $j++) {
                            if (in_array(auth()->id(), $userid[$j])) {
                                $useridfound = 'true';
                            }
                        }

                        if ($useridfound == 'true') {
                            array_push($fields, $dbfields[$i]);
                        }
                        // dd($fields);
                    }
                } else {
                    # code...
                    array_push($fields, $dbfields[$i]);
                }
            }

            $filledformdata = json_decode($form_data->data, true);
            unset($filledformdata['type123']);
            return view('backend.userapplication.applicationedit', compact('groups', 'users', 'application', 'fields', 'filledformdata'));
            // dd($id);
        } catch (\Exception $th) {
            //throw $th;
            //throw $th;
            return redirect()
                ->back()
                ->with('error', $th->getMessage());
        }
    }

    public function findusers($data)
    {
        $array = json_decode($data);
        $userids = [];
        for ($i = 0; $i < count($array); $i++) {
            # code...
            $userarray = Group::find($array[$i]);
            $newarray = json_decode($userarray->userids);
            for ($j = 0; $j < count($newarray); $j++) {
                # code...
                array_push($userids, $newarray[$j]);
            }
            // array_merge($userids, json_decode($userarray->userids));
        }
        return $userids;
    }

    public function userapplication_index($id)
    {
        try {
            $indexing = ApplicationIndexing::where('userid', auth()->id())->first();
            if ($indexing) {
                # code...
                $application = Application::find($id);
                $dbfields = Field::where(['application_id' => $application->id, 'status' => 1])
                    ->orderBy('forder', 'ASC')
                    ->get();

                $fields = [];
                $userid = [];
                for ($i = 0; $i < count($dbfields); $i++) {
                    # code...

                    if ($dbfields[$i]->access == 'private') {
                        # code...
                        if ($dbfields[$i]->groups != 'null') {
                            array_push($userid, $this->findusers($dbfields[$i]->groups));
                            // if ($dbfields[$i]->rolestable()->first()->group_list != 'null') {
                            //     # code...
                            // }

                            // if ($dbfields[$i]->rolestable()->first()->user_list != 'null') {
                            //     # code...
                            //     array_push($userid, json_decode($dbfields[$i]->rolestable()->first()->user_list));
                            // }

                            $useridfound = 'false';
                            // dd(in_array(auth()->id(), $userid[2]));
                            for ($j = 0; $j < count($userid); $j++) {
                                if (in_array(auth()->id(), $userid[$j])) {
                                    $useridfound = 'true';
                                }
                            }

                            if ($useridfound == 'true') {
                                array_push($fields, $dbfields[$i]);
                            }
                            // dd($fields);
                        }
                    } else {
                        # code...
                        array_push($fields, $dbfields[$i]);
                    }
                }
                $i = 0;
                return view('backend.userapplication.userapplicationindex', compact('id', 'fields', 'indexing', 'i'));
            } else {
                # code...

                $application = Application::find($id);
                $dbfields = Field::where(['application_id' => $application->id, 'status' => 1])
                    ->orderBy('forder', 'ASC')
                    ->get();

                $fields = [];
                $userid = [];
                for ($i = 0; $i < count($dbfields); $i++) {
                    # code...

                    if ($dbfields[$i]->access == 'private') {
                        # code...
                        if ($dbfields[$i]->groups != 'null') {
                            array_push($userid, $this->findusers($dbfields[$i]->groups));
                            // if ($dbfields[$i]->rolestable()->first()->group_list != 'null') {
                            //     # code...
                            // }

                            // if ($dbfields[$i]->rolestable()->first()->user_list != 'null') {
                            //     # code...
                            //     array_push($userid, json_decode($dbfields[$i]->rolestable()->first()->user_list));
                            // }

                            $useridfound = 'false';
                            // dd(in_array(auth()->id(), $userid[2]));
                            for ($j = 0; $j < count($userid); $j++) {
                                if (in_array(auth()->id(), $userid[$j])) {
                                    $useridfound = 'true';
                                }
                            }

                            if ($useridfound == 'true') {
                                array_push($fields, $dbfields[$i]);
                            }
                            // dd($fields);
                        }
                    } else {
                        # code...
                        array_push($fields, $dbfields[$i]);
                    }
                }

                $indexing = 'notfound';
                return view('backend.userapplication.userapplicationindex', compact('id', 'fields', 'indexing'));
            }

            // dd($id);
        } catch (\Exception $th) {
            //throw $th;
            //throw $th;
            return redirect()
                ->back()
                ->with('error', $th->getMessage());
        }
    }

    public function userapplication_index_save(Request $request)
    {
        try {
            // dd($request->all());
            $user = ApplicationIndexing::where('userid', $request->userid)->first();
            // dd($user);
            if ($user) {
                # code...
                $data = $request->all();
                unset($data['order']);
                unset($data['update']);
                $data['order'] = json_encode($request->order);
                $indexingvalue = ApplicationIndexing::where('userid', auth()->id())->first();

                $indexingvalue->update($data);
                return redirect()
                    ->back()
                    ->with('success', 'Successfully Updated.');
            } else {
                # code...
                $data = $request->all();
                unset($data['order']);
                $data['order'] = json_encode($request->order);
                ApplicationIndexing::create($data);
                return redirect()
                    ->route('userapplication.list', $request->application_id)
                    ->with('success', 'Successfully Created.');
            }

            // dd($data);
        } catch (\Exception $th) {
            //throw $th;
            //throw $th;
            return redirect()
                ->back()
                ->with('error', $th->getMessage());
        }
    }
}