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
                <h4 class="text-capitalize mt-3 mb-0">Create Lesson</h4>
            </div>
            <div class="col-auto text-end float-end ms-auto">
                <a href="{{ route('lessons.index') }}" class="btn btn-primary"><i class="fas fa-list"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['method' => 'POST', 'route' => ['lesson.store'], 'files' => 'true', 'enctype' => 'multipart/form-data',]) }}
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Lesson Title</label>
                                <input type="text" id="title" name="title" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" required>
                                @if ($errors->has('title'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Chapter</label>
                                <select name="chapter" id="chapter" class="form-control form-select {{ $errors->has('chapter') ? 'is-invalid' : '' }}" required>
                                    <option value="">Select Chapter</option>
                                    @foreach($chapters as $chapter)
                                        <option value="{{ $chapter->id  }}">{{$chapter->title }} </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('chapter'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('chapter') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Content</label>
                                <textarea id="content" name="lesson_content" class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}" style="height: 180px"></textarea>
                                @if ($errors->has('content'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('content') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 mt-2">
                            <div class="file-upload">
                                <div class="file-edit">
                                    <input type='file' name="image" id="image-upload" accept=".png, .jpg, .jpeg" />
                                    <label for="image-upload"></label>
                                </div>
                                <div class="file-preview">
                                    @if(!empty($lesson->image))
                                        <img id="image-preview" style="background-image: url({{ asset($lesson->image) }});"/>
                                    @else
                                        <img id="image-preview" style="background-image: url({{ asset('public/uploads/default/image-not-found.jpg')}});"/>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-outline-primary btn-block">
                                Save
                            </button>
                        </div>
                    </div>
                    {{ Form::close() }}
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
    <!-- begin::Uploader -->
    <script src="{{ asset('public/backend') }}/default/js/uploader/file-uploader.js"></script>
    <!-- end::Uploader -->
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
