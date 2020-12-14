<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Payment</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  
<style>

table{
    margin-top: 12%!important;
}    

.header-container{
    height: 150px;
    margin-bottom: 45px;
}

.logo-block{
    display:inline-table;
}

#logo-image{
    width:100px;
}

.company-header-block{
    display:inline-table;
}

</style>

</head>
<body>

<div class="container header-container">
    <div class="row">
        <div class="logo-block">
            <img id="logo-image" src="{{asset('images/logo.png')}}" alt="">
        </div>
        <div class="company-header-block">
            <h5><b>Phone: +44 203 432 7066</b></h5>
            <h5><b>Chadwell Heath RM6 6AX ENGLAND</b></h5>
            <h5><b>Office 263 321 - 323 High Rd</b></h5>
            <h3>Fintechjobs.io</h3>    
        </div>
        <div class="table-container">
        <table class="table table-bordered">
            <tr>
                <td><b>Company Name</b></td>
                <td>{{$payment->company->name}}</td>
            </tr> 
            <tr>
                <td><b>Payment ID</b></td>
                <td>{{Carbon\Carbon::parse($payment->created_at)->format('Y-m-d')}}#{{$payment->id}}</td>
            </tr> 
            <tr>
                <td><b>Plan</b></td>
                <td>{{$payment->plan->name}}</td>
            </tr> 
            <tr>
                <td><b>Amount</b></td>
                <td>{{number_format($payment->amount, 2, '.', '')}}</td>
            </tr> 
            <tr>
                <td><b>Payment Date</b></td>
                <td>{{Carbon\Carbon::parse($payment->created_at)->format('d-m-Y')}}</td>
            </tr> 
            <tr>
                <td><b>Expiration Date</b></td>
                <td>{{Carbon\Carbon::parse($payment->expire_date)->format('d-m-Y')}}</td>
            </tr> 
        </table>
  </div>
    </div>
</div>

  
</body>
</html>