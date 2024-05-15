@extends('admin.layouts.master')
@section('title','Edit Batch')
@section('maincontent')

@component('components.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __('Admin') }}
@endslot

@slot('menu2')
{{ __(' Edit Batch') }}
@endslot

@slot('button')
<div class="col-md-4 col-lg-4">
  <a href="{{ url('batch') }}" class="float-right btn btn-primary mr-2"><i class="feather icon-arrow-left mr-2"></i>{{ __('Back') }}</a>
</div>
@endslot

@endcomponent
<div class="contentbar">
  <div class="row">
    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="card-box">{{ __('adminstaticword.Edit') }} {{ __('adminstaticword.Batch') }}</h5>
        </div>
        <div class="card-body ml-2">
          <form action="{{route('batch.update',$cor->id)}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="exampleInputTit1e">{{ __('adminstaticword.Title') }}:<sup class="redstar">*</sup></label>
                  <input type="text" class="form-control" name="title" id="exampleInputTitle" value="{{ $cor->title }}">
                </div>

                <div class="form-group">
                  <label>{{ __('adminstaticword.SelectCourse') }}: <span class="redstar">*</span></label>
                  <select class="form-control js-example-basic-single" name="allowed_courses[]" multiple="multiple"
                    size="5" row="5" placeholder="{{ __('adminstaticword.Select') }} Courses">


                    @foreach ($courses as $cat)
                    @if($cat->status == 1)
                    <option value="{{ $cat->id }}"
                      {{in_array($cat->id, $cor['allowed_courses'] ?: []) ? "selected": ""}}>{{ $cat->title }}
                    </option>
                    @endif

                    @endforeach

                  </select>
                </div>


                <div class="form-group">
                  <label>{{ __('adminstaticword.Select') }} {{ __('adminstaticword.Users') }}: <span
                      class="redstar">*</span></label>
                  <select class="form-control js-example-basic-single" name="allowed_users[]" multiple="multiple"
                    size="5" row="5" placeholder="{{ __('adminstaticword.Select') }} {{ __('adminstaticword.Users') }}">



                    @foreach ($users as $user)
                    @if($user->status == 1)
                    <option value="{{ $user->id }}"
                      {{in_array($user->id, $cor['allowed_users'] ?: []) ? "selected": ""}}>{{ $user->fname }}
                    </option>
                    @endif

                    @endforeach

                  </select>
                </div>






                <div class="form-group">
                  <label for="exampleInputDetails">{{ __('adminstaticword.Detail') }}:<sup
                      class="redstar">*</sup></label>
                  <textarea name="detail" rows="3" class="form-control">{!! $cor->detail !!}</textarea>
                </div>

                <div class="form-group">
                  @if(Auth::User()->role == "admin")
                  <label for="exampleInputTit1e">{{ __('adminstaticword.Status') }}</label>
                  <input type="checkbox" class="custom_toggle" name="status"  {{ $cor->status==1 ? 'checked' : '' }}/>
                 
                @endif
                </div>
                  <br>

                <div class="form-group">
                  <label>{{ __('adminstaticword.Image') }}:<sup class="redstar">*</sup></label>
                  <small class="text-muted"><i class="fa fa-question-circle"></i>
                    {{ __('adminstaticword.Recommendedsize') }} (1375 x 409px)</small>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload') }}</span>
                    </div>
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="image" name="image"
                        aria-describedby="inputGroupFileAddon01">
                      <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
                    </div>
                  </div>
                
                  @if($cor['preview_image'] !== NULL && $cor['preview_image'] !== '')
                  <img src="{{ url('/images/batch/'.$cor->preview_image) }}" class="image_size"/>
                  @else
                  <img src="{{ Avatar::create($cor->title)->toBase64() }}" alt="course" class="img-fluid">
                  @endif
                </div>

                

             

                <div class="form-group">
                  <button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i>
                    {{ __('Reset') }}</button>
                  <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                    {{ __('Update') }}</button>
                </div>
                <div class="clear-both"></div>
              </div>

            </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
@endsection
@section('scripts')

<script>
  (function ($) {
    "use strict";


    $(function () {
      $('.js-example-basic-single').select2();
    });

    $(function () {
      $('#cb1').change(function () {
        $('#f').val(+$(this).prop('checked'))
      })
    })

    $(function () {
      $('#cb3').change(function () {
        $('#test').val(+$(this).prop('checked'))
      })
    })

    $(function () {

      $('#murl').change(function () {
        if ($('#murl').val() == 'yes') {
          $('#doab').show();
        } else {
          $('#doab').hide();
        }
      });

    });

    $(function () {

      $('#murll').change(function () {
        if ($('#murll').val() == 'yes') {
          $('#doabb').show();
        } else {
          $('#doab').hide();
        }
      });

    });

    $('#preview').on('change', function () {

      if ($('#preview').is(':checked')) {
        $('#document1').show('fast');
        $('#document2').hide('fast');

      } else {
        $('#document2').show('fast');
        $('#document1').hide('fast');
      }

    });

  })(jQuery);
</script>

@endsection