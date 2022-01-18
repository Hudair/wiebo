<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Session;

class RegisterUserController extends Controller
{
    public function index(Request $request)
    {
        $term = $request->term;

        $users = User::when($term, function($query, $term) {
            $query->where('username', 'like', '%' . $term . '%')->orWhere('email', 'like', '%' . $term . '%');
        })->orderBy('id', 'DESC')->paginate(10);
        return view('admin.register_user.index',compact('users'));
    }

    public function view($id)
    {
        $user = User::findOrFail($id);
        return view('admin.register_user.details',compact('user'));

    }


    public function userban(Request $request)
    {
        $user = User::where('id',$request->user_id)->first();
        $user->update([
            'status' => $request->status,
        ]);
        Session::flash('success', 'Status update successfully!');
        return back();

    }


    public function emailStatus(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->update([
            'email_verified' => $request->email_verified,
        ]);

        Session::flash('success', 'Email status updated for ' . $user->username);
        return back();
    }

    public function userFeatured(Request $request)
    {
        $user = User::where('id',$request->user_id)->first();
        $user->featured = $request->featured;
        $user->save();
        Session::flash('success', 'User featured update successfully!');
        return back();
    }


    public function changePass($id) {
        $data['user'] = User::findOrFail($id);
        return view('admin.register_user.password', $data);
    }


    public function updatePassword(Request $request)
    {

        $messages = [
            'npass.required' => 'New password is required',
            'cfpass.required' => 'Confirm password is required',
        ];

        $request->validate([
            'npass' => 'required',
            'cfpass' => 'required',
        ], $messages);


        $user = User::findOrFail($request->user_id);
        if ($request->npass == $request->cfpass) {
            $input['password'] = Hash::make($request->npass);
        } else {
            return back()->with('warning', __('Confirm password does not match.'));
        }

        $user->update($input);

        Session::flash('success', 'Password update for ' . $user->username);
        return back();
    }

    public function delete(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        if ($user->testimonials()->count() > 0) {
            $testimonials = $user->testimonials()->get();
            foreach ($testimonials as $key => $tstm) {
                @unlink('assets/front/img/user/testimonials/' . $tstm->image);
                $tstm->delete();
            }
        }

        if ($user->social_media()->count() > 0) {
            $user->social_media()->delete();
        }

        if ($user->skills()->count() > 0) {
            $user->skills()->delete();
        }

        if ($user->services()->count() > 0) {
            $services = $user->services()->get();
            foreach ($services as $key => $service) {
                @unlink('assets/front/img/user/services/' . $service->image);
                $service->delete();
            }
        }

        if ($user->subscribers()->count() > 0) {
            $user->subscribers()->delete();
        }

        if ($user->seos()->count() > 0) {
            $user->seos()->delete();
        }

        if ($user->portfolios()->count() > 0) {
            $portfolios = $user->portfolios()->get();
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

        if ($user->portfolioCategories()->count() > 0) {
            $user->portfolioCategories()->delete();
        }

        if ($user->permission()->count() > 0) {
            $user->permission()->delete();
        }

        if ($user->languages()->count() > 0) {
            $user->languages()->delete();
        }

        if ($user->home_page_texts()->count() > 0) {
            $homeTexts = $user->home_page_texts()->get();
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

        if ($user->home_section()->count() > 0) {
            $user->home_section()->delete();
        }

        if ($user->jobs()->count() > 0) {
            $user->jobs()->delete();
        }

        if ($user->jcategories()->count() > 0) {
            $user->jcategories()->delete();
        }

        if ($user->teams()->count() > 0) {
            $teams = $user->teams()->get();
            foreach ($teams as $key => $team) {
                @unlink('/assets/front/img/user/team/'.$team->image);
                $team->delete();
            }
        }

        if ($user->permissions()->count() > 0) {
            $user->permissions()->delete();
        }

        if ($user->qr_codes()->count() > 0) {
            $qr_codes = $user->qr_codes()->get();
            foreach ($qr_codes as $key => $qr) {
                @unlink('assets/front/img/user/qr/' . $qr->image);
                $qr->delete();
            }
        }

        if ($user->quotes()->count() > 0) {
            $user->quotes()->delete();
        }

        if ($user->quote_inputs()->count() > 0) {
            $quote_inputs = $user->quote_inputs()->get();
            foreach ($quote_inputs as $key => $input) {
                if ($input->quote_input_options()->count() > 0) {
                    $input->quote_input_options()->delete();
                }
                $input->delete();
            }
        }

        if ($user->services()->count() > 0) {
            $services = $user->services()->get();
            foreach ($services as $key => $service) {
                @unlink('assets/front/img/user/service/' . $service->image);
                $service->delete();
            }
        }

        if ($user->vcards()->count() > 0) {
            $vcards = $user->vcards()->get();
            foreach ($vcards as $key => $vcard) {
                @unlink('assets/front/img/user/vcard/' . $vcard->profile_image);
                @unlink('assets/front/img/user/vcard/' . $vcard->cover_image);
                if ($vcard->user_vcard_projects()->count() > 0) {
                    foreach ($vcard->user_vcard_projects as $key => $project) {
                        @unlink('assets/front/img/user/projects/' . $project->image);
                        $project->delete();
                    }
                }
                if ($vcard->user_vcard_services()->count() > 0) {
                    foreach ($vcard->user_vcard_services as $key => $service) {
                        @unlink('assets/front/img/user/services/' . $service->image);
                        $service->delete();
                    }
                }
                if ($vcard->user_vcard_testimonials()->count() > 0) {
                    foreach ($vcard->user_vcard_testimonials as $key => $testimonial) {
                        @unlink('assets/front/img/user/testimonials/' . $testimonial->image);
                        $testimonial->delete();
                    }
                }
                $vcard->delete();
            }
        }

        if ($user->processes()->count() > 0) {
            $user->processes()->delete();
        }

        if ($user->blog_categories()->count() > 0) {
            $user->blog_categories()->delete();
        }
        

        if ($user->blogs()->count() > 0) {
            $blogs = $user->blogs()->get();
            foreach ($blogs as $key => $blog) {
                @unlink('assets/front/img/user/blogs/' . $blog->image);
                $blog->delete();
            }
        }

        if ($user->basic_setting()->count() > 0) {
            $bs = $user->basic_setting;
            @unlink('assets/front/img/user/' . $bs->breadcrumb);
            @unlink('assets/front/img/user/' . $bs->logo);
            @unlink('assets/front/img/user/' . $bs->preloader);
            @unlink('assets/front/img/user/' . $bs->favicon);
            @unlink('assets/front/img/user/qr/' . $bs->qr_image);
            @unlink('assets/front/img/user/qr/' . $bs->qr_inserted_image);
            $bs->delete();
        }

        if ($user->memberships()->count() > 0) {
            foreach($user->memberships as $key => $membership) {
                @unlink('assets/front/img/membership/receipt/' . $membership->receipt);
                $membership->delete();
            }
        }
            
    
        if ($user->brands()->count() > 0) {
            $brands = $user->brands()->get();
            foreach ($brands as $key => $brand) {
                @unlink('assets/front/img/user/brands/' . $brand->brand_img);
                $brand->delete();
            }
        }
            
    
        if ($user->user_contact()->count() > 0) {
            $contact = $user->user_contact;
            @unlink('assets/front/img/user/'.$contact->contact_form_image);
            $contact->delete();
        }

        if ($user->faqs()->count() > 0) {
            $user->faqs()->delete();
        }

        if ($user->footer_quick_links()->count() > 0) {
            $user->footer_quick_links()->delete();
        }

        if ($user->footer_texts()->count() > 0) {
            $user->footer_texts()->delete();
        }

        if ($user->menus()->count() > 0) {
            $user->menus()->delete();
        }

        if ($user->pages()->count() > 0) {
            $user->pages()->delete();
        }
            
    
        if ($user->hero_sliders()->count() > 0) {
            $sliders = $user->hero_sliders()->get();
            foreach ($sliders as $key => $slider) {
                @unlink('assets/front/img/hero_slider/'.$slider->img);
                $slider->delete();
            }
        }

        if ($user->hero_static()->count() > 0) {
            $static = $user->hero_static;
            @unlink('assets/front/img/hero_static/' . $static->img);
            $static->delete();
        }

        @unlink('assets/front/img/user/' . $user->photo);
        $user->delete();

        Session::flash('success', 'User deleted successfully!');
        return back();
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        foreach ($ids as $id) {
            $user = User::findOrFail($id);

            if ($user->testimonials()->count() > 0) {
                $testimonials = $user->testimonials()->get();
                foreach ($testimonials as $key => $tstm) {
                    @unlink('assets/front/img/user/testimonials/' . $tstm->image);
                    $tstm->delete();
                }
            }
    
            if ($user->social_media()->count() > 0) {
                $user->social_media()->delete();
            }
    
            if ($user->skills()->count() > 0) {
                $user->skills()->delete();
            }
    
            if ($user->services()->count() > 0) {
                $services = $user->services()->get();
                foreach ($services as $key => $service) {
                    @unlink('assets/front/img/user/services/' . $service->image);
                    $service->delete();
                }
            }
    
            if ($user->subscribers()->count() > 0) {
                $user->subscribers()->delete();
            }
    
            if ($user->seos()->count() > 0) {
                $user->seos()->delete();
            }
    
            if ($user->portfolios()->count() > 0) {
                $portfolios = $user->portfolios()->get();
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
    
            if ($user->portfolioCategories()->count() > 0) {
                $user->portfolioCategories()->delete();
            }
    
            if ($user->permission()->count() > 0) {
                $user->permission()->delete();
            }
    
            if ($user->languages()->count() > 0) {
                $user->languages()->delete();
            }
    
            if ($user->home_page_texts()->count() > 0) {
                $homeTexts = $user->home_page_texts()->get();
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
    
            if ($user->home_section()->count() > 0) {
                $user->home_section()->delete();
            }
    
            if ($user->jobs()->count() > 0) {
                $user->jobs()->delete();
            }
    
            if ($user->jcategories()->count() > 0) {
                $user->jcategories()->delete();
            }
    
            if ($user->teams()->count() > 0) {
                $teams = $user->teams()->get();
                foreach ($teams as $key => $team) {
                    @unlink('/assets/front/img/user/team/'.$team->image);
                    $team->delete();
                }
            }
    
            if ($user->permissions()->count() > 0) {
                $user->permissions()->delete();
            }
    
            if ($user->qr_codes()->count() > 0) {
                $qr_codes = $user->qr_codes()->get();
                foreach ($qr_codes as $key => $qr) {
                    @unlink('assets/front/img/user/qr/' . $qr->image);
                    $qr->delete();
                }
            }
    
            if ($user->quotes()->count() > 0) {
                $user->quotes()->delete();
            }
    
            if ($user->quote_inputs()->count() > 0) {
                $quote_inputs = $user->quote_inputs()->get();
                foreach ($quote_inputs as $key => $input) {
                    if ($input->quote_input_options()->count() > 0) {
                        $input->quote_input_options()->delete();
                    }
                    $input->delete();
                }
            }
    
            if ($user->services()->count() > 0) {
                $services = $user->services()->get();
                foreach ($services as $key => $service) {
                    @unlink('assets/front/img/user/service/' . $service->image);
                    $service->delete();
                }
            }
    
            if ($user->vcards()->count() > 0) {
                $vcards = $user->vcards()->get();
                foreach ($vcards as $key => $vcard) {
                    @unlink('assets/front/img/user/vcard/' . $vcard->profile_image);
                    @unlink('assets/front/img/user/vcard/' . $vcard->cover_image);
                    if ($vcard->user_vcard_projects()->count() > 0) {
                        foreach ($vcard->user_vcard_projects as $key => $project) {
                            @unlink('assets/front/img/user/projects/' . $project->image);
                            $project->delete();
                        }
                    }
                    if ($vcard->user_vcard_services()->count() > 0) {
                        foreach ($vcard->user_vcard_services as $key => $service) {
                            @unlink('assets/front/img/user/services/' . $service->image);
                            $service->delete();
                        }
                    }
                    if ($vcard->user_vcard_testimonials()->count() > 0) {
                        foreach ($vcard->user_vcard_testimonials as $key => $testimonial) {
                            @unlink('assets/front/img/user/testimonials/' . $testimonial->image);
                            $testimonial->delete();
                        }
                    }
                    $vcard->delete();
                }
            }
    
            if ($user->processes()->count() > 0) {
                $user->processes()->delete();
            }
    
            if ($user->blog_categories()->count() > 0) {
                $user->blog_categories()->delete();
            }
            
    
            if ($user->blogs()->count() > 0) {
                $blogs = $user->blogs()->get();
                foreach ($blogs as $key => $blog) {
                    @unlink('assets/front/img/user/blogs/' . $blog->image);
                    $blog->delete();
                }
            }
    
            if ($user->basic_setting()->count() > 0) {
                $bs = $user->basic_setting;
                @unlink('assets/front/img/user/' . $bs->breadcrumb);
                @unlink('assets/front/img/user/' . $bs->logo);
                @unlink('assets/front/img/user/' . $bs->preloader);
                @unlink('assets/front/img/user/' . $bs->favicon);
                @unlink('assets/front/img/user/qr/' . $bs->qr_image);
                @unlink('assets/front/img/user/qr/' . $bs->qr_inserted_image);
                $bs->delete();
            }
    
            if ($user->memberships()->count() > 0) {
                foreach($user->memberships as $key => $membership) {
                    @unlink('assets/front/img/membership/receipt/' . $membership->receipt);
                    $membership->delete();
                }
            }
                
        
            if ($user->brands()->count() > 0) {
                $brands = $user->brands()->get();
                foreach ($brands as $key => $brand) {
                    @unlink('assets/front/img/user/brands/' . $brand->brand_img);
                    $brand->delete();
                }
            }
                
        
            if ($user->user_contact()->count() > 0) {
                $contact = $user->user_contact;
                @unlink('assets/front/img/user/'.$contact->contact_form_image);
                $contact->delete();
            }
    
            if ($user->faqs()->count() > 0) {
                $user->faqs()->delete();
            }
    
            if ($user->footer_quick_links()->count() > 0) {
                $user->footer_quick_links()->delete();
            }
    
            if ($user->footer_texts()->count() > 0) {
                $user->footer_texts()->delete();
            }

            if ($user->menus()->count() > 0) {
                $user->menus()->delete();
            }
    
            if ($user->pages()->count() > 0) {
                $user->pages()->delete();
            }
                
        
            if ($user->hero_sliders()->count() > 0) {
                $sliders = $user->hero_sliders()->get();
                foreach ($sliders as $key => $slider) {
                    @unlink('assets/front/img/hero_slider/'.$slider->img);
                    $slider->delete();
                }
            }
    
            if ($user->hero_static()->count() > 0) {
                $static = $user->hero_static;
                @unlink('assets/front/img/hero_static/' . $static->img);
                $static->delete();
            }
    
            @unlink('assets/front/img/user/' . $user->photo);
            $user->delete();
        }

        Session::flash('success', 'Users deleted successfully!');
        return "success";
    }
}
