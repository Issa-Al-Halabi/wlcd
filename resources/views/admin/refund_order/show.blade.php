@extends('admin.layouts.master')
@section('title', 'Refund Orders - Admin')
@section('body')


<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header with-border">
            <h1 class="box-title">{{ __('adminstaticword.RefundOrders') }}</h1>
        </div>
       <div class="box-body">
          <!-- Nav tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs" id="nav-tab" role="tablist">
              <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><i class="flaticon-optimization" aria-hidden="true"></i> {{ __('adminstaticword.RefundRequest') }}</a></li>
              <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><i class="flaticon-graduation" aria-hidden="true"></i> {{ __('adminstaticword.RefundCompleted') }}</a></li>
             
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane fade in active" id="home">
                <br>
                @include('admin.refund_order.index')
              </div>
              <div role="tabpanel" class="fade tab-pane" id="profile">
                <br>
                @include('admin.refund_order.refunded')
              </div>
             
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection

@section('scripts')

<script>
(function($) {
  "use strict";


  $(document).ready(function(){
    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if(activeTab){
        $('#nav-tab a[href="' + activeTab + '"]').tab('show');
    }
  });

})(jQuery);

</script>



@endsection
