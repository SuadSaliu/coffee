@extends('frontend.appother')

@section('content')
<?php $currency =  setting_by_key("currency"); ?>
<!-- Header Area Start 
    ====================================================== -->
<section class="banner-sec internal-banner" style="background-image:url(assets/frontend/img/menu-page.jpg)">

    <!-- Start: slider-overview -->
    <div class="balck-solid">

        <!-- Start: slider -->
        <div class="container">
            <div class="banner-mid-text internal-header">

                <!-- Start: flexslider -->
                <div class="flexslider">
                    <ul>
                        <!-- Start: flexslider-one -->
                        <li>
                            <h2>Our menu</h2>
                            <div class="hr-outtr-line">
                                <hr><i class="fa fa-heart" aria-hidden="true"></i>
                                <hr>
                            </div>
                        </li>
                        <!-- End: flexslider-one -->
                    </ul>
                </div>
                <!-- End: flexslider -->

            </div>
        </div>
        <!-- End: slider -->

    </div>
    <!-- End: slider-overview -->
</section>
<!-- =================================================
    Header Area End -->


<!-- Reservation  Area Start 
    ====================================================== -->
<section class="resrvation-top-area our-top-sec" id="Welcome">

    <div class="container text-center">
        <div class="row">
            <h2><span>Our</span>Bussinesses</h2>
            <div class="hr-outtr-line">
                <hr><i class="fa fa-heart" aria-hidden="true"></i>
                <hr>
            </div>
        </div>
    </div>
</section>
<!-- =================================================
    AReservation Area End -->

<div class="bussinesses">
    
    @foreach($bussiness as $buss)
        <div class="card" id="{!! $buss->id !!}">
            <div class="card-body">
                <h5 class="card-title">{{ $buss->name }}</h5>
                <p class="card-text">{{ $buss->description }}</p>
            </div>
        </div>
    @endforeach

</div>

<style>
    .bussinesses {
        display: grid;
        grid-template-columns: repeat(2, auto);
        max-width: 80%;
        margin: auto;
        margin-bottom: 12em;
        grid-gap: 30px;
    }

    .bussinesses .card {
        border: 1px solid rgba(0,0,0,.125);
        border-radius: .25rem;
        padding: 28px;
    }

    .bussinesses .card:hover {
        background: #ffddd5;
    }

    .card-text {
        margin-bottom: 0 !important;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<script>
    $(".card").on("click", function() {
        var id = $(this).attr('id');
        location.href = location.href + '/' + id;
    });
</script>


@endsection