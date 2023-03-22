@extends('backend.layouts.app')
@section('content')
    <!-- Recent Sales Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-start rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">

            </div>

            <div class="bg-light rounded h-100 p-4">

                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="d-flex justify-content-between">
                            <div >
                                <h6 class="mb-4"> {{ strtoupper($application->name) }} Role </h6>
                            </div>
                            <div >
                                <a href="{{ route('multiplerole.show', $applicationrole->id) }}">
                                    <button type="button" class="btn btn-danger"><- Return</button>
                                </a>
                            </div>

                        </div>
                        <form action="{{ route('role.update', $applicationrole->id) }}" class="form-horizontal" method="post">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                    id="name" aria-describedby="namehelp" value="{{$applicationrole->name}}" required>
                                @error('name')
                                    <label id="name-error" class="error text-danger" for="name">{{ $message }}</label>
                                @enderror
                                <div id="namehelp" class="form-text">
                                </div>
                            </div>

                            @if ($applicationrole != null)
                                <div class="mb-3">
                                    @if ($applicationrole->import == 1)
                                        <input type="checkbox" id="" name="import" value="1" checked>
                                        <label for=""> Import</label>
                                    @else
                                        <input type="checkbox" id="" name="import" value="1">
                                        <label for=""> Import</label>
                                    @endif

                                </div>

                                <div class="mb-3">
                                    @if ($applicationrole->create == 1)
                                        <input type="checkbox" id="" name="create" value="1" checked>
                                        <label for=""> Create</label>
                                    @else
                                        <input type="checkbox" id="" name="create" value="1">
                                        <label for=""> Create</label>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    @if ($applicationrole->read == 1)
                                        <input type="checkbox" id="" name="read" value="1" checked>
                                        <label for=""> Read</label>
                                    @else
                                        <input type="checkbox" id="" name="read" value="1">
                                        <label for=""> Read</label>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    @if ($applicationrole->update == 1)
                                        <input type="checkbox" id="" name="update" value="1" checked>
                                        <label for=""> Update</label>
                                    @else
                                        <input type="checkbox" id="" name="update" value="1">
                                        <label for=""> Update</label>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    @if ($applicationrole->delete == 1)
                                        <input type="checkbox" id="" name="delete" value="1" checked>
                                        <label for=""> Delete</label>
                                    @else
                                        <input type="checkbox" id="" name="delete" value="1">
                                        <label for=""> Delete</label>
                                    @endif
                                </div>

                                <div>

                                    <div class="mb-3">
                                        {{-- <label for="exampleInputEmail1" class="form-label">{{ strtoupper($item->name) }}</label> --}}
                                        <div class="usergrouplist">
                                            <div class="d-flex justify-content-between mb-2">
                                                <div class="col-md-2 addusers">
                                                    <button type="button" class="btn btn-primary text-end"
                                                        data-bs-toggle="modal" data-bs-target="#exampleModalusers"
                                                        data-bs-whatever="@mdo">Add Users</button>
                                                </div>

                                                <div class="col-md-2 addgroups">
                                                    <button type="button" class="btn btn-primary text-end"
                                                        data-bs-toggle="modal" data-bs-target="#exampleModalgroups"
                                                        data-bs-whatever="@mdo">Add Groups</button>
                                                </div>

                                            </div>

                                            <div class="col-md-12 d-flex justify-content-between">
                                                @if ($selectedusers != [])
                                                    <div class="col-md-5">
                                                        <select id="" class="form-control " multiple disabled>
                                                            @foreach ($selectedusers as $item)
                                                                <option selected>
                                                                    {{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endif

                                                @if ($selectedgroups != [])
                                                    <div class="col-md-5">
                                                        <select id="" class="form-control " multiple disabled>
                                                            @foreach ($selectedgroups as $item)
                                                                <option selected>
                                                                    {{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endif
                                            </div>


                                            <div class="modal fade" id="exampleModalusers" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Select Users
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <div class="mb-3 text-start">
                                                                <label for="message-text"
                                                                    class="col-form-label fw-bold text-left ">Users
                                                                    <small>(ctrl + click) multiple select</small> </label>
                                                                <select name="user_list[]" id=""
                                                                    class="form-control" multiple>
                                                                    @foreach ($users as $item)
                                                                        <option value="{{ $item->id }}">
                                                                            {{ $item->name }}
                                                                        </option>
                                                                    @endforeach


                                                                </select>
                                                            </div>

                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary"
                                                                data-bs-dismiss="modal">Save</button>
                                                            {{-- <button type="button" class="btn btn-primary">Submit</button> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="exampleModalgroups" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Select Groups
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <div class="mb-3 text-start">
                                                                <label for="message-text"
                                                                    class="col-form-label fw-bold text-left ">Groups
                                                                    <small>(ctrl + click) multiple select</small> </label>
                                                                <select name="group_list[]" id=""
                                                                    class="form-control" multiple>
                                                                    @foreach ($groups as $item)
                                                                        <option value="{{ $item->id }}">
                                                                            {{ $item->name }}
                                                                        </option>
                                                                    @endforeach


                                                                </select>
                                                            </div>

                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary"
                                                                data-bs-dismiss="modal">Save</button>
                                                            {{-- <button type="button" class="btn btn-primary">Submit</button> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <input type="hidden" value="{{ auth()->id() }}" name="updated_by">
                                <input type="hidden" value="{{ $application->id }}" name="application_id">
                            @else
                                <div class="mb-3">
                                    <input type="checkbox" id="" name="import" value="1">
                                    <label for=""> Import</label>
                                </div>

                                <div class="mb-3">
                                    <input type="checkbox" id="" name="create" value="1">
                                    <label for=""> Create</label>
                                </div>

                                <div class="mb-3">
                                    <input type="checkbox" id="" name="read" value="1">
                                    <label for=""> Read</label>
                                </div>

                                <div class="mb-3">
                                    <input type="checkbox" id="" name="update" value="1">
                                    <label for=""> Update</label>
                                </div>

                                <div class="mb-3">
                                    <input type="checkbox" id="" name="delete" value="1">
                                    <label for=""> Delete</label>
                                </div>

                                <div>

                                    <div class="mb-3">
                                        {{-- <label for="exampleInputEmail1" class="form-label">{{ strtoupper($item->name) }}</label> --}}
                                        <div class="usergrouplist">
                                            <div class="d-flex justify-content-between mb-2">
                                                <div class="col-md-2 addusers">
                                                    <button type="button" class="btn btn-primary text-end"
                                                        data-bs-toggle="modal" data-bs-target="#exampleModalusers"
                                                        data-bs-whatever="@mdo">Add Users</button>
                                                </div>

                                                <div class="col-md-2 addgroups">
                                                    <button type="button" class="btn btn-primary text-end"
                                                        data-bs-toggle="modal" data-bs-target="#exampleModalgroups"
                                                        data-bs-whatever="@mdo">Add Groups</button>
                                                </div>

                                            </div>

                                            <div class="modal fade" id="exampleModalusers" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Select Users
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <div class="mb-3 text-start">
                                                                <label for="message-text"
                                                                    class="col-form-label fw-bold text-left ">Users
                                                                    <small>(ctrl + click) multiple select</small> </label>
                                                                <select name="user_list[]" id=""
                                                                    class="form-control" multiple>
                                                                    @foreach ($users as $item)
                                                                        <option value="{{ $item->id }}">
                                                                            {{ $item->name }}
                                                                        </option>
                                                                    @endforeach


                                                                </select>
                                                            </div>

                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary"
                                                                data-bs-dismiss="modal">Save</button>
                                                            {{-- <button type="button" class="btn btn-primary">Submit</button> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="exampleModalgroups" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Select Groups
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <div class="mb-3 text-start">
                                                                <label for="message-text"
                                                                    class="col-form-label fw-bold text-left ">Groups
                                                                    <small>(ctrl + click) multiple select</small> </label>
                                                                <select name="group_list[]" id=""
                                                                    class="form-control" multiple>
                                                                    @foreach ($groups as $item)
                                                                        <option value="{{ $item->id }}">
                                                                            {{ $item->name }}
                                                                        </option>
                                                                    @endforeach


                                                                </select>
                                                            </div>

                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary"
                                                                data-bs-dismiss="modal">Save</button>
                                                            {{-- <button type="button" class="btn btn-primary">Submit</button> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <input type="hidden" value="{{ auth()->id() }}" name="updated_by">
                                <input type="hidden" value="{{ $application->id }}" name="application_id">
                            @endif


                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>

            </div>


        </div>
    </div>


    <!-- Recent Sales End -->






    <script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor1');
    </script>
    <script>
        var status = "{{ $application->status }}";
        var currentstatus = document.getElementsByName('status')[0];
        for (let index = 0; index < currentstatus.length; index++) {
            if (currentstatus[index].value == status) {
                currentstatus[index].selected = true;
            }
        }
        var field = "{{ Session::get('field') }}";
        if (field == 'active') {
            document.getElementById('pills-home-tab').className = 'nav-link';
            document.getElementById('pills-profile-tab').className = 'nav-link active';
            document.getElementById('pills-home').className = 'tab-pane fade';
            document.getElementById('pills-profile').className = 'tab-pane fade show active';
        }
    </script>
@endsection
