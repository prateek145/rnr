@extends('backend.layouts.app')
@section('content')
    <!-- Recent Sales Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-start rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">User Edit</h6>

            </div>
            <div class="bg-light rounded h-100 p-4">
                <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            id="name" aria-describedby="namehelp" value="{{ $user->name }}">
                        @error('name')
                            <label id="name-error" class="error text-danger" for="name">{{ $message }}</label>
                        @enderror
                        <div id="namehelp" class="form-text">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" aria-describedby="namehelp" value="{{ $user->email }}">
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
                            aria-describedby="namehelp" value="{{ $user->mobile_no }}">
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
                                    class="form-label @error('repassword') is-invalid @enderror">RePassword</label>
                                <input type="password" class="form-control" id="name" name="password_confirmation"
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
                            <select name="group_id" id="" class="form-control">
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
                            <select name="status" id="" class="form-control">
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

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Recent Sales End -->

    <script>
        var group = "{{ $user->group_id }}";
        var status = "{{ $user->status }}";

        var groupelement = document.getElementsByName('group_id')[0];
        var statuselement = document.getElementsByName('status')[0];

        for (let index = 0; index < groupelement.length; index++) {
            console.log(groupelement[index].value, group);
            if (groupelement[index].value == group) {
                groupelement[index].selected = true;
            }

        }

        for (let index = 0; index < statuselement.length; index++) {
            if (statuselement[index].value == status) {
                statuselement[index].selected = true;
            }

        }
    </script>
@endsection
