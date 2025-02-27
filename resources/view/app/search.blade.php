@extends('app.layouts.app')

@section('head-tag')
    <title>جست و جو</title>
@endsection

@section('content')

    <div class="hero-wrap" style="background-image: url('<?=asset('images/bg_1.jpg')?>');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <p class="breadcrumbs"><span class="mr-2"><a href="<?=route('home')?>">خانه</a></span> <span>جست و جو</span></p>
                    <h1 class="mb-3 bread"> نتایج جست و جو برای : <?=$_GET['search']?></h1>
                </div>
            </div>
        </div>
    </div>

    <section class="ftco-section ftco-properties">
        <div class="container">
            <div class="row justify-content-center mb-5 pb-3">
                <div class="col-md-7 heading-section text-center ftco-animate">
                    <h2 class="mb-4">آگهی ها</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="properties-slider owl-carousel ftco-animate">
                        <?php foreach ($ads as $ad){ ?>
                        <div class="item">
                            <div class="properties">
                                <a href="<?=route('ad',[$ad->id])?>" class="img d-flex justify-content-center align-items-center"
                                   style="background-image: url('<?=asset($ad->image)?>');">
                                    <div class="icon d-flex justify-content-center align-items-center">
                                        <span class="icon-search2"></span>
                                    </div>
                                </a>
                                <div class="text p-3">
                                    <span class="status <?= $ad->sell_status == 0 ? 'rent' : 'sale' ?>"><?=$ad->sellStatus()?></span>
                                    <div class="d-flex">
                                        <div class="one">
                                            <h3><a href="<?=route('ad',[$ad->id])?>"><?=$ad->title?></a></h3>
                                            <p><?=$ad->type()?></p>
                                        </div>
                                        <div class="two">
                                            <span class="price"><?=$ad->amount?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center mb-5 pb-3">
                <div class="col-md-7 heading-section text-center ftco-animate">
                    <h2>بلاگ ها</h2>
                </div>
            </div>
            <div class="row d-flex">
                <?php foreach ($posts as $post){ ?>
                <div class="col-md-3 d-flex ftco-animate">
                    <div class="blog-entry align-self-stretch">
                        <a href="<?=route('post',[$post->id])?>" class="block-20"
                           style="background-image: url('<?=asset($post->image)?>');">
                        </a>
                        <div class="text mt-3 d-block">
                            <h3 class="heading mt-3"><a href="<?=route('post',[$post->id])?>"><?=$post->title?></a></h3>
                            <div class="meta mb-3">
                                <div><a href="<?=route('post',[$post->id])?>"><?=jalaliDate($post->created_at)?></a></div>
                                <div><a href="<?=route('post',[$post->id])?>"><?=$post->user()->first_name . " " . $post->user()->last_name?></a></div>
                                <div><a href="<?=route('post',[$post->id])?>" class="meta-chat"><span class="icon-chat"></span><?=count($post->comments()->get())?></a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
@endsection