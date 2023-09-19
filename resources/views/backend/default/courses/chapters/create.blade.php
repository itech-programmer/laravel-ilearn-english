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
                <h4 class="text-capitalize mt-3 mb-0">Create Chapter</h4>
            </div>
            <div class="col-auto text-end float-end ms-auto">
                <a href="{{ route('chapters.index') }}" class="btn btn-primary"><i class="fas fa-list"></i></a>
            </div>
        </div>
    </div>
    {{ Form::open(['method' => 'POST', 'route' => ['chapter.store'], 'files' => 'true', 'enctype' => 'multipart/form-data',]) }}
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" required>
                                @if ($errors->has('title'))
                                    <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('title') }}</strong>
                                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Course</label>
                                <select name="course" class="form-control form-select {{ $errors->has('course') ? 'is-invalid' : '' }}" required>
                                    <option value="">Select Course</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id  }}">{{$course->title }} </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('course'))
                                    <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('course') }}</strong>
                                                </span>
                                @endif
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
                            <input type='file' name="image" id="image-upload" accept=".png, .jpg, .jpeg" />
                            <label for="image-upload"></label>
                        </div>
                        <div class="file-preview">
                            @if(!empty($chapter->image))
                                <img id="image-preview" style="background-image: url({{ asset($chapter->image) }});"/>
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
@endsection
