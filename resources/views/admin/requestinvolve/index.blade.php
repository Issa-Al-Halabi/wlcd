@extends('admin.layouts.master')
@section('title', 'View All Request Course - Admin')
@section('maincontent')


    @component('components.breadcumb', ['fourthactive' => 'active'])
        @slot('heading')
            {{ __('View All Request Course') }}
        @endslot
        @slot('menu1')
            {{ __('Instructor') }}
        @endslot
        @slot('menu2')
            {{ __('Multiple Instructor') }}
        @endslot
        @slot('menu2')
            {{ __('Involvement Courses') }}
        @endslot
    @endcomponent


    <div class="contentbar">
        <!-- Start row -->
        <div class="row">

            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="box-title">{{ __('Involvement Courses') }}</h5>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('adminstaticword.Image') }}</th>
                                        <th>{{ __('adminstaticword.Title') }}</th>
                                        <th>{{ __('adminstaticword.Slug') }}</th>
                                        @if (Auth::User()->role == 'admin')
                                            <th>{{ __('adminstaticword.Featured') }}</th>
                                            <th>{{ __('adminstaticword.Status') }}</th>
                                        @endif
                                        <th>{{ __('adminstaticword.RequestToInvolve') }}</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>

                                    @if (Auth::User()->role == 'admin')
                                        @foreach ($all_courses as $cat)
                                            <?php $i++; ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td>
                                                    @if ($cat['preview_image'] != null && $cat['preview_image'] != '')
                                                        <img src="{{ asset('images/course/' . $cat['preview_image']) }}"
                                                            class="img-responsive img-circle">
                                                    @else
                                                        <img src="{{ Avatar::create($cat->title)->toBase64() }}"
                                                            class="img-responsive img-circle">
                                                    @endif
                                                </td>
                                                <td>{{ $cat->title }}</td>
                                                <td>{{ $cat->slug }}</td>
                                                    <td>
                                                        <label class="switch">
                                                            <input class="featured" type="checkbox"
                                                                data-id="{{ $cat->id }}" name="featured"
                                                                {{ $cat->featured == '1' ? 'checked' : '' }}>
                                                            <span class="knob"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label class="switch">
                                                            <input class="status" type="checkbox"
                                                                data-id="{{ $cat->id }}" name="status"
                                                                {{ $cat->status == '1' ? 'checked' : '' }}>
                                                            <span class="knob"></span>
                                                        </label>
                                                    </td>

                                                <td>

                                                    @php
                                                        $involvement = App\Involvement::where('course_id', $cat->id)
                                                            ->where('user_id', Auth::user()->id)
                                                            ->first();
                                                    @endphp
                                                    @if (isset($involvement))
                                                        @if ($involvement->user_id == Auth::user()->id && $cat->id == $involvement->course_id)
                                                            {{ __('adminstaticword.AlreadyRequest') }}
                                                        @else
                                                            <a class="btn-sm" type="button" data-toggle="modal"
                                                                data-target="#involverequest{{ $cat->id }}">
                                                                <i class="feather icon-edit mr-2"></i></a>


                                                            <div class="modal" id="involverequest{{ $cat->id }}">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">


                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title">
                                                                                {{ __('Involve Request for Instructor') }}
                                                                            </h4>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal">&times;</button>
                                                                        </div>


                                                                        <div class="modal-body">
                                                                            <form
                                                                                action="{{ route('involve.store', $cat->id) }}"
                                                                                method="post">
                                                                                @csrf
                                                                                <div class="row">
                                                                                    <input type="hidden" name="course_id"
                                                                                        value="{{ $cat->id }}">
                                                                                    <div class="col-sm-12">
                                                                                        <label
                                                                                            for="instructor">{{ __('adminstaticword.Instructor') }}:
                                                                                            <sup
                                                                                                class="redstar">*</sup></label>
                                                                                        @if (Auth::user()->role == 'admin')
                                                                                            <select
                                                                                                class="form-control select2-single form-control"
                                                                                                name="instructor_id">
                                                                                                @foreach ($instructors as $instructor)
                                                                                                    @if ($cat->user_id != $instructor->id)
                                                                                                        <option
                                                                                                            value="{{ $instructor->id }}">
                                                                                                            {{ $instructor->fname }}
                                                                                                            {{ $instructor->lname }}
                                                                                                        </option>
                                                                                                    @endif
                                                                                                @endforeach
                                                                                            </select>
                                                                                        @else
                                                                                            <select
                                                                                                class="form-control select2-single form-control"
                                                                                                name="instructor_id">

                                                                                                <option
                                                                                                    value="{{ Auth::user()->id }}">
                                                                                                    {{ Auth::user()->fname }}
                                                                                                    {{ Auth::user()->lname }}
                                                                                                </option>

                                                                                            </select>
                                                                                        @endif
                                                                                    </div>
                                                                                    <div class="col-sm-12 mt-3">
                                                                                        <label
                                                                                            for="reason">{{ __('adminstaticword.Reason') }}:
                                                                                            <sup
                                                                                                class="redstar">*</sup></label>

                                                                                        <textarea class="form-control" name="reason" id="" cols="30" rows="5"
                                                                                            placeholder="Please enter reason for involvement request"></textarea>
                                                                                    </div>

                                                                                </div>
                                                                                <div class="form-group mt-3">
                                                                                    <button type="reset"
                                                                                        class="btn btn-danger mr-1"><i
                                                                                            class="fa fa-ban"></i>
                                                                                        {{ __('Reset') }}</button>
                                                                                    <button type="submit"
                                                                                        class="btn btn-primary"><i
                                                                                            class="fa fa-check-circle"></i>
                                                                                        {{ __('Update') }}</button>
                                                                                </div>


                                                                            </form>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @else
                                                        <a class="btn-sm" type="button" data-toggle="modal"
                                                            data-target="#involverequest{{ $cat->id }}">
                                                            <i class="feather icon-edit mr-2"></i></a>


                                                        <div class="modal" id="involverequest{{ $cat->id }}">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">


                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">
                                                                            {{ __('Involve Request for Instructor') }}
                                                                        </h4>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal">&times;</button>
                                                                    </div>


                                                                    <div class="modal-body">
                                                                        <form
                                                                            action="{{ route('involve.store', $cat->id) }}"
                                                                            method="post">
                                                                            @csrf
                                                                            <div class="row">
                                                                                <input type="hidden" name="course_id"
                                                                                    value="{{ $cat->id }}">
                                                                                <div class="col-md-12">
                                                                                    <label
                                                                                        for="instructor">{{ __('adminstaticword.Instructor') }}:
                                                                                        <sup class="redstar">*</sup></label>
                                                                                    @if (Auth::user()->role == 'admin')
                                                                                        <select
                                                                                            class="form-control select2-single form-control"
                                                                                            name="instructor_id">
                                                                                            @foreach ($instructors as $instructor)
                                                                                                @if ($cat->user_id != $instructor->id)
                                                                                                    <option
                                                                                                        value="{{ $instructor->id }}">
                                                                                                        {{ $instructor->fname }}
                                                                                                        {{ $instructor->lname }}
                                                                                                    </option>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </select>
                                                                                    @else
                                                                                        <select
                                                                                            class="form-control select2-single form-control"
                                                                                            name="instructor_id">

                                                                                            <option
                                                                                                value="{{ Auth::user()->id }}">
                                                                                                {{ Auth::user()->fname }}
                                                                                                {{ Auth::user()->lname }}
                                                                                            </option>

                                                                                        </select>
                                                                                    @endif
                                                                                </div>
                                                                                <div class="col-sm-12 mt-3">
                                                                                    <label
                                                                                        for="reason">{{ __('adminstaticword.Reason') }}:
                                                                                        <sup
                                                                                            class="redstar">*</sup></label>

                                                                                    <textarea class="form-control" name="reason" id="" cols="30" rows="5"
                                                                                        placeholder="Please enter reason for involvement request"></textarea>
                                                                                </div>

                                                                            </div>
                                                                            <div class="form-group mt-3">
                                                                                <button type="reset"
                                                                                    class="btn btn-danger mr-1"><i
                                                                                        class="fa fa-ban"></i>
                                                                                    {{ __('Reset') }}</button>
                                                                                <button type="submit"
                                                                                    class="btn btn-primary"><i
                                                                                        class="fa fa-check-circle"></i>
                                                                                    {{ __('Update') }}</button>
                                                                            </div>

                                                                        </form>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>



                                            </tr>
                                        @endforeach

                                    @endif
                                    @if (Auth::User()->role == 'instructor')
                                        @foreach ($all_course as $cat)
                                            <?php $i++; ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td>
                                                    @if ($cat['preview_image'] != null && $cat['preview_image'] != '')
                                                        <img src="{{ asset('images/course/' . $cat['preview_image']) }}"
                                                            class="img-responsive img-circle">
                                                    @else
                                                        <img src="{{ Avatar::create($cat->title)->toBase64() }}"
                                                            class="img-responsive img-circle">
                                                    @endif
                                                </td>
                                                <td>{{ $cat->title }}</td>
                                                <td>{{ $cat->slug }}</td>
                                                {{-- @if (Auth::User()->role == 'admin')
                                                    <td>
                                                        <label class="switch">
                                                            <input class="featured" type="checkbox"
                                                                data-id="{{ $cat->id }}" name="featured"
                                                                {{ $cat->featured == '1' ? 'checked' : '' }}>
                                                            <span class="knob"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label class="switch">
                                                            <input class="status" type="checkbox"
                                                                data-id="{{ $cat->id }}" name="status"
                                                                {{ $cat->status == '1' ? 'checked' : '' }}>
                                                            <span class="knob"></span>
                                                        </label>
                                                    </td>
                                                @endif --}}


                                                <td>

                                                    @php
                                                        $involvement = App\Involvement::where('course_id', $cat->id)
                                                            ->where('user_id', Auth::user()->id)
                                                            ->first();
                                                    @endphp
                                                    @if (isset($involvement))
                                                        @if ($involvement->user_id == Auth::user()->id && $cat->id == $involvement->course_id)
                                                            {{ __('adminstaticword.AlreadyRequest') }}
                                                        @else
                                                            <a class="btn-sm" type="button" data-toggle="modal"
                                                                data-target="#involverequest{{ $cat->id }}">
                                                                <i class="feather icon-edit mr-2"></i></a>


                                                            <div class="modal" id="involverequest{{ $cat->id }}">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">


                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title">
                                                                                {{ __('Involve Request for Instructor') }}
                                                                            </h4>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal">&times;</button>
                                                                        </div>


                                                                        <div class="modal-body">
                                                                            <form
                                                                                action="{{ route('involve.store', $cat->id) }}"
                                                                                method="post">
                                                                                @csrf
                                                                                <div class="row">
                                                                                    <input type="hidden" name="course_id"
                                                                                        value="{{ $cat->id }}">
                                                                                    <div class="col-sm-12">
                                                                                        <label
                                                                                            for="instructor">{{ __('adminstaticword.Instructor') }}:
                                                                                            <sup
                                                                                                class="redstar">*</sup></label>
                                                                                        @if (Auth::user()->role == 'admin')
                                                                                            <select
                                                                                                class="form-control select2-single form-control"
                                                                                                name="instructor_id">
                                                                                                @foreach ($instructors as $instructor)
                                                                                                    @if ($cat->user_id != $instructor->id)
                                                                                                        <option
                                                                                                            value="{{ $instructor->id }}">
                                                                                                            {{ $instructor->fname }}
                                                                                                            {{ $instructor->lname }}
                                                                                                        </option>
                                                                                                    @endif
                                                                                                @endforeach
                                                                                            </select>
                                                                                        @else
                                                                                            <select
                                                                                                class="form-control select2-single form-control"
                                                                                                name="instructor_id">

                                                                                                <option
                                                                                                    value="{{ Auth::user()->id }}">
                                                                                                    {{ Auth::user()->fname }}
                                                                                                    {{ Auth::user()->lname }}
                                                                                                </option>

                                                                                            </select>
                                                                                        @endif
                                                                                    </div>
                                                                                    <div class="col-sm-12 mt-3">
                                                                                        <label
                                                                                            for="reason">{{ __('adminstaticword.Reason') }}:
                                                                                            <sup
                                                                                                class="redstar">*</sup></label>

                                                                                        <textarea class="form-control" name="reason" id="" cols="30" rows="5"
                                                                                            placeholder="Please enter reason for involvement request"></textarea>
                                                                                    </div>

                                                                                </div>
                                                                                <div class="form-group mt-3">
                                                                                    <button type="reset"
                                                                                        class="btn btn-danger mr-1"><i
                                                                                            class="fa fa-ban"></i>
                                                                                        {{ __('Reset') }}</button>
                                                                                    <button type="submit"
                                                                                        class="btn btn-primary"><i
                                                                                            class="fa fa-check-circle"></i>
                                                                                        {{ __('Update') }}</button>
                                                                                </div>


                                                                            </form>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @else
                                                        <a class="btn-sm" type="button" data-toggle="modal"
                                                            data-target="#involverequest{{ $cat->id }}">
                                                            <i class="feather icon-edit mr-2"></i></a>


                                                        <div class="modal" id="involverequest{{ $cat->id }}">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">


                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">
                                                                            {{ __('Involve Request for Instructor') }}
                                                                        </h4>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal">&times;</button>
                                                                    </div>


                                                                    <div class="modal-body">
                                                                        <form
                                                                            action="{{ route('involve.store', $cat->id) }}"
                                                                            method="post">
                                                                            @csrf
                                                                            <div class="row">
                                                                                <input type="hidden" name="course_id"
                                                                                    value="{{ $cat->id }}">
                                                                                <div class="col-md-12">
                                                                                    <label
                                                                                        for="instructor">{{ __('adminstaticword.Instructor') }}:
                                                                                        <sup
                                                                                            class="redstar">*</sup></label>
                                                                                    @if (Auth::user()->role == 'admin')
                                                                                        <select
                                                                                            class="form-control select2-single form-control"
                                                                                            name="instructor_id">
                                                                                            @foreach ($instructors as $instructor)
                                                                                                @if ($cat->user_id != $instructor->id)
                                                                                                    <option
                                                                                                        value="{{ $instructor->id }}">
                                                                                                        {{ $instructor->fname }}
                                                                                                        {{ $instructor->lname }}
                                                                                                    </option>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </select>
                                                                                    @else
                                                                                        <select
                                                                                            class="form-control select2-single form-control"
                                                                                            name="instructor_id">

                                                                                            <option
                                                                                                value="{{ Auth::user()->id }}">
                                                                                                {{ Auth::user()->fname }}
                                                                                                {{ Auth::user()->lname }}
                                                                                            </option>

                                                                                        </select>
                                                                                    @endif
                                                                                </div>
                                                                                <div class="col-sm-12 mt-3">
                                                                                    <label
                                                                                        for="reason">{{ __('adminstaticword.Reason') }}:
                                                                                        <sup
                                                                                            class="redstar">*</sup></label>

                                                                                    <textarea class="form-control" name="reason" id="" cols="30" rows="5"
                                                                                        placeholder="Please enter reason for involvement request"></textarea>
                                                                                </div>

                                                                            </div>
                                                                            <div class="form-group mt-3">
                                                                                <button type="reset"
                                                                                    class="btn btn-danger mr-1"><i
                                                                                        class="fa fa-ban"></i>
                                                                                    {{ __('Reset') }}</button>
                                                                                <button type="submit"
                                                                                    class="btn btn-primary"><i
                                                                                        class="fa fa-check-circle"></i>
                                                                                    {{ __('Update') }}</button>
                                                                            </div>

                                                                        </form>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>



                                            </tr>
                                        @endforeach

                                    @endif
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
            $('.featured').change(function() {
                var featured = $(this).prop('checked') == true ? 1 : 0;

                var id = $(this).data('id');

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ url('quickudate/course') }}",
                    data: {
                        'featured': featured,
                        'id': id
                    },
                    success: function(data) {
                        console.log(data)
                    }
                });
            })
        })

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $(function() {
            $('.coursestatus').change(function() {
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
                        var warning = new PNotify({
                            title: 'success',
                            text: 'Status Update Successfully',
                            type: 'success',
                            desktop: {
                                desktop: true,
                                icon: 'feather icon-thumbs-down'
                            }
                        });
                        warning.get().click(function() {
                            warning.remove();
                        });
                    }
                });
            })
        })
    </script>

@endsection
