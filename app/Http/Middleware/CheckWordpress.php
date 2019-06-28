<?php

namespace App\Http\Middleware;

use Auth;
use App\User;
use Closure;

class CheckWordpress {

    private function getUserWithWpUserId($wpUserId)
    {
        return User::where('wp_user_id', $wpUserId)->first();
    }

    private function getUserWithEmail($email)
    {
        return User::where('email', $email)->first();
    }

    private function getNewUser($wpUserId, $email)
    {
        return User::create([
            'name' => $email,
            'email' => $email,
            'wp_user_id' => $wpUserId
        ]);
    }

    private function getUser($wpUserId, $email)
    {
        if ($user = $this->getUserWithWpUserId($wpUserId))
            return $user;
        if ($user = $this->getUserWithEmail($email)) {
            $user->update(['wp_user_id' => $wpUserId]);
            return $user;
        }
        return $this->getNewUser($wpUserId, $email);
    }

    private function loadDotEnv()
    {
        $dotenv = \Dotenv\Dotenv::create(__DIR__ . "/../../../");
        $dotenv->load();
    }

    private function getWpLoadFile()
    {
        return env('WORDPRESS_PATH') . 'wp-load.php';
    }

    private function validWordpressIntegration()
    {
        return (env('WORDPRESS') && file_exists($this->getWpLoadFile()));
    }

    private function initWordpressIntegration()
    {
        if (!defined('WP_USE_THEMES')) define('WP_USE_THEMES', false);
        include $this->getWpLoadFile();
    }

    private function loginWpUser($wpUserObject)
    {
        $user = $this->getUser($wpUserObject->ID, $wpUserObject->user_email);
        $guest = Auth::guest();
        $diffUser = !$guest && Auth::user()->id != $user->id;
        if ($guest || $diffUser) Auth::login($user);
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->loadDotEnv();
        if (!$this->validWordpressIntegration())
            return $next($request);
        $this->initWordpressIntegration();
        if (!is_user_logged_in())
            return redirect(env('WORDPRESS_LOGIN_URL'));
        $user = wp_get_current_user();
        $this->loginWpUser($user);
        return $next($request);
    }
}