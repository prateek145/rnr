@extends('backend.layouts.app')
@section('content')
    <!-- Recent Sales Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Users</h6>
                <a href="{{ route('users.create') }}">
                    <button type="button" class="btn btn-primary">New</button>
                </a>

            </div>
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-dark">
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Created At</th>
                            {{-- <th scope="col">Report Date</th>
                            <th scope="col">Expiry</th>
                            <th scope="col">Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->created_at }}</td>
                                {{-- <td>{{ $item->report_date }}</td>
                                <td>{{ $item->sharewith }}</td> --}}

                                <td class="d-flex justify-content-between"><a class="btn btn-sm btn-primary"
                                        href="{{ route('users.edit', $item->id) }}">Edit</a>

                                    <form action="{{ route('users.destroy', $item->id) }}" method="post">
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
