@extends('user.layout')
@php
    $userDefaultLang = \App\Models\User\Language::where([
    ['user_id',\Illuminate\Support\Facades\Auth::id()],
    ['is_default',1]
    ])->first();
    $userLanguages = \App\Models\User\Language::where('user_id',\Illuminate\Support\Facades\Auth::id())->get();
@endphp

@includeIf('user.partials.rtl-style')

@section('content')
  <div class="page-header">
    <h4 class="page-title">{{ __('Video Section') }}</h4>
    <ul class="breadcrumbs">
      <li class="nav-home">
        <a href="{{route('admin.dashboard')}}">
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
        <a href="#">{{ __('Video Section') }}</a>
      </li>
    </ul>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-10">
              <div class="card-title">{{ __('Update Video Section') }}</div>
            </div>

            <div class="col-lg-2">
                @if(!is_null($userDefaultLang))
                    @if (!empty($userLanguages))
                        <select name="userLanguage" class="form-control" onchange="window.location='{{url()->current() . '?language='}}'+this.value">
                            <option value="" selected disabled>{{__('Select a Language')}}</option>
                            @foreach ($userLanguages as $lang)
                                <option value="{{$lang->code}}" {{$lang->code == request()->input('language') ? 'selected' : ''}}>{{$lang->name}}</option>
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
                id="videoSecForm"
                action="{{ route('user.home.page.update.video', ['language' => request()->input('language')]) }}"
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
                              src="{{isset($data->video_section_image) ? asset('assets/front/img/user/home_settings/'.$data->video_section_image) : asset('assets/admin/img/noimage.jpg')}}"
                              alt="..." class="img-thumbnail">
                      </div>
                      <input type="file" name="video_section_image" id="image"
                             class="form-control image">
                      <p id="error_video_section_image" class="mb-0 text-danger em"></p>
                  </div>
                <div class="form-group">
                  <label for="">{{ __('Video Section Title') }}</label>
                  <input type="text" class="form-control" name="video_section_title" value="{{ $data->video_section_title ?? '' }}">
                  @if ($errors->has('video_section_title'))
                    <p class="mt-2 mb-0 text-danger">{{ $errors->first('video_section_title') }}</p>
                  @endif
                </div>

                @if ($userBs->theme != 'home_two')
                  <div class="form-group">
                    <label for="">{{ __('Video Section Subtitle') }}</label>
                    <input type="text" class="form-control" name="video_section_subtitle" value="{{ $data->video_section_subtitle ?? '' }}">
                    @if ($errors->has('video_section_subtitle'))
                      <p class="mt-2 mb-0 text-danger">{{ $errors->first('video_section_subtitle') }}</p>
                    @endif
                  </div>
                    <div class="form-group">
                        <label for="">{{ __('Video Section Text') }}</label>
                        <textarea class="form-control" name="video_section_text" rows="3" cols="80" >{{ $data->video_section_text ?? null}}</textarea>
                        @if ($errors->has('video_section_text'))
                            <p class="mt-2 mb-0 text-danger">{{ $errors->first('video_section_text') }}</p>
                        @endif
                    </div>
                  <div class="form-group">
                    <label for="">{{ __('Video Section Button Text') }}</label>
                    <input type="text" class="form-control" name="video_section_button_text" value="{{ $data->video_section_button_text ?? '' }}">
                    @if ($errors->has('video_section_button_text'))
                        <p class="mt-2 mb-0 text-danger">{{ $errors->first('video_section_button_text') }}</p>
                    @endif
                  </div>
                  <div class="form-group">
                      <label for="">{{ __('Video Section Button URL') }}</label>
                      <input type="text" class="form-control" name="video_section_button_url" value="{{ $data->video_section_button_url ?? '' }}">
                      @if ($errors->has('video_section_button_url'))
                          <p class="mt-2 mb-0 text-danger">{{ $errors->first('video_section_button_url') }}</p>
                      @endif
                  </div>
                      
                  @endif

                  <div class="form-group">
                      <label for="">{{ __('Video URL') }}</label>
                      <input type="text" class="form-control" name="video_section_url" value="{{ $data->video_section_url ?? '' }}">
                      @if ($errors->has('video_section_url'))
                          <p class="mt-2 mb-0 text-danger">{{ $errors->first('video_section_url') }}</p>
                      @endif
                  </div>
              </form>
            </div>
          </div>
        </div>

        <div class="card-footer">
          <div class="row">
            <div class="col-12 text-center">
              <button type="submit" form="videoSecForm" class="btn btn-success">
                {{ __('Update') }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
