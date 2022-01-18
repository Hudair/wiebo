@extends('user.layout')

@php
    $userLanguages = \App\Models\User\Language::where('user_id',\Illuminate\Support\Facades\Auth::id())->get();
    $userDefaultLang = \App\Models\User\Language::where([
    ['user_id',\Illuminate\Support\Facades\Auth::id()],
    ['is_default', 1]
    ])->first();
@endphp

@includeIf('user.partials.rtl-style')


@php
    $permissions = \App\Http\Helpers\UserPermissionHelper::packagePermission(Auth::user()->id);
    $permissions = json_decode($permissions, true);
@endphp

@section('content')
    <div class="page-header">
        <h4 class="page-title">{{__('Home Sections')}}</h4>
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
                <a href="#">{{__('Home Sections')}}</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card-title d-inline-block">{{__('Home Sections')}}</div>
                        </div>
                        <div class="col-lg-3 offset-lg-3">
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
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            <form id="ajaxForm" action="{{route('user.home.page.text.update')}}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{$home_setting->id}}">
                                <input type="hidden" name="language_id" value="{{$home_setting->language_id}}">
                                
                                @if ($userBs->theme == 'home_one' && (!empty($permissions) && in_array('Skill', $permissions)))
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <br>
                                                <h3 class="text-warning">{{__('Skills Section')}}</h3>
                                                <hr class="border-top">
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 pr-0">
                                                    <div class="form-group">
                                                        <label for="">{{__('Skills Section Title')}}</label>
                                                        <input type="hidden" name="types[]" value="skills_title">
                                                        <input type="text" class="form-control" name="skills_title"
                                                               placeholder="{{__('Enter skills title')}}" value="{{$home_setting->skills_title}}">
                                                        <p id="errskills_title" class="mb-0 text-danger em"></p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 pl-0">
                                                    <div class="form-group">
                                                        <label for="">{{__('Skills Section Subtitle')}}</label>
                                                        <input type="hidden" name="types[]" value="skills_subtitle">
                                                        <input type="text" class="form-control" name="skills_subtitle" placeholder="{{__('Enter skills subtitle')}}" value="{{$home_setting->skills_subtitle}}">
                                                        <p id="errskills_subtitle" class="mb-0 text-danger em"></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="">{{__('Skills Section Content')}}</label>
                                                <input type="hidden" name="types[]" value="skills_content">
                                                <textarea class="form-control" name="skills_content" rows="5" placeholder="">{{ $home_setting->skills_content }}</textarea>
                                                <p id="errskills_content" class="mb-0 text-danger em"></p>
                                            </div>
                                        </div>
                                    </div>
                                @endif


                                @if (!empty($permissions) && in_array('Service', $permissions))
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <br>
                                                <h3 class="text-warning">{{__('Service Section')}}</h3>
                                                <hr class="border-top">
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 pr-0">
                                                    <div class="form-group">
                                                        <label for="">{{__('Service Section Title')}}</label>
                                                        <input type="hidden" name="types[]" value="service_title">
                                                        <input type="text" class="form-control" name="service_title"
                                                               placeholder="{{__('Enter service title')}}" value="{{$home_setting->service_title}}">
                                                        <p id="errservice_title" class="mb-0 text-danger em"></p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 pl-0">
                                                    <div class="form-group">
                                                        <label for="">{{__('Service Section Subtitle')}}</label>
                                                        <input type="hidden" name="types[]" value="service_subtitle">
                                                        <input type="text" class="form-control" name="service_subtitle" placeholder="{{__('Enter service subtitle')}}" value="{{$home_setting->service_subtitle}}">
                                                        <p id="errservice_subtitle" class="mb-0 text-danger em"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if (!empty($permissions) && in_array('Portfolio', $permissions))
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <br>
                                                <h3 class="text-warning">{{__('Portfolio Section')}}</h3>
                                                <hr class="border-top">
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 pr-0">
                                                    <div class="form-group">
                                                        <label for="">{{__('Portfolio Section Title')}}</label>
                                                        <input type="hidden" name="types[]" value="portfolio_title">
                                                        <input type="text" class="form-control" name="portfolio_title"
                                                               placeholder="{{__('Enter portfolio title')}}"
                                                               value="{{$home_setting->portfolio_title}}">
                                                        <p id="errportfolio_title" class="mb-0 text-danger em"></p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 pl-0">
                                                    <div class="form-group">
                                                        <label for="">{{__('Portfolio Section Subtitle')}}</label>
                                                        <input type="hidden" name="types[]" value="portfolio_subtitle">
                                                        <input type="text" class="form-control"
                                                               name="portfolio_subtitle"
                                                               placeholder="{{__('Enter Portfolio Subtitle')}}"
                                                               value="{{$home_setting->portfolio_subtitle}}">
                                                        <p id="errportfolio_subtitle" class="mb-0 text-danger em"></p>
                                                    </div>
                                                </div>
                                            </div>
                                            @if(isset($userBs->theme) && ($userBs->theme === 'home_two' || $userBs->theme === 'home_three'))
                                                <div class="row">
                                                    <div class="col-lg-6 pr-0">
                                                        <div class="form-group">
                                                            <label for="">{{__('View All Portfolio Text')}}</label>
                                                            <input type="hidden" name="types[]"
                                                                   value="view_all_portfolio_text">
                                                            <input type="text" class="form-control"
                                                                   name="view_all_portfolio_text"
                                                                   placeholder="{{__('Enter view all portfolio text')}}"
                                                                   value="{{$home_setting->view_all_portfolio_text}}">
                                                            <p id="errview_all_portfolio_text"
                                                               class="mb-0 text-danger em"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                @if (!empty($permissions) && in_array('Testimonial', $permissions))
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <br>
                                                <h3 class="text-warning">{{__('Testimonial Section')}}</h3>
                                                <hr class="border-top">
                                            </div>
                                            <div class="form-group">
                                                <div class="col-12 mb-2">
                                                    <label for="logo"><strong>{{__('Testimonial Image')}}</strong></label>
                                                </div>
                                                <div class="col-md-12 showTestimonialImage mb-3">
                                                    <img src="{{$home_setting->testimonial_image ? asset('assets/front/img/user/home_settings/'.$home_setting->testimonial_image) : asset('assets/admin/img/noimage.jpg')}}" alt="..." class="img-thumbnail">
                                                </div>
                                                <input type="hidden" name="types[]" value="testimonial_image">
                                                <input type="file" name="testimonial_image" id="testimonial_image" class="form-control ltr">
                                                <p id="errtestimonial_image" class="mb-0 text-danger em"></p>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 pr-0">
                                                    <div class="form-group">
                                                        <label for="">{{__('Testimonial Section Title')}}</label>
                                                        <input type="hidden" name="types[]" value="testimonial_title">
                                                        <input type="text" class="form-control" name="testimonial_title" placeholder="" value="{{$home_setting->testimonial_title}}">
                                                        <p id="errtestimonial_title" class="mb-0 text-danger em"></p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 pl-0">
                                                    <div class="form-group">
                                                        <label for="">{{__('Testimonial Section Subtitle')}}</label>
                                                        <input type="hidden" name="types[]"
                                                               value="testimonial_subtitle">
                                                        <input type="text" class="form-control"
                                                               name="testimonial_subtitle" placeholder=""
                                                               value="{{$home_setting->testimonial_subtitle}}">
                                                        <p id="errtestimonial_subtitle" class="mb-0 text-danger em"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if (($userBs->theme != 'home_three') && (!empty($permissions) && in_array('Blog', $permissions)))
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <br>
                                                <h3 class="text-warning">{{__('Blog Section')}}</h3>
                                                <hr class="border-top">
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 pr-0">
                                                    <div class="form-group">
                                                        <label for="">{{__('Blog Section Title')}}</label>
                                                        <input type="hidden" name="types[]" value="blog_title">
                                                        <input type="text" class="form-control" name="blog_title" placeholder="{{__('Enter blog keyword')}}" value="{{$home_setting->blog_title}}">
                                                        <p id="errblog_title" class="mb-0 text-danger em"></p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 pl-0">
                                                    <div class="form-group">
                                                        <label for="">{{__('Blog Section Subtitle')}}</label>
                                                        <input type="hidden" name="types[]" value="blog_subtitle">
                                                        <input type="text" class="form-control" name="blog_subtitle"
                                                               placeholder="{{__('Enter blog title')}}"
                                                               value="{{$home_setting->blog_subtitle}}">
                                                        <p id="errblog_subtitle" class="mb-0 text-danger em"></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 pr-0">
                                                    <div class="form-group">
                                                        <label for="">{{__('View All Blog Text')}}</label>
                                                        <input type="hidden" name="types[]" value="view_all_blog_text">
                                                        <input type="text" class="form-control"
                                                               name="view_all_blog_text"
                                                               placeholder="{{__('Enter view all blog text')}}"
                                                               value="{{$home_setting->view_all_blog_text}}">
                                                        <p id="errview_all_blog_text" class="mb-0 text-danger em"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($userBs->theme == 'home_three')
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <br>
                                            <h3 class="text-warning">{{ __('FAQ Section') }}</h3>
                                            <hr class="border-top">
                                        </div>
                                        <div class="form-group">
                                            <div class="col-12 mb-2">
                                                <label for="logo"><strong>{{__('FAQ Section Image')}}</strong></label>
                                            </div>
                                            <div class="col-md-12 showFAQSectionImage mb-3">
                                                <img
                                                    src="{{$home_setting->faq_section_image ? asset('assets/front/img/user/home_settings/'.$home_setting->faq_section_image) : asset('assets/admin/img/noimage.jpg')}}"
                                                    alt="..." class="img-thumbnail">
                                            </div>
                                            <input type="hidden" name="types[]" value="faq_section_image">
                                            <input type="file" name="faq_section_image" id="faq_section_image"
                                                   class="form-control ltr">
                                            <p id="errfaq_section_image" class="mb-0 text-danger em"></p>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 pr-0">
                                                <div class="form-group">
                                                    <label for="">{{__('FAQ Section Title')}}*</label>
                                                    <input type="hidden" name="types[]" value="faq_section_title">
                                                    <input type="text" class="form-control" name="faq_section_title"
                                                           placeholder="{{__('Enter faq section title')}}"
                                                           value="{{$home_setting->faq_section_title}}">
                                                    <p id="errfaq_section_title" class="mb-0 text-danger em"></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 pl-0">
                                                <div class="form-group">
                                                    <label for="">{{__('FAQ Section Subtitle')}}*</label>
                                                    <input type="hidden" name="types[]" value="faq_section_subtitle">
                                                    <input type="text" class="form-control" name="faq_section_subtitle"
                                                           placeholder="{{__('Enter faq section subtitle')}}"
                                                           value="{{$home_setting->faq_section_subtitle}}">
                                                    <p id="errfaq_section_subtitle" class="mb-0 text-danger em"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <br>
                                            <h3 class="text-warning">{{ __('Quote Section') }}</h3>
                                            <hr class="border-top">
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 pr-0">
                                                <div class="form-group">
                                                    <label for="">{{__('Quote Section Title')}}</label>
                                                    <input type="hidden" name="types[]" value="quote_section_title">
                                                    <input type="text" class="form-control" name="quote_section_title"
                                                           placeholder="{{__('Enter quote section title')}}"
                                                           value="{{$home_setting->quote_section_title}}">
                                                    <p id="errquote_section_title" class="mb-0 text-danger em"></p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 pl-0">
                                                <div class="form-group">
                                                    <label for="">{{__('Quote Section Subtitle')}}</label>
                                                    <input type="hidden" name="types[]" value="quote_section_subtitle">
                                                    <input type="text" class="form-control" name="quote_section_subtitle"
                                                           placeholder="{{__('Enter quote section subtitle')}}"
                                                           value="{{$home_setting->quote_section_subtitle}}">
                                                    <p id="errquote_section_subtitle" class="mb-0 text-danger em"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="form">
                        <div class="form-group from-show-notify row">
                            <div class="col-12 text-center">
                                <button type="submit" id="submitBtn" class="btn btn-success">{{__('Update')}}</button>
                            </div>
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
