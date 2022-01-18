<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Uploader;
use App\Models\User\HeroStatic;
use App\Models\User\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HeroStaticController extends Controller
{
    public function staticVersion(Request $request)
    {
        $language = Language::where('code', $request->language)->where('user_id', Auth::id())->first();

        $information['language'] = $language;

        // then, get the static version info of that language from db
        $information['data'] = HeroStatic::where('language_id', $language->id)->first();

        return view('user.home.hero_section.static_version', $information);
    }

    public function updateStaticInfo(Request $request, $language): RedirectResponse
    {
        $rules = [
            'title' => 'required',
            'subtitle' => 'required',
            'btn_name' => 'required',
            'btn_url' => 'required'
        ];
        $messages = [
            'img.required' => 'The image field is required',
            'title.required' => 'The title field is required.',
            'subtitle.required' => 'The subtitle field is required.',
            'btn_name.required' => 'The button name field is required.',
            'btn_url.required' => 'The button url field is required.'
        ];

        $lang = Language::where('code', $language)->where('user_id', Auth::id())->first();
        $data = HeroStatic::where('language_id', $lang->id)->where('user_id', Auth::id())->first();
        if (empty($data->img) && !$request->hasFile('img')) {
            $rules['img'] = 'required|mimes:jpeg,jpg,png,svg|max:1000';
        }
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        if (!is_null($data)) {
            $request['image_name'] = $data->img;
            if ($request->hasFile('img')) {
                $request['image_name'] = Uploader::update_picture('assets/front/img/hero_static/', $request->file('img'), $data->img);
            }
            $data->update($request->except('img') + [
                    'img' => $request->image_name
                ]);
        } else {
            $data = new HeroStatic;
            if ($request->hasFile('img')) {
                $request['image_name'] = Uploader::update_picture('assets/front/img/hero_static/', $request->file('img'), $data->img);
            }
            $data->create(
                $request->except('img', 'user_id', 'language_id') + [
                    'img' => $request->image_name,
                    'user_id' => Auth::id(),
                    'language_id' => $lang->id
                ]
            );
        }
        $request->session()->flash('success', 'Static info updated successfully!');
        return redirect()->back();
    }
}

