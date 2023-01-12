@extends('backend.layouts.app')
@section('content')
    <!-- Recent Sales Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-start rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                {{-- <h6 class="mb-0">Application Create</h6> --}}

            </div>

            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Group Edit</h6>
                <form action="{{ route('group.update', $group->id) }}" class="form-horizontal" method="post">
                    @method('PUT')
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            id="name" aria-describedby="namehelp" value="{{ $group->name }}" required>
                        @error('name')
                            <label id="name-error" class="error text-danger" for="name">{{ $message }}</label>
                        @enderror
                        <div id="namehelp" class="form-text">
                        </div>
                    </div>

                    <div class="mb-3 text-start">
                        <div class="d-flex justify-content-between mb-2">
                            <label for="message-text" class="col-form-label fw-bold text-left ">Users</label>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal" data-bs-whatever="@mdo">Add Users</button>

                        </div>

                        <select id="" class="form-control " multiple disabled>
                            @foreach ($selectedusers as $item)
                                <option selected>
                                    {{ $item->name . ' (' . $item->email . ' )' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- for modal --}}
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">New Group</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <div class="mb-3 text-start">
                                        <label for="message-text" class="col-form-label fw-bold text-left ">Users
                                            <small> (multiple select ctrl + click)</small></label>
                                        <select name="userids[]" id="" class="form-control " multiple>
                                            @foreach ($users as $item)
                                                {{-- {{ dd($item) }} --}}
                                                <option value="{{ $item->id }}">{{ $item->name }}
                                                    ({{ $item->email }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- for modal --}}


                    <div class="mb-3">
                        <label for="exampleInputEmail1"
                            class="form-label @error('status') is-invalid @enderror">Status</label>
                        <select name="status" id="" class="form-control @error('status') is-invalid @enderror"
                            required>
                            <option value="1">Active</option>
                            <option value="0">In Active</option>
                        </select>
                        @error('status')
                            <label id="status-error" class="error text-danger" for="status">{{ $message }}</label>
                        @enderror
                    </div>

                    <input type="hidden" value="{{ auth()->id() }}" name="user_id">

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>


        </div>
    </div>


    <!-- Recent Sales End -->






    <script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor1');
    </script>
    <script>
        var status = "{{ $group->status }}";
        var currentstatus = document.getElementsByName('status')[0];
        for (let index = 0; index < currentstatus.length; index++) {
            if (currentstatus[index].value == status) {
                currentstatus[index].selected = true;
            }
        }
    </script>
@endsection
