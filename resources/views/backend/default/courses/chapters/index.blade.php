@extends('backend.default.layouts.app')

@section('style')
    <!-- Data Table CSS -->
    <link href="{{asset('public/backend')}}/default/vendors/datatables/datatables.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Chapters</h3>
            </div>
            <div class="col-auto text-end float-end ms-auto">
                <a href="{{ route('chapter.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-table">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-center mb-0 datatable">
                            <thead>
                            <tr>
                                <th class="text-center">№</th>
                                <th class="text-center">Icon</th>
                                <th class="text-center">Title</th>
                                <th class="text-center">Course</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($chapters as $index => $chapter)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center">
                                        <div class="avatar avatar-xl">
                                            @if(!empty($chapter->image))
                                                <img src="{{ asset($chapter->image) }}" class="avatar-img rounded" alt=" ">
                                            @else
                                                <img src="{{asset('public/uploads')}}/default/icon.jpg" class="avatar-img rounded" alt=" ">
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('chapter.show', $chapter) }}" class="text-uppercase">
                                            <strong><u>{{ $chapter->title }}</u></strong>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        @if(!empty($chapter->course->title))
                                            <a href="{{ route('course.show', $chapter->course->slug) }}">
                                                <span class="text-secondary">{{ $chapter->course->title }}</span>
                                            </a>
                                        @else
                                            <a href="javascript:void(0);">
                                                <span class="text-secondary"> </span>
                                            </a>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($chapter->active_status == 1 )
                                            <span class="text-success">Online</span>
                                        @else
                                            <span class="text-danger">Offline</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('chapter.edit', $chapter) }}" class="btn btn-outline-success me-2">
                                            <i class="fad fa-edit"></i>
                                        </a>
                                      @if($chapter->active_status == 1)
                                            <button class="btn btn-outline-secondary me-2" data-bs-toggle="modal" data-bs-target="#block-{{ $chapter->slug }}">
                                                <i class="fas fa-lock"></i>
                                            </button>
                                            <!-- Block Modal -->
                                            <div class="modal fade" id="block-{{ $chapter->slug }}" tabindex="-1" role="dialog" aria-labelledby="block-{{ $chapter->slug }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <form class="modal-content" action="{{ route('chapter.block', $chapter) }}" method="post" id="block-{{ $chapter->slug }}">
                                                        @method('PUT')
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="block-{{ $chapter->slug }}">{{ $chapter->title }}</h5>
                                                        </div>
                                                        <div class="modal-body bg-secondary">
                                                            <p class="text-center text-white">
                                                                <strong>
                                                                    Do you really want to block ?
                                                                </strong>
                                                            <h6 class="text-white text-uppercase text-center">{{ $chapter->title }}</h6>
                                                            </p>
                                                        </div>
                                                        <div class="row p-2">
                                                            <div class="col-lg-6">
                                                                <button type="submit" class="btn btn-outline-danger btn-block">
                                                                    <i class="fad fa-sad-cry"></i>
                                                                    Yes
                                                                </button>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <a class="btn btn-outline-primary btn-block" data-bs-dismiss="modal">
                                                                    <i class="fad fa-smile-beam"></i>
                                                                    No
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @else
                                                <button class="btn btn-icon btn-outline-success me-2" data-bs-toggle="modal" data-bs-target="#block-{{ $chapter->slug }}">
                                                    <i class="fad fa-unlock"></i>
                                                </button>
                                            <!-- Block Modal -->
                                            <div class="modal fade" id="block-{{ $chapter->slug }}" tabindex="-1" role="dialog" aria-labelledby="block-{{ $chapter->slug }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <form class="modal-content" action="{{ route('chapter.block', $chapter) }}" method="post" id="block-{{ $chapter->slug }}">
                                                        @method('PUT')
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="block-{{ $chapter->slug }}">{{ $chapter->title }}</h5>
                                                        </div>
                                                        <div class="modal-body bg-secondary">
                                                            <p class="text-center text-white">
                                                                <strong>
                                                                    Do you really want to unblock ?
                                                                </strong>
                                                            <h6 class="text-white text-uppercase text-center">{{ $chapter->title }}</h6>
                                                            </p>
                                                        </div>
                                                        <div class="row p-2">
                                                            <div class="col-lg-6">
                                                                <a type="submit" class="btn btn-outline-danger btn-block">
                                                                    <i class="fad fa-sad-cry"></i>
                                                                    No
                                                                </a>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <button class="btn btn-outline-info btn-block" data-bs-dismiss="modal">
                                                                    <i class="fad fa-smile-beam"></i>
                                                                    Yes
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @endif
                                        <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#destroy-{{ $chapter->slug }}">
                                            <i class="fa-duotone fa-trash-can"></i>
                                        </button>
                                        <!-- Destroy Modal -->
                                        <div class="modal fade" id="destroy-{{ $chapter->slug }}" tabindex="-1" role="dialog" aria-labelledby="destroy-{{ $chapter->slug }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <form class="modal-content" action="{{ route('chapter.destroy', $chapter) }}" method="post" id="destroy-{{ $chapter->slug }}">
                                                    @method('DELETE')
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="destroy-{{ $chapter->slug }}">{{ $chapter->title }}</h5>
                                                    </div>
                                                    <div class="modal-body bg-secondary">
                                                        <p class="text-center text-white">
                                                            <strong>
                                                                Do you really want to Destroy ?
                                                            </strong>
                                                        <h6 class="text-white text-uppercase text-center">{{ $chapter->title }}</h6>
                                                        </p>
                                                    </div>
                                                    <div class="row p-2">
                                                        <div class="col-lg-6">
                                                            <button type="submit" class="btn btn-outline-danger btn-block">
                                                                <i class="fad fa-sad-cry"></i>
                                                                Yes
                                                            </button>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <a class="btn btn-outline-primary btn-block" data-bs-dismiss="modal">
                                                                <i class="fad fa-smile-beam"></i>
                                                                No
                                                            </a>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Data Table JS -->
    <script src="{{asset('public/backend')}}/default/vendors/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('public/backend')}}/default/vendors/datatables/datatables.min.js"></script>
    <script>
        $(document).ready( function () {
            $('.datatable').DataTable();
        } );
    </script>
@endsection
