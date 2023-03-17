@extends('layouts.structure')

@section('content')
    <br>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        {{ __('You are logged in!') }}
                        <b>{{ ucwords(strtolower(Auth::user()->name)) }}</b>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-sm-6">
                                {{ __('Dashboard') }}
                            </div>
                            <div class="col-sm-6">
                                <button type="button" class="btn btn-sm btn-primary" data-mdb-toggle="modal"
                                    data-mdb-target="#exampleModal">
                                    Upload New File
                                </button>
                            </div>
                            <!-- Button trigger modal -->
                        </div>
                        <div class="row">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width = "5%">#</th>
                                        <th>DESCRIPTION</th>
                                        <th width ="30%">ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                    @php
                                        $i = 1;
                                    @endphp
                                    @forelse ($media as $med)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $med->name }}</td>
                                        <td>
                                            <a href="{{ asset($med->doc) }}" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip" target="_blank" data-bs-placement="top" title="View Document">View</a>

                                            <button type="button" class="btn btn-sm btn-success" data-mdb-toggle="modal" data-mdb-target="#updatemedia{{ $med->id }}" data-bs-toggle="tooltip"  data-bs-placement="top" title="Edit Description">
                                                Edit
                                         </button>

                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" onclick="deleteMedia({{ $med->id }})" data-bs-placement="top" title="Delete Record">Delete</button>

                                        </td>
                                        <form action="" id="myform{{ $med->id }}" name="myform" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <!-- Modal -->
                                            <div class="modal fade" id="updatemedia{{ $med->id }}" tabindex="-1" aria-labelledby="updatemediaLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="updatemediaLabel">Update</h5>
                                                            <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3 row">
                                                                <label for="name{{ $med->id }}" class="form-label col-sm-2 col-form-label">Description</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control" id="name{{ $med->id }}" name="name" value="{{ $med->name }}"
                                                                        placeholder="Description">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
                                                            <button type="button" onclick="updateMedia({{ $med->id }});" class="btn btn-primary">Save</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" align="center">No data available</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="" id="myform" name="myform" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New Upload</h5>
                        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col">
                            <div class="mb-3 row">
                                <label for="name" class="form-label">Description</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Description">
                            </div>
                            <div class="mb-3 row">
                                <label for="media" class="form-label">Upload [PDF and Word document only]</label>
                                <input class="form-control" type="file" id="media" name="media">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
                        <button type="button" onclick="fileUpload();" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <br>
    <script src="{{ asset('js/media.js') }}"></script>
@endsection
