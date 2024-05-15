@extends('admin.layouts.master')
@section('title','Edit Childcategory')
@section('maincontent')

@component('components.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __('Admin') }}
@endslot

@slot('menu2')
{{ __(' Edit Childcategory') }}
@endslot

@slot('button')
<div class="col-md-4 col-lg-4">
  <a href="{{ url('courseanswer/'. $show->courses->id) }}" class="float-right btn btn-primary mr-2"><i
      class="feather icon-arrow-left mr-2"></i>Back</a>
</div>
@endslot

@endcomponent
 
<div class="contentbar">
   	<div class="row">
	    <div class="col-md-12">
	    	<div class="card m-b-30">
	           	<div class="card-header">
	          	<h3 class="card-box"> {{ __('adminstaticword.Edit') }} {{ __('adminstaticword.Answer') }}</h3>
	       		</div>
	          	<div class="card-body ml-2">
	          		<form action="{{route('courseanswer.update',$show->id)}}" method="POST" enctype="multipart/form-data">
		                {{ csrf_field() }}
		                {{ method_field('PUT') }}
						

						<input type="hidden" name="instructor_id" class="form-control" value="{{ Auth::User()->id }}"  />
						
		              
	                    <input type="hidden" value="{{ $show->course_id }}" autofocus name="course_id" type="text" class="form-control d-none" >


	                    <div class="row">
	                    	<div class="col-md-12">
	                    		<label for="exampleInput">{{ __('adminstaticword.Answer') }}:<sup class="redstar">*</sup></label>
	                  			<textarea id="detail" name="answer" rows="4" class="form-control" placeholder="Please Enter Your Answer" required>{{ $show->answer }}</textarea>
	                    	</div>
	                    </div>
		              	
		              	<br>


		              	<div class="form-group col-md-12">
                          <label class="text-dark" for="exampleInputDetails">{{ __('adminstaticword.Status') }} :</label><br>
                          <label class="switch">
                            <input class="slider" type="checkbox" name="status" {{ $show->status == '1' ? 'checked' : '' }} />
                            <span class="knob"></span>
                          </label>
                        </div>
		              	<br>
		              	<br>
		              	<br>
		              	
						<div class="box-footer">
		              		<button value="" type="submit"  class="btn btn-md col-md-2 btn-primary-rgba">{{ __('adminstaticword.Save') }}</button>
		              	</div>

		          	</form>
	          	</div>
	      	</div>
	  	</div>
  	</div>
</div>
@endsection
