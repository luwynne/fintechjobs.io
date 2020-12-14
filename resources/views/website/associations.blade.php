@extends('layouts.website')

@section('content')

<section class="title">
    <div class="container">
        <div class="row-fluid">
            <div class="span6">
                <h1>FinTech Associations Directory</h1>
            </div>
            <div class="span6">
                <ul class="breadcrumb pull-right">
                    <li><a href="{{ url('/') }}">Home</a> <span class="divider">/</span></li>
                    <li class="active">Associations</li>
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
            Here you will find a detailed list of FinTech Companies from around the world. 
            If your business is not displayed and you would like to advertise in our FinTech Companies Directory please email us at <a href="mailto:info@fintechjobs.io">info@fintechjobs.io</a>.
            </p>
            <h3 class="company-list-title">What is FinTech</h3>
            <p>
                The word “FinTech” is simply a combination of the words “financial” and “technology” and typically refers to 
               companies or services that use technology to provide financial services to businesses or consumers.
            </p>
            <br>
            <div class="company-list-filter">
                <a href="{{ url('/register') }}"><button  class="btn btn-info company-list-search-button">Sign up</button></a>
            </div>
        </div>
    </div>

    <hr>

    <div class="team-block">

        <div class="company-list-filter">
            <input id="name" type="text" class="form-control association-width-top-filter" name="search" placeholder="Association name"></input>
        </div>
            
        <div class="company-list-filter">
            <button id="search" class="btn btn-info association-list-search-button">Search</button>
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
                $sector = $('#sector').val();
                var div = document.getElementById('company-block');
                while(div.firstChild){
                    div.removeChild(div.firstChild);
                }

                $.ajax({
                    type : 'get',
                    url : 'http://localhost:8888/fintechjobs.io/associations/get',
                    data:{'name':$name, 'sector':$sector},
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
                                            '<div class="company-logo-portion">'+
                                                '<a href="http://localhost:8888/fintechjobs.io/association/'+ data[i].id +'/'+ data[i].clean_url_name +'">'+
                                                    '<img class="company-list-logo" src="'+ data[i]['logo'].full_path +'" alt="company-logo">'+
                                                '</a>'+
                                                '<span class="show-mobile"><br></span>'+
                                            '</div>'+
                                            '<div class="company-info-portion">'+
                                                '<h3 class="company-list-title"><a href="http://localhost:8888/fintechjobs.io/association/'+ data[i].id +'/'+ data[i].clean_url_name +'">'+ data[i].name +'</a></h3>'+
                                                '<p>Sector: '+ data[i].sector.name +'<br>'+
                                                    'Phone: '+ data[i].phone +'<br>'+
                                                    'Contact: '+ data[i]['representant'].email +'<br>'+
                                                    '<span class="website">Website: <a target="_blank" href="//'+ data[i].website +'">'+ data[i].website +'</a></span>'+
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