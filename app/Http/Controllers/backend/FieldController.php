<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\backend\Field;
use App\Models\backend\Group;

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
            // dd($data);
            Field::create($data);
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
            // dd($field);
            return view('backend.field.edit', compact('field', 'groups'));
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
                'forder' => 'required',
                'type' => 'required',
                'status' => 'required',
            ];

            $custommessages = [];

            $this->validate($request, $rules, $custommessages);

            $data = $request->all();
            // dd($data);
            unset($data['_token']);
            unset($data['_method']);
            unset($data['groups']);

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
            $audit = Field::find($id);
            $audit->update($data);

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
            $audit = Field::destroy($id);
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
