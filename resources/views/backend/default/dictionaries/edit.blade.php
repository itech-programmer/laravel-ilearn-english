@extends('backend.default.layouts.app')

@section('style')

@endsection

@section('content')
    <div class="page-header">
        <div class="row align-items-center bg-white p-2">
            <div class="col">
                <h4 class="text-capitalize mt-3 mb-0">Create Course</h4>
            </div>
            <div class="col-auto text-end float-end ms-auto">
                <a href="{{ route('dictionaries.index') }}" class="btn btn-primary"><i class="fas fa-list"></i></a>
            </div>
        </div>
    </div>
    {{ Form::open(['method' => 'PUT', 'route' => ['dictionary.update', $dictionary], 'files' => 'true', 'enctype' => 'multipart/form-data',]) }}
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>English</label>
                                    <input type="text" name="english" class="form-control {{ $errors->has('english') ? 'is-invalid' : '' }}" value="{{ $dictionary->en_word }}" required>
                                    @if ($errors->has('english'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('english') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Uzbek</label>
                                    <input type="text" name="uzbek" class="form-control {{ $errors->has('uzbek') ? 'is-invalid' : '' }}" value="{{ $dictionary->uz_word }}" required>
                                    @if ($errors->has('uzbek'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('uzbek') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Karakalpak</label>
                                    <input type="text" name="karakalpak" class="form-control {{ $errors->has('karakalpak') ? 'is-invalid' : '' }}" value="{{ $dictionary->qr_word }}" required>
                                    @if ($errors->has('karakalpak'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('karakalpak') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Russian</label>
                                    <input type="text" name="russian" class="form-control {{ $errors->has('russian') ? 'is-invalid' : '' }}" value="{{ $dictionary->ru_word }}" required>
                                    @if ($errors->has('russian'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('russian') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 row">
                            <div class="col-md-6">
                                <label>English Definition</label>
                                <textarea id="english_definition" name="english_definition" class="form-control {{ $errors->has('english_definition') ? 'is-invalid' : '' }}" style="height: 350px" required>{!! $dictionary->en_definition !!}</textarea>
                                @if ($errors->has('english_definition'))
                                    <span class="invalid-feedback">
                                    <strong>{{ $errors->first('english_definition') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label>Uzbek Definition</label>
                                <textarea rows="5" cols="10" id="uzbek_definition" name="uzbek_definition" class="form-control {{ $errors->has('uzbek_definition') ? 'is-invalid' : '' }}" style="height: 350px" required>{!! $dictionary->uz_definition !!}</textarea>
                                @if ($errors->has('uzbek_definition'))
                                    <span class="invalid-feedback">
                                    <strong>{{ $errors->first('uzbek_definition') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-6 mt-4">
                                <label>Karakalpak Definition</label>
                                <textarea rows="5" cols="10" id="karakalpak_definition" name="karakalpak_definition" class="form-control {{ $errors->has('karakalpak_definition') ? 'is-invalid' : '' }}" style="height: 350px" required>{!! $dictionary->qr_definition !!}</textarea>
                                @if ($errors->has('karakalpak_definition'))
                                    <span class="invalid-feedback">
                                    <strong>{{ $errors->first('karakalpak_definition') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-6 mt-4">
                                <label>Russian Definition</label>
                                <textarea rows="5" cols="10" id="russian_definition" name="russian_definition" class="form-control {{ $errors->has('russian_definition') ? 'is-invalid' : '' }}" style="height: 350px" required>{!! $dictionary->ru_definition !!}</textarea>
                                @if ($errors->has('russian_definition'))
                                    <span class="invalid-feedback">
                                    <strong>{{ $errors->first('russian_definition') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 mb-4">
            <button type="submit" class="btn btn-primary btn-block">Update</button>
        </div>
    </div>
    {{ Form::close() }}
@endsection

@section('script')
    <!-- begin::textarea editor tinymce -->
    <script src="{{ asset('public/backend') }}/default/vendors/tinymce/tinymce.min.js"></script>
    <script src="{{ asset('public/backend') }}/default/vendors/tinymce/jquery.tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '#english_definition',
            schema: 'html5',
            plugins: 'code',
            toolbar: 'styleselect bold italic bullist numlist outdent indent code',
            menubar: false,
        });
        tinymce.init({
            selector: '#uzbek_definition',
            schema: 'html5',
            plugins: 'code',
            toolbar: 'styleselect bold italic bullist numlist outdent indent code',
            menubar: false,
        });
        tinymce.init({
            selector: '#karakalpak_definition',
            schema: 'html5',
            plugins: 'code',
            toolbar: 'styleselect bold italic bullist numlist outdent indent code',
            menubar: false,
        });
        tinymce.init({
            selector: '#russian_definition',
            schema: 'html5',
            plugins: 'code',
            toolbar: 'styleselect bold italic bullist numlist outdent indent code',
            menubar: false,
        });
    </script>
    <!-- begin::textarea editor tinymce -->
@endsection
