@extends('layouts.website')

@section('content')

<section class="title">
    <div class="container">
        <div class="row-fluid">
            <div class="span6">
                <h1>About Us</h1>
            </div>
            <div class="span6">
                <ul class="breadcrumb pull-right">
                    <li><a href="{{ url('/') }}">Home</a> <span class="divider">/</span></li>
                    <li class="active">About Us</li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- / .title -->

<section id="about-us" class="container main">
    <div class="row-fluid">
        <div class="span6">
            <h2>About us</h2>
            <p>
            Fintechjobs.io offers an online meeting platform for people looking to find a job in the FinTech Sector and further afield. Fintechjobs.ie its sister <a class="dark-body-a" href="https://fintechjobs.ie/about">site</a> was founded in 2017 by David Crowley and Gerry Gorman both of whom have huge experience within the recruitment and financial sector.
            </p>
            <p>
            David & Gerry saw a need for a dedicated Fintech Jobs Board in Ireland and following on from the success of the Irish Jobs Site David set up <a class="dark-body-a" href="https://fintechjobs.ie">Fintechjobs.io</a> which will advertise Fintech Jobs international but also give a deep understanding on how the rapid growth of the Fintech Industry will not only effect how we do business here in the UK but be a worldwide game changer in the way Companies operate.
            </p>
            </div>
        <div class="span6">
            <h2>Our Range</h2>
            <div>
                <div class="progress progress-info"><div class="bar" style="width: 100%; text-align:left; padding-left:10px;">FinTech Consultants and Sales professionals</div></div>
                <div class="progress progress-info"><div class="bar" style="width: 100%; text-align:left; padding-left:10px;">Blockchain, Software and FinTech Developers</div></div>
                <div class="progress progress-info"><div class="bar" style="width: 100%; text-align:left; padding-left:10px;">Information Security, Ethical Hackers and Cyber FinTech professionals</div></div>
                <div class="progress progress-info"><div class="bar" style="width: 100%; text-align:left; padding-left:10px;">From entry level to senior positions</div></div>
            </div>
        </div>
    </div>

    <hr>

    <!-- Meet the team -->
    <h2 class="center">Meet the Team</h2>

    <hr>

    <div class="team-block">
        <div class="span8">
            <div class="box bios">
                <p><img class="imgTeam"src="images/sample/team/david.jpg" alt="David Crowley picture" ></p>
                <h5>David Crowley</h5>
                <h6>CEO - Finance Specialist</h6>
                <p><br>
                David has extensive financial experience and is the Director of IFCFinance.com – a specialist Financial Advisory Company which provides consultancy to companies and individuals on area’s such as Wealth Management and Financial Planning.
                David primarily deals with customers within the UK and Irish markets and is one of the leading players in the world of Corporate Pensions looking after a variety of successful companies.
                <br>
                David has been a key player in leading an executive team and a senior advisory board in a recent project to develop alternative finance strategies for the SME and Agri-Sector including the attempt to establish Ireland’s first Business/Agri Bank since the birth of the Country.
                He is a founding partner and board member of Crossflow Payments Ireland, a specialised E-Invoicing and Supply Chain Finance Platform. This business is a joint venture with Crossflow payments UK and has many leading UK Companies on its books.
                <br>
                David has also experience in the Renewable Energy sector and has built up some key contacts and achieved great success in a number of key areas.
                With 30 years plus experience to his credit David has established key relationships within governmental, financial and the general business community. David is also an active member of a number of important Financial Associations.
                <br>
                David has a keen interest in start-up business’s and is more than willing to help them connect with suitably qualified personnel that can assist in driving their business’s forward.
                David believes Fintechjobs.io is an ideal platform for business’s to source key personnel that have all the necessary qualifications and experience to successfully grow their Fintech <a class="dark-body-a" href="https://fintechjobs.io">Companies</a>. Fintechjobs.io is your ideal recruiting partner to advertise Fintech jobs in London, the UK and further afield.
                </p>
                <a href="mailto:david@fintechjobs.ie?Subject=FinTechjobs.ie" target="_top">david@fintechjobs.io</a>
            </div>
        </div>
    </div>


    <div class="team-block">
        <div class="span8">
            <div class="box bios">
                <p><img class="imgTeam"src="images/sample/team/luiz.jpg" alt="Luiz Wynne picture" ></p>
                <h5>Luiz Wynne</h5>
                <h6>Software Developer</h6>
                <p><br>
                Luiz is a Software Developer Specialist. Originally from Sao Paulo he holds qualifications in Marketing and Computer Science and has years of experience in IT and Cloud Computing.
Luiz is an advocate that learning is the key to everything. Luiz looks after all web technology associated with both <a class="dark-body-a" href="https://fintechjobs.ie">Fintechjobs.ie</a> and <a class="dark-body-a" href="https://fintechjobs.io">Fintechjobs.io</a>.
                </p><br><br>
                <a href="mailto:luiz@fintechjobs.ie?Subject=FinTechjobs.ie" target="_top">luiz@fintechjobs.io</a>
                </div>
        </div>
    </div>

    <div class="team-block">
      <div class="span8">
            <div class="box bios">
                <p><img class="imgTeam"src="images/sample/team/kevin.jpg" alt="Kevin Shortall picture" ></p>
                <h5>Kevin Shortall</h5>
                <h6>Sales & Marketing Manager</h6>
                <p><br>
                Kevin is the Sales & Marketing Manager for <a class="dark-body-a" href="https://fintechjobs.io">Fintechjobs.io</a> and <a class="dark-body-a" href="https://fintechjobs.io">Fintechjobs.ie</a>. With over 20 years of customer care and business development experience Kevin is the ideal person to establish contacts with Fintech Companies, advise them of the many benefits of advertising their vacancies on our site(s) and follow up with excellent after-sales service. Kevin is a qualified Sales & Marketing Consultant and has worked for many companies helping them develop their customer base and grow more profitable.
                </p>
                <a href="mailto:kevin@fintechjobs.ie?Subject=FinTechjobs.ie" target="_top">kevin@fintechjobs.io</a>
                </div>
        </div>
    </div>




</section>


@endsection
