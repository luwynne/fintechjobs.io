@extends('mails.layout')

@section('content')

<!-- big image section -->
<table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="bg_color">

<tr>
    <td align="center">
        <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">
            
            <tr>
                <td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
            </tr>
            <tr>
                <td align="center" style="color: #343434; font-size: 24px; font-family: Quicksand, Calibri, sans-serif; font-weight:700;letter-spacing: 3px; line-height: 35px;" class="main-header">


                    <div style="line-height: 35px">

                        Events on Fintechjobs.io

                    </div>
                </td>
            </tr>

            <tr>
                <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
            </tr>

            <tr>
                <td align="center">
                    <table border="0" width="40" align="center" cellpadding="0" cellspacing="0" bgcolor="eeeeee">
                        <tr>
                            <td height="2" style="font-size: 2px; line-height: 2px;">&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
            </tr>

            <tr>
                <td align="center">
                    <table border="0" width="400" align="center" cellpadding="0" cellspacing="0" >
                        <tr>
                            <td align="center" style="color: #888888; font-size: 16px; font-family: 'Work Sans', Calibri, sans-serif; line-height: 24px;">
                                <div>
                                    @foreach($events as $event)
                                        <a style="text-decoration: none;color: #5caad2;" href="https://fintechjobs.io/event/{{$event->id}}/{{$event->name}}"><h4>{{$event->name}}</h4></a>
                                        <p>{{ Carbon\Carbon::parse($event->start_date)->format('d/m') }} | {{$event->city}} - {{$event->country}}</p>
                                        <br>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

        </table>

    </td>
</tr>

</table>
<!-- end section -->

@endsection