<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

<tr>
    <td align="center" bgcolor="#ffffff">

		<table width="90%" border="0" cellspacing="0" cellpadding="0">
			<tr>
            <td align="center">
			    		<a href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; float:left; width:100%; padding:20px;text-align:center; font-size: 13px;">
							<font face="Arial, Helvetica, sans-seri; font-size: 13px;" size="3" color="#596167">
							<img src="{{asset('images/logo.png')}}" width="50" alt="Metronic" border="0"  /></font></a>
                            <h1 style="font-family: Arial, Helvetica, sans-serif">New job created</h1>

                    </td>
			</tr>
		</table>
		<!-- padding -->
	</td>
    </tr>
<div style="font-family: Arial, Helvetica, sans-serif">
    <p>
    A new job has been created on the platform:<br>
    <b>Company: </b>{{$job->company->name}}<br>
    <b>Job title: </b>{{$job->name}}<br>
    Click <a href="http://localhost:8888/fintechjobs.io/superadmin/jobs/{{$job->id}}">here</a> to approve the job. 
    </p>

</div>

<tr>
        <td class="iage_footer" align="center" bgcolor="#ffffff">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr><td align="center" style="padding:20px;flaot:left;width:100%; text-align:center;">
                    <font face="Arial, Helvetica, sans-serif" size="3" color="#96a5b5" style="font-size: 13px;">
                    <span style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;">
                        2019 © Fintechjobs.io. ALL Rights Reserved.<br>
                    </span></font>
                </td></tr>
            </table>
        </td>
    </tr>
