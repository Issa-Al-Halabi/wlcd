@extends('admin.layouts.master')
@section('title', 'Edit Facts - Admin')
@section('maincontent')
@component('components.breadcumb',['thirdactive' => 'active'])
@slot('heading')
   {{ __('Edit Facts') }}
@endslot
@slot('menu1')
{{ __('Facts') }}
@endslot
@slot('menu2')
{{ __('Edit Facts') }}
@endslot

@slot('button')
<div class="col-md-4 col-lg-4">
  <div class="widgetbar">
    <a href="{{url('fact')}}" class="btn btn-primary-rgba"><i class="feather icon-arrow-left mr-2"></i>{{ __("Back")}}</a>

  </div>
</div>
@endslot
@endcomponent

<div class="contentbar">
  @if ($errors->any())  
  <div class="alert alert-danger" role="alert">
  @foreach($errors->all() as $error)     
  <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true" style="color:red;">&times;</span></button></p>
      @endforeach  
  </div>
  @endif
                          
                        
  <div class="row">
    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="card-title">{{ __('Edit Fact') }}</h5>
        </div>
        <div class="card-body">
            <form id="demo-form2" method="post" action="{{ route('fact.update',$data->id) }}" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
              {{ csrf_field() }}
              {{ method_field('PUT') }}

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="exampleInputTit1e">{{ __('Tittle') }}:<sup
                                        class="redstar text-danger">*</sup></label>
                                <input class="form-control" type="text" name="title" value={{ $data->title }}
                                    placeholder="{{ __('Enter Tittle') }}">

                            </div>

                            <div class="form-group col-md-6">
                                <label for="exampleInputSlug"> {{ __('Image') }}:<sup
                                        class="redstar text-danger">*</sup></label><br>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"
                                            id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" name="image" class="custom-file-input" id="inputGroupFile01"
                                            aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label"
                                            for="inputGroupFile01">{{ __('Choose file') }}</label>
                                    </div>
                                </div>
                                @if($data->image != null || $data->image !='')
                                <div class="edit-user-img">
                                  <img src="{{ url('/images/facts/'.$data->image) }}"  alt="User Image" class="img-responsive image_size">
                                </div>
                                @else
                                <div class="edit-user-img">
                                  <img src="{{ asset('images/fact/'.$data->tittle)}}"  alt="User Image" class="img-responsive img-circle">
                                </div>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label class="text-dark"
                                    for="exampleInputDetails">{{ __('adminstaticword.Description') }}:<sup
                                    class="redstar text-danger">*</sup></label>
                                <input name="description" value="{{ $data->description }}" rows="1" class="form-control"
                                    placeholder="{{ __('adminstaticword.Please') }} {{ __('adminstaticword.Enter') }} description">
                            </div>



                            <div class="col-md-6 form-group">
                                <label for="exampleInputSlug">{{ __('Number') }}:<sup
                                  class="redstar text-danger">*</sup></label>
                                <input type="number" name="number"  value="{{ $data->number }}" class="form-control" />
                            </div>
                            <div class="form-group col-md-2">
                              <label class="text-dark" for="exampleInputDetails">{{ __('adminstaticword.Status') }} :</label><br>
                              <input type="checkbox" class="custom_toggle" name="status" {{ $data->status == '1' ? 'checked' : '' }} />
                              
                          </div>
                            <div class="form-group col-md-12">
                                <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i>
                                    {{ __("Reset")}}</button>
                                <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                    {{ __("Update")}}</button>
                            </div>
                    </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection