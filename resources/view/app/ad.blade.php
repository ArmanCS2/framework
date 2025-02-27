@extends('app.layouts.app')

@section('head-tag')
    <title>آگهی</title>
@endsection

@section('content')
    <div class="hero-wrap" style="background-image: url('<?=asset('images/bg_1.jpg')?>');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <p class="breadcrumbs" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"><span
                                class="mr-2"><a href="<?=route('home')?>">خانه</a></span> <span class="mr-2"><a
                                    href="<?=route('ads')?>">آگهی ها</a></span> <span><?=$ad->title?></span></p>
                    <h1 class="mb-3 bread">آگهی</h1>
                </div>
            </div>
        </div>
    </div>


    <section class="ftco-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-md-12 ftco-animate">
                            <div class="single-slider owl-carousel">
                                <?php foreach ($galleries as $gallery){?>
                                <div class="item">
                                    <div class="properties-img"
                                         style="background-image: url('<?=asset($gallery->image)?>');">

                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-12 Properties-single mt-4 mb-5 ftco-animate">
                            <h2><?=$ad->title?></h2>
                            <p class="rate mb-4">
                                <span class="loc"><a href="#"><i class="icon-map"></i><?=$ad->address?></a></span>
                            </p>
                            <p><?=html($ad->description)?></p>
                            <div class="d-md-flex mt-5 mb-5">
                                <ul>
                                    <li><span> متراژ : </span><?=$ad->area?></li>
                                    <li><span>اتاق خواب : </span><?=$ad->room?></li>
                                    <li><span>سرویس بهداشتی : </span><?=$ad->toilet?></li>
                                    <li><span>پارکینگ : </span><?=$ad->parking?></li>
                                    <li><span>نوع ملک : </span><?=$ad->type()?></li>
                                </ul>
                                <ul class="ml-md-5">
                                    <li><span>نوع کفپوش : </span><?=$ad->floor?></li>
                                    <li><span>سال ساخت : </span><?=$ad->year?></li>
                                    <li><span>انباری : </span><?=$ad->storeroom?></li>
                                    <li><span>بالکن : </span><?=$ad->balcony?></li>
                                    <li><span>نوع آگهی : </span><?=$ad->sellStatus()?></li>
                                </ul>
                            </div>
                        </div>


                        <div class="col-md-12 properties-single ftco-animate mb-5 mt-5">
                            <h4 class="mb-4">آگهی های مرتبط</h4>
                            <div class="row">
                                <?php foreach ($relatedAds as $ad){?>
                                <div class="col-md-6 ftco-animate">
                                    <div class="properties">
                                        <a href="<?=route('ad', [$ad->id])?>"
                                           class="img img-2 d-flex justify-content-center align-items-center"
                                           style="background-image: url('<?=asset($ad->image)?>');">
                                            <div class="icon d-flex justify-content-center align-items-center">
                                                <span class="icon-search2"></span>
                                            </div>
                                        </a>
                                        <div class="text p-3">
                                            <span class="status <?=$ad->sell_status == 1 ? 'sale' : 'rent'?>"><?=$ad->sellStatus()?></span>
                                            <div class="d-flex">
                                                <div class="one">
                                                    <h3><a href="<?=route('ad', [$ad->id])?>"><?=$ad->title?></a></h3>
                                                    <p><?=$ad->type()?></p>
                                                </div>
                                                <div class="two">
                                                    <span class="price"><?=$ad->amount?></span>
                                                </div>
                                            </div>
                                            <p><?= "..." . substr(html($ad->description), 0, 40) ?></p>
                                            <hr>
                                            <p class="bottom-area d-flex">
                                                <span><i class="flaticon-selection"></i> <?=$ad->area?></span>
                                                <span class="ml-auto"><i class="flaticon-bathtub"></i> <?=$ad->toilet?></span>
                                                <span><i class="flaticon-bed"></i> <?=$ad->room?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- .col-md-8 -->
                <div class="col-lg-4 sidebar ftco-animate">

                    <div class="sidebar-box ftco-animate">
                        <div class="categories">
                            <h3>دسته بندی ها</h3>
                            <?php foreach ($categories as $category){ ?>
                            <li><a href="<?=route('category',[$category->id])?>"><?=$category->name?><span>(<?=count($category->ads()->get())?>)</span></a>
                            </li>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="sidebar-box ftco-animate">
                        <h3>آخرین بلاگ ها</h3>
                        <?php foreach ($posts as $post){ ?>
                        <div class="block-21 mb-4 d-flex">
                            <a class="blog-img mr-4" style="background-image: url('<?=asset($post->image)?>');"></a>
                            <div class="text">
                                <h3 class="heading"><a href="<?=route('post',[$post->id])?>"><?=$post->title?></a></h3>
                                <div class="meta">
                                    <div><a href="<?=route('post',[$post->id])?>"><span
                                                    class="icon-calendar"></span><?=jalaliDate($post->created_at)?></a>
                                    </div>
                                    <div><a href="<?=route('post',[$post->id])?>"><span
                                                    class="icon-person"></span><?=$post->user()->first_name . " " . $post->user()->last_name?>
                                        </a></div>
                                    <div><a href="<?=route('post',[$post->id])?>"><span class="icon-chat"></span><?=count($post->comments()->get())?>
                                        </a></div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection