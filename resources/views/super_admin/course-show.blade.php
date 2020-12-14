@extends('layouts.super_admin')

@section('content')

<div id="page-wrapper" >
    <div id="page-inner">
        <div class="row">
            <div class="col-lg-12">

                <form action="{{ url('/superadmin/courses/'.$course->id) }}" method="POST">
                    {{ csrf_field() }}
                    <label for="name">Title</label>
                    <input type="text" name="name" class="form-control" disabled value="{{$course->name}}">

                    <label for="benefits">URL</label>
                    <input type="text" name="url" class="form-control" disabled value="{{$course->url}}">

                    <label for="benefits">Description</label><br>
                    <textarea disabled style="min-width: 100%" name ="description" rows="10">{{ $course->render_escaped_html_description() }}</textarea><br>

                    <br>
                    <input type="submit" class="btn btn-success" value="Approve">

                </form>
        </div>
            </div>
        </div>
    </div>
</div>

@endsection