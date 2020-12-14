@extends('layouts.website')

@section('content')

<section class="title">
    <div class="container">
        <div class="row-fluid">
            <div class="span6">
                <h1>Events in FinTech</h1>
            </div>
            <div class="span6">
                <ul class="breadcrumb pull-right">
                    <li><a href="{{ url('/') }}">Home</a> <span class="divider">/</span></li>
                    <li class="active">Events</li>
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
            Fintech Events - Are you interested in Fintech Events taking place in Europe or elsewhere? If so, please visit this page regularly for updates on Fintech Events in London, the UK, Europe and further afield or email us at info@fintechjobs.io so you are kept informed of what’s coming up.
            </p>

            <p>
            Become Part of our <a class="dark-body-a" href="https://www.linkedin.com/company/24983760/admin/">community</a>. If you know about Fintech Events taking place; please help us to help you and let us know what’s taking place. We’d be thrilled to post them up and let’s all build the Fintech Community activity and Fintech <a class="dark-body-a" href="https://fintechjobs.io">Jobs</a> together. Email us at <a href="mailto:info@fintechjobs.io">info@fintechjobs.io</a>.
            </p>

            <p>
            London is Europe’s main Fintech Hub and is home to some of the major Fintech Companies in the World this includes companies such as Funding Circle, TransferWise and Revoult. It is also the go-to-place for Fintech <a class="dark-body-a" href="https://fintechjobs.io">Jobs</a>. London also plays host to Fintech Conferences and Exhibitions.
            </p>

            </div>
    </div>

    <div class="team-block">

        <div class="company-list-filter">
            <select id="country" class="browser-default custom-select width-top-filter">
                <option value="" selected>Country</option>
                @foreach($countries as $country)
                    <option value="{{$country->id}}">{{$country->name}}</option>        
                @endforeach
            </select>
        </div>

        <div class="company-list-filter">
            <input id="month" type="month" class="form-control width-top-filter" name="month" placeholder="Date"></input>
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

   

    <div id="event_block">
    </div>
    

</section>  


<script type="text/javascript">

$(document).ready(function(){

        var loading_block = $('#loading-block');
        var event_block = $('#event_block');
        
        function getEvents(){
            
            $month = $('#month').val();
            $country = $('#country').val();
            var div = document.getElementById('event_block');
            while(div.firstChild){
                div.removeChild(div.firstChild);
            }

            $.ajax({
                type : 'get',
                url : 'http://localhost:8888/fintechjobs.io/events/list',
                data:{'month':$month, 'country':$country},
                dataType: 'json', 
                success:function(data){
                    
                    console.log(data);
                    var table =  $('#event_block');
                    var max_size = data.length;
                    var sta = 0;
                    var elements_per_page = 5;
                    var limit = elements_per_page;
                    var no_fee_message = "No Fee";

                    if(data.length <= elements_per_page){
                        $('#navigation-holders').css('display', 'none');
                    }else{
                        $('#navigation-holders').css('display', 'block');
                    }
                    
                    goFun(sta,limit);
                    
                    function goFun(sta,limit) {

                        for (var i =sta ; i < limit; i++) {

                                var $nr = $(
                                    '<div class="team-block event-block">'+
                                        '<div class="span8">'+
                                            '<a target="_blank" href="'+data[i].url+'">'+
                                                '<div style="background-image: linear-gradient(to bottom, #ddd, rgba(255, 255, 255, 0.80)), url('+data[i].image_path+')" class="box bios event-box">'+
                                                    '<h3 class="company-list-title">'+data[i].name+'</h3>'+
                                                    '<p>Organizer: '+data[i].organizer+'</p>'+
                                                    '<p>'+data[i].location+'</p>'+
                                                    '<p>'+data[i].start_date+'</p>'+
                                                    '<p>Fee: '+data[i].fee+'</p>'+
                                                '</div>'+
                                            '</a>'+
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
        getEvents();
        setTimeout(function(){ 
            loading_block.addClass('hiden');
            event_block.removeClass('hiden'); 
        }, 500);
        
    })     

    window.onload = function() {
        getEvents();
    };

});

</script>



@endsection
