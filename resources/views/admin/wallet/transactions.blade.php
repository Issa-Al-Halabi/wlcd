@extends('admin.layouts.master')
@section('title', __('Wallet Transactions - Admin'))
@section('maincontent')

  @component('components.breadcumb',['secondactive' => 'active'])

    @slot('heading')
      {{ __('Wallet Transactions') }}
    @endslot
    @slot('menu1')
      {{ __('Wallet Transactions') }}
    @endslot

  @endcomponent

<!-- Content bar start -->
  <div class="contentbar">


    <div class="row">

      <div class="col-lg-12">
        <div class="card m-b-30">
          <div class="card-header">
            <h5 class="card-title">{{ __('Wallet Transactions')}}</h5>
          </div>
          <div class="card-body">

            <div class="table-responsive">
              <table id="datatable-buttons" class="table table-striped table-bordered">
                <thead>
                  <tr>

                    <th>{{ __("#") }}</th>
                    <th>{{ __('adminstaticword.User') }}</th>
                    <th>{{ __('adminstaticword.Type') }}</th>
                    <th>{{ __('adminstaticword.Amount') }}</th>
                    <th>{{ __('adminstaticword.PaymentMethod') }}</th>
                    <th>{{ __('adminstaticword.Detail') }}</th>
                  </tr>
                </thead>
                <tbody>
                 

                  @foreach($wallet_transactions as $key => $wallet)
                  
                  <tr>
                    <td>{{ ++$key }}</td>
                    <td>
                      @if(isset($wallet->user))
                        {{ strip_tags($wallet->user->fname) }}
                      @endif
                    </td>

                    <td>{{ strip_tags($wallet->type) }}</td>

                    <td>

                      @if($gsetting['currency_swipe'] == 1)

                      <i class="{{ $wallet->currency_icon }}"></i>{{ strip_tags($wallet->total_amount) }}

                      @else
                      {{ strip_tags($wallet->total_amount) }}

                      <i class="{{ $wallet->currency_icon }}"></i>

                      @endif

                    </td>

                    <td>{{ strip_tags($wallet->payment_method) }}</td>

                    <td>{{ strip_tags($wallet->detail) }}</td>

                  </tr>
                  @endforeach

                </tbody>

              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- End col -->
    </div>
    <!-- End row -->
  </div>
<!-- Content bar end -->

@endsection