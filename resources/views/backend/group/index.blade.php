@extends('backend.layouts.app')
@section('content')
    <!-- Recent Sales Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Group</h6>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"
                    data-bs-whatever="@mdo">New</button>

            </div>


            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('group.store') }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">New Group</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3 text-start">
                                    <label for="message-text" class="col-form-label fw-bold text-left ">Name</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>

                                <div class="mb-3 text-start">
                                    <label for="message-text" class="col-form-label fw-bold text-left ">Users</label>
                                    <select name="userids[]" id="" class="form-control " multiple required>
                                        @foreach ($users as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 text-start">
                                    <label for="message-text" class="col-form-label fw-bold text-left ">Status</label>
                                    <select name="status" id="" class="form-control ">
                                        <option value="1">Active</option>
                                        <option value="0">In Active</option>
                                    </select>
                                </div>

                            </div>
                            <input type="hidden" value="{{ auth()->id() }}" name="user_id">

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-dark">
                            <th scope="col">Date</th>
                            <th scope="col">Name</th>
                            <th scope="col">Status</th>
                            <th scope="col">UserName</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groups as $item)
                            <tr>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    @if ($item->status == 1)
                                        Active
                                    @else
                                        InActive
                                    @endif
                                </td>
                                @php
                                    if ($item->user_id) {
                                        $user = App\Models\User::find($item->user_id);
                                        $username = $user->name;
                                    } else {
                                        $username = 'none';
                                    }
                                @endphp
                                <td>{{ $username }}</td>
                                <td class="d-flex justify-content-between"><a class="btn btn-sm btn-primary"
                                        href="{{ route('group.edit', $item->id) }}">Edit</a>

                                    <form action="{{ route('group.destroy', $item->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <input class="btn btn-sm btn-danger" onclick="return confirm('Are You Sure ?')"
                                            type="submit" value="Delete">
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Recent Sales End -->
@endsection
