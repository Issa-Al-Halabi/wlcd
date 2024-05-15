@extends('admin.layouts.master')
@section('title', 'Adsense Setting - Admin')
@section('maincontent')
@component('components.breadcumb',['fourthactive' => 'active'])
@slot('heading')
   {{ __('Adsense Settings') }}
@endslot
@slot('menu1')
{{ __('Adsense Settings') }}
@endslot
@endcomponent
<div class="contentbar">
    <div class="row">
@if ($errors->any())  
  <div class="alert alert-danger" role="alert">
  @foreach($errors->all() as $error)     
  <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true" style="color:red;">&times;</span></button></p>
      @endforeach  
  </div>
  @endif
  
    <!-- row started -->
    <div class="col-lg-12">
    
        <div class="card m-b-30">
                <!-- Card header will display you the heading -->
                <div class="card-header">
                    <h5 class="card-box">{{ __('adminstaticword.AdsenseSetting') }}</h5>
                </div> 
               
                <!-- card body started -->
                <div class="card-body">
                <!-- form start -->
				<form action="{{ action('AdsenseController@update') }}" method="POST" enctype="multipart/form-data">
		                {{ csrf_field() }}
		                {{ method_field('PUT') }}
		                <div class="form-group">
			                <label class="text-dark" for="policy">{{ __('adminstaticword.EnterYourAdsenseScript') }} :<span class="text-danger">*</span></label>
                            <textarea class="form-control" name="code" id="inputTextarea" rows="3" placeholder="Textarea text">{{ optional($ad)->code }}</textarea>
			            </div>
			            <br>

			            <div class="row">
                            <div class="form-group col-md-4">
                                <label class="text-dark" for="exampleInputDetails">{{ __('adminstaticword.Status') }} :</label><br>
                                <input type="checkbox" class="custom_toggle" name="status" {{ optional($ad)->status == 1 ? 'checked' : '' }} />
                                <input type="hidden"  name="free" value="0" for="status" id="status">
                            </div>
    						
                            <div class="form-group col-md-4">
                                <label class="text-dark" for="exampleInputDetails">{{ __('adminstaticword.VisibleonHome') }} :</label><br>
                                <input type="checkbox" class="custom_toggle" name="ishome"  {{ optional($ad)->ishome == 1 ? 'checked' : '' }} />
                                <input type="hidden"  name="free" value="0" for="status" id="status">
                            </div>
    						
                            <div class="form-group col-md-4">
                                <label class="text-dark" for="exampleInputDetails">{{ __('adminstaticword.VisibleonCart') }} :</label><br>
                                <input type="checkbox" class="custom_toggle" name="iscart"  {{ optional($ad)->iscart == 1 ? 'checked' : '' }} />
                                <input type="hidden"  name="free" value="0" for="status" id="status">
                            </div>
    						
                            <div class="form-group col-md-4">
                                <label class="text-dark" for="exampleInputDetails">{{ __('adminstaticword.VisibleonWishlist') }} :</label><br>
                                <input type="checkbox" class="custom_toggle" name="iswishlist"  {{ optional($ad)->iswishlist == 1 ? 'checked' : '' }} />
                                <input type="hidden"  name="free" value="0" for="status" id="status">
                            </div>
    						
                            <div class="form-group col-md-4">
                                <label class="text-dark" for="exampleInputDetails">{{ __('adminstaticword.VisibleonDetail') }} :</label><br>
                                <input type="checkbox" class="custom_toggle" name="isdetail"  {{ optional($ad)->isdetail == 1 ? 'checked' : '' }} />
                                <input type="hidden"  name="free" value="0" for="status" id="status">
                            </div>
    						
                            <div class="form-group col-md-4">
                                <label class="text-dark" for="exampleInputDetails">{{ __('adminstaticword.VisibleonAll') }} :</label><br>
                                <input type="checkbox" class="custom_toggle" name="isviewall"  {{ optional($ad)->isviewall == 1 ? 'checked' : '' }} />
                                <input type="hidden"  name="free" value="0" for="status" id="status">
                            </div>
    					
    					</div>

						<div class="form-group">
                            <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                            <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                {{ __("Update")}}</button>
                        </div>

		          	</form>
                  <!-- form end -->
                </div>
				<!-- card body end -->
            
        </div><!-- col end -->
    </div>
</div>
</div><!-- row end -->
    <br><br>
@endsection
<!-- main content section ended -->
<!-- This section will contain javacsript start -->
@section('script')

@endsection
<!-- This section will contain javacsript end -->