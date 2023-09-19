@extends('backend.default.layouts.app')

@section('style')
    <!-- begin::Select -->
    <link rel="stylesheet" href="{{ asset('public/backend') }}/default/vendors/select2/css/select2.min.css">
    <!-- end::Select -->
    <!-- begin::textarea editor summernote -->
    <link rel="stylesheet" href="{{ asset('public/backend') }}/default/vendors/summernote/css/summernote.css">
    <!-- end::textarea editor summernote -->
@endsection

@section('content')
    <div class="page-header">
        <div class="row align-items-center bg-white p-2">
            <div class="col">
                <h4 class="text-capitalize mt-3 mb-0">Edit Exercise</h4>
            </div>
            <div class="col-auto text-end float-end ms-auto">
                <a href="{{ route('exercises.index') }}" class="btn btn-primary"><i class="fas fa-list"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form class="row" method="post" action="{{ route('exercise.update', $exercise) }}">
                       @method('PUT')
                        @csrf
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Conditions</label>
                                <select name="condition" id="condition" class="form-control form-select {{ $errors->has('condition') ? 'is-invalid' : '' }}" required>
                                    @if(empty($exercise->condition_id))
                                        <option value="">Select Lesson</option>
                                    @endif
                                    @foreach($conditions as $condition)
                                        <option value="{{ $condition->id  }}" {{ ($exercise->condition_id == $condition->id) ? 'selected' : '' }}>{{$condition->title }} </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('condition'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('condition') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Answer</label>
                                <input type="text" id="answer" name="answer" class="form-control {{ $errors->has('answer') ? 'is-invalid' : '' }}" value="{{ $exercise->answer }}" required>
                                @if ($errors->has('answer'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('answer') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Lessons</label>
                                <select name="lesson" id="lesson" class="form-control form-select {{ $errors->has('lesson') ? 'is-invalid' : '' }}" required>
                                    @if(empty($exercise->lesson_id))
                                        <option value="">Select Lesson</option>
                                    @endif
                                    @foreach($lessons as $lesson)
                                        <option value="{{ $lesson->id  }}" {{ ($exercise->lesson_id == $lesson->id) ? 'selected' : '' }}>{{$lesson->title }} </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('lesson'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('lesson') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Content</label>
                                <textarea id="content" name="exercise_content" class="form-control {{ $errors->has('exercise_content') ? 'is-invalid' : '' }}" required>{{ $exercise->content }}</textarea>
                                @if ($errors->has('exercise_content'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('exercise_content') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-outline-primary btn-block">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{--        <div class="col-lg-6">--}}
        {{--            <div class="card">--}}
        {{--                <div class="card-header text-center">--}}
        {{--                    <h6 id="title_preview"></h6>--}}
        {{--                </div>--}}
        {{--                <div class="card-body">--}}
        {{--                    <div id="content_preview"></div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}
    </div>
@endsection

@section('script')
    <!-- begin::select -->
    <script src="{{ asset('public/backend') }}/default/vendors/select2/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select').select2();
        });
    </script>
    <!-- end::select -->
    <!-- begin::textarea preview -->
    {{--    <script src="{{ asset('public/backend') }}/default/js/pages/jquery.textareaPreview.js"></script>--}}
    {{--    <script>--}}
    {{--        $('#title').keyup(function(){--}}
    {{--            var $this = $(this);--}}
    {{--            $('#title_preview').html($this.val());--}}
    {{--        });--}}
    {{--        $(function() {--}}
    {{--            $("#content").textareaPreview({--}}
    {{--                container: "#content_preview"    // or container: $("#preview")--}}
    {{--            });--}}
    {{--        });--}}
    {{--    </script>--}}
    <!-- begin::textarea preview -->
    <!-- begin::textarea editor tinymce -->
    <script src="{{ asset('public/backend') }}/default/vendors/tinymce/tinymce.min.js"></script>
    <script src="{{ asset('public/backend') }}/default/vendors/tinymce/jquery.tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '#content',
            schema: 'html5',
            plugins: 'code',
            toolbar: 'styleselect bold italic bullist numlist outdent indent code',
            menubar: false,
        });
    </script>
    <!-- end::textarea editor tinymce -->
@endsection
