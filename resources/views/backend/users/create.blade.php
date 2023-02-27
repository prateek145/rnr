@extends('backend.layouts.app')
@section('content')
    <!-- Recent Sales Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-start rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">User Create</h6>

            </div>
            <div class="bg-light rounded h-100 p-4">
                {{-- <h6 class="mb-4">Audit </h6> --}}
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">First Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            id="name" aria-describedby="namehelp" required>
                        @error('name')
                            <label id="name-error" class="error text-danger" for="name">{{ $message }}</label>
                        @enderror
                        <div id="namehelp" class="form-text">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Last Name</label>
                        <input type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname"
                            id="lastname" aria-describedby="lastnamehelp" required>
                        @error('lastname')
                            <label id="lastname-error" class="error text-danger" for="lastname">{{ $message }}</label>
                        @enderror
                        <div id="lastnamehelp" class="form-text">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" aria-describedby="namehelp" required>
                        @error('email')
                            <label id="email-error" class="error text-danger" for="email">{{ $message }}</label>
                        @enderror
                        <div id="namehelp" class="form-text">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label @error('mobile_no') is-invalid @enderror">Mobile
                            No</label>
                        <input type="text" class="form-control" id="name" name="mobile_no"
                            aria-describedby="namehelp" required>
                        @error('mobile_no')
                            <label id="mobile_no-error" class="error text-danger" for="mobile_no">{{ $message }}</label>
                        @enderror
                        <div id="namehelp" class="form-text">
                        </div>
                    </div>

                    <div class="mb-3">

                        <div class="row">
                            <div class="col-md-6">
                                <label for="exampleInputEmail1"
                                    class="form-label @error('password') is-invalid @enderror">Password</label>
                                <input type="password" class="form-control" id="name" name="password"
                                    aria-describedby="namehelp">
                                @error('password')
                                    <label id="password-error" class="error text-danger"
                                        for="password">{{ $message }}</label>
                                @enderror
                                <div id="namehelp" class="form-text">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="exampleInputEmail1"
                                    class="form-label @error('repassword') is-invalid @enderror">Re-Password</label>
                                <input type="password" class="form-control" id="name" name="repassword"
                                    aria-describedby="namehelp">
                                @error('repassword')
                                    <label id="repassword-error" class="error text-danger"
                                        for="repassword">{{ $message }}</label>
                                @enderror
                                <div id="namehelp" class="form-text">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="mb-3 row">

                        <div class="col-md-6">
                            <label for="exampleInputEmail1"
                                class="form-label @error('department') is-invalid @enderror">Groups</label>
                            <select name="group_id[]" id="" class="form-control" multiple>
                                <option value="">Select Group</option>
                                @foreach ($groups as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('group_id')
                                <label id="group_id-error" class="error text-danger" for="group_id">{{ $message }}</label>
                            @enderror
                            <div id="namehelp" class="form-text">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="exampleInputEmail1"
                                class="form-label @error('department') is-invalid @enderror">Status</label>
                            <select name="status" id="" class="form-control" required>
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            @error('group_id')
                                <label id="group_id-error" class="error text-danger"
                                    for="group_id">{{ $message }}</label>
                            @enderror
                            <div id="namehelp" class="form-text">
                            </div>
                        </div>

                    </div>

                    <div class="col-md-12 mb-2">
                        <label for="remarks"> <strong>SHHkey/Token/Certificate</strong> </label>
                        <textarea name="remarks" id="" cols="30" rows="4" class="form-control">
                            
                        </textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Recent Sales End -->
@endsection
