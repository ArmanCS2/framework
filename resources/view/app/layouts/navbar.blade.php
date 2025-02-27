<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar"
     style="direction: rtl;">
    <div class="container">
        <a class="navbar-brand" href="<?=route('index')?>"><span>Ashianeh</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
                aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> منو
        </button>

        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item <?=active(route('index'), false)?>"><a href="<?=route('index')?>" class="nav-link">خانه</a>
                </li>
                <li class="nav-item <?=active(route('ads'), false)?>"><a href="<?=route('ads')?>" class="nav-link">آگهی
                        ها</a></li>
                <li class="nav-item <?=active(route('about'), false)?>"><a href="<?=route('about')?>" class="nav-link">درباره
                        من</a></li>
                <li class="nav-item <?=active(route('posts'), false)?>"><a href="<?=route('posts')?>" class="nav-link">بلاگ</a>
                </li>

                <li class="nav-item"><a href="https://armanafzali.ir/" class="nav-link">سایت رزومه من</a>
                </li>

                <?php if (\System\Auth\Auth::checkLogin()){
                    if (\System\Auth\Auth::user()->user_type=='admin'){
                ?>
                <li class="nav-item btn-primary"><a href="<?=route('admin.index')?>" class="nav-link text-white"><span
                                class="icon-home m-2"></span>پنل ادمین</a></li>
                <?php } ?>
                <li class="nav-item cta cta-colored"><a href="<?=route('home')?>" class="nav-link"><span
                                class="icon-pencil m-2"></span><?=\System\Auth\Auth::user()->first_name . " " .\System\Auth\Auth::user()->last_name?></a></li>
                <li class="nav-item btn-danger"><a href="<?=route('auth.logout')?>" class="nav-link text-white"><span
                                class="icon-exit_to_app m-2 "></span>خروج</a></li>
                <?php }else{ ?>
                <li class="nav-item cta"><a href="<?=route('auth.login.view')?>" class="nav-link ml-lg-1 mr-lg-5"><span
                                class="icon-user m-2"></span>ورود</a></li>
                <li class="nav-item cta cta-colored"><a href="<?=route('auth.register.view')?>" class="nav-link"><span
                                class="icon-pencil m-2"></span>ثبت نام</a></li>
                <?php }?>

            </ul>
        </div>
    </div>
</nav>
<!-- END nav -->
