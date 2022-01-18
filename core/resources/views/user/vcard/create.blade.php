@extends('user.layout')
@section('content')
<div class="page-header">
   <h4 class="page-title">{{__('Add vCard')}}</h4>
   <ul class="breadcrumbs">
      <li class="nav-home">
         <a href="#">
         <i class="flaticon-home"></i>
         </a>
      </li>
      <li class="separator">
         <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
         <a href="#">{{__('vCards Management')}}</a>
      </li>
      <li class="separator">
         <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
         <a href="#">{{__('Add vCard')}}</a>
      </li>
   </ul>
</div>
<div class="row">
   <div class="col-md-12">
      <div class="card">
         <div class="card-header">
            <div class="card-title d-inline-block">{{__('Add vCard')}}</div>
            <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('user.vcard')}}">
            <span class="btn-label">
            <i class="fas fa-backward"></i>
            </span>
            {{__('Back')}}
            </a>
         </div>
         <div class="card-body pt-5 pb-5">
            <div class="row">
               <div class="col-lg-12">

                  {{-- Featured image upload end --}}
                  <form id="ajaxForm" class="" action="{{route('user.vcard.store')}}" method="POST" enctype="multipart/form-data">
                     @csrf
                     <div class="row">
                        <div class="col-12">
                           <div class="form-group">
                              <label class="form-label">{{__('Choose a Template')}}</label>
                              <div class="row">
                                 <div class="col-2">
                                    <label class="imagecheck mb-4">
                                       <input name="template" type="radio" value="1" class="imagecheck-input" checked>
                                       <figure class="imagecheck-figure">
                                          <img src="{{asset('assets/front/img/user/vcard-templates/1.jpg')}}" alt="title" class="imagecheck-image">
                                       </figure>
                                    </label>
                                 </div>
                                 <div class="col-2">
                                    <label class="imagecheck mb-4">
                                       <input name="template" type="radio" value="2" class="imagecheck-input">
                                       <figure class="imagecheck-figure">
                                          <img src="{{asset('assets/front/img/user/vcard-templates/2.jpg')}}" alt="title" class="imagecheck-image">
                                       </figure>
                                    </label>
                                 </div>
                                 <div class="col-2">
                                    <label class="imagecheck mb-4">
                                       <input name="template" type="radio" value="3" class="imagecheck-input">
                                       <figure class="imagecheck-figure">
                                          <img src="{{asset('assets/front/img/user/vcard-templates/3.jpg')}}" alt="title" class="imagecheck-image">
                                       </figure>
                                    </label>
                                 </div>
                                 <div class="col-2">
                                    <label class="imagecheck mb-4">
                                       <input name="template" type="radio" value="4" class="imagecheck-input">
                                       <figure class="imagecheck-figure">
                                          <img src="{{asset('assets/front/img/user/vcard-templates/4.jpg')}}" alt="title" class="imagecheck-image">
                                       </figure>
                                    </label>
                                 </div>
                              </div>
                              <p class="em text-danger em-0" id="errtemplate"></p>
                           </div>
                        </div>
                     </div>

                     <div class="row">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <div class="col-12 mb-2">
                              <label for="image"><strong>{{__('Profile Image')}}</strong></label>
                            </div>
                            <div class="col-md-12 showImage mb-3">
                              <img src="{{asset('assets/admin/img/noimage.jpg')}}" alt="..." class="img-thumbnail">
                            </div>
                            <input type="file" name="profile_image" class="image" class="form-control image">
                            <p id="errprofile_image" class="mb-0 text-danger em"></p>
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <div class="col-12 mb-2">
                              <label for="image"><strong>{{__('Cover Image')}}</strong></label>
                            </div>
                            <div class="col-md-12 showImage mb-3">
                              <img src="{{asset('assets/admin/img/noimage.jpg')}}" alt="..." class="img-thumbnail">
                            </div>
                            <input type="file" name="cover_image" class="image" class="form-control image">
                            <p id="errcover_image" class="mb-0 text-danger em"></p>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                           <div class="col-lg-6">
                              <div class="form-group">
                                 <label for="">{{__('vCard Name')}} **</label>
                                 <input type="text" class="form-control" name="vcard_name" value="" placeholder="{{__('Enter vcard name')}}">
                                 <p class="text-warning mb-0">{{__('Use this name to identify sepcific vcard from your vcards list.')}}</p>
                                 <p id="errvcard_name" class="mb-0 text-danger em"></p>
                              </div>
                           </div>
                          <div class="col-lg-6">
                              <div class="form-group">
                                  <label for="">{{__('Direction')}} **</label>
                                  <select name="direction" class="form-control" id="direction">
                                      <option value="" selected disabled>{{__('Select a Direction')}}</option>
                                      <option value="1">{{__('LTR (Left to Right)')}}</option>
                                      <option value="2">{{__('RTL (Right to Left)')}}</option>
                                  </select>
                                  <p id="errdirection" class="mb-0 text-danger em"></p>
                              </div>
                          </div>
                      </div>

                     <div class="row">
                        <div class="col-lg-4">
                           <div class="form-group">
                              <label for="">{{__('Name')}}</label>
                              <input type="text" class="form-control" name="name" value="" placeholder="{{__('Enter name')}}">
                              <p id="errname" class="mb-0 text-danger em"></p>
                           </div>
                        </div>
                        <div class="col-lg-4">
                           <div class="form-group">
                              <label for="">{{__('Company Name')}}</label>
                              <input type="text" class="form-control" name="company" value="" placeholder="{{__('Enter company')}}">
                              <p id="errcompany" class="mb-0 text-danger em"></p>
                           </div>
                        </div>
                        <div class="col-lg-4">
                           <div class="form-group">
                              <label for="">{{__('Position')}}</label>
                              <input type="text" class="form-control" name="occupation" value="" placeholder="{{__('Enter postion')}}">
                              <p id="erroccupation" class="mb-0 text-danger em"></p>
                           </div>
                        </div>
                     </div>

                     <div class="row">
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label for="">{{__('Email')}}</label>
                              <input type="text" class="form-control ltr" name="email" value="" placeholder="{{__('Enter email')}}">
                              <p id="erremail" class="mb-0 text-danger em"></p>
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label for="">{{__('Phone')}}</label>
                              <input type="text" class="form-control ltr" name="phone" value="" placeholder="{{__('Enter phone')}}">
                              <p class="text-warning mb-0">{{__('Enter Phone Number with')}} <strong class="text-danger">{{__('Country Code')}}</strong></p>
                              <p id="errphone" class="mb-0 text-danger em"></p>
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label for="">{{__('Address')}}</label>
                              <input type="text" class="form-control" name="address" value="" >
                              <p id="erraddress" class="mb-0 text-danger em"></p>
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="form-group">
                              <label for="">{{__('Website URL')}}</label>
                              <input type="text" class="form-control ltr" name="website_url" value="" placeholder="{{__('Enter website url')}}">
                              <p id="errwebsite_url" class="mb-0 text-danger em"></p>
                           </div>
                        </div>
                     </div>


                     <div class="row">

                        <div class="col-lg-12">
                           <div class="form-group">
                              <label for="summary">{{__('Introduction')}}</label>
                              <textarea name="introduction" id="introduction" class="form-control" rows="4" placeholder="{{__('Enter Introduction')}}"></textarea>
                           </div>
                        </div>
                     </div>


                     <div id="app">
                        {{-- Infromation Start --}}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="" class="d-block mb-2">{{__('Other Infromation')}}</label>
                                    <button class="btn btn-primary" @click="addInformation">{{__('Add Information')}}</button>
                                </div>
                            </div>
                        </div>


                        <div class="row no-gutters" v-for="(information, index) in infromations" :key="information.uniqid">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">{{__('Icon')}} **</label>
                                    <div class="btn-group d-block">
                                        <button type="button" class="btn btn-primary iconpicker-component"><i :id="'vcard-icp-icon' + index"
                                                class="fa fa-fw fa-heart"></i></button>
                                        <button type="button" class="vcard-icp vcard-icp-dd btn btn-primary dropdown-toggle"
                                                data-selected="fa-car" data-toggle="dropdown">
                                        </button>
                                        <div class="dropdown-menu"></div>
                                    </div>
                                    <input type="hidden" name="icons[]" value="fas fa-heart">
                                    <p class="em text-danger mb-0" :id="'erricons.'+index"></p>
                                </div>
                            </div>
                            <div class="col-lg-1">
                                <div class="form-group">
                                   <label for="">{{__('Link')}}</label><br>
                                    <input name="links[]" class="ltr" :value="index" type="checkbox">
                                    <p class="em text-danger mb-0" :id="'errlinks.'+index"></p>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                   <label for="">{{__('Icon Color')}} **</label>
                                    <input name="colors[]" class="jscolor ltr form-control" value="000000" type="text" >
                                    <p class="em text-danger mb-0" :id="'errcolors.'+index"></p>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                   <label for="">{{__('Label')}} **</label>
                                    <input name="labels[]" class="form-control" :class="{rtl: information.dir == 2}" value="" type="text">
                                    <p class="em text-danger mb-0" :id="'errlabels.'+index"></p>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                   <label for="">{{__('Value')}} **</label>
                                    <input name="values[]" class="form-control" :class="{rtl: information.dir == 2}" value="" type="text">
                                    <p class="em text-danger mb-0" :id="'errvalues.'+index"></p>
                                </div>
                            </div>
                            <div class="col-lg-1">
                                <button class="btn btn-danger text-white mt-4" @click="removeInformation(index)">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        {{-- Infromation End --}}
                     </div>
                  </form>
               </div>
            </div>
         </div>
         <div class="card-footer">
            <div class="form">
               <div class="form-group from-show-notify row">
                  <div class="col-12 text-center">
                     <button type="submit" id="submitBtn" class="btn btn-success">{{__('Submit')}}</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

@section('scripts')
    <script src="{{asset('assets/front/user/js/create-vcard.js')}}"></script>
@endsection
