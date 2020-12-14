@extends('layouts.website')

@section('content')

    <section class="title">
    <div class="container">
        <div class="row-fluid">
            <div class="span6">
                <h1>Products</h1>
            </div>
        </div>
    </div>
</section>
<!-- / .title -->


<section id="pricing-table" class="container">

    @if(count($profile_products) > 0 || count($event_products) > 0 || count($jobs_products) > 0 || count($education_products))
        <div class="coupon-buttom-wrapper">
            <h5 id="discount-modal-opener" class="coupon-buttom">I have a discount coupon</h5>
        </div>
    @endif    

        <div class="row-fluid center clearfix">
        @if(count($profile_products) > 0)
        <h3>Company Profile Packages</h3>
            @foreach($profile_products as $profile_product)
                        <div class="columns">
                            <ul class="price">
                                <li class="header">{{$profile_product->name}}</li>
                                <li class="grey">{!! $profile_product->description !!}</li>
                                @if($discount > 0)
                                <li><br><h4>
                                <strike>£{{$profile_product->full_price}}</strike><br>
                                        Promotional price: £{{$profile_product->full_price - (($profile_product->full_price * $discount) / 100 )}}
                                </h4><br></li>
                                @else
                                <li><br><h4>£{{$profile_product->full_price}} for 1 year</h4><br></li>
                                @endif
                                <li class="grey">
                                <form action="{{action('CheckoutController@subscribe_process')}}" method="post">
                                {{ csrf_field() }}
                                <script
                                        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                        data-key="pk_test_DCjo3s9fSWn7B3cNoMRgDT5800Yy2jVtKO"
                                        data-amount="{{$discount > 0 ? $profile_product->stripe_price - (($profile_product->stripe_price * $discount) / 100 ) : $profile_product->stripe_price}}"
                                        data-name="{{$profile_product->stripe_value}}"
                                        data-description="{{$profile_product->description}}"
                                        data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                        data-locale="auto"
                                        data-currency="GBP">
                                </script>
                                <input type="hidden" id="package" name="package" value="{{$profile_product->stripe_value}}">
                                <input type="hidden" id="discount" name="discount" value="{{$discount}}">
                            </form>
                                </li>
                            </ul>
                        </div>
                        @endforeach
                    @endif
                </div>
                
        <p>&nbsp;</p>

        <div class="row-fluid center clearfix">
            @if(count($event_products) > 0)
            <h3>Events Packages</h3>
                @foreach($event_products as $event_product)
                            <div class="columns">
                                <ul class="price">
                                    <li class="header">{{$event_product->name}}</li>
                                    <li class="grey">{!! $event_product->description !!}</li> 
                                    @if($discount > 0)
                                    <li><br><h4>
                                    <strike>{{$event_product->full_price}}</strike><br>
                                            Promotional price: £{{$event_product->full_price - (($event_product->full_price * $discount) / 100 )}}
                                    </h4><br></li>
                                    @else
                                    <li><br><h4>£{{$event_product->full_price}}</h4><br></li>
                                    @endif
                                    <li class="grey">
                                    <form action="{{action('CheckoutController@subscribe_process')}}" method="post">
                                    {{ csrf_field() }}
                                    <script
                                            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                            data-key="pk_test_DCjo3s9fSWn7B3cNoMRgDT5800Yy2jVtKO"
                                            data-amount="{{$discount > 0 ? $event_product->stripe_price - (($event_product->stripe_price * $discount) / 100 ) : $event_product->stripe_price}}"
                                            data-name="{{$event_product->stripe_value}}"
                                            data-description="{{$event_product->description}}"
                                            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                            data-locale="auto"
                                            data-currency="GBP">
                                    </script>
                                    <input type="hidden" id="package" name="package" value="{{$event_product->stripe_value}}">
                                    <input type="hidden" id="discount" name="discount" value="{{$discount}}">
                                </form>
                                    </li>
                                </ul>
                            </div>
                        @endforeach
                    @endif
            </div>

        <p>&nbsp;</p>  

        <div class="row-fluid center clearfix">
        @if(count($education_products) > 0)
        <h3>Education Packages</h3>
            @foreach($education_products as $education_product)
                        <div class="columns">
                            <ul class="price">
                                <li class="header">{{$education_product->name}}</li>
                                <li class="grey">{!! $education_product->description !!}</li>
                                @if($discount > 0)
                                <li><br><h4>
                                <strike>£{{$education_product->full_price}}</strike><br>
                                        Promotional price: £{{$education_product->full_price - (($education_product->full_price * $discount) / 100 )}}
                                </h4><br></li>
                                @else
                                <li><br><h4>£{{$education_product->full_price}} for 3 months</h4><br></li>
                                @endif
                                <li class="grey">
                                <form action="{{action('CheckoutController@subscribe_process')}}" method="post">
                                {{ csrf_field() }}
                                <script
                                        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                        data-key="pk_test_DCjo3s9fSWn7B3cNoMRgDT5800Yy2jVtKO"
                                        data-amount="{{$discount > 0 ? $education_product->stripe_price - (($education_product->stripe_price * $discount) / 100 ) : $education_product->stripe_price}}"
                                        data-name="{{$education_product->stripe_value}}"
                                        data-description="{{$education_product->description}}"
                                        data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                        data-locale="auto"
                                        data-currency="GBP">
                                </script>
                                <input type="hidden" id="package" name="package" value="{{$education_product->stripe_value}}">
                                <input type="hidden" id="discount" name="discount" value="{{$discount}}">
                            </form>
                                </li>
                            </ul>
                        </div>
                        @endforeach
                    @endif
                </div>
                
        <p>&nbsp;</p>  

        <div class="row-fluid center clearfix">
            @if(count($jobs_products) > 0)
            <h3>Job Credit Packages</h3>
                @foreach($jobs_products as $product)
                            <div class="columns">
                                <ul class="price">
                                    <li class="header">{{$product->name}}</li>
                                    <li class="grey">{!! $product->description !!}</li> 
                                    @if($discount > 0)
                                    <li><br><h4>
                                    <strike>{{$product->full_price}}</strike><br>
                                            Promotional price: £{{$product->full_price - (($product->full_price * $discount) / 100 )}}
                                    </h4><br></li>
                                    @else
                                    <li><br><h4>£{{$product->full_price}}</h4><br></li>
                                    @endif
                                    <li class="grey">
                                    <form action="{{action('CheckoutController@subscribe_process')}}" method="post">
                                    {{ csrf_field() }}
                                    <script
                                            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                            data-key="pk_test_DCjo3s9fSWn7B3cNoMRgDT5800Yy2jVtKO"
                                            data-amount="{{$discount > 0 ? $product->stripe_price - (($product->stripe_price * $discount) / 100 ) : $product->stripe_price}}"
                                            data-name="{{$product->stripe_value}}"
                                            data-description="{{$product->description}}"
                                            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                            data-locale="auto"
                                            data-currency="GBP">
                                    </script>
                                    <input type="hidden" id="package" name="package" value="{{$product->stripe_value}}">
                                    <input type="hidden" id="discount" name="discount" value="{{$discount}}">
                                </form>
                                    </li>
                                </ul>
                            </div>
                        @endforeach
                    @endif
            </div>

            <div class="row-fluid center clearfix">
                @if(!count($jobs_products) > 0 && !count($event_products) > 0 && !count($profile_products) > 0 && !count($education_products) > 0)
                    <h3>You either have a high valid current package or no packages are available for your Company type.</h3>
                    <p>For updates or more details, please contact our support team on support@fintechjobs.io.</p>
                @endif
            </div>

    </section>


<!--  coupon form -->
<div class="modal hide fade in" id="coupon-modal" aria-hidden="false">
    <div class="modal-wrapper">
        <div class="modal-header">
            <i class="icon-remove" data-dismiss="modal" aria-hidden="true"></i>
            <h4>Enter discount coupon code</h4>
        </div>
        <!--Modal Body-->
        <div class="modal-body">

            <form class="form-inline" name="form" id="form" action="{{route('products_discount')}}" method="post">
                {{ csrf_field() }}
                <p id="message_show"></p>
                <input type="text" id="coupon" name="coupon" class="input-xlarge" required>
                <br><br>
                <button type="submit" id="form_submit" name="form_submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <!--/Modal Body-->
    </div>
</div>
<!--  coupon form -->


<style scoped>

.modal{
    width: 100%!important;
    height: 100vh!important;
    margin-left:0!important;
    left:0!important;
    background:rgba(0,0,0,0.8);
}

.modal-wrapper{
    width:30%;
    height:170px;
    background-color: rgba(255,255,255, 1.0);
    margin: auto;
    margin-top: 10%;
    border-radius: 5px;
}

.modal .icon-remove {
    position: relative!important;
    right: 0!important;
    top: -5px!important;
    left: 102%!important;
    top: -12px!important;
}

.modal .modal-header {
    padding: 8px 20px 0!important;
}

.modal.fade.in {
    top: 0%!important;
}

.modal input[type="text"]{
width:80%;
}

</style>


<script>

$(document).ready(function(){

    $("#discount-modal-opener").click(function(){
        $("#coupon-modal").fadeIn(200);
    });

    $(".icon-remove").click(function() {
        $("#coupon-modal").fadeOut(200);
    });

});

</script>
    

@endsection
