@extends('admin.layouts.master')
@section('title','Create a new subcategory')
@section('breadcum')
@component('components.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
   {{ __('Subcategory') }}
@endslot

@slot('menu1')
   {{ __('Subcategory') }}
@endslot

@slot('button')

<div class="col-md-4 col-lg-4">
  <div class="widgetbar">
    <a href="{{ url('subcategory') }}" class="float-right btn btn-dark-rgba mr-2"><i
      class="feather icon-arrow-left mr-2"></i>Back</a></div>                        
</div>

@endslot
@endcomponent
@if ($errors->any())
<div class="alert alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif
<div class="contentbar">
  <div class="row">
    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="card-tittle">{{ __('adminstaticword.Add') }} {{ __('Subcategory') }}</h5>
        </div>
        <div class="card-body">
          <form id="demo-form2" method="post" action="{{url('subcategory/')}}" data-parsley-validate class="form-horizontal form-label-left" autocomplete="off">
            {{ csrf_field() }}
            <div class="box-body">
              <div class="form-group">
                <form id="demo-form2" method="post" action="{{url('subcategory/')}}" data-parsley-validate class="form-horizontal form-label-left" autocomplete="off">
                  {{ csrf_field() }}
    
                  <div class="row">
                    <div class="col-md-6">
                      <label for="exampleInputTit1e">{{ __('adminstaticword.Category') }}</label>
                      <select name="category_id" class="form-control select2">
                        @foreach($category as $cate)
                        <option value="{{$cate->id}}">{{$cate->title}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label for="exampleInputTit1e">{{ __('adminstaticword.Category') }}</label>
                      <br>
                      <button type="button" data-dismiss="modal" data-toggle="modal" data-target="#myModal9" title="AddCategory"  class="btn btn-md btn-primary col-md-5">{{ __('adminstaticword.Add') }}</button>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-6">
                      <label for="exampleInputTit1e">{{ __('adminstaticword.SubCategory') }}:<sup class="redstar">*</sup></label>
                      <input type="text" class="form-control" name="title" id="exampleInputTitle" placeholder="Enter Your subcategory" value="">
                    </div>
    
                     <div class="col-md-6">
                      <label for="exampleInputTit1e">{{ __('adminstaticword.Slug') }}:<sup class="redstar">*</sup></label>
                      <input pattern="[/^\S*$/]+" type="text" class="form-control" name="slug" id="exampleInputTitle" placeholder="Enter slug" value="">
                    </div>
                    
                  </div>
                  <br>
    
                  <div class="row">
    
                    <div class="col-md-6">
                      <label for="exampleInputTit1e">{{ __('adminstaticword.Icon') }}:</label>
                      <input type="text" class="form-control icp-auto icp" name="icon" id="exampleInputTitle" placeholder="Enter Your icon" value="">
                      
                      <div class="input-group">
                  <input type="text" class="form-control iconvalue" name="icon" value="Choose icon">
                  <span class="input-group-append">
                      <button  type="button" class="btnicon btn btn-outline-secondary" role="iconpicker"></button>
                  </span>
              </div>
                    </div>
    
                    <div class="col-md-6">
                      <label for="exampleInputDetails">{{ __('adminstaticword.Status') }}:</label><br>
                    <input id="status_toggle" type="checkbox" class="custom_toggle" name="status" checked/>
                    <input type="hidden" name="free" value="0" for="status" id="status">
                     
                    </div>
                  </div>
                  <br>
             
                  <div class="form-group">
                    <button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i> Reset</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                        Create</button>
                </div>
            
            <div class="clear-both"></div>
           
               
            </div>
          </form>
          

        </div>
      </div>
    </div>
  </div>
</div>
@include('admin.category.subcategory.cat') 

@endsection


