@extends('admin.layouts.master')
@section('title','Create a new Refund Policy')
@section('breadcum')
@component('components.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
{{ __('Refund Policy') }}
@endslot

@slot('menu1')
{{ __('Refund Policy') }}
@endslot

@slot('button')

<div class="col-md-4 col-lg-4">
  <div class="widgetbar">
    <a href="{{url('refundpolicy')}}" class="btn btn-primary-rgba"><i
        class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a> </div>
</div>

@endslot
@endcomponent
<div class="contentbar">
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
          <h5 class="box-tittle">{{ __('adminstaticword.Add') }} {{ __('adminstaticword.RefundPolicy') }}</h5>
        </div>
        <div class="card-body">
          <form id="demo-form2" method="post" action="{{url('refundpolicy/')}}" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
            {{ csrf_field() }}
        
            <div class="row">
              <div class="form-group col-md-6">
                <label for="exampleInputTit1e">{{ __('adminstaticword.Name') }}:<sup class="redstar">*</sup></label>
                <input type="text"  class="form-control" name="name" placeholder=" Please Enter your name"  id="exampleInputTitle" value="">
              </div>
              
              
           
            <br>

            
              <div class="form-group col-md-6">
                <label for="exampleInputTit1e">{{ __('adminstaticword.Days') }}:<sup class="redstar">*</sup></label>
                <input type="number"  class="form-control" name="days" placeholder=" PleaseEnter Return Days"  id="exampleInputTitle" value="">
              </div>
              
            
            <br>

           
              <div class="col-md-12">
                <label for="exampleInputDetails">{{ __('adminstaticword.Detail') }}:<sup class="redstar">*</sup></label>
                <textarea name="detail"  rows="5" class="form-control" placeholder="Enter Your Details"></textarea>
                <br>
              </div>


              
              <div class="form-group col-md-6">                 
                <label for="exampleInputDetails">{{ __('adminstaticword.Status') }}:</label>
                <input id="123"  type="checkbox" class="custom_toggle" name="status" checked />
              </div>

              
            </div>
            <br>

            <div class="form-group">
              <button type="reset" class="btn btn-danger-rgba"><i class="fa fa-ban"></i> {{ __('Reset') }}</button>
              <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
               {{ __('Create') }} </button>
            </div>

            <div class="clear-both"></div>
            
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')



  <script>
tinymce.init({
  selector: '#editor1,#editor2,.editor',
  height: 350,
  menubar: 'edit view insert format tools table tc',
  autosave_ask_before_unload: true,
  autosave_interval: "30s",
  autosave_prefix: "{path}{query}-{id}-",
  autosave_restore_when_empty: false,
  autosave_retention: "2m",
  image_advtab: true,
  plugins: [
    'advlist autolink lists link image charmap print preview anchor',
    'searchreplace visualblocks fullscreen',
    'insertdatetime media table paste wordcount'
  ],
  toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media  template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
  content_css: '//www.tiny.cloud/css/codepen.min.css'
});
</script>
@endsection



