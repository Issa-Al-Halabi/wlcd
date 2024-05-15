@extends('admin.layouts.master')
@section('title', 'Import Demo - Admin')
@section('maincontent')
@component('components.breadcumb',['fourthactive' => 'active'])
@slot('heading')
   {{ __('Import Demo') }}
@endslot
@slot('menu1')
{{ __('Import Demo') }}
@endslot
@slot('button')
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
                    <h5 class="card-box">{{ __('Demo Import') }}</h5>
                </div> 
               
                <!-- card body started -->
                <div class="card-body">
                
                    <div class="card-body bg-success-rgba">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <small class="text-success process-fonts"><i class="fa fa-info-circle"></i> {{ __('adminstaticword.ImportantNote') }}
                                    <ul class="process-font">
                                        <li>
                                            ON Click of import data your existing data will remove (except users &amp; settings)
                                        </li>
                                        <li>
                                            ON Click of reset data will reset your site (which you see after fresh install).
                                        </li>
                                    </ul>
                                
                            </div>
                        </div>
                    </div>
                
                <!-- ========== DemoImport and reset start ===================== -->
                <div class="row">
                    <!-- DemoImport start -->
                    <div class="col-6">
                        <!-- ========== DemoImport start ===================== -->
                        <!-- form start -->
                        <form action="{{ url('admin/import/demo') }}" class="form" method="POST">
                            @csrf
                            <!-- row start -->
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- card start -->
                                    <div class="card">
                                        <!-- card body start -->
                                        <div class="card-body">
                                            <!-- row start -->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <!-- row start -->
                                                    <div class="row">       
                                                            <!-- DemoImport -->
                                                            <div class="col-md-12">
                                                                <label class="text-dark">{{ __('adminstaticword.DemoImport') }} :<span class="text-danger">*</span></label>
                                                                <button type="submit" class="btn btn-danger-rgba btn-lg btn-block">
                                                                    {{ __('adminstaticword.DemoImport') }}
                                                                </button>
                                                            </div>
                                                    </div><!-- row end -->
                                                </div><!-- col end -->
                                            </div><!-- row end -->
                                        </div><!-- card body end -->
                                    </div><!-- card end -->
                                </div><!-- col end -->
                            </div><!-- row end -->
                        </form>
                    <!-- form end -->
                    </div>
                    <!-- DemoImport end -->
                    <!-- reset start -->
                    <div class="col-6">
                          <!-- form start -->
                        <form action="{{ url('admin/reset/demo') }}" class="form" method="POST">
                            @csrf
                            <!-- row start -->
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- card start -->
                                    <div class="card">
                                        <!-- card body start -->
                                        <div class="card-body">
                                            <!-- row start -->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <!-- row start -->
                                                    <div class="row">       
                                                        <!-- ResetDemo -->
                                                        <div class="col-md-12">
                                                                <label class="text-dark">{{ __('adminstaticword.ResetDemo') }} :<span class="text-danger">*</span></label>
                                                                <button type="submit" class="btn btn-warning-rgba btn-lg btn-block">
                                                                    {{ __('adminstaticword.ResetDemo') }}
                                                                </button>
                                                        </div>
                                                    </div><!-- row end -->
                                                </div><!-- col end -->
                                            </div><!-- row end -->
                                        </div><!-- card body end -->
                                    </div><!-- card end -->
                                </div><!-- col end -->
                            </div><!-- row end -->
                        </form>
                    <!-- form end -->
                    </div>
                     <!-- reset end -->
                </div>
                <!-- ========== DemoImport and reset end ===================== -->
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