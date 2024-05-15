@extends('admin.layouts.master')
@section('title', 'All Categories')
@section('maincontent')
    @component('components.breadcumb', ['secondaryactive' => 'active'])
        @slot('heading')
            {{ __('Categories') }}
        @endslot

        @slot('menu1')
            {{ __('Categories') }}
        @endslot

        @slot('button')
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    @can('categories.delete')
                        <button type="button" class="float-right btn btn-danger-rgba mr-2 " data-toggle="modal"
                            data-target="#bulk_delete"><i class="feather icon-trash mr-2"></i> {{ __('Delete Selected') }}</button>
                    @endcan
                    @can('categories.create')
                        <button type="button" class="float-right btn btn-primary-rgba mr-2" data-toggle="modal" data-target="#myModal">
                            <i class="feather icon-plus mr-2"></i>{{ __('Add Category') }}</a>
                        @endcan
                </div>
            </div>
        @endslot
    @endcomponent
    <div class="contentbar">
        <div class="row">

            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-box">{{ __('All Categories') }}</h5>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th> <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]"
                                                value="all" />
                                            <label for="checkboxAll" class="material-checkbox"></label>#
                                        </th>
                                        <th>{{ __('adminstaticword.Image') }}</th>
                                        <th>{{ __('adminstaticword.Category') }}</th>
                                        <th>{{ __('adminstaticword.Icon') }}</th>
                                        <th>{{ __('adminstaticword.Slug') }}</th>
                                        <th>{{ __('adminstaticword.Featured') }}</th>
                                        <th>{{ __('adminstaticword.Status') }}</th>
                                        @can('categories.edit', 'categories.delete')
                                            <th>{{ __('adminstaticword.Action') }}</th>
                                        @endcan

                                    </tr>
                                </thead>
                                <tbody id="sortable">
                                    <?php $i = 0; ?>
                                    @foreach ($cate as $cat)
                                        <?php $i++; ?>
                                        <tr class="sortable" id="id-{{ $cat->id }}">
                                            <td> <input type='checkbox' form='bulk_delete_form'
                                                    class='check filled-in material-checkbox-input' name='checked[]'
                                                    value="{{ $cat->id }}" id='checkbox{{ $cat->id }}'>
                                                <label for='checkbox{{ $cat->id }}' class='material-checkbox'></label>
                                                <?php echo $i; ?>
                                                <div id="bulk_delete" class="delete-modal modal fade" role="dialog">
                                                    <div class="modal-dialog modal-sm">
                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal">&times;</button>
                                                                <div class="delete-icon"></div>
                                                            </div>
                                                            <div class="modal-body text-center">
                                                                <h4 class="modal-heading">{{ __('Are You Sure') }} ?</h4>
                                                                <p>{{ __('Do you really want to delete selected item names here? This process cannot be undone') }}.
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form id="bulk_delete_form" method="post"
                                                                    action="{{ route('categories.bulk_delete') }}">
                                                                    @csrf
                                                                    @method('POST')
                                                                    <button type="reset"
                                                                        class="btn btn-gray translate-y-3"
                                                                        data-dismiss="modal">{{ __('No') }}</button>
                                                                    <button type="submit"
                                                                        class="btn btn-danger">{{ __('Yes') }}</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if ($cat['cat_image'] !== null && $cat['cat_image'] !== '')
                                                    <img src="images/category/<?php echo $cat['cat_image']; ?>"
                                                        class="img-responsive img-circle">
                                                @else
                                                    <img src="{{ Avatar::create($cat->title)->toBase64() }}"
                                                        class="img-responsive img-circle">
                                                @endif
                                            </td>
                                            <td>{{ $cat->getTranslation('title', Session::get('changed_language'), false) }}</td>
                                            <td>
                                                <div class="index-image">
                                                    <i class="fa {{ $cat->icon }}"></i>
                                                </div>
                                            </td>
                                            <td>{{ $cat->slug }}</td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-rounded {{ ($cat->featured == '1' ? 'checked' : '') ? 'btn-success-rgba' : 'btn-danger-rgba' }}">
                                                    @if ($cat->featured)
                                                        {{ __('adminstaticword.Active') }}
                                                    @else
                                                        {{ __('adminstaticword.Deactive') }}
                                                    @endif
                                                </button>
                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-rounded {{ ($cat->status == '1' ? 'checked' : '') ? 'btn-success-rgba' : 'btn-danger-rgba' }}">
                                                    @if ($cat->status)
                                                        {{ __('adminstaticword.Active') }}
                                                    @else
                                                        {{ __('adminstaticword.Deactive') }}
                                                    @endif
                                                </button>
                                            </td>
                                            @can('categories.edit', 'categories.delete')
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-round btn-outline-primary" type="button"
                                                            id="CustomdropdownMenuButton1" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false"><i
                                                                class="feather icon-more-vertical-"></i></button>
                                                        <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                                                            @can('categories.edit')
                                                                <a class="dropdown-item" data-toggle="modal"
                                                                    data-target="#edit{{ $cat->id }}"><i
                                                                        class="feather icon-edit mr-2"></i>{{ __('Edit') }}</a>
                                                            @endcan
                                                            @can('categories.delete')
                                                                <a class="dropdown-item btn btn-link" data-toggle="modal"
                                                                    data-target="#delete{{ $cat->id }}">
                                                                    <i class="feather icon-delete mr-2"></i>{{ __('Delete') }}</a>
                                                                </a>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                    <div class="modal fade bd-example-modal-sm" id="edit{{ $cat->id }}"
                                                        role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleSmallModalLabel">
                                                                        {{ __('Edit Category') }}</h5>
                                                                    <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form id="demo-form" method="post"
                                                                        action="{{ url('category/' . $cat->id) }}
"
                                                                        data-parsley-validate
                                                                        class="form-horizontal form-label-left"
                                                                        autocomplete="off" enctype="multipart/form-data">
                                                                        {{ csrf_field() }}
                                                                        {{ method_field('PUT') }}
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="exampleInputTit1e">{{ __('adminstaticword.English Title') }}:<sup
                                                                                            class="redstar">*</sup></label>
                                                                                    <input type="text" class="form-control"
                                                                                        name="title_en" id="exampleInputTitle"
                                                                                        value="{{ $cat->getTranslation('title', 'en', false) }}">
                                                                                </div>

                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="exampleInputTit1e">{{ __('adminstaticword.Arabic Title') }}:<sup
                                                                                            class="redstar">*</sup></label>
                                                                                    <input type="text" class="form-control"
                                                                                        name="title_ar" id="exampleInputTitle"
                                                                                        value="{{ $cat->getTranslation('title','ar', false) }}">
                                                                                </div>

                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="slug">{{ __('adminstaticword.Slug') }}:<sup
                                                                                            class="redstar">*</sup></label>
                                                                                    <input pattern="[/^\S*$/]+"
                                                                                        placeholder="Please Enter slug"
                                                                                        type="text" class="form-control"
                                                                                        name="slug" required
                                                                                        value="{{ $cat->slug }}">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="exampleInputTit1e">{{ __('adminstaticword.Icon') }}:<sup
                                                                                            class="redstar">*</sup></label>
                                                                                    <div class="input-group">
                                                                                        <input type="text"
                                                                                            class="form-control iconvalue"
                                                                                            name="icon"
                                                                                            value="{{ $cat->icon }}">
                                                                                        <span class="input-group-append">
                                                                                            <button type="button"
                                                                                                class="btnicon btn btn-outline-secondary"
                                                                                                role="iconpicker"></button>
                                                                                        </span>
                                                                                    </div>



                                                                                </div>

                                                                                <div class="row">
                                                                                    <div class="form-group col-md-6">
                                                                                        <label
                                                                                            for="exampleInputDetails">{{ __('adminstaticword.Status') }}:<sup
                                                                                                class="redstar text-danger">*</sup></label><br>
                                                                                        <input id="status" type="checkbox"
                                                                                            class="custom_toggle"
                                                                                            {{ $cat->status == '1' ? 'checked' : '' }}
                                                                                            name="status" />

                                                                                    </div>
                                                                                    <div class="form-group col-md-6">
                                                                                        <label
                                                                                            for="exampleInputDetails">{{ __('adminstaticword.Featured') }}:<sup
                                                                                                class="redstar text-danger">*</sup></label><br>
                                                                                        <input id="featured" type="checkbox"
                                                                                            class="custom_toggle"
                                                                                            {{ $cat->featured == '1' ? 'checked' : '' }}
                                                                                            name="featured" />

                                                                                    </div>
                                                                                </div>

                                                                                <div class="form-group">
                                                                                    <label>{{ __('adminstaticword.PreviewImage') }}:</label>
                                                                                    - <p class="inline info">
                                                                                        {{ __('size') }}: 255x200</p>
                                                                                    <br>
                                                                                    <label>{{ __('adminstaticword.Image') }}:<sup
                                                                                            class="redstar">*</sup></label>
                                                                                    <small class="text-muted"><i
                                                                                            class="fa fa-question-circle"></i>
                                                                                        {{ __('adminstaticword.Recommendedsize') }}
                                                                                        (1375 x 409px)
                                                                                    </small>
                                                                                    <div class="input-group mb-3">
                                                                                        <div class="input-group-prepend">
                                                                                            <span class="input-group-text"
                                                                                                id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                                                                                        </div>
                                                                                        <div class="custom-file">
                                                                                            <input type="file"
                                                                                                class="custom-file-input"
                                                                                                id="inputGroupFile01"
                                                                                                name="image"
                                                                                                aria-describedby="inputGroupFileAddon01">
                                                                                            <label class="custom-file-label"
                                                                                                for="inputGroupFile01">{{ __('Choose file') }}</label>
                                                                                        </div>
                                                                                    </div>

                                                                                    @if (isset($cat['cat_image']))
                                                                                        <img src="{{ url('/images/category/' . $cat['cat_image']) }}"
                                                                                            class="image_size" />
                                                                                    @endif
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <div class="form-group">
                                                                            <button type="reset"
                                                                                class="btn btn-danger-rgba"><i
                                                                                    class="fa fa-ban"></i>
                                                                                {{ __('Reset') }}</button>
                                                                            <button type="submit"
                                                                                class="btn btn-primary-rgba"><i
                                                                                    class="fa fa-check-circle"></i>
                                                                                {{ __('Update') }}</button>

                                                                        </div>
                                                                        <div class="clear-both"></div>
                                                                </div>
                                                            </div>

                                                            </form>
                                                        </div>
                                                    </div>

                            </div>
                        </div>
                    </div>

                    <div class="modal fade bd-example-modal-sm" id="delete{{ $cat->id }}" role="dialog"
                        aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleSmallModalLabel">{{ __('Delete') }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-muted">
                                        {{ __('Do you really want to delete this Bundle ? This process cannot be
                                                                                                                                                                                                                undone') }}.
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <form method="post" action="{{ url('category/' . $cat->id) }}" data-parsley-validate
                                        class="form-horizontal form-label-left">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <button type="reset" class="btn btn-gray translate-y-3"
                                            data-dismiss="modal">{{ __('adminstaticword.No') }}</button>
                                        <button type="submit"
                                            class="btn btn-danger">{{ __('adminstaticword.Yes') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    </td>
                @endcan

                </tr>
                @endforeach
                </tbody>
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
    <div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModal">{{ __('Add Category') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>

                </div>
                <div class="modal-body">
                    <form id="demo-form2" method="post" action="{{ url('category/') }}" data-parsley-validate
                        class="form-horizontal form-label-left" autocomplete="off" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-12">
                                <label for="c_name">{{ __('adminstaticword.English Title') }}:<sup
                                        class="redstar">*</sup></label>
                                <input placeholder="{{ __('adminstaticword.English Title') }}" type="text" class="form-control"
                                    name="title_en" required="">
                            </div>
                        </div>
                        <br>
                         <div class="row">
                            <div class="col-md-12">
                                <label for="c_name">{{ __('adminstaticword.Arabic Title') }}:<sup
                                        class="redstar">*</sup></label>
                                <input placeholder=" {{ __('adminstaticword.Arabic Title') }}" type="text" class="form-control"
                                    name="title_ar" required="">
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="slug">{{ __('adminstaticword.Slug') }}:<sup
                                        class="redstar">*</sup></label>
                                <input pattern="[/^\S*$/]+" placeholder="Please Enter slug" type="text"
                                    class="form-control" name="slug" required>
                            </div>
                        </div>
                        <br>


                        <div class="row">
                            <div class="col-md-12">
                                <label for="icon">{{ __('adminstaticword.Icon') }}:<sup
                                        class="redstar"></sup></label>

                                <!--========================================================================-->
                                <div class="input-group">
                                    <input type="text" class="form-control iconvalue" name="icon"
                                        value="Please Choose icon">
                                    <span class="input-group-append">
                                        <button type="button" class="btnicon btn btn-outline-secondary"
                                            role="iconpicker"></button>
                                    </span>
                                </div>
                                <!--========================================================================-->



                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-md-4">
                                <label for="exampleInputDetails">{{ __('adminstaticword.Featured') }}:<sup
                                        class="redstar text-danger">*</sup></label><br>
                                <input id="status_toggle" type="checkbox" class="custom_toggle" name="featured"
                                    checked />
                            </div>

                            <div class="col-md-4">
                                <label for="exampleInputDetails">{{ __('adminstaticword.Status') }}:<sup
                                        class="redstar text-danger">*</sup></label><br>
                                <input id="status_toggle" type="checkbox" class="custom_toggle" name="status"
                                    checked />
                            </div>

                        </div>
                        <br>


                        <div class="form-group">
                            <label>{{ __('adminstaticword.PreviewImage') }}:</label> - <p class="inline info">
                                {{ __('size') }}: 255x200</p>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" id="image"
                                        aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label"
                                        for="inputGroupFile01">{{ __('Choose file') }}</label>
                                </div>
                            </div>




                        </div>


                        <div class="form-group">
                            <button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i>
                                {{ __('Reset') }}</button>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                                {{ __('Create') }}</button>
                        </div>
                        <div class="clear-both"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')

    <script>
        $(function() {
            $("#sortable").sortable();
            $("#sortable").disableSelection();
        });

        $("#sortable").sortable({
            update: function(e, u) {
                var data = $(this).sortable('serialize');

                $.ajax({
                    url: "{{ route('category_reposition') }}",
                    type: 'get',
                    data: data,
                    dataType: 'json',
                    success: function(result) {
                        console.log(data);
                    }
                });

            }

        });


        $("#checkboxAll").on('click', function() {
            $('input.check').not(this).prop('checked', this.checked);
        });
    </script>

    <!-- script to change featured-status start -->
    <script>
        $(document).on("change", ".status1", function() {
            $.ajax({
                type: "GET",
                dataType: "json",
                url: 'featured-status',
                data: {
                    'featured': $(this).is(':checked') ? 1 : 0,
                    'id': $(this).data('id')
                },
                success: function(data) {
                    console.log(id)
                }
            });

        });
    </script>
    <!-- script to change featured-status end -->
    <!-- script to change status start -->
    <script>
        $(document).on("change", ".status2", function() {
            $.ajax({
                type: "GET",
                dataType: "json",
                url: 'cat-status',
                data: {
                    'status': $(this).is(':checked') ? 1 : 0,
                    'id': $(this).data('id')
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
        });
    </script>
    <!-- script to change status end -->
    <!-- ============================================ -->


@endsection
