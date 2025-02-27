@extends('app.layouts.app')

@section('head-tag')
    <title>آگهی ها</title>
@endsection

@section('content')
    <div class="hero-wrap" style="background-image: url('<?=asset('images/bg_1.jpg')?>');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <p class="breadcrumbs"><span class="mr-2"><a href="<?=route('home')?>">خانه</a></span> <span>آگهی ها</span>
                    </p>
                    <h1 class="mb-3 bread">آگهی ها</h1>
                </div>
            </div>
        </div>
    </div>



    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row">
                <?php foreach (paginate($ads,6) as $ad){ ?>
                <div class="col-md-4 ftco-animate">
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
            <?= paginateView($ads,6) ?>
        </div>
    </section>
@endsection
