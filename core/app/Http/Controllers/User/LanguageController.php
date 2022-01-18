<?php

namespace App\Http\Controllers\User;

use App\Models\User\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;


class LanguageController extends Controller
{
    public function index($lang = false)
    {
        $data['languages'] = Language::where('user_id', Auth::id())->get();
        return view('user.language.index', $data);
    }


    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'code' => ['required',
                function ($attribute, $value, $fail) {
                    $language = Language::where([
                        ['code', $value],
                        ['user_id', Auth::id()]
                    ])->get();
                    if ($language->count() > 0) {
                        $fail(':attribute already taken');
                    }
                },
            ],
            'direction' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $deLang = Language::first();

        $in['name'] = $request->name;
        $in['code'] = $request->code;
        $in['rtl'] = $request->direction;
        $in['keywords'] = $deLang->keywords;
        $in['user_id'] = Auth::id();
        if (Language::where([
                ['is_default', 1],
                ['user_id', Auth::id()]
            ])->count() > 0) {
            $in['is_default'] = 0;
        } else {
            $in['is_default'] = 1;
        }
        Language::create($in);
        Session::flash('success', 'Language added successfully!');
        return "success";
    }

    public function edit($id)
    {
        if ($id > 0) {
            $data['language'] = Language::where('user_id', Auth::user()->id)->where('id', $id)->firstOrFail();
        }
        $data['id'] = $id;
        return view('user.language.edit', $data);
    }


    public function update(Request $request)
    {
        $language = Language::where('user_id', Auth::user()->id)->where('id', $request->language_id)->firstOrFail();

        $rules = [
            'name' => 'required|max:255',
            'code' => [
                'required',
                'max:255',
                Rule::unique('user_languages')->ignore($language->id),
            ],
            'direction' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errmsgs = $validator->getMessageBag()->add('error', 'true');
            return response()->json($validator->errors());
        }

        $language->name = $request->name;
        $language->code = $request->code;
        $language->rtl = $request->direction;
        $language->user_id = Auth::id();
        $language->save();

        Session::flash('success', 'Language updated successfully!');
        return "success";
    }

    public function editKeyword($id)
    {

        $data['la'] = Language::where('user_id', Auth::user()->id)->where('id', $id)->firstOrFail();
        $data['keywords'] = json_decode($data['la']->keywords, true);
        return view('user.language.edit-keyword', $data);

    }

    public function updateKeyword(Request $request, $id)
    {
        $lang = Language::where('user_id', Auth::user()->id)->where('id', $id)->firstOrFail();
        $keywords = $request->except('_token');
        $lang->keywords = json_encode($keywords);
        $lang->save();
        return back()->with('success', 'Updated Successfully');
    }


    public function delete($id)
    {

        $la = Language::where('user_id', Auth::user()->id)->where('id', $id)->firstOrFail();
        if ($la->is_default == 1) {
            return back()->with('warning', 'Default language cannot be deleted!');
        }
        if (session()->get('user_lang') == $la->code) {
            session()->forget('user_lang');
        }

        if ($la->testimonials()->count() > 0) {
            $testimonials = $la->testimonials()->get();
            foreach ($testimonials as $key => $tstm) {
                @unlink('assets/front/img/user/testimonials/' . $tstm->image);
                $tstm->delete();
            }
        }


        if ($la->skills()->count() > 0) {
            $la->skills()->delete();
        }

        if ($la->menus()->count() > 0) {
            $la->menus()->delete();
        }

        if ($la->pages()->count() > 0) {
            $la->pages()->delete();
        }

        if ($la->services()->count() > 0) {
            $services = $la->services()->get();
            foreach ($services as $key => $service) {
                @unlink('assets/front/img/user/services/' . $service->image);
                $service->delete();
            }
        }

        if ($la->seos()->count() > 0) {
            $la->seos()->delete();
        }

        if ($la->achievements()->count() > 0) {
            $la->achievements()->delete();
        }

        if ($la->portfolios()->count() > 0) {
            $portfolios = $la->portfolios()->get();
            foreach ($portfolios as $key => $portfolio) {
                @unlink('assets/front/img/user/portfolios/' . $portfolio->image);
                if ($portfolio->portfolio_images()->count() > 0) {
                    foreach ($portfolio->portfolio_images as $key => $pi) {
                        @unlink('assets/front/img/user/portfolios/' . $pi->image);
                        $pi->delete();
                    }
                }
                $portfolio->delete();
            }
        }

        if ($la->portfolio_categories()->count() > 0) {
            $la->portfolio_categories()->delete();
        }

        if ($la->home_page_texts()->count() > 0) {
            $homeTexts = $la->home_page_texts()->get();
            foreach ($homeTexts as $key => $homeText) {
                @unlink('assets/front/img/user/home_settings/' . $homeText->about_image);
                @unlink('assets/front/img/user/home_settings/' . $homeText->about_video_image);
                @unlink('assets/front/img/user/home_settings/' . $homeText->testimonial_image);
                @unlink('assets/front/img/user/home_settings/'. $homeText->video_section_image);
                @unlink('assets/front/img/user/home_settings/'. $homeText->why_choose_us_section_image);
                @unlink('assets/front/img/user/home_settings/'. $homeText->why_choose_us_section_video_image);
                @unlink('assets/front/img/work_process/'.$homeText->work_process_section_img);
                @unlink('assets/front/img/work_process/'.$homeText->work_process_section_video_img);
                @unlink('assets/front/img/user/home_settings/'. $homeText->quote_section_image);

                $homeText->delete();
            }
        }

        if ($la->jobs()->count() > 0) {
            $la->jobs()->delete();
        }

        if ($la->jcategories()->count() > 0) {
            $la->jcategories()->delete();
        }

        if ($la->teams()->count() > 0) {
            $teams = $la->teams()->get();
            foreach ($teams as $key => $team) {
                @unlink('/assets/front/img/user/team/'.$team->image);
                $team->delete();
            }
        }

        if ($la->quote_inputs()->count() > 0) {
            $quote_inputs = $la->quote_inputs()->get();
            foreach ($quote_inputs as $key => $input) {
                if ($input->quote_input_options()->count() > 0) {
                    $input->quote_input_options()->delete();
                }
                $input->delete();
            }
        }

        if ($la->processes()->count() > 0) {
            $la->processes()->delete();
        }

        if ($la->blog_categories()->count() > 0) {
            $la->blog_categories()->delete();
        }
        

        if ($la->blogs()->count() > 0) {
            $blogs = $la->blogs()->get();
            foreach ($blogs as $key => $blog) {
                @unlink('assets/front/img/user/blogs/' . $blog->image);
                $blog->delete();
            }
        }

        if ($la->faqs()->count() > 0) {
            $la->faqs()->delete();
        }

        if ($la->quick_links()->count() > 0) {
            $la->quick_links()->delete();
        }

        if ($la->footer_texts()->count() > 0) {
            $la->footer_texts()->delete();
        }

        if ($la->hero_static()->count() > 0) {
            $static = $la->hero_static;
            @unlink('assets/front/img/hero_static/' . $static->img);
            $static->delete();
        }
            
    
        if ($la->hero_sliders()->count() > 0) {
            $sliders = $la->hero_sliders()->get();
            foreach ($sliders as $key => $slider) {
                @unlink('assets/front/img/hero_slider/'.$slider->img);
                $slider->delete();
            }
        }

        // if the the deletable language is the currently selected language in frontend then forget the selected language from session
        session()->forget('lang');
        $la->delete();
        return back()->with('success', 'Language Delete Successfully');
    }


    public function default(Request $request, $id)
    {
        Language::where('is_default', 1)->where('user_id', Auth::user()->id)->update(['is_default' => 0]);
        $lang = Language::find($id);
        $lang->is_default = 1;
        $lang->save();
        return back()->with('success', $lang->name . ' language is set as default.');
    }

    public function rtlcheck($langid)
    {
        if ($langid > 0) {
            $lang = Language::where('user_id', Auth::user()->id)->where('id', $langid)->firstOrFail();
        } else {
            return 0;
        }
        return $lang->rtl;
    }
}
