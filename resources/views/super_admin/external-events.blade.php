@extends('layouts.super_admin')

@section('content')

<div  id="page-wrapper" >
        <div id="page-inner">
            <div class="row">
                <div class="col-lg-12">
                    @if(Auth::user()->isSuperAdminAdmin())
                        <h2>External Events</h2>
                    @else
                        <h2>Events</h2>
                    @endif    
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
                                <a href="{{ URL('/superadmin/edit_event/'.$event->id )}}">{{$event->name}}</a>
                                @if($event->is_approved == false)
                                    <span class="badge badge-small">!</span>
                                @endif
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