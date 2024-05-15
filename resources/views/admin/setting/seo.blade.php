<form action="{{ route('seo.set') }}" method="POST">
	@csrf
	<div class="row">
		<div class="col-md-6">
			<div class="form-group{{ $errors->has('meta_data_desc') ? ' has-error' : '' }}">
				<label class="text-dark" for="">{{ __('adminstaticword.MetaDataDescription') }} :</label>
				<textarea class="form-control" name="meta_data_desc" id="inputTextarea" rows="3" placeholder="Enter description">{{ $setting->meta_data_desc }}</textarea>
				<small class="text-danger">{{ $errors->first('meta_data_desc','Meta data description is required !') }}</small>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group{{ $errors->has('meta_data_keyword') ? ' has-error' : '' }}">
				<label class="text-dark" for="">{{ __('adminstaticword.MetaDataKeywords') }} :</label>
				<textarea class="form-control" name="meta_data_keyword" id="inputTextarea" rows="3" placeholder="Use Comma to seprate keyword">{{ $setting->meta_data_keyword }}</textarea>
				<small class="text-danger">{{ $errors->first('meta_data_keyword','Meta Keyword Cannot be blank !') }}</small>
			</div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group{{ $errors->has('google_ana') ? ' has-error' : '' }}">
				<label class="text-dark" for="">{{ __('adminstaticword.GoogleAnalyticKey') }} :</label>
				<input type="text" class="form-control" placeholder="Enter Google analytic key" name="google_ana" value="{{ $setting->google_ana }}">
				<small class="text-danger">{{ $errors->first('google_ana','Google analytic Code is required !') }}</small>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group{{ $errors->has('fb_pixel') ? ' has-error' : '' }}">
				<label class="text-dark" for="">{{ __('adminstaticword.FacebookPixelCode') }} :</label>
				<input type="text" name="fb_pixel" class="form-control" placeholder="Enter Facebook Pixel Code" value="{{ $setting->fb_pixel }}">
				<small class="text-danger">{{ $errors->first('fb_pixel','Facebook Pixel Code is required !') }}</small>
			</div>
		</div>
	</div>
	
	<div class="form-group">
		<button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
		<button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
		{{ __("Update")}}</button>
	</div>
	
</form>


