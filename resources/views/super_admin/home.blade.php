@extends('layouts.super_admin')

@section('content')

<div  id="page-wrapper" >
        <div id="page-inner">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Companies</h2>
                    <br />
                </div>

            <div class="col-lg-12">
                <table class="table">
                    <tbody>
                        @foreach($companies as $company)
                        <tr>
                            <td>
                            <strong>
                                <a href="{{ URL('/superadmin/company/'.$company->id.'/edit' )}}">{{$company->name}}</a>
                            </strong>
                            </td>
                            <td class="align-left">
                                
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>
        </div>
        {{ $companies->links() }}
        <!-- /. ROW  -->
            
    </div>
</div>

@endsection