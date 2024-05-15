<div>
    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true" style="color:red;">&times;</span></button></p>
            @endforeach
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">{{ __('Add Faq') }}</h5>
                </div>
                <div class="card-body">

                    <!-- form start -->
                    <form action="{{ route('flash-sales.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">

                            <label for="">{{ __("Title:") }} <span class="text-danger">*</span> </label>
                            <input type="text" class="form-control" class="required" name="title"
                                placeholder="Halloween Sale" value="{{ old('title') }}">
                        </div>

                        <div class="form-group">
                            <label for="">{{ __("Background image:") }} <span class="text-danger">*</span> </label>
                            <div class="input-group ">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                                </div>
                                <div class="custom-file">

                                    <input required type="file" name="background_image" class="custom-file-input"
                                        id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose background image') }}
                                         (2000x2000)</label>

                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">{{ __("Start date:") }} <span class="text-danger">*</span> </label>
                            <input required value="{{ old('start_date') ?? now()->addDays(1)->format('Y-m-d h:i a') }}"
                                type="text" class="timepickerwithdate form-control" class="required"
                                name="start_date" />
                        </div>

                        <div class="form-group">
                            <label for="">{{ __("End date:") }} <span class="text-danger">*</span> </label>
                            <input required value="{{ old('end_date') ?? now()->addDays(7)->format('Y-m-d h:i a') }}"
                                type="text" class="timepickerwithdate form-control" class="required" name="end_date" />
                        </div>

                        <div class="form-group">
                            <label for="">{{ __("Detail:") }}</label>
                            <textarea name="detail" id="detail" cols="30" rows="10">{{ old("detail") }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Status') }} :</label>
                            <br>
                            <label class="switch">
                                <input id="status" type="checkbox" name="status" {{ old('status') ? "checked" : "" }}>
                                <span class="knob"></span>
                            </label>
                        </div>

                        <h4>{{ __('Select Courses') }}</h4>

                        <table class="courselist table table-bordered table-hover">
                            <thead>
                                <th>{{ __('Courses') }}</th>
                                <th>{{ __('Discount') }}</th>
                                <th>{{ __("Discount type") }}</th>
                                <th>
                                    {{ __('#') }}
                                </th>
                            </thead>

                            <tbody>

                                @if(!old('course'))

                                    <tr>
                                        <td>
                                            <input type="text" class="course_name form-control" placeholder="Search course"
                                                required name="course[]">
                                            
                                            <input type="hidden" class="form-control course_ids" name="course_id[]">
                                        </td>
                                        <td>
                                            <div class="input-group">

                                                <input type="number" min="1" class="form-control" placeholder="50" required
                                                    name="discount[]">
                                                <span class="input-group-text">
                                                    %
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <select name="discount_type[]" class="mt-3 form-control" id="discount_type">
                                                    <option value="">{{ __('Select discount type') }}</option>
                                                    <option value="fixed">{{ __('Fixed') }}</option>
                                                    <option value="upto">{{ __('Upto') }}</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <button type="button" class="addnew btn-primary-rgba btn-sm">
                                                <i class="feather icon-plus"></i>
                                            </button>
                                            <button type="button" class="removeBtn btn-danger-rgba btn-sm">
                                                <i class="feather icon-trash"></i>
                                            </button>
                                        </td>
                                    </tr>


                                @else 

                                    @foreach(old('course') as $key => $course)
                                    
                                        <tr>
                                            <td>
                                                <input type="text" class="course_name form-control" placeholder="Search course"
                                                    required name="course[]" value="{{ $course ?? '' }}">
                                               
                                                <input type="hidden" value="{{ old('course_id')[$key] }}" class="form-control course_ids" name="course_id[]">
                                            </td>
                                            <td>
                                                <div class="input-group">

                                                    <input value="{{ old('discount')[$key] }}" type="number" min="1" class="form-control" placeholder="50" required
                                                        name="discount[]">
                                                    <span class="input-group-text">
                                                        %
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <select name="discount_type[]" class="mt-3 form-control" id="discount_type">
                                                        <option value="">{{ __('Select discount type') }}</option>
                                                        <option {{ old('discount_type')[$key] == 'fixed' ? "selected" : "" }} value="fixed">{{ __('Fixed') }}</option>
                                                        <option {{ old('discount_type')[$key] == 'upto' ? "selected" : "" }} value="upto">{{ __('Upto') }}</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <button type="button" class="addnew btn-primary-rgba btn-sm">
                                                    <i class="feather icon-plus"></i>
                                                </button>
                                                <button type="button" class="removeBtn btn-danger-rgba btn-sm">
                                                    <i class="feather icon-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                
                                    @endforeach

                                @endif
                            </tbody>
                        </table>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success-rgba">
                                <i class="feather icon-plus"></i> {{__("Create")}}
                            </button>
                        </div>

                    </form>
                    <!-- form end -->

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function($) {
        "use strict";
        tinymce.init({
            selector: 'textarea'
        });
    })(jQuery);
</script>
