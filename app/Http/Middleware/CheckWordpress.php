<?php

namespace App\Http\Middleware;

use Auth;
use App\User;
use Closure;

class CheckWordpress
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $dotenv = \Dotenv\Dotenv::create(__DIR__."/../../../");
        $dotenv->load();
        $wpLoadFile = env('WORDPRESS_PATH').'wp-load.php';
        if(env('WORDPRESS') && file_exists($wpLoadFile)){
            define( 'WP_USE_THEMES', false );
            include $wpLoadFile;
            if (!is_user_logged_in())
                return redirect(env('WORDPRESS_LOGIN_URL'));
            $user = wp_get_current_user();
            $laravelUser = User::where('email', $user->data->user_email)->first();
            if (!$laravelUser)
                $laravelUser = User::create([
                    'email'=> $user->data->user_email,
                    'name'=> $user->data->user_email
                ]);
            Auth::login($laravelUser);
        }
        return $next($request);
    }
}