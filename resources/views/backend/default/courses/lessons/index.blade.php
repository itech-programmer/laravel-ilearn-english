@extends('backend.default.layouts.app')

@section('style')
    <!-- Data Table CSS -->
    <link href="{{asset('public/backend')}}/default/vendors/datatables/datatables.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Lessons</h3>
            </div>
            <div class="col-auto text-end float-end ms-auto">
                <a href="{{ route('lesson.create') }}" class="btn btn-primary">
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
                                <th class="text-center">Title</th>
                                <th class="text-center">Chapter</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($lessons as $index => $lesson)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('lesson.show', $lesson->slug) }}" class="text-uppercase">
                                            <strong><u>{{ $lesson->title }}</u></strong>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        @if(!empty($lesson->chapter->slug))
                                            <a href="{{ route('chapter.show', $lesson->chapter->slug) }}">
                                                <span class="text-secondary">{{ $lesson->chapter->title }}</span>
                                            </a>
                                        @else
                                            <a href="javascript:void(0);">
                                                <span class="text-secondary"> </span>
                                            </a>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($lesson->active_status == 1 )
                                            <span class="text-success">Online</span>
                                        @else
                                            <span class="text-danger">Offline</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('lesson.edit', $lesson) }}" class="btn btn-outline-success me-2">
                                            <i class="fad fa-edit"></i>
                                        </a>
                                        @if($lesson->active_status == 1)
                                            <button class="btn btn-outline-secondary me-2" data-bs-toggle="modal" data-bs-target="#block-{{ $lesson->slug }}">
                                                <i class="fas fa-lock"></i>
                                            </button>
                                            <!-- Block Modal -->
                                            <div class="modal fade" id="block-{{ $lesson->slug }}" tabindex="-1" role="dialog" aria-labelledby="block-{{ $lesson->slug }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <form class="modal-content" action="{{ route('lesson.block', $lesson) }}" method="post" id="block-{{ $lesson->slug }}">
                                                        @method('PUT')
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="block-{{ $lesson->slug }}">{{ $lesson->title }}</h5>
                                                        </div>
                                                        <div class="modal-body bg-secondary">
                                                            <p class="text-center text-white">
                                                                <strong>
                                                                    Do you really want to block ?
                                                                </strong>
                                                            <h6 class="text-white text-uppercase text-center">{{ $lesson->title }}</h6>
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
                                                <button class="btn btn-icon btn-outline-info me-2" data-bs-toggle="modal" data-bs-target="#block-{{ $lesson->slug }}">
                                                    <i class="fad fa-unlock"></i>
                                                </button>
                                            <!-- Block Modal -->
                                            <div class="modal fade" id="block-{{ $lesson->slug }}" tabindex="-1" role="dialog" aria-labelledby="block-{{ $lesson->slug }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <form class="modal-content" action="{{ route('lesson.block', $lesson) }}" method="post" id="block-{{ $lesson->slug }}">
                                                        @method('PUT')
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="block-{{ $lesson->slug }}">{{ $lesson->title }}</h5>
                                                        </div>
                                                        <div class="modal-body bg-secondary">
                                                            <p class="text-center text-white">
                                                                <strong>
                                                                    Do you really want to unblock ?
                                                                </strong>
                                                            <h6 class="text-white text-uppercase text-center">{{ $lesson->title }}</h6>
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
                                        <button class="btn btn-icon btn-outline-danger me-2" data-bs-toggle="modal" data-bs-target="#destroy-{{ $lesson->slug }}">
                                            <i class="fa-duotone fa-trash-can"></i>
                                        </button>
                                        <!-- Destroy Modal -->
                                        <div class="modal fade" id="destroy-{{ $lesson->slug }}" tabindex="-1" role="dialog" aria-labelledby="destroy-{{ $lesson->slug }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <form class="modal-content" action="{{ route('lesson.destroy', $lesson) }}" method="post" id="destroy-{{ $lesson->slug }}">
                                                    @method('DELETE')
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="destroy-{{ $lesson->slug }}">{{ $lesson->title }}</h5>
                                                    </div>
                                                    <div class="modal-body bg-secondary">
                                                        <p class="text-center text-white">
                                                            <strong>
                                                                Do you really want to Destroy ?
                                                            </strong>
                                                        <h6 class="text-white text-uppercase text-center">{{ $lesson->title }}</h6>
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
