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

                        Your payment has been received

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
                    <font face="Arial, Helvetica, sans-serif" size="4" color="#57697e" style="font-size: 15px;">
                    <table width="90%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td align="center" style="color: #888888; font-size: 16px; font-family: 'Work Sans', Calibri, sans-serif; line-height: 24px;">
                                <b>Package: </b>{{$payment_package}}<br>
                                <b>Ammount:</b> {{$payment_amount}}<br>
                                <b>Date:</b> {{$payment_date}}<br>
                            </td>
                        </tr>
                        <tr>
                        <td>
                        </br>

                    </table>
                    </font>
                </td>
            </tr>

            <tr>
                <td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
            </tr>

            <tr>
                <td align="center">
                    <table border="0" align="center" width="160" cellpadding="0" cellspacing="0" bgcolor="5caad2" style="">

                        <tr>
                            <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
                        </tr>

                        <tr>
                            <td align="center" style="color: #ffffff; font-size: 14px; font-family: 'Work Sans', Calibri, sans-serif; line-height: 26px;">


                                <div style="line-height: 26px;">
                                    <a href="https://fintechjobs.io/admin/home" target="_blank" style="color: #ffffff; text-decoration: none;">My dashboard</a>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
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