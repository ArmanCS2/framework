@extends('app.layouts.app')

@section('head-tag')
    <title>درباره من</title>
@endsection

@section('content')
    <div class="hero-wrap" style="background-image: url('<?=asset('images/bg_1.jpg')?>');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <p class="breadcrumbs"><span class="mr-2"><a href="<?=route('home')?>">خانه</a></span> <span>درباره من</span>
                    </p>
                    <h1 class="mb-3 bread">درباره من</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="ftco-section ftc-no-pb">
        <div class="container">
            <div class="row no-gutters">
                <div class="col-md-5 p-md-5 img img-2 d-flex justify-content-center align-items-center"
                     style="background-image: url('<?=asset('images/about.jpg')?>');">
                    <a href="https://armanafzali.ir"
                       class="icon popup-vimeo d-flex justify-content-center align-items-center">
                        <span class="icon-play"></span>
                    </a>
                </div>
                <div class="col-md-7 wrap-about pb-md-5 ftco-animate">
                    <div class="heading-section heading-section-wo-line mb-5 pl-md-5">
                        <div class="pl-md-5 ml-md-5">
                            <span class="subheading">خلاصه وبسایت</span>
                            <h2 class="mb-4">آشیانه</h2>
                        </div>
                    </div>
                    <div class="pl-md-5 ml-md-5 mb-5">
                        <p>
                            این وبسایت صرفا جهت نمونه کار پیاده سازی شده است برای سفارش پروژه خود از راه های ارتباطی زیر کمک بگیرید
                        </p>
                        <p>tel : <a href="tel:+989223618018">09223618018</a></p>
                        <p>email : <a href="mailto:armanafzali31@gmail.com">armanafzali31@gmail.com</a></p>
                        <p>website : <a href="https://armanafzali.ir">armanafzali.ir</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
