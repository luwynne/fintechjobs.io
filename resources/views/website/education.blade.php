@extends('layouts.website')

@section('content')

<section class="title">
    <div class="container">
        <div class="row-fluid">
            <div class="span6">
                <h1>FinTech education</h1>
            </div>
            <div class="span6">
                <ul class="breadcrumb pull-right">
                    <li><a href="{{ url('/') }}">Home</a> <span class="divider">/</span></li>
                    <li class="active">Education</li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- / .title -->

<section id="about-us" class="container main">
    <div class="row-fluid">
        <div class="span10">
            <p>
            Fintech Education - Are you considering a career in Fintech? If the answer is Yes, please keep tuned to this page as we will shortly feature details of top-rated educational establishments which will give you the opportunity to attain a solid Fintech Education by enrolling on one of their programs. The world of Fintech is constantly evolving with new technology advances in areas such as blockchain, regulation and politics, finance, wealth management, e-payments and cognitive computing.
           </p>
            <p>
            Fintech Careers - Developing a Fintech Career could just be just the move for you. Popular Fintech Careers include Data Analysts, Financial Technology Specialists and Finance Analysts to name just a few. Find Fintech Jobs by clicking on <a class="dark-body-a" href="https://fintechjobs.io">this Link.</a>
            </p>
            <p>
            Financial Organisations are regularly advertising Finance <a class="dark-body-a" href="https://fintechjobs.io">Jobs</a> and Technology <a class="dark-body-a" href="https://fintechjobs.io">Jobs.</a> It is indeed the area where these two roles meet that we find the exciting world of Fintech Jobs or Financial Technology Jobs. The best way to secure a well-paying Fintech Role is to get a proper Fintech Education.
            </p>
            <p>
            There is no doubt major advances in technology are causing big changes in the way organisations such as Banks and Financial Companies conduct their business. With these changes happening at a rapid pace organisations are in constant need of Finance, I.T. and Fintech Professionals to help run their operations smoothly. Now is the time to go and get qualified in this exciting area.
            </p>
            </div>
    </div>

    <hr>

    <div class="team-block">

        <div class="company-list-filter">
            <input id="name" type="text" class="form-control width-top-filter" name="search" placeholder="Institute name"></input>
        </div>

        <div class="company-list-filter">
            <select id="country_id" class="browser-default custom-select width-top-filter">
                <option value="" selected>Countries</option>
                @foreach($countries as $country)
                    <option value="{{$country->id}}">{{$country->name}}</option>        
                @endforeach
            </select>
        </div>
            
        <div class="company-list-filter">
            <button id="search" class="btn btn-info company-list-search-button">Search</button>
        </div>

        <div id="navigation-holders">
            <span id="PreeValue"><b>< Previous</b></span>&nbsp;&nbsp;<span id="nextValue"><b>Next ></b></span>
        </div>

        <hr>
        <div class="hiden" id="loading-block">
            <img src="http://localhost:8888/fintechjobs.io/public/admin/img/loading.gif">        
        </div>

    </div>
   
    <div id="company-block" class="team-block">
    </div>

</section>


<script type="text/javascript">
    

    $(document).ready(function(){

            var loading_block = $('#loading-block');
            var event_block = $('#company-block');
        
            function getCompanies(){

                $name = $('#name').val();
                $country_id = $('#country_id').val();
                var div = document.getElementById('company-block');
                while(div.firstChild){
                    div.removeChild(div.firstChild);
                }

                $.ajax({
                    type : 'get',
                    url : 'http://localhost:8888/fintechjobs.io/education/institutes',
                    data:{'name':$name, 'country_id':$country_id},
                    dataType: 'json', 
                    success:function(data){
                        
                        console.log(data);
                        var table =  $('#company-block');
                        var max_size = data.length;
                        var sta = 0;
                        var elements_per_page = 5;
                        var limit = elements_per_page;

                        if(data.length <= elements_per_page){
                            $('#navigation-holders').css('display', 'none');
                        }else{
                            $('#navigation-holders').css('display', 'block');
                        }
                        
                        goFun(sta,limit);
                        function goFun(sta,limit) {
                        

                            for (var i =sta ; i < limit; i++) {

                                    var $nr = $(
                                    '<div class="span8 companies-individual-blocks">'+
                                        '<div class="box bios">'+
                                            '<div class="company-logo-portion education-institute-logo-portion">'+
                                                '<a target="_blank" href="'+ data[i].clean_url +'">'+
                                                    '<img class="company-list-logo education-institute-logo" src="http://localhost:8888/fintechjobs.io/public/images/sample/institutes/'+ data[i].logo_name +'" alt="company-logo">'+
                                                '</a>'+
                                                '<span class="show-mobile"><br></span>'+
                                            '</div>'+
                                            '<div class="company-info-portion">'+
                                                '<h3 class="company-list-title"><a target="_blank" href="'+ data[i].clean_url +'">'+ data[i].name +'</a></h3>'+
                                                '<p class="company-list-title">Country: '+ data[i].country.name +'<br>'+
                                                    'Contact: '+ data[i].contact_email +'<br>'+
                                                    '<span class="website"><a target="_blank" href="'+ data[i].url +'">'+ 'Visit website' +'</a></span>'+
                                                '<p>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'
                                    );

                                
                                table.append($nr);
                                
                            }
                            
                        }
                        console.log(data.length);

                        $('#nextValue').click(function(){
                            var next = limit;
                            if(max_size >= next) {
                                limit = limit + elements_per_page;
                                table.empty();
                                goFun(next,limit);
                            }
                        });

                        $('#PreeValue').click(function(){
                            var pre = limit-(2*elements_per_page);
                            if(pre>=0) {
                                limit = limit - elements_per_page;
                                table.empty();
                                goFun(pre,limit); 
                            }
                        });

                    }
                });

            }
            
        
        
        $('#search').on('click',function(){
            loading_block.removeClass('hiden');
            event_block.addClass('hiden');
            getCompanies();
            setTimeout(function(){ 
                loading_block.addClass('hiden');
                event_block.removeClass('hiden'); 
            }, 500);
        }) 

        window.onload = function() {
            getCompanies();
        };

    });

</script>

<script type="text/javascript">
    $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script>


@endsection
