@extends('layouts.super_admin')

@section('content')

<div  id="page-wrapper" >
        <div id="page-inner">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Jobs waiting for approval</h2>
                    <br />
                </div>
            
            <div class="col-lg-12">
            @if($jobs->count() > 0)
                <table class="table">
                    <tbody>
                        @foreach($jobs as $job)
                        <tr>
                            <td>
                            <strong>
                                <a href="{{ URL('/superadmin/jobs/'.$job->id )}}">{{$job->name}}</a>
                            </strong>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else 
                <p>No pending jobs at the moment!</p>
                @endif
            </div>
            
        </div>
        {{ $jobs->links() }}
        <!-- /. ROW  -->
            
    </div>
</div>

@endsection