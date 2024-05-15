@extends('admin.layouts.master')
@section('title', 'View Subscription - Admin')
@section('body')
 
<section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">View {{ __('adminstaticword.Subscription') }}</h3>
            </div>
            <div class="panel-body">
        
            <div id="printableArea">
              <!-- title row -->
              <div class="row">
                  <div class="col-xs-12">
                    <h2 class="page-header">
                      @if($setting->logo_type == 'L')
                        <div class="logo-invoice">
                          <img src="{{ asset('images/logo/'.$setting->logo) }}">
                        </div>
                      @else()
                          <a href="{{ url('/') }}"><b><div class="logotext" >{{ $setting->project_title }}</div></b></a>
                      @endif
                      <small>{{ __('adminstaticword.Date') }}:&nbsp;{{ date('jS F Y', strtotime($plans['created_at'])) }}</small>
                    </h2>
                  </div>
                  <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="view-order">
                <div class="row invoice-info">
                   
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                      {{ __('adminstaticword.User') }}:
                      <address>
                        <strong>
                          @if(Auth::user()->role == "admin")
                          {{$plans->user['fname'] }} {{$plans->user['lname']}}
                          @else
                            @if($gsetting->hide_identity == 0)
                            {{$plans->user['fname'] }} {{$plans->user['lname']}}
                            @else
                              Hidden
                            @endif
                          @endif
                        </strong><br>
                          {{ __('adminstaticword.Address') }}: {{ $plans->user['address'] }}<br>
                        @if($plans->user['state_id'] == !NULL)
                          {{ $plans->user->state['name'] }},
                        @endif
                        @if($plans->user['country_id'] == !NULL)
                          {{ $plans->user->country['name'] }}<br>
                        @endif
                          {{ __('adminstaticword.Phone') }}:&nbsp;
                          
                          @if(Auth::user()->role == "admin")
                          {{ $plans->user['mobile'] }}
                          @else
                            @if($gsetting->hide_identity == 0)
                            {{ $plans->user['mobile'] }}
                            @else
                              Hidden
                            @endif
                          @endif
                          <br>
                          {{ __('adminstaticword.Email') }}:&nbsp;
                          @if(Auth::user()->role == "admin")
                          {{ $plans->user['email'] }}
                          @else
                            @if($gsetting->hide_identity == 0)
                            {{ $plans->user['email'] }}
                            @else
                              Hidden
                            @endif
                          @endif
                      </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4 invoice-col">
                      <br>
                      <b>{{ __('adminstaticword.OrderID') }}:</b> {{ $plans['order_id'] }}<br>
                      <b>{{ __('adminstaticword.TransactionId') }}:</b>&nbsp;{{ $plans['transaction_id'] }}<br>
                      <b>{{ __('adminstaticword.PaymentMethod') }}:</b>&nbsp;{{ $plans['payment_method'] }}<br>
                      <b>{{ __('adminstaticword.Currency') }}:</b>&nbsp;{{ $plans['currency'] }}
                      
                      </br>
                      <b>{{ __('adminstaticword.Enrollon') }}:</b> {{ date('jS F Y', strtotime($plans['created_at'])) }}</br>
                      <b>
                        @if($plans->enroll_expire != NULL)
                          {{ __('adminstaticword.EnrollEnd') }}:</b> {{ date('jS F Y', strtotime($plans['enroll_expire'])) }}</br>
                        @endif
                        <br>

                       
                        
                    </div>
                    <!-- /.col -->
                </div>
              </div>
              <!-- /.row -->
                    
              <div class="order-table">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>{{ __('adminstaticword.Plan') }}</th>
                      <th>{{ __('adminstaticword.Currency') }}</th>
                      
                      <th>{{ __('adminstaticword.Total') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        
                          {{ $plans->plans['title'] }}
                        
                      </td>
                      
                      <td>{{ $plans['currency'] }}</td>

                      

                      <td>
                        
                            <i class="fa {{ $plans['currency_icon'] }}"></i>{{ $plans['total_amount'] }}

                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              

            </div>
            
            <input type="button" class="btn btn-primary"  onclick="printDiv('printableArea')" value="Print Invoice" />

            </div>
        </div>
      </div>
    </div>
</section>

@endsection


@section('scripts')

<script>
    $(document).ready(function() {
      $('.js-example-basic-single').select2();
    });
</script>

<script lang='javascript'>
    function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
  }
</script>
@endsection


