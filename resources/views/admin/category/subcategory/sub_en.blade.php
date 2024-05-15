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
                    <form id="demo-form2" method="post" action="{{ url('subcategory/') }}" data-parsley-validate class="form-horizontal form-label-left" autocomplete="off">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="form-group">
                                <form id="demo-form2" method="post" action="{{ url('subcategory/') }}" data-parsley-validate class="form-horizontal form-label-left" autocomplete="off">
                                    {{ csrf_field() }}

                                    <div class="row">
                                        <div class="col-md-10">
                                            <label for="exampleInputTit1e">{{ __('adminstaticword.Category') }}</label>
                                            <select name="category_id" class="form-control select2">
                                                @foreach ($category as $cate)
                                                <option value="{{ $cate->id }}">
                                                    {{ $cate->getTranslation('title', 'en', false) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <br>
                                            <button type="button" data-dismiss="modal" data-toggle="modal" data-target="#myModal9" title="AddCategory" class="btn btn-md btn-primary">+</button>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="exampleInputTit1e">{{ __('adminstaticword.SubCategory') }}:<sup class="redstar">*</sup></label>
                                            <input type="text" class="form-control" name="title" id="exampleInputTitle" placeholder="Enter subcategory" value="">
                                        </div>
                                    </div>
                                    <br> 
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="exampleInputTit1e">{{ __('adminstaticword.Slug') }}:<sup class="redstar">*</sup></label>
                                            <input pattern="[/^\S*$/]+" type="text" class="form-control" name="slug" id="exampleInputTitle" placeholder="Enter slug" value="">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-md-12">
                                        <label for="exampleInputTit1e">{{ __('adminstaticword.Icon') }}:<sup class="redstar"></sup></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control iconvalue" name="icon" value="Choose icon">
                                            <span class="input-group-append">
                                                <button type="button" class="btnicon btn btn-outline-secondary" role="iconpicker"></button>
                                            </span>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-md-6">
                                        <label for="exampleInputDetails">{{ __('adminstaticword.Status') }}:<sup class="redstar text-danger">*</sup></label><br>
                                        <input id="status_toggle" type="checkbox" class="custom_toggle" name="status" checked />
                                        <input type="hidden" name="free" value="0" for="status" id="status">

                                    </div>
                            </div>


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
</div>

<script>
    (function($) {
        "use strict";
        tinymce.init({
            selector: 'textarea'
        });
    })(jQuery);

</script>
