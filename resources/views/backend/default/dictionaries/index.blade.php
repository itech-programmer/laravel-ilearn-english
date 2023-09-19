@extends('backend.default.layouts.app')

@section('style')
    <!-- Data Table CSS -->
    <link href="{{asset('public/backend')}}/default/vendors/datatables/datatables.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Dictionaries</h3>
            </div>
            <div class="col-auto text-end float-end ms-auto">
                <a href="{{ route('dictionary.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-table">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="datatable table table-bordered table-stripped">
                            <thead>
                            <tr>
                                <th><small>№</small></th>
                                <th><small>Word</small></th>
                                <th><small>Translation</small></th>
                                <th><small>Definition</small></th>
                                <th class="text-center"><small>Actions</small></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (!empty($dictionaries) && $dictionaries->count())
                                @foreach($dictionaries as $index => $dictionary)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>
                                            <a href="{{ route('dictionary.show', $dictionary) }}" class="text-uppercase">
                                                @if(!empty($dictionary->en_word))
                                                    <span class="mb-0">
                                                    <small>
                                                {{ $dictionary->en_word }}
                                                    </small>
                                                </span>
                                                @else
                                                    <span class="mb-0">
                                                    <small>

                                                    </small>
                                                </span>
                                                @endif
                                            </a>
                                        </td>
                                        <td>
                                            @if(!empty($dictionary->uz_word))
                                                <p class="m-0"><small>{{ $dictionary->uz_word }}</small></p>
                                            @else
                                                <p class="m-0"><small> </small></p>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($dictionary->uz_definition))
                                                <p class="mb-0">
                                                    <small>
                                                        {!! $dictionary->uz_definition !!}
                                                    </small>
                                                </p>
                                            @else
                                                <p class="mb-0">
                                                    <small>
                                                    </small>
                                                </p>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('dictionary.edit', $dictionary) }}" class="btn btn-outline-success me-2">
                                                <i class="fad fa-edit"></i>
                                            </a>
                                            @if($dictionary->active_status == 1)
                                                <button class="btn btn-outline-secondary me-2" data-bs-toggle="modal" data-bs-target="#block-{{ $dictionary->id }}">
                                                    <i class="fas fa-lock"></i>
                                                </button>
                                                <!-- Block Modal -->
                                                <div class="modal fade" id="block-{{ $dictionary->id }}" tabindex="-1" role="dialog" aria-labelledby="block-{{ $dictionary->id }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <form class="modal-content" action="{{ route('dictionary.block', $dictionary) }}" method="post" id="block-{{ $dictionary->id }}">
                                                            @method("PUT")
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="block-{{ $dictionary->id }}">{{ $dictionary->en_word }}</h5>
                                                            </div>
                                                            <div class="modal-body bg-secondary">
                                                                <p class="text-center text-white">
                                                                    <strong>
                                                                        Do you really want to block ?
                                                                    </strong>
                                                                <h6 class="text-white text-uppercase text-center">{{ $dictionary->en_word }}</h6>
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
                                                <button class="btn btn-icon btn-outline-info me-2" data-bs-toggle="modal" data-bs-target="#block-{{ $dictionary->id }}">
                                                    <i class="fad fa-unlock"></i>
                                                </button>
                                                <!-- Block Modal -->
                                                <div class="modal fade" id="block-{{ $dictionary->id }}" tabindex="-1" role="dialog" aria-labelledby="block-{{ $dictionary->id }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <form class="modal-content" action="{{ route('dictionary.block', $dictionary) }}" method="post" id="block-{{ $dictionary->id }}">
                                                            @method("PUT")
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="block-{{ $dictionary->id }}">{{ $dictionary->en_word }}</h5>
                                                            </div>
                                                            <div class="modal-body bg-secondary">
                                                                <p class="text-center text-white">
                                                                    <strong>
                                                                        Do you really want to unblock ?
                                                                    </strong>
                                                                <h6 class="text-white text-uppercase text-center">{{ $dictionary->en_word }}</h6>
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
                                            <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#destroy-{{ $dictionary->id }}">
                                                <i class="fa-duotone fa-trash-can"></i>
                                            </button>
                                            <!-- Destroy Modal -->
                                            <div class="modal fade" id="destroy-{{ $dictionary->id }}" tabindex="-1" role="dialog" aria-labelledby="destroy-{{ $dictionary->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <form class="modal-content" action="{{ route('dictionary.destroy', $dictionary) }}" method="post" id="destroy-{{ $dictionary->id }}">
                                                        @method("DELETE")
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="destroy-{{ $dictionary->id }}">{{ $dictionary->en_word }}</h5>
                                                        </div>
                                                        <div class="modal-body bg-secondary">
                                                            <p class="text-center text-white">
                                                                <strong>
                                                                    Do you really want to Destroy ?
                                                                </strong>
                                                            <h6 class="text-white text-uppercase text-center">{{ $dictionary->en_word }}</h6>
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
                            @else
                                <tr class="text-center">
                                    <td colspan="10">There are no data.</td>
                                </tr>
                            @endif
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
