@extends('admin.layouts.master')
@section('title', 'Edit Flashdeal | ')
@section('maincontent')
    @component('components.breadcumb', ['secondaryactive' => 'active'])
        @slot('heading')
            {{ __('Edit Flashdeals') }}
        @endslot

        @slot('menu1')
            {{ __('Flashdeals') }}
        @endslot

        @slot('button')
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a href=" {{ route('flash-sales.index') }} " class="btn btn-primary-rgba mr-2">
                        <i class="feather icon-arrow-left mr-2"></i> {{ __('Back') }}
                    </a>
                </div>
            </div>
        @endslot
    @endcomponent

    <div class="contentbar">
        <div class="row">
            <div class="col-md-12">

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}<button type="button" class="close" data-dismiss="alert"
                                    aria-label="Close">
                                    <span aria-hidden="true" style="color:red;">&times;</span></button></p>
                        @endforeach
                    </div>
                @endif

                <div class="card m-b-30">
                    <div class="card-header">
                        <h3 class="card-title">
                            {{ __('Edit flash deal') }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="card-body">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a @if ($deal->getTranslation('title', 'en', false) != null) class="nav-link active"
								@else
								class="nav-link" @endif
                                        id="pills-home1-tab" data-toggle="pill" href="#pills-home1" role="tab"
                                        aria-controls="pills-home" aria-selected="true">{{ __('English') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a @if ($deal->getTranslation('title', 'en', false) != null) class="nav-link"
									@else
									class="nav-link active" @endif
                                        id="pills-profile1-tab" data-toggle="pill" href="#pills-profile1" role="tab"
                                        aria-controls="pills-profile" aria-selected="false">{{ __('Arabic') }}</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div @if ($deal->getTranslation('title', 'en', false) != null) class="tab-pane fade show active"
								@else
								class="tab-pane fade show" @endif
                                    id="pills-home1" role="tabpanel" aria-labelledby="pills-home1-tab">
                                    <form action="{{ route('flash-sales.update', $deal->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @method('PUT')
                                        @csrf
                                         <input type="hidden" name="lang" value="en" id="lang">

                                        <div class="form-group">
                                            <label for="">{{ __('Title:') }} <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" class="required" name="title"
                                                placeholder="Halloween Sale" value="{{ $deal->getTranslation('title', 'en', false) }}">
                                        </div>

                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="">{{ __('Background image:') }} <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <div class="input-group ">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"
                                                                id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                                                        </div>
                                                        <div class="custom-file">

                                                            <input type="file" name="background_image"
                                                                class="custom-file-input" id="inputGroupFile01"
                                                                aria-describedby="inputGroupFileAddon01">
                                                            <label class="custom-file-label"
                                                                for="inputGroupFile01">{{ __('Choose background
                                                                                                                                                                                image') }}
                                                                (2000x2000)</label>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <img title="Current banner" width="200px"
                                                    src="{{ url('/images/flashdeals/' . $deal->background_image) }}"
                                                    alt="{{ $deal->background_image }}" class="img-fluid rounded">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="">{{ __('Start date:') }} <span
                                                    class="text-danger">*</span> </label>
                                            <input required value="{{ date('Y-m-d h:i a', strtotime($deal->start_date)) }}"
                                                type="text" class="timepickerwithdate form-control" class="required"
                                                name="start_date" />
                                        </div>

                                        <div class="form-group">
                                            <label for="">{{ __('End date:') }} <span class="text-danger">*</span>
                                            </label>
                                            <input required value="{{ date('Y-m-d h:i a', strtotime($deal->end_date)) }}"
                                                type="text" class="timepickerwithdate form-control" class="required"
                                                name="end_date" />
                                        </div>

                                        <div class="form-group">
                                            <label for="">{{ __('Detail:') }}</label>
                                            <textarea name="detail" id="detail" cols="30" rows="10">{{  $deal->getTranslation('detail', 'en', false) }}
                                            </textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>{{ __('Status') }} :</label>
                                            <br>
                                            <label class="switch">
                                                <input id="status" type="checkbox" name="status"
                                                    {{ $deal->status == 1 ? 'checked' : '' }}>
                                                <span class="knob"></span>
                                            </label>
                                        </div>

                                        <h4>{{ __('Update Courses') }}</h4>

                                        <table class="courselist table table-bordered table-hover">
                                            <thead>
                                                <th>{{ __('Course') }}</th>
                                                <th>{{ __('Discount') }}</th>
                                                <th>{{ __('Discount type') }}</th>
                                                <th>#</th>
                                            </thead>

                                            <tbody>
                                                @forelse($deal->saleitems as $item)
                                                    <tr>
                                                        <td>
                                                            @isset($item->courses->title)
                                                                <input type="text" class="course form-control"
                                                                    placeholder="Search course" name="course[]" required
                                                                    value="{{ $item->courses->title }}" />
                                                            @endisset

                                                            <input type="hidden" value="{{ $item->course_id }}"
                                                                class="form-control product_type" name="type[]">
                                                            <input value="{{ $item->course_id }}" type="hidden"
                                                                class="form-control course_ids" name="course_id[]" />
                                                        </td>
                                                        <td>
                                                            <div class="input-group">

                                                                <input value="{{ $item->discount }}" type="number"
                                                                    min="1" class="form-control" placeholder="50"
                                                                    required name="discount[]">
                                                                <span class="input-group-text">
                                                                    %
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <select name="discount_type[]" class="mt-3 form-control"
                                                                    id="discount_type">
                                                                    <option value="">
                                                                        {{ __('Select discount type') }} </option>
                                                                    <option
                                                                        {{ $item->discount_type == 'fixed' ? 'selected' : '' }}
                                                                        value="fixed">{{ __('Fixed') }}</option>
                                                                    <option
                                                                        {{ $item->discount_type == 'upto' ? 'selected' : '' }}
                                                                        value="upto">{{ __('Upto') }}</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="addnew btn-primary-rgba btn-sm">
                                                                <i class="feather icon-plus"></i>
                                                            </button>
                                                            <button type="button"
                                                                class="removeBtn btn-danger-rgba btn-sm">
                                                                <i class="feather icon-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="course form-control"
                                                                placeholder="Search course" required name="course[]">
                                                            <input type="hidden" class="form-control course_type"
                                                                name="type[]">
                                                            <input type="hidden" class="form-control course_ids"
                                                                name="course_id[]">
                                                        </td>
                                                        <td>
                                                            <div class="input-group">

                                                                <input type="number" min="1" class="form-control"
                                                                    placeholder="50" required name="discount[]">
                                                                <span class="input-group-text">
                                                                    %
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <select name="discount_type[]" class="mt-3 form-control"
                                                                    id="discount_type">
                                                                    <option value="">
                                                                        {{ __('Select discount type') }}</option>
                                                                    <option value="fixed">{{ __('Fixed') }}</option>
                                                                    <option value="upto">{{ __('Upto') }}</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="addnew btn-primary-rgba btn-sm">
                                                                <i class="feather icon-plus"></i>
                                                            </button>
                                                            <button type="button"
                                                                class="removeBtn btn-danger-rgba btn-sm">
                                                                <i class="feather icon-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-info-rgba">
                                                <i class="feather icon-save"></i> {{ __('Update') }}
                                            </button>
                                        </div>



                                    </form>

                                </div>
                                <div @if ($deal->getTranslation('title', 'en', false) != null) class="tab-pane fade show"
								@else
								class="tab-pane fade show active" @endif
                                    id="pills-profile1" role="tabpanel" aria-labelledby="pills-profile-tab">
                                    <form action="{{ route('flash-sales.update', $deal->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @method('PUT')
                                        @csrf

                                        <input type="hidden" name="lang" value="ar" id="lang">

                                        <div class="form-group">
                                            <label for="">{{ __('Title:') }} <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" class="required" name="title"
                                                placeholder="Halloween Sale" value="{{ $deal->getTranslation('title', 'ar', false) }}">
                                        </div>

                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="">{{ __('Background image:') }} <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <div class="input-group ">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"
                                                                id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                                                        </div>
                                                        <div class="custom-file">

                                                            <input type="file" name="background_image"
                                                                class="custom-file-input" id="inputGroupFile01"
                                                                aria-describedby="inputGroupFileAddon01">
                                                            <label class="custom-file-label"
                                                                for="inputGroupFile01">{{ __('Choose background
                                                                                                                                                                                image') }}
                                                                (2000x2000)</label>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <img title="Current banner" width="200px"
                                                    src="{{ url('/images/flashdeals/' . $deal->background_image) }}"
                                                    alt="{{ $deal->background_image }}" class="img-fluid rounded">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="">{{ __('Start date:') }} <span
                                                    class="text-danger">*</span> </label>
                                            <input required
                                                value="{{ date('Y-m-d h:i a', strtotime($deal->start_date)) }}"
                                                type="text" class="timepickerwithdate form-control" class="required"
                                                name="start_date" />
                                        </div>

                                        <div class="form-group">
                                            <label for="">{{ __('End date:') }} <span
                                                    class="text-danger">*</span>
                                            </label>
                                            <input required value="{{ date('Y-m-d h:i a', strtotime($deal->end_date)) }}"
                                                type="text" class="timepickerwithdate form-control" class="required"
                                                name="end_date" />
                                        </div>

                                        <div class="form-group">
                                            <label for="">{{ __('Detail:') }}</label>
                                            <textarea name="detail" id="detail" cols="30" rows="10">{{ $deal->getTranslation('detail', 'ar', false)  }}
                                           </textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>{{ __('Status') }} :</label>
                                            <br>
                                            <label class="switch">
                                                <input id="status" type="checkbox" name="status"
                                                    {{ $deal->status == 1 ? 'checked' : '' }}>
                                                <span class="knob"></span>
                                            </label>
                                        </div>

                                        <h4>{{ __('Update Courses') }}</h4>

                                        <table class="courselist table table-bordered table-hover">
                                            <thead>
                                                <th>{{ __('Course') }}</th>
                                                <th>{{ __('Discount') }}</th>
                                                <th>{{ __('Discount type') }}</th>
                                                <th>#</th>
                                            </thead>

                                            <tbody>
                                                @forelse($deal->saleitems as $item)
                                                    <tr>
                                                        <td>
                                                            @isset($item->courses->title)
                                                                <input type="text" class="course form-control"
                                                                    placeholder="Search course" name="course[]" required
                                                                    value="{{ $item->courses->title }}" />
                                                            @endisset

                                                            <input type="hidden" value="{{ $item->course_id }}"
                                                                class="form-control product_type" name="type[]">
                                                            <input value="{{ $item->course_id }}" type="hidden"
                                                                class="form-control course_ids" name="course_id[]" />
                                                        </td>
                                                        <td>
                                                            <div class="input-group">

                                                                <input value="{{ $item->discount }}" type="number"
                                                                    min="1" class="form-control" placeholder="50"
                                                                    required name="discount[]">
                                                                <span class="input-group-text">
                                                                    %
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <select name="discount_type[]" class="mt-3 form-control"
                                                                    id="discount_type">
                                                                    <option value="">
                                                                        {{ __('Select discount type') }} </option>
                                                                    <option
                                                                        {{ $item->discount_type == 'fixed' ? 'selected' : '' }}
                                                                        value="fixed">{{ __('Fixed') }}</option>
                                                                    <option
                                                                        {{ $item->discount_type == 'upto' ? 'selected' : '' }}
                                                                        value="upto">{{ __('Upto') }}</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="addnew btn-primary-rgba btn-sm">
                                                                <i class="feather icon-plus"></i>
                                                            </button>
                                                            <button type="button"
                                                                class="removeBtn btn-danger-rgba btn-sm">
                                                                <i class="feather icon-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="course form-control"
                                                                placeholder="Search course" required name="course[]">
                                                            <input type="hidden" class="form-control course_type"
                                                                name="type[]">
                                                            <input type="hidden" class="form-control course_ids"
                                                                name="course_id[]">
                                                        </td>
                                                        <td>
                                                            <div class="input-group">

                                                                <input type="number" min="1" class="form-control"
                                                                    placeholder="50" required name="discount[]">
                                                                <span class="input-group-text">
                                                                    %
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <select name="discount_type[]" class="mt-3 form-control"
                                                                    id="discount_type">
                                                                    <option value="">
                                                                        {{ __('Select discount type') }}</option>
                                                                    <option value="fixed">{{ __('Fixed') }}</option>
                                                                    <option value="upto">{{ __('Upto') }}</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="addnew btn-primary-rgba btn-sm">
                                                                <i class="feather icon-plus"></i>
                                                            </button>
                                                            <button type="button"
                                                                class="removeBtn btn-danger-rgba btn-sm">
                                                                <i class="feather icon-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-info-rgba">
                                                <i class="feather icon-save"></i> {{ __('Update') }}
                                            </button>
                                        </div>



                                    </form>
                                </div>

                            </div>
                        </div>

                        <!-- form start -->

                        <!-- form end -->

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function enableAutoComplete($element) {



            $element.autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: @json(route('test.fetch')),
                        data: {
                            term: request.term
                        },
                        dataType: "json",
                        success: function(data) {

                            var resp = $.map(data, function(obj) {
                                return {

                                    label: obj.label,
                                    value: obj.value,
                                    id: obj.id,
                                }
                            });

                            response(resp);
                        }
                    });
                },
                select: function(event, ui) {

                    if (ui.item.value != 'No result found') {
                        this.value = ui.item.value.replace(/\D/g, '');
                        // $(this).closest('td').find('input.product_type').val(ui.item.type);
                        $(this).closest('td').find('input.course_ids').val(ui.item.id);
                    } else {
                        $(this).val('');
                        // $(this).closest('td').find('input.product_type').val('');
                        $(this).closest('td').find('input.course_ids').val('');
                        return false;
                    }

                },
                minlength: 1,

            });
        }

        $(document).ready(function() {
            $(".course").each(function(index) {
                enableAutoComplete($(this));
            });
        });

        $(".courselist").on('click', 'button.addnew', function() {

            var n = $(this).closest('tr');
            addNewRow(n);


            function addNewRow(n) {

                // e.preventDefault();

                var $tr = n;
                var allTrs = $tr.closest('table').find('tr');
                var lastTr = allTrs[allTrs.length - 1];
                var $clone = $(lastTr).clone();
                $clone.find('td').each(function() {
                    var el = $(this).find(':first-child');
                    var id = el.attr('id') || null;
                    if (id) {

                        var i = id.substr(id.length - 1);
                        var prefix = id.substr(0, (id.length - 1));
                        el.attr('id', prefix + (+i + 1));
                        el.attr('name', prefix + (+i + 1));
                    }
                });

                $clone.find('input').val('');

                $tr.closest('table').append($clone);

                $('input.product').last().focus();

                enableAutoComplete($("input.product:last"));
            }


        });

        $('.courselist').on('click', '.removeBtn', function() {

            var d = $(this);
            removeRow(d);

        });

        function removeRow(d) {
            var rowCount = $('.courselist tr').length;
            if (rowCount !== 2) {
                d.closest('tr').remove();
            } else {
                console.log('Atleast one sell is required');
            }
        }
    </script>
@endsection
