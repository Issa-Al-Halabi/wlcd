@extends('admin.layouts.master')
@section('title', 'Subscribed Instructors - Admin')
@section('body')

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-bsubscrib">
                        <h3 class="box-title"> {{ __('adminstaticword.SubscribedInstructors') }}</h3>
                       
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bsubscribed table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('adminstaticword.User') }}</th>
                                        <th>{{ __('adminstaticword.Plan') }}</th>
                                        <th>{{ __('adminstaticword.TransactionId') }}</th>
                                        <th>{{ __('adminstaticword.PaymentMethod') }}</th>
                                        <th>{{ __('adminstaticword.TotalAmount') }}</th>
                                        <th>{{ __('adminstaticword.View') }}</th>
                                        <th>{{ __('adminstaticword.Delete') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>
                                    @foreach ($subscribed as $subscrib)
                                        <?php $i++; ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td>
                                               
                                                @if(isset($subscrib->user))
                                                {{ $subscrib->user['fname'] }} {{ $subscrib->user['lname'] }}
                                                @endif
                                                
                                            </td>
                                            <td>

                                                @if ($subscrib->plan_id != null)
                                                    {{ $subscrib->plans['title'] }}
                                                @else
                                                    {{ $subscrib->plans['title'] }}
                                                @endif
                                            </td>
                                            <td>{{ $subscrib->transaction_id }}</td>
                                            <td>{{ $subscrib->payment_method }}</td>

                                            <td>{{ $subscrib->total_amount }}</td>


                                            

                                            
                                            <td><a class="btn btn-primary btn-sm"
                                                    href="{{ url('orders/subscription', $subscrib->id) }}">{{ __('adminstaticword.View') }}</a>
                                            </td>
                                            
                                            <td>
                                                <form method="post" action="{{ url('orders/subscription/' . $subscrib->id) }}"
                                                    data-parsley-validate class="form-horizontal form-label-left">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fa fa-fw fa-trash-o"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                            </table>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
@endsection
