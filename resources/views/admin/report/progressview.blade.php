@extends('admin.layouts.master')
@section('title','All ProgressView')
@section('maincontent')
@component('components.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
   {{ __('Progress View') }}
@endslot

@slot('menu1')
   {{ __('Progress View') }}
@endslot
@endcomponent
<div class="contentbar"> 
  <div class="row">
      <div class="col-lg-12">
          <div class="card m-b-30">
              <div class="card-header">
                  <h5 class="card-box">{{ __('All Progress View') }}</h5>
              </div>
              <div class="card-body">
              
                  <div class="table-responsive">
                      <table id="datatable-buttons" class="table table-striped table-bordered">
                          <thead>
                 <label for="checkboxAll" class="material-checkbox"></label></th>
                 <th>{{ __('adminstaticword.User') }}</th>
                 <th>{{ __('adminstaticword.Course') }}</th>
                    <th>{{ __('Progress') }}</th>
                  </thead>
                   <tbody>
                    @foreach($progress as $progres)
                      @if(!is_null($progres->user) && !is_null($progres->courses))
                   
                      @php
                        if(Auth::user()->role == "instructor") 
                        {
                          $check = $progres->courses->user_id == Auth::user()->id;
                        }
                        else{
                          $check = $progres->courses;
                        }

                      @endphp

                      @if($check) 
                    
   
                        @php
                           $total_class = $progres->all_chapter_id;
                            $total_count = count($total_class);
                            $total_per = 100;
                            $read_class = $progres->mark_chapter_id;
                            $read_count =  count($read_class);
                            $progres_total = ($read_count/$total_count) * 100;
                                    
                        @endphp

                        <tr>
                          <td>
                              {{ optional($progres->user)->fname}}
                            </td>
                            <td>
                              {{ optional($progres->courses)->title}}
                            </td>
                          <td>
                              <div class="progressbar-list">
                                  <div class="progress">
                                      <div class="progress-bar" role="progressbar" style="width: <?php echo $progres_total; ?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">{{ $progres_total }}%</div>
                                  </div>
                              </div>
                          </td>
                        </tr>
                      @endif
                      @endif
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

