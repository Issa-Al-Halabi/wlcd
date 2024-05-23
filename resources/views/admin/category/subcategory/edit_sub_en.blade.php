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
                </div>
                <div class="card-body">
                    <form id="demo-form" method="post" action="{{ url('subcategory/' . $cat->id) }}"
                        data-parsley-validate class="form-horizontal form-label-left" autocomplete="off">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <input type="hidden" name="lang" value="en" id="lang">

                        <div class="row">

                            <div class="col-md-6">
                                <label for="exampleInputSlug">{{ __('adminstaticword.SelectCategory') }}</label>
                                <select name="category_id" class="form-control select2">

                                    @foreach ($category as $cou)
                                        <option value="{{ $cou->id }}"
                                            {{ $cat->category_id == $cou->id ? 'selected' : '' }}>
                                            {{ $cou->getTranslation('title', 'en', false) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="exampleInputTit1e">{{ __('adminstaticword.SubCategory') }}:<span
                                        class="redstar">*</span></label>
                                <input type="title" class="form-control" name="title" id="exampleInputTitle"
                                    value="{{ $cat->getTranslation('title', 'en', false) }}">
                            </div>
                        </div>
                        <br>
                        <div class="row">

                            <div class="col-md-6">
                                <label for="exampleInputTit1e">{{ __('adminstaticword.Slug') }}:<sup
                                        class="redstar">*</sup></label>
                                <input pattern="[/^\S*$/]+" type="text" class="form-control" name="slug"
                                    id="exampleInputTitle" placeholder=" Please Enter slug"
                                    value="{{ $cat->slug }}">
                            </div>


                            <div class="col-md-6">
                                <label for="icon">{{ __('adminstaticword.Icon') }}:<span
                                        class="redstar">*</span></label>

                                <div class="input-group">
                                    <input type="text" class="form-control iconvalue" name="icon"
                                        value="{{ $cat->icon }}">
                                    <span class="input-group-append">
                                        <button type="button" class="btnicon btn btn-outline-secondary"
                                            role="iconpicker"></button>
                                    </span>
                                </div>
                            </div>



                        </div>
                        <br>

                        <div class="row">

                            <div class="col-md-6">
                                <label for="exampleInputDetails">{{ __('adminstaticword.Status') }}:<sup
                                        class="redstar text-danger">*</sup></label><br>
                                <input id="status" type="checkbox" class="custom_toggle"
                                    {{ $cat->status == '1' ? 'checked' : '' }} name="status" />

                            </div>
                        </div>
                        <br>



                        <div class="form-group">
                            <button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i>
                                {{ __('Reset') }}</button>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                                {{ __('Update') }}</button>
                        </div>

                        <div class="clear-both"></div>
                    </form>
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
