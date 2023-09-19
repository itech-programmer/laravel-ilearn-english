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
    {{ Form::open(['method' => 'PUT', 'route' => ['question.update', $question], 'files' => 'true', 'enctype' => 'multipart/form-data',]) }}
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <label>Question</label>
                            <textarea rows="5" cols="10" id="question" name="question_title" class="form-control {{ $errors->has('question') ? 'is-invalid' : '' }}" style="height: 225px">{{ $question->question_title }}</textarea>
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
                                    <select name="chapter" class="form-control form-select {{ $errors->has('lesson') ? 'is-invalid' : '' }}">
                                        @if(empty($question->lesson->title))
                                            <option value="">Select Chapter</option>
                                        @endif
                                        @foreach($lessons as $lesson)
                                            <option value="{{ $lesson->id  }}" {{ ($question->lesson_id == $lesson->id) ? 'selected' : '' }}>{{$lesson->title}} </option>
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
                                    <input type="text" name="time_limit" class="form-control" value="{{ $question->time_limit }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Point</label>
                                    <input type="text" name="point" class="form-control" value="{{ $question->point }}">
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
                            @if(!empty($question->image))
                                <img id="question-preview" style="background-image: url({{ asset($question->image) }});"/>
                            @else
                                <img id="question-preview" style="background-image: url({{ asset('public/uploads/default/image-not-found.jpg')}});"/>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row row-deck">
        @foreach($answers as $index => $answer)
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <div class="form-group row">
                            <label class="col-form-label col-md-2">
                                @switch( $index + 1 )
                                    @case(1)
                                    A
                                    @break
                                    @case(2)
                                    B
                                    @break
                                    @case(3)
                                    C
                                    @break
                                    @case(4)
                                    D
                                    @break
                                @endswitch
                                <input type="hidden" name="answer_id_{{ $index + 1 }}" value="{{ $answer->id }}">
                            </label>
                            <div class="col-md-10">
                                <input type="text" name="answer_title_{{ $index + 1 }}" class="form-control" value="{{ $answer->answer_title }}">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select name="type_{{ $index + 1 }}" class="form-control form-select">
                                        @if(empty($answer->true_answer == null))
                                            <option value="">Select Chapter</option>
                                        @endif
                                        @if($answer->true_answer == 1)
                                            <option value="1" selected>True</option>
                                            <option value="0">False</option>
                                        @else
                                            <option value="0" selected>False</option>
                                            <option value="1">True</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <div class="avatar avatar-xxl">
                                    @if(!empty($answer->image))
                                        <img src="{{ asset($answer->image) }}" class="avatar-img rounded" alt=""/>
                                    @else
                                        <img src="{{ asset('public/uploads/default/image-not-found.jpg') }}" class="avatar-img rounded" alt=""/>
                                    @endif
                                </div>
                            </div>
                            <div id="answer-{{ $index + 1 }}" class="col-md-12 m-t-15">
                                <div class="answer-image-wrapper" data-text="Select your file!">
                                    <input name="answer_image_{{ $index + 1 }}" type="file" class="answer-image" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row">
        <div class="card">
            <div class="card-body">
                <button type="submit" class="btn btn-primary btn-block">Update</button>
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
    <!-- begin::textarea editor tinymce -->
    <script src="{{ asset('public/backend') }}/default/vendors/tinymce/tinymce.min.js"></script>
    <script src="{{ asset('public/backend') }}/default/vendors/tinymce/jquery.tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '#question',
            schema: 'html5',
            plugins: 'code',
            toolbar: 'styleselect bold italic bullist numlist outdent indent code',
            menubar: false,
        });
    </script>
    <!-- end::textarea editor tinymce -->
@endsection
