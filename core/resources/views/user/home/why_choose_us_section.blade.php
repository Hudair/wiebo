@extends('user.layout')

@php
    $userLanguages = \App\Models\User\Language::where('user_id',\Illuminate\Support\Facades\Auth::id())->get();
    $userDefaultLang = \App\Models\User\Language::where([
    ['user_id',\Illuminate\Support\Facades\Auth::id()],
    ['is_default',1]
    ])->first();
@endphp

@includeIf('user.partials.rtl-style')

@section('content')
    <div class="page-header">
        <h4 class="page-title">{{ __('Why Choose Us Section') }}</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{route('user-dashboard')}}">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">{{ __('Home Page') }}</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">{{ __('Why Choose Us Section') }}</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="card-title">{{ __('Update Why Choose Us Section') }}</div>
                        </div>
                        <div class="col-lg-2">
                            @if(!is_null($userDefaultLang))
                                @if (!empty($userLanguages))
                                    <select name="userLanguage" class="form-control"
                                            onchange="window.location='{{url()->current() . '?language='}}'+this.value">
                                        <option value="" selected disabled>{{__('Select a Language')}}</option>
                                        @foreach ($userLanguages as $lang)
                                            <option
                                                value="{{$lang->code}}" {{$lang->code == request()->input('language') ? 'selected' : ''}}>{{$lang->name}}</option>
                                        @endforeach
                                    </select>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body pt-5 pb-5">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-3">
                            <form
                                id="whyChooseUsSecForm"
                                action="{{ route('user.home_page.update_why_choose_us_section', ['language' => request()->input('language')]) }}"
                                method="POST"
                                enctype="multipart/form-data"
                            >
                                @csrf
                                <div class="form-group">
                                    <div class="col-12 mb-2">
                                        <label for="image"><strong>{{__('Background Image')}}</strong></label>
                                    </div>
                                    <div class="col-md-12 showImage mb-3">
                                        <img
                                            src="{{isset($data->why_choose_us_section_image) ? asset('assets/front/img/user/home_settings/'.$data->why_choose_us_section_image) : asset('assets/admin/img/noimage.jpg')}}"
                                            alt="..." class="img-thumbnail">
                                    </div>
                                    <input type="file" name="why_choose_us_section_image" id="image"
                                           class="form-control image">
                                    <p id="error_why_choose_us_section_image" class="mb-0 text-danger em"></p>
                                </div>
                                <div class="form-group">
                                    <label for="">{{ __('Why Choose Us Section Title') }}</label>
                                    <input type="text" class="form-control" name="why_choose_us_section_title"
                                           value="{{ $data->why_choose_us_section_title ?? '' }}"
                                           placeholder="{{__('Enter title')}}">
                                    @if ($errors->has('why_choose_us_section_title'))
                                        <p class="mt-2 mb-0 text-danger">{{ $errors->first('why_choose_us_section_title') }}</p>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="">{{ __('Why Choose Us Section Subtitle') }}</label>
                                    <input type="text" class="form-control" name="why_choose_us_section_subtitle"
                                           value="{{ $data->why_choose_us_section_subtitle ?? '' }}"
                                           placeholder="{{__('Enter subtitle')}}">
                                    @if ($errors->has('why_choose_us_section_subtitle'))
                                        <p class="mt-2 mb-0 text-danger">{{ $errors->first('why_choose_us_section_subtitle') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">{{ __('Why Choose Us Section Text') }}</label>
                                    <textarea class="form-control" name="why_choose_us_section_text" rows="3" cols="80"
                                              placeholder="{{__('Enter text')}}">{{ $data->why_choose_us_section_text??null}}</textarea>
                                    @if ($errors->has('why_choose_us_section_text'))
                                        <p class="mt-2 mb-0 text-danger">{{ $errors->first('why_choose_us_section_text') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">{{ __('Why Choose Us Section Button Text') }}</label>
                                    <input type="text" class="form-control" name="why_choose_us_section_button_text"
                                           value="{{ $data->why_choose_us_section_button_text ?? '' }}"
                                           placeholder="{{__('Enter button text')}}">
                                    @if ($errors->has('why_choose_us_section_button_text'))
                                        <p class="mt-2 mb-0 text-danger">{{ $errors->first('why_choose_us_section_button_text') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">{{ __('Why Choose Us Section Button URL') }}</label>
                                    <input type="text" class="form-control" name="why_choose_us_section_button_url"
                                           value="{{ $data->why_choose_us_section_button_url ?? '' }}"
                                           placeholder="{{__('Enter button url')}}">
                                    @if ($errors->has('why_choose_us_section_button_url'))
                                        <p class="mt-2 mb-0 text-danger">{{ $errors->first('why_choose_us_section_button_url') }}</p>
                                    @endif
                                </div>
                                @if($userBs->theme === "home_three")
                                    <div class="form-group">
                                        <div class="col-12 mb-2">
                                            <label for="logo"><strong>{{__('Why choose us video section image')}}</strong></label>
                                        </div>
                                        <div class="col-md-12 showAboutVideoImage mb-3">
                                            <img
                                                src="{{!empty($data->why_choose_us_section_video_image) ? asset('assets/front/img/user/home_settings/'.$data->why_choose_us_section_video_image) : asset('assets/admin/img/noimage.jpg')}}"
                                                alt="..." class="img-thumbnail">
                                        </div>
                                        <input type="file" name="why_choose_us_section_video_image"
                                               id="about_video_image"
                                               class="form-control ltr">
                                        @if ($errors->has('why_choose_us_section_video_image'))
                                            <p class="mt-2 mb-0 text-danger">{{ $errors->first('why_choose_us_section_video_image') }}</p>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="">{{__('Video URL')}}</label>
                                        <input type="text" class="form-control ltr" name="why_choose_us_section_video_url"
                                               placeholder="{{__('Enter video url')}}"
                                               value="{{ $data->why_choose_us_section_video_url ?? '' }}">
                                        @if ($errors->has('why_choose_us_section_video_url'))
                                            <p class="mt-2 mb-0 text-danger">{{ $errors->first('why_choose_us_section_video_url') }}</p>
                                        @endif
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-12 text-center">
                            <button type="submit" form="whyChooseUsSecForm" class="btn btn-success">
                                {{ __('Update') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('assets/admin/js/home-sections.js')}}"></script>
@endsection
