@extends('workflows::layouts.workflow_app')
@section('content')
<!-- Recent Sales Start -->
<div class="container-fluid pt-4 px-4">
  <div class="bg-light text-start rounded p-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
      {{-- <h6 class="mb-0">Application Create</h6> --}}

    </div>
    {{-- {{ dd(Session::get('genral'), Session::get('field')) }} --}}

    <div class="bg-light rounded h-100 p-4">
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
          <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-4">Evaluating Content</h6>
            <button type="button" class="btn btn-danger">
              <a onclick="closeSettings()" style="color:aliceblue">
                <- back</a>
            </button>
          </div>

        </div>

        <form action="{{route('updatecontent.save')}}" class="form-horizontal" enctype="multipart/form-data" method="post">
            @csrf
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label"> Name</label>
                <input type="text" class="form-control" name="name">
  
            </div>


            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Description</label>
                <textarea class="form-control" name="description" id="" cols="30" rows="10"></textarea>
            </div>

            <div class="mb-3 col-md-3">
                <label for="exampleInputEmail1" class="form-label">Status</label>
                <select name="status" id="" class="form-control">
                    <option value="active">Active</option>
                    <option value="inactive">InActive</option>
                </select>
            </div>

            <hr>
            <div class="row d-flex justify-content-between">
                <div class="row">
                    <h3>Rules</h3>

                </div>
                <div class="row">
                    <button class="btn btn-primary">++</button>
                    <button class="btn btn-danger">--</button>

                </div>
            </div>
            <div class="container">
                <div class="col-md-12 row">
                    <div class="col-md-4">
                        <label for="">Field Name</label>
                        <select name="fieldname" id="" class="form-control">
                            @foreach ($fields as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                                
                            @endforeach
                        </select>
                    </div>
    
                    <div class="col-md-4">
                        <label for="">Operators</label>
                        <select name="fieldname" id="" class="form-control">
                            <option value="equal">Equal</option>
                            <option value="notequal">Not Equal</option>
                        
                        </select>
                    </div>
    
                    <div class="col-md-4">
                        <label for="">Values</label>
                        <input type="text" class="form-control" name="value">
    
                    </div>

                </div>
            </div>

            <input type="hidden" value="{{ auth()->id() }}" name="userid">

            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
      </div>

    </div>


  </div>
</div>


<!-- Recent Sales End -->



{{-- <script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor1');
    </script> --}}
@endsection