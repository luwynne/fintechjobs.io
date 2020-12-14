@extends('layouts.super_admin')

@section('content')

<div  id="page-wrapper" >
        <div id="page-inner">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Courses waiting for approval</h2>
                    <br />
                </div>
            
            <div class="col-lg-12">
            @if($courses->count() > 0)
                <table class="table">
                    <tbody>
                        @foreach($courses as $course)
                        <tr>
                            <td>
                            <strong>
                                <a href="{{ URL('/superadmin/courses/'.$course->id )}}">{{$course->name}}</a>
                            </strong>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else 
                <p>No pending courses at the moment!</p>
                @endif
            </div>
            
        </div>
        {{ $courses->links() }}
        <!-- /. ROW  -->
            
    </div>
</div>

@endsection