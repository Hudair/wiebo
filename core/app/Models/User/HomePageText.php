<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class HomePageText extends Model
{
    public $table = 'user_home_page_texts';

    protected $fillable = [
        'about_image',
        'about_keyword',
        'about_title',
        'about_video_image',
        'about_video_url',
        'technical_image',
        'technical_keyword',
        'technical_title',
        'technical_content',
        'service_keyword',
        'service_title',
        'experience_keyword',
        'experience_title',
        'achievement_image',
        'achievement_keyword',
        'achievement_title',
        'portfolio_keyword',
        'portfolio_title',
        'view_all_portfolio_text',
        'testimonial_keyword',
        'testimonial_title',
        'testimonial_image',
        'team_section_title',
        'team_section_subtitle',
        'blog_keyword',
        'blog_title',
        'view_all_blog_text',
        'contact_title',
        'contact_title',
        'contact_subtitle',
        'contact_button_text',
        'video_section_image',
        'video_section_title',
        'video_section_subtitle',
        'video_section_text',
        'video_section_button_text',
        'video_section_button_url',
        'video_section_url',
        'why_choose_us_section_image',
        'why_choose_us_section_title',
        'why_choose_us_section_subtitle',
        'why_choose_us_section_text',
        'why_choose_us_section_button_text',
        'why_choose_us_section_button_url',
        'why_choose_us_section_video_image',
        'why_choose_us_section_video_url',
        'work_process_section_title',
        'work_process_section_subtitle',
        'work_process_section_text',
        'work_process_section_img',
        'work_process_section_video_img',
        'work_process_section_video_url',
        'quote_section_title',
        'quote_section_subtitle',
        'quote_section_image'
    ];
    public function language() {
        return $this->belongsTo('App\Models\User\Language','language_id');
    }
}
