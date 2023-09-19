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
                <a href="{{ route('course.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
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
                                <th class="text-center">Cover</th>
                                <th class="text-center">Title</th>
                                <th class="text-center">Teacher</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($courses as $index => $course)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center">
                                        <div class="avatar avatar-xl">
                                            @if(!empty($course->image))
                                                <img src="{{ asset($course->image) }}" class="avatar-img rounded" alt=" ">
                                            @else
                                                <img src="{{asset('public/uploads')}}/default/cover.jpg" class="avatar-img rounded" alt=" ">
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('course.show', $course) }}" class="text-uppercase">
                                            <strong><u>{{ $course->title }}</u></strong>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        @if(!empty($course->teachers->slug))
                                            <a href="{{ route('user.show', $course->teachers->slug) }}">
                                                <span class="text-secondary">{{ $course->teachers->full_name }}</span>
                                            </a>
                                        @else
                                            <a href="javascript:void(0);">
                                                <span class="text-secondary"> </span>
                                            </a>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($course->active_status == 1 )
                                            <span class="text-success">Active</span>
                                        @else
                                            <span class="text-danger">Disabled</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('course.edit', $course) }}" class="btn btn-outline-success me-2">
                                            <i class="fad fa-edit"></i>
                                        </a>
                                        @if($course->active_status == 1)
                                            <button class="btn btn-outline-secondary me-2" data-bs-toggle="modal" data-bs-target="#block-{{ $course->slug }}">
                                                <i class="fas fa-lock"></i>
                                            </button>
                                            <!-- Block Modal -->
                                            <div class="modal fade" id="block-{{ $course->slug }}" tabindex="-1" role="dialog" aria-labelledby="block-{{ $course->slug }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <form class="modal-content" action="{{ route('course.block', $course) }}" method="post" id="block-{{ $course->slug }}">
                                                        @method('PUT')
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="block-{{ $course->slug }}">{{ $course->title }}</h5>
                                                        </div>
                                                        <div class="modal-body bg-secondary">
                                                            <p class="text-center text-white">
                                                                <strong>
                                                                    Do you really want to block ?
                                                                </strong>
                                                            <h6 class="text-white text-uppercase text-center">{{ $course->title }}</h6>
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
                                            <button class="btn btn-icon btn-outline-info me-2" data-bs-toggle="modal" data-bs-target="#block-{{ $course->slug }}">
                                                <i class="fad fa-unlock"></i>
                                            </button>
                                            <!-- Block Modal -->
                                            <div class="modal fade" id="block-{{ $course->slug }}" tabindex="-1" role="dialog" aria-labelledby="block-{{ $course->slug }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <form class="modal-content" action="{{ route('course.block', $course) }}" method="post" id="block-{{ $course->slug }}">
                                                        @method('PUT')
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="block-{{ $course->slug }}">{{ $course->title }}</h5>
                                                        </div>
                                                        <div class="modal-body bg-secondary">
                                                            <p class="text-center text-white">
                                                                <strong>
                                                                    Do you really want to unblock ?
                                                                </strong>
                                                            <h6 class="text-white text-uppercase text-center">{{ $course->title }}</h6>
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
                                        <button class="btn btn-icon btn-outline-danger" data-bs-toggle="modal" data-bs-target="#destroy-{{ $course->slug }}">
                                            <i class="fa-duotone fa-trash-can"></i>
                                        </button>
                                        <!-- Destroy Modal -->
                                        <div class="modal fade" id="destroy-{{ $course->slug }}" tabindex="-1" role="dialog" aria-labelledby="destroy-{{ $course->slug }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <form class="modal-content" action="{{ route('course.destroy', $course) }}" method="post" id="destroy-{{ $course->slug }}">
                                                    @method('DELETE')
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="destroy-{{ $course->slug }}">{{ $course->title }}</h5>
                                                    </div>
                                                    <div class="modal-body bg-secondary">
                                                        <p class="text-center text-white">
                                                            <strong>
                                                                Do you really want to Destroy ?
                                                            </strong>
                                                        <h6 class="text-white text-uppercase text-center">{{ $course->title }}</h6>
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
                                                            <a class="btn btn-outline-info btn-block" data-bs-dismiss="modal">
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
