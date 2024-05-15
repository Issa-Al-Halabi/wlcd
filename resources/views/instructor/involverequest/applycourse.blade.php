@extends('admin.layouts.master')
@section('title', 'Apply Course - Instructor')
@section('maincontent')


    @component('components.breadcumb', ['fourthactive' => 'active'])
        @slot('heading')
            {{ __('Apply Course') }}
        @endslot
        @slot('menu1')
            {{ __('Instructor') }}
        @endslot
        @slot('menu2')
            {{ __('Multiple Instructor') }}
        @endslot
        @slot('menu3')
            {{ __('Apply Course') }}
        @endslot
    @endcomponent


    <div class="contentbar">
        <!-- Start row -->
        <div class="row">

            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="box-title">{{ __('Apply Course') }}</h5>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('adminstaticword.Image') }}</th>
                                        <th>{{ __('adminstaticword.Title') }}</th>
                                        <th>{{ __('adminstaticword.Instructor') }}</th>
                                        {{-- <th>{{ __('adminstaticword.Status') }}</th> --}}
                                        <th>{{ __('adminstaticword.Edit') }}</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>

                                    @foreach ($involve_requests as $cat)
                                        <?php $i++; ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td>
                                                @if ($cat->course['preview_image'] != null && $cat->course['preview_image'] != '')
                                                    <img src="{{ url('/images/course/' . $cat->course['preview_image']) }}"
                                                        class="img-responsive img-circle">
                                                @else
                                                    <img src="{{ Avatar::create($cat->course->title)->toBase64() }}"
                                                        class="img-responsive img-circle">
                                                @endif
                                            </td>
                                            <td>{{ $cat->course->title }}</td>
                                            <td>{{ $cat->course->user['fname'] }} {{ $cat->course->user['lname'] }}</td>
                                            {{-- <td>
                                                <label class="switch">
                                                    <input class="applycourse" type="checkbox"
                                                        data-id="{{ $cat->id }}" name="status"
                                                        {{ $cat->status == '1' ? 'checked' : '' }}>
                                                    <span class="knob"></span>
                                                </label>
                                            </td> --}}


                                            <td>
                                                <a class="btn  btn-sm" href="{{ route('course.show', $cat->course_id) }}">
                                                    <i class="feather icon-edit mr-2"></i></a>
                                            </td>


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


@endsection



@section('scripts')


    <script>
        "use Strict";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $(function() {
            $('.applycourse').change(function() {
                var status = $(this).prop('checked') == true ? 1 : 0;

                var id = $(this).data('id');



                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ url('quickupdate/coursestatus') }}",
                    data: {
                        'status': status,
                        'id': id
                    },
                    success: function(data) {
                        console.log(data)
                    }
                });
            })
        })
    </script>


@endsection
