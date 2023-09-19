@extends('backend.default.layouts.app')

@section('style')
    <!-- Data Table CSS -->
    <link href="{{asset('public/backend')}}/default/vendors/datatables/datatables.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <!--begin::Tab-->
                <ul class="nav nav-tabs nav-tabs-solid">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#students">
                            <span class="nav-icon"><i class="fad fa-user-graduate"></i></span>
                            <span class="nav-text">Students</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#teachers">
                            <span class="nav-icon"><i class="fad fa-user-tie"></i></span>
                            <span class="nav-text">Teachers</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#others">
                            <span class="nav-icon"><i class="fad fa-user-alt"></i></span>
                            <span class="nav-text">Others</span>
                        </a>
                    </li>
                </ul>
                <!--end::Tab-->
            </div>
            <div class="col-auto text-end float-end ms-auto">

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="tab-content">
                <div class="tab-pane show active" id="students">
                    <div class="card card-table">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0 datatable">
                                    <thead>
                                    <tr>
                                        <th class="text-center">№</th>
                                        <th class="text-center">Avatar</th>
                                        <th class="text-center">Full Name</th>
                                        <th class="text-center">Username</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($students as $index => $student)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td class="text-center">
                                                <a href="" class="avatar avatar-sm me-2">
                                                    @if(!empty($student->avatar))
                                                        @if(Cache::has('user-is-online-' . $student->id))
                                                            <div class="avatar avatar-online">
                                                                <img src="{{ asset($student->avatar) }}" class="avatar-img rounded-circle" alt=""/>
                                                            </div>
                                                        @else
                                                            <div class="avatar avatar-offline">
                                                                <img src="{{ asset($student->avatar) }}" class="avatar-img rounded-circle" alt=""/>
                                                            </div>
                                                        @endif
                                                    @else
                                                        @if(Cache::has('user-is-online-' . $student->id))
                                                            <div class="avatar avatar-online">
                                                                <img src="{{ asset('public/uploads') }}/default/avatar.png" class="avatar-img rounded-circle" alt=""/>
                                                            </div>
                                                        @else
                                                            <div class="avatar avatar-offline">
                                                                <img src="{{ asset('public/uploads') }}/default/avatar.png" class="avatar-img rounded-circle" alt=""/>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('user.show', $student) }}" class="text-uppercase">{{ $student->full_name }}</a>
                                            </td>
                                            <td class="text-center">{{ $student->username }}</td>
                                            @if(!empty($student->email))
                                            <td class="text-center">{{ $student->email }}</td>
                                            @else
                                            <td class="text-center"></td>
                                            @endif
                                            <td class="text-center">
                                                @if($student->active_status == 1)
                                                    <div class="btn-group">
                                                        <button class="btn btn-icon btn-outline-danger" data-bs-toggle="modal" data-bs-target="#destroy-{{ $student->slug }}">
                                                            <i class="fad fa-user-lock"></i>
                                                        </button>
                                                    </div>
                                                    <!-- Destroy Modal -->
                                                    <div class="modal fade" id="destroy-{{ $student->slug }}" tabindex="-1" role="dialog" aria-labelledby="destroy-{{ $student->slug }}" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <form class="modal-content" action="{{ route('user.block', $student) }}" method="post" id="destroy-{{ $student->slug }}">
                                                                @method('PUT')
                                                                @csrf
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="destroy-{{ $student->slug }}">{{ $student->full_name }}</h5>
                                                                </div>
                                                                <div class="modal-body bg-dark">
                                                                    <p class="text-center text-white">
                                                                        <strong>
                                                                            Do you really want to block ?
                                                                        </strong>
                                                                    <h4 class="text-white text-uppercase text-center">{{ $student->full_name }}</h4>
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
                                                @else
                                                    <div class="btn-group">
                                                        <button class="btn btn-icon btn-outline-success" data-bs-toggle="modal" data-bs-target="#destroy-{{ $student->slug }}">
                                                            <i class="fad fa-user-unlock"></i>
                                                        </button>
                                                    </div>
                                                    <!-- Destroy Modal -->
                                                    <div class="modal fade" id="destroy-{{ $student->slug }}" tabindex="-1" role="dialog" aria-labelledby="destroy-{{ $student->slug }}" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <form class="modal-content" action="{{ route('user.block', $student) }}" method="post" id="destroy-{{ $student->slug }}">
                                                                @method('PUT')
                                                                @csrf
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="destroy-{{ $student->slug }}">{{ $student->full_name }}</h5>
                                                                </div>
                                                                <div class="modal-body bg-secondary">
                                                                    <p class="text-center text-white">
                                                                        <strong>
                                                                            Do you really want to unblock ?
                                                                        </strong>
                                                                    <h4 class="text-white text-uppercase text-center">{{ $student->full_name }}</h4>
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
                                                                        <button class="btn btn-outline-primary btn-block" data-dismiss="modal">
                                                                            <i class="fad fa-smile-beam"></i>
                                                                            Yes
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane show" id="teachers">
                    <div class="card card-table">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0 datatable">
                                    <thead>
                                    <tr>
                                        <th class="text-center">№</th>
                                        <th class="text-center">Avatar</th>
                                        <th class="text-center">Full Name</th>
                                        <th class="text-center">Username</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($teachers as $index => $teacher)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td class="text-center">
                                                <a href="" class="avatar avatar-sm me-2">
                                                    @if(!empty($teacher->avatar))
                                                        @if(Cache::has('user-is-online-' . $teacher->id))
                                                            <div class="avatar avatar-online">
                                                                <img src="{{ asset($teacher->avatar) }}" class="avatar-img rounded-circle" alt=""/>
                                                            </div>
                                                        @else
                                                            <div class="avatar avatar-offline">
                                                                <img src="{{ asset($teacher->avatar) }}" class="avatar-img rounded-circle" alt=""/>
                                                            </div>
                                                        @endif
                                                    @else
                                                        @if(Cache::has('user-is-online-' . $teacher->id))
                                                            <div class="avatar avatar-online">
                                                                <img src="{{ asset('public/uploads') }}/default/avatar.png" class="avatar-img rounded-circle" alt=""/>
                                                            </div>
                                                        @else
                                                            <div class="avatar avatar-offline">
                                                                <img src="{{ asset('public/uploads') }}/default/avatar.png" class="avatar-img rounded-circle" alt=""/>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('user.show', $teacher) }}" class="text-uppercase">{{ $teacher->full_name }}</a></td>
                                            <td class="text-center">{{ $teacher->username }}</td>
                                            @if(!empty($teacher->email))
                                                <td class="text-center">{{ $teacher->email }}</td>
                                            @else
                                                <td class="text-center"></td>
                                            @endif
                                            <td class="text-center">
                                                @if($teacher->active_status == 1)
                                                    <div class="btn-group">
                                                        <button class="btn btn-icon btn-outline-danger" data-bs-toggle="modal" data-bs-target="#destroy-{{ $teacher->slug }}">
                                                            <i class="fad fa-user-lock"></i>
                                                        </button>
                                                    </div>
                                                    <!-- Destroy Modal -->
                                                    <div class="modal fade" id="destroy-{{ $teacher->slug }}" tabindex="-1" role="dialog" aria-labelledby="destroy-{{ $teacher->slug }}" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <form class="modal-content" action="{{ route('user.block', $teacher) }}" method="post" id="destroy-{{ $teacher->slug }}">
                                                                @method('PUT')
                                                                @csrf
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="destroy-{{ $teacher->slug }}">{{ $teacher->full_name }}</h5>
                                                                </div>
                                                                <div class="modal-body bg-dark">
                                                                    <p class="text-center text-white">
                                                                        <strong>
                                                                            Do you really want to block ?
                                                                        </strong>
                                                                    <h4 class="text-white text-uppercase text-center">{{ $teacher->full_name }}</h4>
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
                                                    <div class="btn-group">
                                                        <button class="btn btn-icon btn-outline-success" data-bs-toggle="modal" data-bs-target="#destroy-{{ $teacher->slug }}">
                                                            <i class="fad fa-user-unlock"></i>
                                                        </button>
                                                    </div>
                                                    <!-- Destroy Modal -->
                                                    <div class="modal fade" id="destroy-{{ $teacher->slug }}" tabindex="-1" role="dialog" aria-labelledby="destroy-{{ $teacher->slug }}" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <form class="modal-content" action="{{ route('user.block', $teacher) }}" method="post" id="destroy-{{ $teacher->slug }}">
                                                                @method('PUT')
                                                                @csrf
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="destroy-{{ $teacher->slug }}">{{ $teacher->full_name }}</h5>
                                                                </div>
                                                                <div class="modal-body bg-secondary">
                                                                    <p class="text-center text-white">
                                                                        <strong>
                                                                            Do you really want to unblock ?
                                                                        </strong>
                                                                    <h4 class="text-white text-uppercase text-center">{{ $teacher->full_name }}</h4>
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
                                                                        <button class="btn btn-outline-primary btn-block" data-dismiss="modal">
                                                                            <i class="fad fa-smile-beam"></i>
                                                                            Yes
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane show" id="others">
                    <div class="card card-table">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0 datatable">
                                    <thead>
                                    <tr>
                                        <th class="text-center">№</th>
                                        <th class="text-center">Avatar</th>
                                        <th class="text-center">Full Name</th>
                                        <th class="text-center">Username</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $index => $user)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td class="text-center">
                                                <a href="" class="avatar avatar-sm me-2">
                                                    @if(!empty($user->avatar))
                                                        @if(Cache::has('user-is-online-' . $user->id))
                                                            <div class="avatar avatar-online">
                                                                <img src="{{ asset($user->avatar) }}" class="avatar-img rounded-circle" alt=""/>
                                                            </div>
                                                        @else
                                                            <div class="avatar avatar-offline">
                                                                <img src="{{ asset($user->avatar) }}" class="avatar-img rounded-circle" alt=""/>
                                                            </div>
                                                        @endif
                                                    @else
                                                        @if(Cache::has('user-is-online-' . $user->id))
                                                            <div class="avatar avatar-online">
                                                                <img src="{{ asset('public/uploads') }}/default/avatar.png" class="avatar-img rounded-circle" alt=""/>
                                                            </div>
                                                        @else
                                                            <div class="avatar avatar-offline">
                                                                <img src="{{ asset('public/uploads') }}/default/avatar.png" class="avatar-img rounded-circle" alt=""/>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('user.show', $user) }}" class="text-uppercase">{{ $user->full_name  }}</a>
                                            </td>
                                            <td class="text-center">{{ $user->username }}</td>
                                            @if(!empty($user->email))
                                                <td class="text-center">{{ $user->email }}</td>
                                            @else
                                                <td class="text-center"></td>
                                            @endif
                                            <td class="text-center">
                                                @if($user->active_status == 1)
                                                    <div class="btn-group">
                                                        <button class="btn btn-icon btn-outline-danger" data-bs-toggle="modal" data-bs-target="#destroy-{{ $user->slug }}">
                                                            <i class="fad fa-user-lock"></i>
                                                        </button>
                                                    </div>
                                                    <!-- Destroy Modal -->
                                                    <div class="modal fade" id="destroy-{{ $user->slug }}" tabindex="-1" role="dialog" aria-labelledby="destroy-{{ $user->slug }}" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <form class="modal-content" action="{{ route('user.block', $user) }}" method="post" id="destroy-{{ $user->slug }}">
                                                                @method('PUT')
                                                                @csrf
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="destroy-{{ $user->slug }}">{{ $user->full_name }}</h5>
                                                                </div>
                                                                <div class="modal-body bg-dark">
                                                                    <p class="text-center text-white">
                                                                        <strong>
                                                                            Do you really want to block ?
                                                                        </strong>
                                                                    <h4 class="text-white text-uppercase text-center">{{ $user->full_name }}</h4>
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
                                                    <div class="btn-group">
                                                        <button class="btn btn-icon btn-outline-success" data-bs-toggle="modal" data-bs-target="#destroy-{{ $user->slug }}">
                                                            <i class="fad fa-user-unlock"></i>
                                                        </button>
                                                    </div>
                                                    <!-- Destroy Modal -->
                                                    <div class="modal fade" id="destroy-{{ $user->slug }}" tabindex="-1" role="dialog" aria-labelledby="destroy-{{ $user->slug }}" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <form class="modal-content" action="{{ route('user.block', $teacher) }}" method="post" id="destroy-{{ $user->slug }}">
                                                                @method('PUT')
                                                                @csrf
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="destroy-{{ $user->slug }}">{{ $user->full_name }}</h5>
                                                                </div>
                                                                <div class="modal-body bg-secondary">
                                                                    <p class="text-center text-white">
                                                                        <strong>
                                                                            Do you really want to unblock ?
                                                                        </strong>
                                                                    <h4 class="text-white text-uppercase text-center">{{ $user->full_name }}</h4>
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
                                                                        <button class="btn btn-outline-primary btn-block" data-dismiss="modal">
                                                                            <i class="fad fa-smile-beam"></i>
                                                                            Yes
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endif
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
