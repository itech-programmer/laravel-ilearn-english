@extends('backend.default.layouts.app')

@section('style')
    <!-- Data Table CSS -->
    <link href="{{asset('public/backend')}}/default/vendors/datatables/datatables.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Questions</h3>
            </div>
            <div class="col-auto text-end float-end ms-auto">
                <a href="{{ route('question.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
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
                                <th class="text-center">Question</th>
                                <th class="text-center">Lesson</th>
                                <th class="text-center">Point</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($questions as $index => $question)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('question.show', $question) }}" class="text-uppercase">
                                            <strong><u>{{ $question->question_title }}</u></strong>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        @if(!empty($question->lesson_id))
                                            <a href="{{ route('lesson.show', $question->lesson->slug) }}">
                                                <span class="text-secondary">{{ $question->lesson->title }}</span>
                                            </a>
                                        @else
                                            <span class="text-secondary"></span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{ $question->point }}
                                    </td>
                                    <td class="text-center">
                                        @if($question->active_status == 1 )
                                            <span class="text-success">Online</span>
                                        @else
                                            <span class="text-danger">Offline</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('question.edit', $question) }}" class="btn btn-outline-success me-2">
                                            <i class="fad fa-edit"></i>
                                        </a>
                                        @if($question->active_status == 1)
                                            <button class="btn btn-outline-secondary me-2" data-bs-toggle="modal" data-bs-target="#block-{{ $question->slug }}">
                                                <i class="fas fa-lock"></i>
                                            </button>
                                            <!-- Block Modal -->
                                            <div class="modal fade" id="block-{{ $question->slug }}" tabindex="-1" role="dialog" aria-labelledby="block-{{ $question->slug }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <form class="modal-content" action="{{ route('question.block', $question) }}" method="post" id="block-{{ $question->slug }}">
                                                        @method('PUT')
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="block-{{ $question->slug }}">{{ $question->question_title }}</h5>
                                                        </div>
                                                        <div class="modal-body bg-secondary">
                                                            <p class="text-center text-white">
                                                                <strong>
                                                                    Do you really want to block ?
                                                                </strong>
                                                            <h6 class="text-white text-uppercase text-center">{{ $question->question_title }}</h6>
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
                                            <button class="btn btn-icon btn-outline-info me-2" data-bs-toggle="modal" data-bs-target="#block-{{ $question->slug }}">
                                                <i class="fad fa-unlock"></i>
                                            </button>

                                            <!-- Block Modal -->
                                            <div class="modal fade" id="block-{{ $question->slug }}" tabindex="-1" role="dialog" aria-labelledby="block-{{ $question->slug }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <form class="modal-content" action="{{ route('question.block', $question) }}" method="post" id="block-{{ $question->slug }}">
                                                        @method('PUT')
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="block-{{ $question->slug }}">{{ $question->question_title }}</h5>
                                                        </div>
                                                        <div class="modal-body bg-secondary">
                                                            <p class="text-center text-white">
                                                                <strong>
                                                                    Do you really want to unblock ?
                                                                </strong>
                                                            <h6 class="text-white text-uppercase text-center">{{ $question->question_title }}</h6>
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
                                        <button class="btn btn-icon btn-outline-danger" data-bs-toggle="modal" data-bs-target="#destroy-{{ $question->slug }}">
                                            <i class="fa-duotone fa-trash-can"></i>
                                        </button>

                                        <!-- Destroy Modal -->
                                        <div class="modal fade" id="destroy-{{ $question->slug }}" tabindex="-1" role="dialog" aria-labelledby="destroy-{{ $question->slug }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <form class="modal-content" action="{{ route('question.destroy', $question) }}" method="post" id="destroy-{{ $question->slug }}">
                                                    @method('DELETE')
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="destroy-{{ $question->slug }}">{{ $question->question_title }}</h5>
                                                    </div>
                                                    <div class="modal-body bg-secondary">
                                                        <p class="text-center text-white">
                                                            <strong>
                                                                Do you really want to Destroy ?
                                                            </strong>
                                                        <h6 class="text-white text-uppercase text-center">{{ $question->question_title }}</h6>
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
