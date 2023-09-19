@extends('backend.default.layouts.app')

@section('style')
    <!-- begin::Select -->
    <link rel="stylesheet" href="{{ asset('public/backend') }}/default/vendors/select2/css/select2.min.css">
    <!-- end::Select -->
    <!-- begin::Uploader -->
    <link rel="stylesheet" href="{{ asset('public/backend') }}/default/css/uploader/file-uploader.css">
    <!-- end::Uploader -->
@endsection

@section('content')
    <div class="page-header">
        <div class="row align-items-center bg-white p-2">
            <div class="col">
                <h4 class="text-capitalize mt-3 mb-0">Create Question</h4>
            </div>
            <div class="col-auto text-end float-end ms-auto">
                <a href="{{ route('questions.index') }}" class="btn btn-primary"><i class="fas fa-list"></i></a>
            </div>
        </div>
    </div>
    {{ Form::open(['method' => 'POST', 'route' => ['question.store'], 'files' => 'true', 'enctype' => 'multipart/form-data',]) }}
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <label>Question</label>
                            <textarea id="question_title" name="question_title" class="form-control {{ $errors->has('question') ? 'is-invalid' : '' }}" style="height: 225px"></textarea>
                            @if ($errors->has('question'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('question') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-4 row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Lesson</label>
                                    <select name="chapter" id="lesson" class="form-control form-select {{ $errors->has('lesson') ? 'is-invalid' : '' }}">
                                        <option value="0" selected disabled>Select Lesson</option>
                                        @foreach($lessons as $lesson)
                                            <option value="{{ $lesson->id  }}">{{$lesson->title}} </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('lesson'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('lesson') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Time Limit</label>
                                    <input type="number" name="time_limit" id="time_limit" class="form-control {{ $errors->has('time_limit') ? 'is-invalid' : '' }}" placeholder="15">
                                    @if ($errors->has('time_limit'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('time_limit') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Point</label>
                                    <input type="number" name="point" id="point" class="form-control {{ $errors->has('point') ? 'is-invalid' : '' }}" placeholder="5">
                                    @if ($errors->has('point'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('point') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="file-upload">
                        <div class="file-edit">
                            <input type='file' name="question_image" id="question-image-upload" accept=".png, .jpg, .jpeg" />
                            <label for="question-image-upload"></label>
                        </div>
                        <div class="file-preview">
                            <img id="question-preview" style="background-image: url({{ asset('public/uploads/default/image-not-found.jpg')}});"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row row-deck">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <div class="form-group row">
                        <label class="col-form-label col-md-2">A</label>
                        <div class="col-md-10">
                            <input type="text" name="answer_title_1" id="answer_title_1" class="form-control {{ $errors->has('answer_title_1') ? 'is-invalid' : '' }}" placeholder="answer">
                            @if ($errors->has('answer_title_1'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('answer_title_1') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <select name="type_1" id="type_1" class="form-control form-select {{ $errors->has('type_1') ? 'is-invalid' : '' }}">
                                    <option value=" " selected disabled>Select Type</option>
                                    <option value="0">False </option>
                                    <option value="1">True </option>
                                </select>
                                @if ($errors->has('type_1'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('type_1') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <div id="answer-1" class="col-md-12">
                                <div class="answer-image-wrapper" data-text="Select your file!">
                                    <input name="answer_image_1" type="file" class="answer-image" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <div class="form-group row">
                        <label class="col-form-label col-md-2">B</label>
                        <div class="col-md-10">
                            <input type="text" name="answer_title_2" id="answer_title_2" class="form-control {{ $errors->has('answer_title_2') ? 'is-invalid' : '' }}" placeholder="answer">
                            @if ($errors->has('answer_title_2'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('answer_title_2') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <select name="type_2" id="type_2" class="form-control form-select {{ $errors->has('type_2') ? 'is-invalid' : '' }}">
                                    <option value=" " selected disabled>Select Type</option>
                                    <option value="0">False </option>
                                    <option value="1">True </option>
                                </select>
                                @if ($errors->has('type_2'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('type_2') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <div id="answer-2" class="col-md-12">
                                <div class="answer-image-wrapper" data-text="Select your file!">
                                    <input name="answer_image_2" type="file" class="answer-image" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <div class="form-group row">
                        <label class="col-form-label col-md-2">C</label>
                        <div class="col-md-10">
                            <input type="text" name="answer_title_3" id="answer_title_3" class="form-control {{ $errors->has('answer_title_3') ? 'is-invalid' : '' }}" placeholder="answer">
                            @if ($errors->has('answer_title_3'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('answer_title_3') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <select name="type_3" id="type_3" class="form-control form-select {{ $errors->has('type_3') ? 'is-invalid' : '' }}">
                                    <option value=" " selected disabled>Select Type</option>
                                    <option value="0">False </option>
                                    <option value="1">True </option>
                                </select>
                                @if ($errors->has('type_3'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('type_3') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <div id="answer-3" class="col-md-12">
                                <div class="answer-image-wrapper" data-text="Select your file!">
                                    <input name="answer_image_3" type="file" class="answer-image" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <div class="form-group row">
                        <label class="col-form-label col-md-2">D</label>
                        <div class="col-md-10">
                            <input type="text" name="answer_title_4" id="answer_title_4" class="form-control {{ $errors->has('answer_title_4') ? 'is-invalid' : '' }}" placeholder="answer">
                            @if ($errors->has('answer_title_4'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('answer_title_4') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <select name="type_4" id="type_4" class="form-control form-select {{ $errors->has('type_4') ? 'is-invalid' : '' }}">
                                    <option value=" " selected disabled>Select Type</option>
                                        <option value="0">False </option>
                                        <option value="1">True </option>
                                </select>
                                @if ($errors->has('type_4'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('type_4') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <div id="answer-4" class="col-md-12">
                                <div class="answer-image-wrapper" data-text="Select your file!">
                                    <input name="answer_image_4" type="file" class="answer-image" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card">
            <div class="card-body">
                <button type="submit" class="btn btn-primary btn-block">Save</button>
            </div>
        </div>
    </div>
    {{ Form::close() }}
@endsection

@section('script')
    <!-- begin::Select -->
    <script src="{{ asset('public/backend') }}/default/vendors/select2/js/select2.min.js"></script>
    <!-- end::Select -->
    <script>
        $(document).ready(function() {
            $('.select').select2();
        });
    </script>
    <!-- begin::Uploader -->
    <script src="{{ asset('public/backend') }}/default/js/uploader/file-uploader.js"></script>
    <!-- end::Uploader -->
    <!-- begin::Validation -->
    <script src="{{ asset('public/backend') }}/default/js/pages/validation.js"></script>
    <!-- end::Validation -->
    <!-- begin::textarea editor tinymce -->
    <script src="{{ asset('public/backend') }}/default/vendors/tinymce/tinymce.min.js"></script>
    <script src="{{ asset('public/backend') }}/default/vendors/tinymce/jquery.tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '#question_title',
            schema: 'html5',
            plugins: 'code',
            toolbar: 'styleselect bold italic bullist numlist outdent indent code',
            menubar: false,
        });
    </script>
    <!-- end::textarea editor tinymce -->
@endsection
