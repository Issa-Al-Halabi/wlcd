@extends('admin.layouts.master')
@section('title', 'IP Block Settings - Admin')
@section('maincontent')
@component('components.breadcumb',['fourthactive' => 'active'])
@slot('heading')
   {{ __('IP Block Settings') }}
@endslot
@slot('menu1')
{{ __('IP Block Settings') }}
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
                    <h5 class="card-box">{{ __('IP Block Settings') }}</h5>
                </div> 
               
                <!-- card body started -->
                <div class="card-body">
                        <!-- form start -->
				  <form action="{{ url('admin/ipblock/update') }}" method="POST">
			            @csrf
			            <div class="form-group">
			            	<label for="url">{{ __('Enter IP Address to block') }} (ex: 172.16.254.1, 506.457.14.512)</label>
							<select class="select2-multi-select form-control" name="ipblock[]" multiple="multiple">
							@if(is_array($settings['ipblock']) || is_object($settings['ipblock']))
		                      @foreach($settings['ipblock'] as $cat)
		                        <option value="{{ $cat }}" {{in_array($cat, $settings['ipblock'] ?: []) ? "selected": ""}} >{{ $cat }}
		                        </option>
		                      @endforeach
		                    @endif
		                    </select>
		                </div>

						<div class="form-group">
							<button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
							<button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
							{{ __('adminstaticword.Update') }}</button>
						</div>
		            
			        </form>
                  <!-- form end -->
                </div><!-- card body end -->
            
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