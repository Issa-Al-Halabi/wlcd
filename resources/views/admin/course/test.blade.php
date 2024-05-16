<div class="row">
    <div class="col-lg-12">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card m-b-30">
            <div class="card-header">
                <h5 class="card-box">{{ __('Edit') }} {{ __('Course') }}</h5>
            </div>

            <div class="card-body">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-english-tab" data-toggle="pill" href="#pills-english"
                            role="tab" aria-controls="pills-english" aria-selected="true">{{ __('English') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-arabic-tab" data-toggle="pill" href="#pills-arabic" role="tab"
                            aria-controls="pills-arabic" aria-selected="false">{{ __('Arabic') }}</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-english" role="tabpanel"
                        aria-labelledby="pills-english-tab">
                        @include('admin.course.test_en')
                    </div>
                    <div class="tab-pane fade" id="pills-arabic" role="tabpanel" aria-labelledby="pills-arabic-tab">
                        @include('admin.course.test_ar')
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<!-- edit media Modal start -->

<!-- edit media Model ended -->
@section('script')
    <script>
        (function($) {
            "use strict";

            $(function() {
                $('.js-example-basic-single').select2({
                    tags: true,
                    tokenSeparators: [',', ' ']
                });
            });

            $(function() {
                $('#cb1').change(function() {
                    $('#f').val(+$(this).prop('checked'))
                })
            })

            $(function() {
                $('#cb3').change(function() {
                    $('#test').val(+$(this).prop('checked'))
                })
            })

            $(function() {

                $('#murl').change(function() {
                    if ($('#murl').val() == 'yes') {
                        $('#doab').show();
                    } else {
                        $('#doab').hide();
                    }
                });

            });

            $(function() {

                $('#murll').change(function() {
                    if ($('#murll').val() == 'yes') {
                        $('#doabb').show();
                    } else {
                        $('#doab').hide();
                    }
                });

            });

            $('#customSwitch2').change(function() {
                if ($('#customSwitch2').is(':checked')) {
                    $('#doabox').show('fast');

                    $('#priceMain').prop('required', 'required');

                } else {
                    $('#doabox').hide('fast');

                    $('#priceMain').removeAttr('required');
                }

            });

            $('#customSwitch61').on('change', function() {

                if ($('#customSwitch61').is(':checked')) {
                    $('#document1').show('fast');
                    $('#document2').hide('fast');

                } else {
                    $('#document2').show('fast');
                    $('#document1').hide('fast');
                }

            });

            $(function() {
                var urlLike = '{{ url('admin/dropdown') }}';
                $('#category_id').change(function() {
                    var up = $('#upload_id').empty();
                    var cat_id = $(this).val();
                    if (cat_id) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: "GET",
                            url: urlLike,
                            data: {
                                catId: cat_id
                            },
                            success: function(data) {
                                console.log(data);
                                up.append('<option value="0">Please Choose</option>');
                                $.each(data, function(id, title) {
                                    up.append($('<option>', {
                                        value: id,
                                        text: title
                                    }));
                                });
                            },
                            error: function(XMLHttpRequest, textStatus, errorThrown) {
                                console.log(XMLHttpRequest);
                            }
                        });
                    }
                });
            });

            $(function() {
                var urlLike = '{{ url('admin/gcat') }}';
                $('#upload_id').change(function() {
                    var up = $('#grand').empty();
                    var cat_id = $(this).val();
                    if (cat_id) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: "GET",
                            url: urlLike,
                            data: {
                                catId: cat_id
                            },
                            success: function(data) {
                                console.log(data);
                                up.append('<option value="0">Please Choose</option>');
                                $.each(data, function(id, title) {
                                    up.append($('<option>', {
                                        value: id,
                                        text: title
                                    }));
                                });
                            },
                            error: function(XMLHttpRequest, textStatus, errorThrown) {
                                console.log(XMLHttpRequest);
                            }
                        });
                    }
                });
            });

        })(jQuery);
    </script>


    <script>
        $(".midia-toggle").midia({
            base_url: '{{ url('') }}',
            title: 'Choose Course Image',
            dropzone: {
                acceptedFiles: '.jpg,.png,.jpeg,.webp,.bmp,.gif'
            },
            directory_name: 'course'
        });
    </script>
@endsection
