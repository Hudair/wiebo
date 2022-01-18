<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Language extends Model
{
    public $table = "user_languages";

    protected $fillable = [
        'id',
        'name',
        'is_default',
        'code',
        'rtl',
        'user_id',
        'keywords'
    ];

    public function services(){
        return $this->hasMany('App\Models\User\UserService','lang_id')->where('user_id',Auth::id());
    }

    public function contacts(){
        return $this->hasOne('App\Models\User\UserContact','language_id')->where('user_id',Auth::id());
    }

    public function quick_links(){
        return $this->hasMany('App\Models\User\FooterQuickLink','language_id')->where('user_id',Auth::id());
    }

    public function footer_texts(){
        return $this->hasMany('App\Models\User\FooterText','language_id')->where('user_id',Auth::id());
    }

    public function hero_static(){
        return $this->hasOne('App\Models\User\HeroStatic','language_id')->where('user_id',Auth::id());
    }

    public function hero_sliders(){
        return $this->hasMany('App\Models\User\HeroSlider','language_id')->where('user_id',Auth::id());
    }

    public function faqs(){
        return $this->hasMany('App\Models\User\FAQ','language_id')->where('user_id',Auth::id());
    }
    public function testimonials(){
        return $this->hasMany('App\Models\User\UserTestimonial','lang_id')->where('user_id',Auth::id());
    }
    public function blogs(){
        return $this->hasMany('App\Models\User\Blog')->where('user_id',Auth::id());
    }
    public function blog_categories(){
        return $this->hasMany('App\Models\User\BlogCategory')->where('user_id',Auth::id());
    }
    public function skills(){
        return $this->hasMany('App\Models\User\Skill')->where('user_id',Auth::id());
    }
    public function achievements(){
        return $this->hasMany('App\Models\User\CounterInformation')->where('user_id',Auth::id());
    }
    public function portfolios(){
        return $this->hasMany('App\Models\User\Portfolio')->where('user_id',Auth::id());
    }
    public function pages(){
        return $this->hasMany('App\Models\User\Page')->where('user_id',Auth::id());
    }
    public function menus(){
        return $this->hasMany('App\Models\User\Menu')->where('user_id',Auth::id());
    }
    public function portfolio_categories(){
        return $this->hasMany('App\Models\User\PortfolioCategory')->where('user_id',Auth::id());
    }
    public function seos(){
        return $this->hasMany('App\Models\User\Seo','language_id')->where('user_id',Auth::id());
    }
    public function jobs(){
        return $this->hasMany('App\Models\User\Job','language_id')->where('user_id',Auth::id());
    }
    public function jcategories(){
        return $this->hasMany('App\Models\User\Jcategory','language_id')->where('user_id',Auth::id());
    }
    public function home_page_texts(){
        return $this->hasMany('App\Models\User\HomePageText','language_id')->where('user_id',Auth::id());
    }
    public function processes(){
        return $this->hasMany('App\Models\User\WorkProcess','language_id')->where('user_id',Auth::id());
    }
    public function teams(){
        return $this->hasMany('App\Models\User\Member','language_id')->where('user_id',Auth::id());
    }
    public function quote_inputs(){
        return $this->hasMany('App\Models\User\QuoteInput','language_id')->where('user_id',Auth::id());
    }

}
