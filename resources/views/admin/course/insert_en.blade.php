<div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="box-tittle">{{ __('adminstaticword.Add') }} {{ __('adminstaticword.Course') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ url('course/') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <input type="hidden" name="lang" value="en" id="lang">

                        <div class="row">
                            <div class="col-md-4">
                                <label>{{ __('adminstaticword.Category') }}:<span class="redstar">*</span></label>
                                <select name="category_id" id="category_id" class="form-control select2">
                                    <option value="0">{{ __('adminstaticword.SelectanOption') }}</option>
                                    @foreach ($category as $cate)
                                        <option value="{{ $cate->id }}">{{ $cate->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>{{ __('adminstaticword.SubCategory') }}:<span class="redstar">*</span></label>
                                <select name="subcategory_id" id="upload_id" class="form-control select2">
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>{{ __('adminstaticword.ChildCategory') }}:</label>
                                <select name="childcategory_id" id="grand" class="form-control select2"></select>
                            </div>
                        </div>
                        <br>

                        <div class="row">

                            <div class="col-md-4">
                                <label for="exampleInputTit1e">{{ __('adminstaticword.Instructor') }}</label>
                                <select name="user_id" class="form-control js-example-basic-single col-md-7 col-xs-12">

                                    @if (Auth::user()->role == 'admin')
                                        <option value="{{ Auth::user()->id }}">{{ Auth::user()->fname }}
                                            {{ Auth::user()->lname }}</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->fname }}
                                                {{ $user->lname }}</option>
                                        @endforeach
                                    @else
                                        <option value="{{ Auth::user()->id }}">{{ Auth::user()->fname }}</option>

                                    @endif
                                </select>


                            </div>

                            <div class="col-md-4">
                                <label>{{ __('adminstaticword.Language') }}: <span class="redstar">*</span></label>
                                <select name="language_id" class="form-control select2">
                                    @php
                                        $languages = App\CourseLanguage::all();
                                    @endphp
                                    @foreach ($languages as $caat)
                                        <option {{ $caat->language_id == $caat->id ? 'selected' : '' }}
                                            value="{{ $caat->id }}">
                                            {{ $caat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label>{{ __('adminstaticword.Type') }}: <span class="redstar">*</span></label>
                                <select name="course_type" class="form-control">
                                    <option value="1">Online</option>
                                    <option value="2">Record</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                @php
                                    $ref_policy = App\RefundPolicy::all();
                                @endphp
                                <label for="exampleInputSlug">{{ __('adminstaticword.SelectRefundPolicy') }}</label>
                                <select name="refund_policy_id" class="form-control select2">
                                    <option value="none" selected disabled hidden>
                                        {{ __('frontstaticword.SelectanOption') }}
                                    </option>
                                    @foreach ($ref_policy as $ref)
                                        <option value="{{ $ref->id }}">{{ $ref->name }}</option>
                                    @endforeach
                                </select>

                            </div>

                            {{-- @if (Auth::User()->role == 'admin')
              <div class="col-md-4">
                <label>{{ __('Institute') }}: <span class="redstar">*</span></label>
                <select name="institude_id" class="form-control select2">
                  @php
                  $institute = App\Institute::where('status' ,'1')->get();
                  @endphp  
                  <option value="none" selected disabled hidden> 
                    {{ __('adminstaticword.SelectanOption') }}
                  </option>
                  @foreach ($institute as $inst)
                    <option  value="{{ $inst->id }}">{{ $inst->title }}</option>
                  @endforeach
                </select>
              </div>
              @endif --}}

                            {{-- @if (Auth::User()->role == 'instructor')
                                    <div class="col-md-4">
                                        <label>{{ __('Institute') }}: <span class="redstar">*</span></label>
                                        <select name="institude_id" class="form-control select2">
                                            @php
                                                $institute = App\Institute::where('user_id', Auth::user()->id)
                                                    ->where('status', '1')
                                                    ->get();
                                            @endphp
                                            <option value="none" selected disabled hidden>
                                                {{ __('adminstaticword.SelectanOption') }}
                                            </option>
                                            @foreach ($institute as $inst)
                                                <option value="{{ $inst->id }}">{{ $inst->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif --}}


                        </div>
                        <br>



                        <div class="row">
                            <div class="col-md-6">
                                <label for="exampleInputTit1e">{{ __('adminstaticword.Title') }}: <sup
                                        class="redstar">*</sup></label>
                                <input type="title" class="form-control" name="title" id="exampleInputTitle"
                                    placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.Title') }}"
                                    value="{{ old('title') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="exampleInputSlug">{{ __('adminstaticword.Slug') }}: <sup
                                        class="redstar">*</sup></label>
                                <input pattern="[/^\S*$/]+" type="text" class="form-control" name="slug"
                                    id="exampleInputPassword1"
                                    placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.Slug') }}"
                                    value="{{ old('slug') }}" required>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="exampleInputTit1e">{{ __('adminstaticword.ShortDetail') }}: <sup
                                        class="redstar">*</sup></label>
                                <textarea name="short_detail" rows="3" class="form-control"
                                    placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.ShortDetail') }}" required>{{ old('short_detail') }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="exampleInputTit1e">{{ __('adminstaticword.Requirements') }}: <sup
                                        class="redstar">*</sup></label>
                                <textarea name="requirement" rows="3" class="form-control"
                                    placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.Requirements') }}" required>{{ old('requirement') }}</textarea>
                            </div>
                        </div>
                        <br>


                        <div class="row">
                            <div class="col-md-6">
                                <label for="exampleInputTit1e">{{ __('adminstaticword.VR-hole') }}: <sup
                                        class="redstar">*</sup></label>
                                <input type="number" class="form-control" name="vr_hole" id="exampleInputTitle"
                                    placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.VR-hole') }}"
                                    value="{{ old('vr_hole') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="exampleInputSlug">{{ __('adminstaticword.VR-code') }}: <sup
                                        class="redstar">*</sup></label>
                                <input type="number" class="form-control" name="vr_code" id="exampleInputPassword1"
                                    placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.VR-code') }}"
                                    value="{{ old('vr_code') }}" required>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="exampleInputTit1e">{{ __('adminstaticword.Detail') }}: <sup
                                        class="redstar">*</sup></label>
                                <textarea id="detail" name="detail" rows="3" class="form-control">{{ old('detail') }}</textarea>
                            </div>
                        </div>
                        <br>

                        <!-- country start -->
                        {{-- <div class="row">
                                <div class="col-md-12">

                                    <label>{{ __('Country') }}: </label>
                                    <select class="select2-multi-select form-control" name="country[]" multiple="multiple">
                                        @foreach ($countries as $country)
                                            <option>{{ $country->name }}</option>
                                        @endforeach
                                    </select>

                                    <small class="text-info"><i class="fa fa-question-circle"></i>
                                        ({{ __('Select those countries where you want to block courses') }} )</small>

                                </div>
                            </div>
                            <br> --}}
                        <!-- country end -->


                        @if (Auth::User()->role == 'admin')
                            <div class="row">
                                <div class="col-md-6">

                                    <label for="exampleInputSlug">{{ __('adminstaticword.SelectTags') }}:</label>
                                    <select class="form-control js-example-basic-single" name="level_tags">
                                        <option value="none" selected disabled hidden>
                                            {{ __('adminstaticword.SelectanOption') }}
                                        </option>

                                        {{-- <option value="trending">{{ __('Trending') }}</option> --}}

                                        {{-- <option value="onsale">{{ __('Onsale') }}</option> --}}

                                        {{-- <option value="bestseller">{{ __('Bestseller') }}</option> --}}

                                        <option value="beginner">{{ __('Beginner') }}</option>

                                        <option value="intermediate">{{ __('Intermediate') }}</option>

                                        <option value="expert">{{ __('Expert') }}</option>

                                    </select>

                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark"
                                            for="start_date">{{ __('adminstaticword.StartDate') }}:
                                        </label>
                                        <input value="{{ old('start_date') }}" type="text" id="start-date1"
                                            class="default-date form-control" name="start_date"
                                            placeholder="dd/mm/yyyy" aria-describedby="basic-addon2" />
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2"><i
                                                    class="feather icon-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <br>

                        <div class="row">
                            <div class="col-md-6">

                                <label>{{ __('adminstaticword.CourseTags') }}: <span class="redstar">*</span></label>
                                <select class="select2-multi-select form-control" name="course_tags[]"
                                    multiple="multiple" size="5" row="5" placeholder="">

                                    <option></option>

                                </select>

                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark" for="end_date">{{ __('adminstaticword.EndDate') }}:
                                    </label>
                                    <input value="{{ old('end_date') }}" type="text" id="end-date1"
                                        class="default-date form-control" name="end_date" placeholder="dd/mm/yyyy"
                                        aria-describedby="basic-addon2" />
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2"><i
                                                class="feather icon-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>



                        <div class="row">
                            <div class="col-md-12 d-none">


                                <label for="exampleInputSlug">{{ __('adminstaticword.ReturnAvailable') }}</label>
                                <select name="refund_enable"
                                    class="form-control js-example-basic-single col-md-7 col-xs-12">
                                    <option value="none" selected disabled hidden>
                                        {{ __('frontstaticword.SelectanOption') }}
                                    </option>

                                    <option value="1">{{ __('Return Available') }}</option>
                                    <option value="0">{{ __('Return Not Available') }}</option>

                                </select>

                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="exampleInputDetails">{{ __('adminstaticword.Paid') }}:</label>
                                <input type="checkbox" class="custom_toggle" id="cb111" name="type" />

                                <label class="tgl-btn" data-tg-off="{{ __('adminstaticword.Free') }}"
                                    data-tg-on="{{ __('adminstaticword.Paid') }}" for="cb111"></label>

                                <br>
                                <div style="display: none;" id="pricebox">
                                    <label for="exampleInputSlug">{{ __('adminstaticword.Price') }}: <sup
                                            class="redstar">*</sup></label>
                                    <input type="number" step="0.01" class="form-control" name="price"
                                        id="priceMain"
                                        placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.Price') }}"
                                        value="{{ old('price') }}">

                                    <label for="exampleInputSlug">{{ __('adminstaticword.DiscountPrice') }}: </label>
                                    <input type="number" step="0.01" class="form-control" name="discount_price"
                                        id="offerPrice"
                                        placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.DiscountPrice') }}"
                                        value="{{ old('discount_price') }}">
                                </div>
                            </div>
                            <div class="col-md-3 d-none">
                                {{-- <label for="exampleInputDetails">{{ __('adminstaticword.MoneyBack') }}:</label>
                <input  type="checkbox" class="custom_toggle"   id="cb01" name="type" checked />
                <label class="tgl-btn" data-tg-off="{{ __('adminstaticword.No') }}" data-tg-on="{{ __('adminstaticword.Yes') }}" for="cb01"></label> --}}
                                {{-- <input type="hidden" name="free" value="0" id="cb10"> --}}
                                <br>
                                {{-- <div class="display-none" id="dooa">
        
                  <label for="exampleInputSlug">{{ __('adminstaticword.Days') }}: <sup class="redstar">*</sup></label>
                  <input type="number" min="1" class="form-control" name="day" id="exampleInputPassword1" placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.Days') }}" value="">
             
                </div>  --}}
                            </div>

                            <div class="col-md-3">
                                @if (Auth::User()->role == 'admin')
                                    <label for="exampleInputDetails">{{ __('adminstaticword.Featured') }}:</label>
                                    <input type="checkbox" class="custom_toggle" id="cb1" name="featured"
                                        checked />
                                    <label class="tgl-btn" data-tg-off="{{ __('adminstaticword.OFF') }}"
                                        data-tg-on="{{ __('adminstaticword.ON') }}" for="cb1"></label>
                                    {{-- <input type="hidden" name="featured" value="0" id="j"> --}}
                                @endif
                            </div>
                            <div class="col-md-3">
                                @if (Auth::User()->role == 'admin')
                                    <label for="exampleInputDetails">{{ __('adminstaticword.Status') }}:</label>
                                    <input type="checkbox" class="custom_toggle" name="status" id="cb3"
                                        checked />
                                    <label class="tgl-btn" data-tg-off="{{ __('adminstaticword.Deactive') }}"
                                        data-tg-on="{{ __('adminstaticword.Active') }}" for="cb3"></label>
                                    {{-- <input type="hidden" name="status" id="test"> --}}
                                @endif
                            </div>

                            <div class="col-md-3">
                                <label
                                    for="exampleInputDetails">{{ __('adminstaticword.InvolvementRequest') }}:</label>
                                <input name="involvement_request" type="checkbox" class="custom_toggle"
                                    id="involve" checked />
                                <label class="tgl-btn" data-tg-off="{{ __('adminstaticword.OFF') }}"
                                    data-tg-on="{{ __('adminstaticword.ON') }}" for="involve"></label>

                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="exampleInputDetails">{{ __('adminstaticword.PreviewVideo') }}:</label>
                                <input id="preview" type="checkbox" class="custom_toggle" name="preview_type" />
                                <label class="tgl-btn" data-tg-off="{{ __('adminstaticword.URL') }}"
                                    data-tg-on="{{ __('adminstaticword.Upload') }}" for="preview"></label>

                                <div style="display: none;" id="document1">
                                    <label for="exampleInputSlug">{{ __('adminstaticword.UploadVideo') }}:</label>
                                    <input type="file" name="video" id="video" value=""
                                        class="form-control">
                                </div>
                                <div id="document2">
                                    <label for="">{{ __('adminstaticword.URL') }}: </label>
                                    <input type="url" name="url" id="url"
                                        placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.URL') }}"
                                        class="form-control" value="{{ old('url') }}">
                                </div>
                            </div>



                            {{-- <div class="col-md-6">
								<label for="">{{ __('adminstaticword.Duration') }}: </label>
								<input id="duration_type" type="checkbox" class="custom_toggle" name="duration_type" checked />
								<label class="tgl-btn" data-tg-off="{{ __('adminstaticword.Days') }}"
									data-tg-on="{{ __('adminstaticword.Month') }}" for="duration_type"></label>
								<small class="text-muted"><i class="fa fa-question-circle"></i>
									{{ __('If enabled duration can be in months') }},</small>
								<small class="text-muted"> {{ __('when Disabled duration can be in days') }}.</small>
								<br>
								<label for="exampleInputSlug">{{ __('adminstaticword.CourseExpireDuration') }}</label>
								<input min="1" class="form-control" name="duration" type="number" id="duration"
									placeholder="{{ __('adminstaticword.Enter') }} {{ __('adminstaticword.CourseExpireDuration') }}"
									value="{{ old('duration') }}">
							</div> --}}
                        </div>

                        <br>

                        <div class="row">
                            @if (Auth::user()->role == 'instructor')
                                <div class="col-md-6">
                                    <label class="text-dark"
                                        for="exampleInputSlug">{{ __('adminstaticword.PreviewImage') }}: </label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="file">{{ __('Upload') }}</span>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" name="preview_image" class="custom-file-input"
                                                id="file" aria-describedby="inputGroupFileAddon01">
                                            <label class="custom-file-label"
                                                for="inputGroupFile01">{{ __('Choose file') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-dark"
                                        for="exampleInputSlug">{{ __('adminstaticword.PreviewImage') }} 2: </label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="file">{{ __('Upload') }}</span>
                                        </div>
                                        {{-- <div class="custom-file">
											<input type="file" name="thumble_preview_image" class="custom-file-input" id="file"
												aria-describedby="inputGroupFileAddon01">
											<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
										</div> --}}
                                    </div>
                                </div>
                            @endif

                            @if (Auth::user()->role == 'admin')
                                <div class="col-md-6">
                                    <label class="text-dark">{{ __('adminstaticword.Image') }}:<span
                                            class="text-danger">*</span></label><br>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" readonly id="image"
                                            name="preview_image">
                                        <div class="input-group-append">
                                            <span data-input="image"
                                                class="midia-toggle btn-primary  input-group-text"
                                                id="basic-addon2">{{ __('Browse') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-dark">{{ __('adminstaticword.Image') }} 2:<span
                                            class="text-danger">*</span></label><br>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" readonly
                                            id="thumble_preview_image" name="thumble_preview_image">
                                        <div class="input-group-append">
                                            <span data-input="thumble_preview_image"
                                                class="midia-toggle btn-primary  input-group-text"
                                                id="basic-addon2">{{ __('Browse') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif


                            <div class="col-md-6">
                                @if (Auth::User()->role == 'admin')
                                    <label for="Revenue">{{ __('adminstaticword.InstructorRevenue') }}:</label>
                                    <div class="input-group">
                                        <input min="1" max="100" class="form-control"
                                            name="instructor_revenue" type="number" id="revenue"
                                            placeholder="{{ __('adminstaticword.Enter') }} revenue percentage"
                                            class="{{ $errors->has('instructor_revenue') ? ' is-invalid' : '' }} form-control"
                                            value="{{ old('instructor_revenue') }}">
                                        <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        </br>
                        <br>


                        <div class="row">
                            <div class="col-sm-6">

                                <label for="exampleInputDetails">{{ __('adminstaticword.Assignment') }}:</label>
                                <input {{ old('assignment_enable') == '0' ? '' : 'checked' }} id="frees"
                                    type="checkbox" class="custom_toggle" name="assignment_enable" checked />
                                <label class="tgl-btn" data-tg-off="{{ __('adminstaticword.No') }}"
                                    data-tg-on="{{ __('adminstaticword.Yes') }}" for="frees"></label>

                            </div>

                            {{-- <div class="col-sm-4">

								<label for="exampleInputDetails">{{ __('adminstaticword.Appointment') }}:</label>
								<input {{ old('appointment_enable') == '0' ? '' : 'checked' }} id="frees1" type="checkbox"
									class="custom_toggle" name="appointment_enable" checked />
								<label class="tgl-btn" data-tg-off="{{ __('adminstaticword.No') }}"
									data-tg-on="{{ __('adminstaticword.Yes') }}" for="frees1"></label>

							</div> --}}

                            <div class="col-sm-6">
                                <label
                                    for="exampleInputDetails">{{ __('adminstaticword.CertificateEnable') }}:</label>
                                <input {{ old('certificate_enable') == '0' ? '' : 'checked' }} id="frees2"
                                    type="checkbox" class="custom_toggle" name="certificate_enable" checked />
                                <label class="tgl-btn" data-tg-off="{{ __('adminstaticword.No') }}"
                                    data-tg-on="{{ __('adminstaticword.Yes') }}" for="frees2"></label>
                            </div>

                            {{-- <div class="col-sm-3">
								<label for="">{{ __('adminstaticword.DripContent') }}: </label>
								<input id="drip_enable" type="checkbox" class="custom_toggle" name="drip_enable" checked />
								<label class="tgl-btn" data-tg-off="Disable" data-tg-on="Enable" for="drip_enable"></label>
							</div> --}}
                        </div>
                        <br>
                        <br>
                        <div class="form-group">
                            <button type="reset" class="btn btn-danger-rgba"><i class="fa fa-ban"></i>
                                {{ __('Reset') }}</button>
                            <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                {{ __('Create') }}</button>
                        </div>

                        <div class="clear-both"></div>
                </div>

                </form>
            </div>
        </div>
    </div>
</div>



@section('scripts')
    <script>
        (function($) {
            "use strict";

            $(function() {
                $('.js-example-basic-single').select2({
                    tags: true,
                    tokenSeparators: [',', ' ']
                });
            });

            $(function() {
                $("#start-date1").datepicker({
                    language: 'en',
                    // changeYear: true,
                    // yearRange: "-100:+0",
                    dateFormat: 'yyyy-mm-dd',
                });
            });

            $(function() {
                $("#end-date1").datepicker({
                    language: 'en',
                    // changeYear: true,
                    // yearRange: "-100:+0",
                    dateFormat: 'yyyy-mm-dd',
                });
            });

            $(function() {
                $('#cb1').change(function() {
                    $('#j').val(+$(this).prop('checked'))
                })
            })

            $(function() {
                $('#cb3').change(function() {
                    $('#test').val(+$(this).prop('checked'))
                })
            })

            $('#cb111').on('change', function() {

                if ($('#cb111').is(':checked')) {
                    $('#pricebox').show('fast');

                    $('#priceMain').prop('required', 'required');

                } else {
                    $('#pricebox').hide('fast');

                    $('#priceMain').removeAttr('required');
                }

            });

            $('#preview').on('change', function() {

                if ($('#preview').is(':checked')) {
                    $('#document1').show('fast');
                    $('#document2').hide('fast');
                } else {
                    $('#document2').show('fast');
                    $('#document1').hide('fast');
                }

            });

            $("#cb3").on('change', function() {
                if ($(this).is(':checked')) {
                    $(this).attr('value', '1');
                } else {
                    $(this).attr('value', '0');
                }
            });

            $(function() {

                $('#ms').change(function() {
                    if ($('#ms').val() == 'yes') {
                        $('#doabox').show();
                    } else {
                        $('#doabox').hide();
                    }
                });

            });

            $(function() {

                $('#ms').change(function() {
                    if ($('#ms').val() == 'yes') {
                        $('#doaboxx').show();
                    } else {
                        $('#doaboxx').hide();
                    }
                });

            });

            $(function() {

                $('#msd').change(function() {
                    if ($('#msd').val() == 'yes') {
                        $('#doa').show();
                    } else {
                        $('#doa').hide();
                    }
                });

            });

            $(function() {
                var urlLike = '{{ url('admin/dropdown') }}';
                $('#category_id').change(function() {
                    var up = $('#upload_id').empty();
                    var cat_id = $(this).val();
                    if (cat_id) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: "GET",
                            url: urlLike,
                            data: {
                                catId: cat_id
                            },
                            success: function(data) {
                                console.log(data);
                                up.append('<option value="0">Please Choose</option>');
                                $.each(data, function(id, title) {
                                    up.append($('<option>', {
                                        value: id,
                                        text: title
                                    }));
                                });
                            },
                            error: function(XMLHttpRequest, textStatus, errorThrown) {
                                console.log(XMLHttpRequest);
                            }
                        });
                    }
                });
            });

            $(function() {
                var urlLike = '{{ url('admin/gcat') }}';
                $('#upload_id').change(function() {
                    var up = $('#grand').empty();
                    var cat_id = $(this).val();
                    if (cat_id) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: "GET",
                            url: urlLike,
                            data: {
                                catId: cat_id
                            },
                            success: function(data) {
                                console.log(data);
                                up.append('<option value="0">Please Choose</option>');
                                $.each(data, function(id, title) {
                                    up.append($('<option>', {
                                        value: id,
                                        text: title
                                    }));
                                });
                            },
                            error: function(XMLHttpRequest, textStatus, errorThrown) {
                                console.log(XMLHttpRequest);
                            }
                        });
                    }
                });
            });
        })(jQuery);
    </script>


    <script>
        $(".midia-toggle").midia({
            base_url: '{{ url('') }}',
            title: 'Choose Course Image',
            dropzone: {
                acceptedFiles: '.jpg,.png,.jpeg,.webp,.bmp,.gif'
            },
            directory_name: 'course'
        });
    </script>
@endsection
