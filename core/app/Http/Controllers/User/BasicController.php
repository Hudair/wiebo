<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Uploader;
use App\Models\User\BasicSetting;
use App\Models\User\HomePageText;
use App\Models\User\HomeSection;
use App\Models\User\Language;
use App\Models\User\Member;
use App\Models\User\SEO;
use App\Models\User\WorkProcess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Purifier;
use Response;

class BasicController extends Controller
{
    public function themeVersion()
    {
        $data = BasicSetting::where('user_id',Auth::id())->first();

        return view('user.settings.themes', ['data' => $data]);
    }

    public function updateThemeVersion(Request $request)
    {
        $rule = [
            'theme' => 'required'
        ];

        $validator = Validator::make($request->all(), $rule);

        if ($validator->fails()) {
            return Response::json([
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }

        $data = BasicSetting::where('user_id',Auth::id())->first();
        $data->theme = $request->theme;
        $data->save();

        $request->session()->flash('success', 'Theme updated successfully!');

        return 'success';
    }

    public function favicon(Request $request)
    {
        $data['basic_setting'] = BasicSetting::where('user_id',Auth::id())->first();
        return view('user.settings.favicon',$data);
    }

    public function updatefav(Request $request)
    {
        $img = $request->file('favicon');
        $allowedExts = array('jpg', 'png', 'jpeg', 'ico');

        $rules = [
            'favicon' => [
                function ($attribute, $value, $fail) use ($img, $allowedExts) {
                    if (!empty($img)) {
                        $ext = $img->getClientOriginalExtension();
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg, ico image is allowed");
                        }
                    }
                },
            ],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json(['errors' => $validator->errors(), 'id' => 'favicon']);
        }

        if ($request->hasFile('favicon')) {
            $filename = uniqid() . '.' . $img->getClientOriginalExtension();
            $img->move('assets/front/img/user/', $filename);
            $bss = BasicSetting::where('user_id',Auth::id())->first();
            if(!is_null($bss)){
                if($bss->favicon){
                    @unlink('assets/front/img/user/' . $bss->favicon);
                }
                $bss->favicon = $filename;
                $bss->user_id = Auth::id();
                $bss->save();
            }else {
                $bs = new BasicSetting();
                $bs->favicon = $filename;
                $bs->user_id = Auth::id();
                $bs->save();
            }
        }
        Session::flash('success', 'Favicon update successfully.');
        return "success";
    }

    public function logo(Request $request)
    {
        $data['basic_setting'] = BasicSetting::where('user_id',Auth::id())->first();
        return view('user.settings.logo',$data);
    }

    public function updatelogo(Request $request)
    {
        $img = $request->file('file');
        $allowedExts = array('jpg', 'png', 'jpeg');

        $rules = [
            'file' => [
                function ($attribute, $value, $fail) use ($img, $allowedExts) {
                    if (!empty($img)) {
                        $ext = $img->getClientOriginalExtension();
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg image is allowed");
                        }
                    }
                },
            ],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json(['errors' => $validator->errors(), 'id' => 'logo']);
        }

        if ($request->hasFile('file')) {
            $bss = BasicSetting::where('user_id',Auth::id())->first();
            $filename = uniqid() . '.' . $img->getClientOriginalExtension();
            $img->move('assets/front/img/user/', $filename);
            $bss = BasicSetting::where('user_id',Auth::id())->first();
            if(!is_null($bss)){
                if($bss->logo){
                    @unlink('assets/front/img/user/' . $bss->logo);
                }
                $bss->logo = $filename;
                $bss->user_id = Auth::id();
                $bss->save();
            }else {
                $bs = new BasicSetting();
                $bs->logo = $filename;
                $bs->user_id = Auth::id();
                $bs->save();
            }
        }
        Session::flash('success', 'Logo update successfully.');
        return back();
    }

    public function breadcrumb(Request $request)
    {
        $data['basic_setting'] = BasicSetting::where('user_id',Auth::id())->first();
        return view('user.settings.breadcrumb',$data);
    }

    public function updateBreadcrumb(Request $request)
    {
        $img = $request->file('breadcrumb');
        $allowedExts = array('jpg', 'png', 'jpeg');

        $rules = [
            'breadcrumb' => [
                function ($attribute, $value, $fail) use ($img, $allowedExts) {
                    if (!empty($img)) {
                        $ext = $img->getClientOriginalExtension();
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg image is allowed");
                        }
                    }
                },
            ],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json(['errors' => $validator->errors(), 'id' => 'favicon']);
        }

        if ($request->hasFile('breadcrumb')) {
            $filename = uniqid() . '.' . $img->getClientOriginalExtension();
            $img->move('assets/front/img/user/', $filename);
            $bss = BasicSetting::where('user_id',Auth::id())->first();
            if(!is_null($bss)){
                if($bss->favicon){
                    @unlink('assets/front/img/user/' . $bss->breadcrumb);
                }
                $bss->breadcrumb = $filename;
                $bss->user_id = Auth::id();
                $bss->save();
            }else {
                $bs = new BasicSetting();
                $bs->breadcrumb = $filename;
                $bs->user_id = Auth::id();
                $bs->save();
            }
        }
        Session::flash('success', 'Breadcrumb update successfully.');
        return back();
    }

    public function preloader(Request $request)
    {
        $data['basic_setting'] = BasicSetting::where('user_id',Auth::id())->first();
        return view('user.settings.preloader', $data);
    }

    public function updatepreloader(Request $request)
    {
        $img = $request->file('file');
        $allowedExts = array('jpg', 'png', 'jpeg', 'gif');

        $rules = [
            'file' => [
                function ($attribute, $value, $fail) use ($img, $allowedExts) {
                    if (!empty($img)) {
                        $ext = $img->getClientOriginalExtension();
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg, gif image is allowed");
                        }
                    }
                },
            ],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->getMessageBag()->add('error', 'true');
            return response()->json(['errors' => $validator->errors(), 'id' => 'preloader']);
        }

        if ($request->hasFile('file')) {
            $bss = BasicSetting::where('user_id',Auth::id())->first();
            $filename = uniqid() . '.' . $img->getClientOriginalExtension();
            $img->move('assets/front/img/user/', $filename);
            $bss = BasicSetting::where('user_id',Auth::id())->first();
            if(!is_null($bss)){
                @unlink('assets/front/img/user/' . $bss->preloader);
                $bss->preloader = $filename;
                $bss->user_id = Auth::id();
                $bss->save();
            }else {
                $bs = new BasicSetting();
                $bs->preloader = $filename;
                $bs->user_id = Auth::id();
                $bs->save();
            }
        }

        Session::flash('success', 'Preloader updated successfully.');
        return back();
    }

    public function homePageTextEdit(Request $request){
        $language = Language::where('user_id', Auth::user()->id)->where('code', $request->language)->firstOrFail();
        $text = HomePageText::where('user_id', Auth::user()->id)->where('language_id', $language->id);
        if ($text->count() == 0) {
            $text = new HomePageText;
            $text->language_id = $language->id;
            $text->user_id = Auth::user()->id;
            $text->save();
        } else {
            $text = $text->first();
        }

        $data['home_setting'] = $text;

        return view('user.home.edit',$data);
    }

    public function homePageTextUpdate(Request $request){
        $homeText = HomePageText::query()->where('language_id', $request->language_id)->where('user_id', Auth::user()->id)->firstOrFail();
        foreach ($request->types as $key => $type) {
            if ($type == 'faq_section_image' || $type == 'testimonial_image' || $type == 'about_video_image' ) {
                continue;
            }
            $homeText->$type = Purifier::clean($request[$type]);
        }
        if($request->hasFile('testimonial_image')){
            $testimonialImage = uniqid() . '.' .$request->file('testimonial_image')->getClientOriginalExtension();
            $request->file('testimonial_image')->move('assets/front/img/user/home_settings/', $testimonialImage);
            @unlink('assets/front/img/user/home_settings/' . $homeText->testimonial_image);
            $homeText->testimonial_image = $testimonialImage;
        }
        if($request->hasFile('about_video_image')){
            $aboutVideoImage = uniqid() . '.' .$request->file('about_video_image')->getClientOriginalExtension();
            $request->file('about_video_image')->move('assets/front/img/user/home_settings/', $aboutVideoImage);
            @unlink('assets/front/img/user/home_settings/' . $homeText->about_video_image);
            $homeText->about_video_image = $aboutVideoImage;
        }
        if($request->hasFile('faq_section_image')){
            $faqSectionImage = uniqid() . '.' .$request->file('faq_section_image')->getClientOriginalExtension();
            $request->file('faq_section_image')->move('assets/front/img/user/home_settings/', $faqSectionImage);
            @unlink('assets/front/img/user/home_settings/' . $homeText->faq_section_image);
            $homeText->faq_section_image = $faqSectionImage;
        }
        $homeText->user_id = Auth::id();
        $homeText->language_id = $request->language_id;
        $homeText->save();
        Session::flash('success', 'Home page text updated successfully.');
        return "success";
    }

    public function seo(Request $request)
    {
      // first, get the language info from db
      $language = Language::where('code', $request->language)->where('user_id', Auth::user()->id)->firstOrFail();
      $langId = $language->id;

      // then, get the seo info of that language from db
      $seo = SEO::where('language_id', $langId)->where('user_id', Auth::user()->id);

      if ($seo->count() == 0) {
        // if seo info of that language does not exist then create a new one
        SEO::create($request->except('language_id', 'user_id') + [
          'language_id' => $langId,
          'user_id' => Auth::user()->id
        ]);
      }

      $information['language'] = $language;

      // then, get the seo info of that language from db
      $information['data'] = $seo->first();

      // get all the languages from db
      $information['langs'] = Language::where('user_id', Auth::user()->id)->get();

      return view('user.settings.seo', $information);
    }

    public function updateSEO(Request $request)
    {
      // first, get the language info from db
      $language = Language::where('code', $request->language)->where('user_id', Auth::user()->id)->first();
      $langId = $language->id;

      // then, get the seo info of that language from db
      $seo = SEO::where('language_id', $langId)->where('user_id', Auth::user()->id)->first();

      // else update the existing seo info of that language
      $seo->update($request->all());

      $request->session()->flash('success', 'SEO Informations updated successfully!');

      return redirect()->back();
    }
    public function teamSection(Request $request){
        // first, get the language info from db
        $language = Language::where('code', $request->language)->where('user_id', Auth::user()->id)->first();
        $information['language'] = $language;

        // then, get the testimonial section heading info of that language from db
        $information['data'] = HomePageText::where('language_id', $language->id)->where('user_id', Auth::user()->id)->first();

        // also, get the testimonials of that language from db
        $information['memberInfos'] = Member::where('language_id', $language->id)
            ->where('user_id', Auth::user()->id)
            ->orderby('id', 'desc')
            ->get();

        // get all the languages from db
        $information['langs'] = Language::where('code', $request->language)->where('user_id', Auth::user()->id)->get();

        return view('user.team_section.index', $information);

    }
    public function updateTeamSection(Request $request)
    {
        $lang = Language::where('code', $request->language)->where('user_id', Auth::user()->id)->first();
        $data = HomePageText::where('language_id', $lang->id)->where('user_id', Auth::user()->id)->first();
        $data->team_section_title = $request->team_section_title;
        $data->team_section_subtitle = $request->team_section_subtitle;
        $data->save();
        $request->session()->flash('success', 'Team section updated successfully!');
        return redirect()->back();
    }

    public function homePageAbout(Request $request){
        $language = Language::where('user_id', Auth::user()->id)->where('code', $request->language)->firstOrFail();
        $text = HomePageText::where('user_id', Auth::user()->id)->where('language_id', $language->id);
        if ($text->count() == 0) {
            $text = new HomePageText;
            $text->language_id = $language->id;
            $text->user_id = Auth::user()->id;
            $text->save();
        } else {
            $text = $text->first();
        }

        $data['home_setting'] = $text;
        return view('user.about_section', $data);

    }

    public function homePageAboutUpdate(Request $request) {
        $rules = [
            'about_button_text' => 'nullable|max:50',
            'about_button_url' => 'nullable|max:255',
        ];
        $messages = [
            'about_button_text.max' => 'Button text field can contain maximum 50 characters',
            'about_button_url.max' => 'Button URL field can contain maximum 255 characters'
        ];  
        $request->validate($rules, $messages);
        $homeText = HomePageText::query()->where('language_id', $request->language_id)->where('user_id', Auth::user()->id)->firstOrFail();
        foreach ($request->types as $key => $type) {
            if ($type == 'about_image' || $type == 'about_video_url' || $type == 'about_video_image') {
                continue;
            }
            $homeText->$type = Purifier::clean($request[$type]);
        }
        if($request->hasFile('about_image')) {
            $aboutImage = uniqid() . '.' .$request->file('about_image')->getClientOriginalExtension();
            $request->file('about_image')->move('assets/front/img/user/home_settings/', $aboutImage);
            @unlink('assets/front/img/user/home_settings/' . $homeText->about_image);
            $homeText->about_image = $aboutImage;
        }
        if($request->hasFile('about_video_image')){
            $aboutVidImg = uniqid() . '.' .$request->file('about_video_image')->getClientOriginalExtension();
            $request->file('about_video_image')->move('assets/front/img/user/home_settings/', $aboutVidImg);
            @unlink('assets/front/img/user/home_settings/' . $homeText->about_video_image);
            $homeText->about_video_image = $aboutVidImg;
        }
        if($request->filled('about_video_url')){
            $videoLink = $request->about_video_url;
            if (strpos($videoLink, "&") != false) {
                $videoLink = substr($videoLink, 0, strpos($videoLink, "&"));
            }
        } else {
            $videoLink = NULL;
        }
        $homeText->about_video_url = $videoLink;
        $homeText->user_id = Auth::id();
        $homeText->language_id = $request->language_id;
        $homeText->save();
        Session::flash('success', 'About section updated successfully.');
        return "success";
    }

    public function homePageVideo(Request $request) {
        // first, get the language info from db
        $language = Language::where('code', $request->language)->where('user_id', Auth::user()->id)->first();
        // then, get the testimonial section heading info of that language from db
        $information['data'] = HomePageText::where('language_id', $language->id)->where('user_id', Auth::user()->id)->first();
        return view('user.video_section', $information);

    }
    
    public function homePageUpdateVideo(Request $request)
    {
        $lang = Language::where('code', $request->language)->where('user_id', Auth::user()->id)->first();
        $data = HomePageText::where('language_id', $lang->id)->where('user_id', Auth::user()->id)->first();
        if (empty($data->video_section_image) && !$request->hasFile('video_section_image')) {
            $request->validate(
                ['video_section_image' => 'required|mimes:jpeg,jpg,png|max:1000']
            );
        }
        $request['image_name'] = $data->video_section_image;
        if ($request->hasFile('video_section_image')) {
            $request['image_name'] = Uploader::update_picture('assets/front/img/user/home_settings/', $request->file('video_section_image'), $data->video_section_image);
        }
        $videoLink = $request->video_section_url;
        if (strpos($videoLink, "&") != false) {
            $videoLink = substr($videoLink, 0, strpos($videoLink, "&"));
            $request['video_section_url'] = $videoLink;
        }
        $data->update($request->except(['video_section_image', 'video_section_text']) + [
                'video_section_image' => $request->image_name,
                'video_section_text' => clean($request->video_section_text),
        ]);
        $request->session()->flash('success', 'Video section updated successfully!');
        return redirect()->back();
    }
    public function whyChooseUsSection(Request $request)
    {
        // first, get the language info from db
        $language = Language::where('code', $request->language)->where('user_id',Auth::id())->first();
        // then, get the blog section heading info of that language from db
        $information['data'] = HomePageText::where('language_id', $language->id)->first();
        return view("user.home.why_choose_us_section", $information);
    }

    public function updateWhyChooseUsSection(Request $request, $language)
    {
        $rules = [
            'why_choose_us_section_title' => 'nullable|max:255',
            'why_choose_us_section_subtitle' => 'nullable|max:255',
            'why_choose_us_section_text' => 'nullable',
            'why_choose_us_section_button_text' => 'nullable|max:255',
            'why_choose_us_section_button_url' => 'nullable|max:255'
        ];
        $messages = [
            'why_choose_us_section_title.max' => 'The title field can contain maximum 255 characters',
            'why_choose_us_section_subtitle.max' => 'The subtitle field can contain maximum 255 characters',
            'why_choose_us_section_button_text.max' => 'The button name field can contain maximum 255 characters',
            'why_choose_us_section_button_url.max' => 'The button url field can contain maximum 255 characters',
            'why_choose_us_section_image.max' => 'The image field is required',
            'why_choose_us_section_video_image.max' => 'The video section image field is required',
            'why_choose_us_section_video_url.max' => 'The video section url field can contain maximum 255 characters'
        ];

        $lang = Language::where('code', $language)->where('user_id',Auth::id())->first();
        $userBs = BasicSetting::where('user_id',Auth::id())->first();
        $data = HomePageText::where('language_id', $lang->id)->where('user_id',Auth::id())->first();
        $request['video_image_name'] = $data->why_choose_us_section_video_image;
        $request['image_name'] = $data->why_choose_us_section_image;

        if (empty($data->why_choose_us_section_image) && !$request->hasFile('why_choose_us_section_image')) {
           $rules['why_choose_us_section_image'] = 'nullable|mimes:jpeg,jpg,png';
        }
        if (empty($data->why_choose_us_section_video_image) && !$request->hasFile('why_choose_us_section_video_image') && $userBs->theme === 'home_three') {
            $rules['why_choose_us_section_video_image'] = 'nullable|mimes:jpeg,jpg,png';
        }

        if ($request->hasFile('why_choose_us_section_image')) {
            $request['image_name'] = Uploader::update_picture('assets/front/img/user/home_settings/', $request->file('why_choose_us_section_image'), $data->why_choose_us_section_image);
        }
        if($userBs->theme === 'home_three'){
            $rules['why_choose_us_section_video_url'] = 'nullable';
            if ($request->hasFile('why_choose_us_section_video_image')) {
                $request['video_image_name'] = Uploader::update_picture('assets/front/img/user/home_settings/', $request->file('why_choose_us_section_video_image'), $data->why_choose_us_section_video_image);
            }
        }
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $data->update($request->except(['why_choose_us_section_image', 'why_choose_us_section_text','why_choose_us_section_video_image', 'why_choose_us_section_video_url']) + [
                'why_choose_us_section_image' => $request->image_name,
                'why_choose_us_section_video_image' => $request->video_image_name,
                'why_choose_us_section_text' => clean($request->why_choose_us_section_text),
                'why_choose_us_section_video_url' => (strpos($request->why_choose_us_section_video_url, "&") != false) ? substr($request->why_choose_us_section_video_url, 0, strpos($request->why_choose_us_section_video_url, "&")) : $request->why_choose_us_section_video_url,
            ]);
        $request->session()->flash('success', 'Why choose us section updated successfully!');
        return redirect()->back();
    }
    public function sections(Request $request)
    {
        $data['sections'] = HomeSection::where('user_id',Auth::id())->first();

        return view('user.sections', $data);
    }

    public function updateSection(Request $request)
    {
        $fields = $request->except('_token');
        $sections = HomeSection::where('user_id',Auth::id())->first();
        if(is_null($sections)){
            $sections = new HomeSection;
        }

        foreach ($fields as $key => $value) {
            if ($request->has("$key")) {
                $sections["$key"] = $value;
            }
        }
        $sections->save();

        Session::flash('success', 'Sections customized successfully!');
        return back();
    }

    public function workProcessSection(Request $request)
    {
        // first, get the language info from db
        $language = Language::where('code', $request->language)->where('user_id', Auth::id())->first();

        // then, get the blog section heading info of that language from db
        $information['data'] = HomePageText::where('language_id', $language->id)->where('user_id', Auth::id())->first();

        $information['workProcessInfos'] = WorkProcess::where('language_id', $language->id)
            ->orderby('id', 'desc')
            ->get();

        return view('user.home.work_process_section.index', $information);
    }

    public function updateWorkProcessSection(Request $request){
        $request->validate([
            'work_process_section_title' => 'nullable|max:255',
            'work_process_section_subtitle' => 'nullable|max:255',
            'work_process_section_text' => 'nullable',
        ], [
            'work_process_section_title.required' => 'The title field cannot contain more than 255 characters',
            'work_process_section_subtitle.required' => 'The subtitle field cannot contain more than 255 characters',
            'work_process_section_img.required' => 'The image field is required',
            'work_process_section_video_img.required' => 'The video image field is required',
        ]);

        $lang = Language::where('code', $request->language)->where('user_id',Auth::id())->first();
        $data = HomePageText::where('language_id', $lang->id)->where('user_id',Auth::id())->first();
        $userBs = BasicSetting::where('user_id', Auth::id())->first();

        if ($userBs->theme === 'home_two'){
            if (empty($data->work_process_section_img) && !$request->hasFile('work_process_section_img')) {
                $request->validate(
                    ['work_process_section_img' => 'nullable|mimes:jpeg,jpg,png|max:1000']
                );
            }
            if (empty($data->work_process_section_video_img) && !$request->hasFile('work_process_section_video_img')) {
                $request->validate(
                    ['work_process_section_video_img' => 'nullable|mimes:jpeg,jpg,png|max:1000']
                );
            }
            $request['image_name'] = $data->work_process_section_img;
            $request['video_image_name'] = $data->work_process_section_video_img;
            if ($request->hasFile('work_process_section_img')) {
                $request['image_name'] = Uploader::update_picture('assets/front/img/work_process/', $request->file('work_process_section_img'), $data->work_process_section_img);
            }
            if ($request->hasFile('work_process_section_video_img')) {
                $request['video_image_name'] = Uploader::update_picture('assets/front/img/work_process/', $request->file('work_process_section_video_img'), $data->work_process_section_video_img);
            }
            $data->work_process_section_img = $request->image_name;
            $data->work_process_section_video_img = $request->video_image_name;
            $data->work_process_section_video_url = $request->work_process_section_video_url;
            $data->save();
        }
        $videoLink = $request->work_process_section_video_url;
        if (!empty($videoLink) && (strpos($videoLink, "&") != false)) {
            $videoLink = substr($videoLink, 0, strpos($videoLink, "&"));
        }
        $data->update($request->except(['work_process_section_text','work_process_section_img','work_process_section_video_img', 'work_process_section_video_url']) + [
                'work_process_section_text' => clean($request->work_process_section_text),
                'work_process_section_video_url' => $videoLink
        ]);
        $request->session()->flash('success', 'Work process section updated successfully!');
        return redirect()->back();
    }
}
