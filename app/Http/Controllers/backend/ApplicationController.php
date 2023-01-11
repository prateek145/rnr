<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\backend\Application;
use App\Models\backend\Attachments;
use App\Models\backend\Field;

class ApplicationController extends Controller
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
            $applications = Application::latest()->get();
            return view('backend.applications.index', compact('applications'));
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
            $rules = [
                'name' => 'required',
                // 'attachments' => 'required|mimes:pdf,jpg,png|min:5|max:2048',
                'status' => 'required',
                // 'description' => 'required',
            ];

            $custommessages = [];

            $this->validate($request, $rules, $custommessages);
            //code...
            $data = $request->all();
            // dd($data);
            unset($data['_token']);
            if ($request->attachments) {
                $attachments = [];
                # code...
                foreach ($request->file('attachments') as $image) {
                    $filename = rand() . $image->getClientOriginalName();
                    $destination_path = public_path('/application');
                    $image->move($destination_path, $filename);
                    array_push($attachments, $filename);
                }
                $data['attachments'] = json_encode($attachments);
            }

            Application::create($data);
            return redirect()
                ->route('application.index')
                ->with('success', 'Application Created.');
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
            $application = Application::find($id);
            // dd($application->attachments);
            $attachments = Attachments::where('application_id', $id)
                ->latest()
                ->get();
            $fields = Field::where('application_id', $id)
                ->latest()
                ->get();
            // dd($attachments);
            return view('backend.applications.edit', compact('application', 'attachments', 'fields'));
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

            if ($request->application_id) {
                $rules = [
                    'attachments' => 'required|mimes:pdf,jpg,png|min:5|max:2048',
                ];

                $custommessages = [];

                $this->validate($request, $rules, $custommessages);
                # code...
                // dd($request->all());
                $data['name'] = $request->attachments->getClientOriginalName();
                $data['imagename'] = rand() . $request->attachments->getClientOriginalName();
                $data['size'] = round($request->attachments->getSize() / 1024, 4) . 'KB';
                $data['type'] = $request->attachments->getMimeType();
                $data['application_id'] = $request->application_id;
                $destination_path = public_path('/application');
                $request->attachments->move($destination_path, $data['imagename']);
                // dd($data);
                $attachment = Attachments::create($data);
                if ($attachment) {
                    # code...
                    return redirect()
                        ->back()
                        ->with('success', 'Successfully Attachments Create.');
                } else {
                    # code...
                    return redirect()
                        ->back()
                        ->with('error', 'Technical Error.');
                }
            } else {
                # code...
                // dd('prateek');
                $data = $request->all();
                unset($data['_token']);
                unset($data['_method']);

                $application = Application::find($id);
                $application->update($data);
                if ($application) {
                    # code...
                    return redirect()
                        ->back()
                        ->with('success', 'Successfully Application Edit.');
                } else {
                    # code...
                    return redirect()
                        ->back()
                        ->with('error', 'Technical Error.');
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
        try {
            //code...
            $audit = Application::destroy($id);
            return redirect()
                ->back()
                ->with('success', 'Successfully Application Delete.');
            // dd($audit);
        } catch (\Exception $th) {
            //throw $th;
            return redirect()
                ->back()
                ->with('error', $th->getMessage());
        }
    }

    public function attachment_delete($id)
    {
        try {
            //code...
            // dd($id);
            $audit = Attachments::destroy($id);
            return redirect()
                ->back()
                ->with('success', 'Successfully Attachments Delete.');
            // dd($audit);
        } catch (\Exception $th) {
            //throw $th;
            return redirect()
                ->back()
                ->with('error', $th->getMessage());
        }
    }
}
