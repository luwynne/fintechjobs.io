@extends('layouts.super_admin')

@section('content')

<div id="page-wrapper" >
    <div id="page-inner">
        <div class="row">
            <div class="col-lg-12">

                <form id="create_course_form" action="{{ url('superadmin/edit_education_institute', [$institute->id]) }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <label for="name">Institute Name</label>
                    <input type="text" name="name" class="form-control" value="{{$institute->name}}" required>

                    <label for="benefits">Country</label>
                    <select name="country" class="form-control">
                        @foreach($countries as $country)
                            <option {{ ( $institute->country_id == $country->id ) ? 'selected' : "" }} value="{{$country->id}}">{{$country->name}}</option>
                        @endforeach    
                    <select>

                    <label for="website">Website</label>
                    <input type="text" name="url" class="form-control" value="{{$institute->url}}" required>

                    <label for="contact_email">Contact email</label>
                    <input type="email" name="contact_email" class="form-control" value="{{$institute->contact_email}}" required>

                    <label for="logo">Logo</label><br>

                    @if($institute->logo_name !== "")
                        <img width="100" src="http://localhost:8888/fintechjobs.io/public/images/sample/institutes/{{$institute->logo_name}}">
                    @endif
                    
                    <input type="file" name="logo" class="form-control">

                    <div id="courses">
                        <h3>Courses</h3>

                        @foreach($institute->courses as $course)
                            <div id="course_{{$institute->id.$course->id}}" class="db_courses">
                                <label for="name">Name</label>
                                <input type="text" name="course_name_{{$institute->id.$course->id}}" class="form-control" value="{{$course->name}}" disabled>
                                <label for="name">Description</label>
                                <input type="text" name="course_description_{{$institute->id.$course->id}}" class="form-control" value="{{$course->description}}" disabled>
                                <label for="name">URL</label>
                                <input type="text" name="course_url_{{$institute->id.$course->id}}" class="form-control" value="{{$course->url}}" disabled>
                                <br>
                                <button id="{{$institute->id.$course->id}}" class="delete_course btn btn-sm btn-danger db_courses_delete">Delete</button>
                            </div>  
                        @endforeach

                    </div>
                    
                    <br>
                    <button id="add_course" class="btn btn-primary">Add course</button>

                    <input type="hidden" id="courses_count" name="courses_count" value="0">

                    <input type="hidden" id="db_courses_count" name="db_courses_count" value="0">

                    @if(Auth::user()->isSuperAdminAdmin())
                    <br><br>
                        <input type="checkbox" name="is_approved" value="1" {{$institute->is_approved == true ? 'checked' : ''}}>
                        <label for="is_approved">Is approved</label>  
                    @endif

                    <br><br>
                    <input type="submit" class="btn btn-success" value="Submit">

                </form>
                
            </div>
        </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function(){

        var field_id = 0;

        var numItems = $('.db_courses').length;
        $('#db_courses_count').val(numItems);
        console.log(numItems);

        $('#add_course').on('click',function(){ 
            field_id ++;
            var input = $('<div id="course_'+field_id+'"><label for="name">Name</label><input type="text" name="course_name_'+field_id+'" class="form-control" required><label for="name">Description</label><input type="text" name="course_description_'+field_id+'" class="form-control" required><label for="name">URL</label><input type="text" name="course_url_'+field_id+'" class="form-control" required><br><button id="'+field_id+'" class="delete_course btn btn-sm btn-danger">Delete</button></div>');
            $('#courses').append(input);
            $('#courses_count').val(field_id);
        }) 

        $(document).on("click", ".delete_course", function(){
            var id = $(this).attr('id');
            var div = document.getElementById('course_'+id);
            div.remove();
            
            if($(this).hasClass('db_courses_delete')){
                numItems --; 
                $('#db_courses_count').val(numItems);
                console.log(numItems);
            }
        })

    });

</script>

@endsection