<?php

namespace App\Providers;

use App\Ads;
use App\Post;
use App\User;
use System\View\Composer;

class AppServiceProvider extends Provider
{
    public function boot()
    {
        define('MAIL_HOST', 'mail.armanafzali.ir');
        define('SMTP_AUTH', true);
        define('MAIL_USERNAME', '_mainaccount@armanafzali.ir');
        define('MAIL_PASSWORD', '05]Y8Wblj3AiU[');
        define('MAIL_PORT', 587);
        define('SENDER_MAIL', 'armanafz@armanafzali.ir');
        define('SENDER_NAME','Arman Afzali');

        /*define('MAIL_HOST', 'smtp.gmail.com');
        define('SMTP_AUTH', true);
        define('MAIL_USERNAME', 'encyclopedia.online.mail@gmail.com');
        define('MAIL_PASSWORD', 'apksprsfnpqdzvcm');
        define('MAIL_PORT', 587);
        define('SENDER_MAIL', 'encyclopedia.online.mail@gmail.com');
        define('SENDER_NAME','Arman Afzali');*/

        define('DISPLAY_ERROR', true);
        define('DB_HOST', 'localhost');
        define('DB_NAME', 'framework');
        define('DB_USERNAME', 'root');
        define('DB_PASSWORD', '');

        define('CURRENT_DOMAIN', currentDomain());

        Composer::view("app.index", function (){
            $ads = Ads::all();
            $sumArea = 0;
            foreach ($ads as $advertise)
            {
                $sumArea += (int) $advertise->area;
            }
            $usersCount = count(User::all());
            $postsCount = count(Post::all());
            return [
                "sumArea"       => $sumArea,
                "usersCount"    => $usersCount,
                "adsCount"      => count($ads),
                "postsCount"    => $postsCount
            ];
        });

    }
}