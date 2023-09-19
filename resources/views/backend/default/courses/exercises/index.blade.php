@extends('backend.default.layouts.app')

@section('style')
    <!-- Data Table CSS -->
    <link href="{{asset('public/backend')}}/default/vendors/datatables/datatables.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Exercises</h3>
            </div>
            <div class="col-auto text-end float-end ms-auto">
                <a href="{{ route('exercise.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
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
                                <th class="text-center">Lesson</th>
                                <th class="text-center">Content</th>
                                <th class="text-center">Condition</th>
                                <th class="text-center">Answer</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($exercises as $index => $exercise)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center">
                                        @if(!empty($exercise->lesson->title))
                                            <span class="text-secondary">{{ $exercise->lesson->title }}</span>
                                        @else
                                            <a href="javascript:void(0);">
                                                <span class="text-secondary"> </span>
                                            </a>
                                        @endif
                                    </td>
                                    <td class="text-center text-info">
                                        <strong>{!! $exercise->content !!}</strong>
                                    </td>
                                    <td class="text-center">
                                        @if(!empty($exercise->condition->title))
                                            <span class="text-secondary">{{ $exercise->condition->title }}</span>
                                        @else
                                            <a href="javascript:void(0);">
                                                <span class="text-secondary"> </span>
                                            </a>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{ $exercise->answer }}
                                    </td>
                                    <td class="text-center">
                                        @if($exercise->active_status == 1 )
                                            <span class="text-success">Online</span>
                                        @else
                                            <span class="text-danger">Offline</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('exercise.edit', $exercise) }}" class="btn btn-outline-success me-2">
                                            <i class="fad fa-edit"></i>
                                        </a>
                                        @if($exercise->active_status == 1)
                                            <button class="btn btn-outline-secondary me-2" data-bs-toggle="modal" data-bs-target="#block-{{ $exercise->id }}">
                                                <i class="fa-duotone fa-lock"></i>
                                            </button>
                                            <!-- Block Modal -->
                                            <div class="modal fade" id="block-{{ $exercise->id }}" tabindex="-1" role="dialog" aria-labelledby="block-{{ $exercise->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <form class="modal-content" action="{{ route('exercise.block', $exercise) }}" method="post" id="block-{{ $exercise->id }}">
                                                       @method('PUT')
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h6 class="modal-title" id="block-{{ $exercise->id }}">{!! $exercise->content !!}</h6>
                                                        </div>
                                                        <div class="modal-body bg-secondary">
                                                            <p class="text-center text-white">
                                                                <strong>
                                                                    Do you really want to block ?
                                                                </strong>
                                                            <p class="text-white text-uppercase text-center p-2">{!! $exercise->content !!}</p>
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
                                                <button class="btn btn-icon btn-outline-info me-2" data-bs-toggle="modal" data-bs-target="#block-{{ $exercise->id }}">
                                                    <i class="fa-duotone fa-unlock"></i>
                                                </button>
                                            <!-- Block Modal -->
                                            <div class="modal fade" id="block-{{ $exercise->id }}" tabindex="-1" role="dialog" aria-labelledby="block-{{ $exercise->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <form class="modal-content" action="{{ route('exercise.block', $exercise) }}" method="post" id="block-{{ $exercise->id }}">
                                                        @method('PUT')
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="block-{{ $exercise->id }}">{!! $exercise->content !!}</h5>
                                                        </div>
                                                        <div class="modal-body bg-secondary">
                                                            <p class="text-center text-white">
                                                                <strong>
                                                                    Do you really want to unblock ?
                                                                </strong>
                                                            <h6 class="text-white text-uppercase text-center">{!! $exercise->content !!}</h6>
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
                                            <button class="btn btn-icon btn-outline-danger me-2" data-bs-toggle="modal" data-bs-target="#destroy-{{ $exercise->id }}">
                                                <i class="fa-duotone fa-trash-can"></i>
                                            </button>
                                        <!-- Block Modal -->
                                        <div class="modal fade" id="destroy-{{ $exercise->id }}" tabindex="-1" role="dialog" aria-labelledby="destroy-{{ $exercise->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <form class="modal-content" action="{{ route('exercise.destroy', $exercise) }}" method="post" id="destroy-{{ $exercise->id }}">
                                                    @method('DELETE')
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="destroy-{{ $exercise->id }}">{!! $exercise->content !!}</h5>
                                                    </div>
                                                    <div class="modal-body bg-secondary">
                                                        <p class="text-center text-white">
                                                            <strong>
                                                                Do you really want to Destroy ?
                                                            </strong>
                                                        <h6 class="text-white text-uppercase text-center">{!! $exercise->content !!}</h6>
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
