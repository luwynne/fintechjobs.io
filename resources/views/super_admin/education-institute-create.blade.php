@extends('layouts.super_admin')

@section('content')

<div id="page-wrapper" >
    <div id="page-inner">
        <div class="row">
            <div class="col-lg-12">

                <form id="create_course_form" action="{{ url('/superadmin/create_education_institute') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <label for="name">Institute Name</label>
                    <input type="text" name="name" class="form-control" required>

                    <label for="benefits">Country</label>
                    <select name="country" class="form-control" required>
                        @foreach($countries as $country)
                            <option value="{{$country->id}}">{{$country->name}}</option>
                        @endforeach    
                    <select>

                    <label for="website">Website</label>
                    <input type="text" name="url" class="form-control" required>

                    <label for="contact_email">Contact email</label>
                    <input type="email" name="contact_email" class="form-control" required>

                    <label for="logo">Logo</label>
                    <input type="file" name="logo" class="form-control" required>

                    <div id="courses">
                        <h3>Courses</h3>
                    </div>
                    
                    <br>
                    <button id="add_course" class="btn btn-primary">Add course</button>

                    <input type="hidden" id="courses_count" name="courses_count" value="0">

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
        })

    });

</script>

@endsection