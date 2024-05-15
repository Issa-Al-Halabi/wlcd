@extends('admin.layouts.master')
@section('title', 'Admin Revenue - Admin')
@section('maincontent')
@component('components.breadcumb',['fourthactive' => 'active'])
@slot('heading')
   {{ __('Admin Revenue') }}
@endslot
@slot('menu1')
{{ __('Admin Revenue') }}
@endslot
@slot('button')
<div class="col-md-4 col-lg-4">
  <div class="widgetbar">
  <button type="button" class="float-right btn btn-danger-rgba mr-2" data-toggle="modal" data-target="#bulk_delete"><i
            class="feather icon-trash mr-2"></i> {{ __('Back') }}Delete Selected</button>
  </div>
</div>
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
                    <h5 class="card-box">{{ __('Admin Revenue') }}</h5>
                </div> 
               
                <!-- card body started -->
                <div class="card-body">
                <div class="table-responsive">
                        <!-- table to display faq start -->
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                            <th>
                                <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]"
                                value="all" />
                                <label for="checkboxAll" class="material-checkbox"></label>   # 
                            </th>
                            <th>{{ 'User Name' }}</th>
                            <th>{{ 'Email' }}</th>

                            <th>{{ __('adminstaticword.Enrolled') }} {{ __('adminstaticword.Courses') }}</th>
                            <th>{{ __('adminstaticword.AdminRevenue') }}</th>
                            <th>{{ __('adminstaticword.Enrolled') }} {{ __('adminstaticword.Date') }}</th>
                        </thead>

                        <tbody>
                            <?php $i=0;?>
                              @foreach($orders as $order)
                              <?php $i++;?>
                              @php
                                $revenue = App\PendingPayout::where('order_id', $order->id)->first();
                                if(isset($revenue->instructor_revenue)){
                                  $ull = $revenue->instructor_revenue;
                                }else{
                                  $ull = 0;
                                }
                              @endphp
                            <tr>
                            <td>
                                 <input type='checkbox' form='bulk_delete_form' class='check filled-in material-checkbox-input'
                                        name='checked[]' value="{{ $order->id }}" id='checkbox{{ $order->id }}'>
                                    <label for='checkbox{{ $order->id }}' class='material-checkbox'></label>
                                    <?php echo $i; ?>
                                <div id="bulk_delete" class="delete-modal modal fade" role="dialog">
                                    <div class="modal-dialog modal-sm">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <div class="delete-icon"></div>
                                            </div>
                                            <div class="modal-body text-center">
                                                <h4 class="modal-heading">{{ __('Are You Sure') }} ?</h4>
                                                <p>{{ __('Do you really want to delete selected item ? This process
                                                    cannot be undone') }}.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <form id="bulk_delete_form" method="post"
                                                    action="{{ route('admin.revenue.bulk_delete') }}">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="reset" class="btn btn-gray translate-y-3"
                                                        data-dismiss="modal">{{ __('No') }}</button>
                                                    <button type="submit" class="btn btn-danger">{{ __('Yes') }}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </td>
                                <td>{{ $order->user->fname }}</td>
                                <td>{{ $order->user->email }}</td>

                                <td>
                                  @if($order->courses)
                                  {{ $order->courses->title }}
                                  @endif
                                </td>    
                                <td>
                                  @if($gsetting['currency_swipe'] == 1)
                                  <i class="fa {{ $order['currency_icon'] }}"></i> 
                                  @if($order->total_amount != NULL && $order->total_amount != '')
                                  {{ $order->total_amount - $ull }}
                                  @endif
                                @else
                                @if($order->total_amount != NULL && $order->total_amount != '')
                                  {{ $order->total_amount -  $ull }} 

                                  @endif
                                <i class="fa {{ $order['currency_icon'] }}"></i>
                                @endif
                                </td>
                                <td>{{  date('d-m-Y', strtotime($order->created_at)) }}</td>

                            </tr> 
                            @endforeach 
                        </tbody>
                        </table>                  
                        <!-- table to display faq data end -->                
                    </div><!-- table-responsive div end -->
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
<script>
    $("#checkboxAll").on('click', function () {
$('input.check').not(this).prop('checked', this.checked);
});
</script>
@endsection
<!-- This section will contain javacsript end -->