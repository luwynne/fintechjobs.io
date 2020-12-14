@extends('layouts.super_admin')

@section('content')

<div  id="page-wrapper" >
        <div id="page-inner">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Events waiting for approval</h2>
                    <br />
                </div>
            
            <div class="col-lg-12">
            @if($events->count() > 0)
                <table class="table">
                    <tbody>
                        @foreach($events as $event)
                        <tr>
                            <td>
                            <strong>
                                <a href="{{ URL('/superadmin/events/'.$event->id )}}">{{$event->name}}</a>
                            </strong>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else 
                <p>No pending events at the moment!</p>
                @endif
            </div>
            
        </div>
        {{ $events->links() }}
        <!-- /. ROW  -->
            
    </div>
</div>

@endsection