@extends('layouts.super_admin')

@section('content')

<div id="page-wrapper" >
    <div id="page-inner">
        <div class="row">
            <div class="col-lg-12">

                <form action="{{ url('/superadmin/events/'.$event->id) }}" method="POST">
                    {{ csrf_field() }}
                    <label for="name">Title</label>
                    <input type="text" name="name" class="form-control" disabled value="{{$event->name}}">

                    <label for="benefits">Description</label><br>
                    <textarea disabled style="min-width: 100%" name ="description" rows="10">{{ $event->render_escaped_html_description() }}</textarea><br>

                    <label for="location">Start date and time</label>
                    <input type="text" name="start_date" class="form-control" disabled value="{{$event->start_date}}">

                    <label for="experience">End date and time</label>
                    <input type="text" name="end_date" class="form-control" disabled value="{{$event->end_date}}">

                    <label for="benefits">Address</label>
                    <input type="text" name="address" class="form-control" disabled value="{{$event->address}}">

                    <label for="benefits">City</label>
                    <input type="text" name="city" class="form-control" disabled value="{{$event->city}}">

                    <label for="benefits">Country</label>
                    <input type="text" name="country" class="form-control" disabled value="{{$event->country}}">

                    <label for="benefits">Fee</label>
                    <input type="text" name="fee" class="form-control" disabled value="{{$event->fee}}">

                    <label for="benefits">URL</label>
                    <input type="text" name="url" class="form-control" disabled value="{{$event->url}}">

                    <label for="benefits">Event image</label>
                    <img src="http://localhost:8888/fintechjobs.io/public/admin/img/events/{{$event->file_name}}" id="myImg" style="width:100%;max-width:300px" class="img-responsive" width="150">
                    
                    <br>
                    <input type="submit" class="btn btn-success" value="Approve">

                </form>
        </div>
            </div>
        </div>
    </div>
</div>

<!-- The Modal -->
<div id="myModal" class="modal">
    <span class="close">&times;</span>
        <img class="modal-content" id="img01">
                        <div id="caption"></div>
                    </div>

<style>

#myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

/* Caption of Modal Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation */
.modal-content, #caption {  
  -webkit-animation-name: zoom;
  -webkit-animation-duration: 0.6s;
  animation-name: zoom;
  animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
  from {-webkit-transform:scale(0)} 
  to {-webkit-transform:scale(1)}
}

@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}

/* The Close Button */
.close {
  position: relative;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content {
    width: 100%;
  }
}
</style>

<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById("myImg");
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function(){
  modal.style.display = "block";
  modalImg.src = this.src;
  captionText.innerHTML = this.alt;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
  modal.style.display = "none";
}
</script>

@endsection