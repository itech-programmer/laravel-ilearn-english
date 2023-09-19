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
                <h4 class="text-capitalize mt-3 mb-0">Create Course</h4>
            </div>
            <div class="col-auto text-end float-end ms-auto">
                <a href="{{ route('courses.index') }}" class="btn btn-primary"><i class="fas fa-list"></i></a>
            </div>
        </div>
    </div>
    {{ Form::open(['method' => 'POST', 'route' => ['course.store'], 'files' => 'true', 'enctype' => 'multipart/form-data',]) }}
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 row">
                            @role('Teacher')
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Course Title</label>
                                        <input type="text" name="title" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" required>
                                        @if ($errors->has('title'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Teachers</label>
                                        <select name="teacher" class="form-control form-select {{ $errors->has('teacher') ? 'is-invalid' : '' }}" required>
                                                <option value="">Select Teacher</option>
                                            @foreach($teachers as $teacher)
                                                <option value="{{ $teacher->id  }}">{{$teacher->full_name }} </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('teacher'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('teacher') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Course Title</label>
                                        <input type="text" name="title" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" required>
                                        @if ($errors->has('title'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            @endrole
                        </div>
                        <div class="col-md-12">
                            <label>Course Description</label>
                            <textarea rows="5" cols="20" name="description" id="description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" style="height: 250px" required></textarea>
                            @if ($errors->has('description'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
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
                            <input type='file' name="image" id="image-upload" accept=".png, .jpg, .jpeg" />
                            <label for="image-upload"></label>
                        </div>
                        <div class="file-preview">
                            @if(!empty($course->image))
                                <img id="image-preview" style="background-image: url({{ asset($course->image) }});"/>
                            @else
                                <img id="image-preview" style="background-image: url({{ asset('public/uploads/default/image-not-found.jpg')}});"/>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <button type="submit" class="btn btn-primary btn-block">Save</button>
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
            selector: '#description',
            schema: 'html5',
            plugins: 'code',
            toolbar: 'styleselect bold italic bullist numlist outdent indent code',
            menubar: false,
        });
    </script>
    <!-- end::textarea editor tinymce -->
@endsection
