@extends('backend.layouts.app')
@section('content')
    <!-- Recent Sales Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-start rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Field Details</h6>

            </div>
            <div class="bg-light rounded h-100 p-4">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="mb-4">Field </h6>

                    </div>

                    {{-- <div class="col-md-6 text-end">
                        <button class="btn btn-primary">
                            <a href="">
                                <-return back</a> </button>
                    </div> --}}

                </div>

                <form action="{{ route('field.update', $field->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            id="name" aria-describedby="namehelp" value="{{ $field->name }}">
                        @error('name')
                            <label id="name-error" class="error text-danger" for="name">{{ $message }}</label>
                        @enderror
                        <div id="namehelp" class="form-text">
                        </div>
                    </div>
                    <div class="class mb-3">
                        <label for="exampleInputEmail1" class="form-label">Type</label>
                        <select name="type" id="" class="form-control @error('type') is-invalid @enderror"
                            required>
                            <option value="date">Date</option>
                            <option value="date_time">Date Time</option>
                            <option value="attachments">Attachments</option>
                            <option value="images">Images</option>
                            <option value="ip_address">IP Address</option>
                            <option value="number">Numeric</option>
                            <option value="text">Text</option>
                            <option value="value_list">Value List</option>
                            <option value="user_group_list">User Group List</option>
                        </select>
                    </div>
                    <div class="class mb-3 row">

                        <div class="col-md-6">
                            <label for="exampleInputEmail1" class="form-label">Status</label>
                            <select name="status" id=""
                                class="form-control @error('status') is-invalid @enderror">
                                <option value="1">Active</option>
                                <option value="0">In Active</option>
                            </select>

                        </div>

                        <div class="col-md-6 mt-2">
                            <label for="forder">Order</label>
                            <input class="form-control" type="number" name="forder" value="{{ $field->forder }}"
                                placeholder="Field Order">

                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="">Options</label><br>
                        @if ($field->requiredfield == 1)
                            <input type="checkbox" id="" name="requiredfield" value="1" checked>
                            <label for=""> make it required field</label><br>
                        @else
                            <input type="checkbox" id="" name="requiredfield" value="1">
                            <label for=""> make it required field</label><br>
                        @endif

                        @if ($field->requireuniquevalue == 1)
                            <input type="checkbox" id="" name="requireuniquevalue" checked value="1">
                            <label for=""> make it unique field</label><br>
                        @else
                            <input type="checkbox" id="" name="requireuniquevalue" value="1">
                            <label for=""> make it unique field</label><br>
                        @endif

                        @if ($field->keyfield == 1)
                            <input type="checkbox" id="" name="keyfield" checked value="1">
                            <label for=""> make it key field</label><br>
                        @else
                            <input type="checkbox" id="" name="keyfield" value="1">
                            <label for=""> make it key field</label><br>
                        @endif

                    </div>


                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Access</label><br>
                        <input type="radio" name="access" value="public">
                        <label for="">Public</label><br>
                        <input type="radio" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo"
                            name="access" value="private">
                        <label for="">Private</label><br>

                    </div>



                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Select Group</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                @php
                                    $selectedvalues = json_decode($field->groups);
                                    // dd($selectedvalues);
                                @endphp
                                <div class="modal-body">
                                    <div class="mb-3 text-start">
                                        <label for="message-text" class="col-form-label fw-bold text-left ">Groups</label>
                                        <select name="groups[]" id="" class="form-control" multiple>
                                            @if ($field->groups != null)
                                                @foreach ($groups as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ in_array($item->id, $selectedvalues) ? 'selected' : '' }}>
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            @else
                                                @foreach ($groups as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            @endif

                                        </select>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
                                    {{-- <button type="button" class="btn btn-primary">Submit</button> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" value="{{ auth()->id() }}" name="updated_by">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Recent Sales End -->

    <script>
        var type = "{{ $field->type }}";
        var currenttype = document.getElementsByName('type')[0];
        // console.log(type, currenttype);
        for (let index = 0; index < currenttype.length; index++) {
            if (currenttype[index].value == type) {
                currenttype[index].selected = true;
            }
        }

        var radioselected = "{{ $field->access }}";
        var radio = document.getElementsByName('access');
        // console.log(radio);
        for (let index = 0; index < radio.length; index++) {
            if (radio[index].value == radioselected) {
                radio[index].checked = true;
            }
        }
    </script>
@endsection
