<?php
namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Helpers\Account\Values;

class User extends ApplicationModel implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "name", "email", "password", "avatar", "wp_user_id"
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        "remember_token",
    ];

    public function avatar()
    {
        if ($this->avatar != null) {
            return Auth::user()->avatar;
        }
        return url("/images/no_image.png");
    }

    /**
     * Get the comments for the blog post.
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|null
     */
    public function categoryOf(string $type)
    {
        if ($type == "question") {
            return $this->questions();
        } elseif ($type == "test") {
            return $this->tests();
        }
        return null;
    }

    /**
     * Return hasMany if user has questions
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function questions()
    {
        return $this->hasMany("App\Question", "user_id");
    }

    /**
     * Return hasMany if user has tests
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function tests()
    {
        return $this->hasMany("App\Test", "user_id");
    }

    /**
     * Return hasMany if user has questionCategories
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function questionCategories()
    {
        return $this->hasMany("App\QuestionCategory", "user_id");
    }

    /**
     * Return hasMany if user has testCategories
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function testCategories()
    {
        return $this->hasMany("App\TestCategory", "user_id");
    }

    public function createSocialAccount(ProviderUser $provUser){
        $account = new SocialAccount([
            "provider_user_id" => $provUser->getId(),
            "provider" => "facebook"
        ]);
        $account->user()->associate($this);
        $account->save();
        return $account;
    }
}
