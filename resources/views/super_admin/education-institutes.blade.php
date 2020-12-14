@extends('layouts.super_admin')

@section('content')

<div  id="page-wrapper" >
        <div id="page-inner">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Education Institutes</h2>
                    <br />
                </div>
            
            <div class="col-lg-12">
            @if($institutes->count() > 0)
                <table class="table">
                    <tbody>
                        @foreach($institutes as $institute)
                        <tr>
                            <td>
                            <strong>
                                <a href="{{ URL('/superadmin/edit_education_institute/'.$institute->id )}}">{{$institute->name}}</a>
                            </strong>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else 
                <p>No pending Event Institutes!</p>
                @endif
            </div>
            
        </div>
        {{ $institutes->links() }}
        <!-- /. ROW  -->
            
    </div>
</div>

@endsection