@extends('admin.layouts.master')
@section('title','Import User')
@section('maincontent')
@component('components.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
   {{ __('User') }}
@endslot
@slot('menu1')
{{ __('User') }}
@endslot

@slot('button')

<div class="col-md-4 col-lg-4">
  <div class="widgetbar">
    <a href="{{ url('files/user.csv') }}" class="float-right btn btn-primary-rgba mr-2"><i
        class="feather icon-arrow-down mr-2"></i>Download Example csv File</a> </div>
</div>

@endslot
@endcomponent
<div class="contentbar">

<div class="row">
    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="box-tittle">{{ __('adminstaticword.Import') }} {{ __('adminstaticword.User') }}</h5>
        </div>
        <div class="card-body">
			<form action="{{ route('user.csvfileupload') }}" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}
		  
		  <div class="row">
			  <div class="form-group col-md-6">
			   <label for="file">Select csv File :</label>
				<input required="" type="file" name="file" class="form-control">
				@if ($errors->has('file'))
				  <span class="invalid-feedback text-danger" role="alert">
					  <strong>{{ $errors->first('file') }}</strong>
				  </span>
			   @endif
			  <br>
			   <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                Submit</button>
			  </div>

			  
		  </div>

		  </form>
		</div>
		<div class="row">
		
			<div class="col-lg-12">
				<div class="card m-b-30">
					<div class="card-header">
						<h5 class="box-title">{{ __('Import Institute') }}</h5>
					</div>
					<div class="card-body">
					
						<div class="table-responsive">
							<table id="datatable-buttons" class="table table-striped table-bordered">
								<thead>
								<tr>
                                    <th>Column No</th>
                                    <th>Column Name</th>
                                    <th>Description</th>
                        </tr>
					</thead>
	
					<tbody>
						<tr>
							<td>1</td>
							<td><b>First Name</b> (Required)</td>
							<td>First Name</td>
                        </tr>
                        <tr>
							<td>2</td>
							<td><b>Last Name</b> (Required)</td>
							<td>Last Name</td>
						</tr>
	
						<tr>
							<td>3</td>
							<td><b>Mobile</b> (Required)</td>
							<td>Mobile</td>
						</tr>
	
						<tr>
							<td>4</td>
							<td><b>Email</b> (Required)</td>
							<td>Email</td>
						</tr>
	
						<tr>
							<td>5</td>
							<td><b>Address</b> (Required)</td>
							<td>Address</td>
						</tr>
	        			<tr>
							<td>6</td>
							<td><b>Gender</b> (Required)</td>
							<td>Gender</td>
						</tr>
                        <tr>
							<td>7</td>
							<td><b>Image</b> (Required)</td>
							<td>Image</td>
						</tr>
                        <tr>
							<td>8</td>
							<td><b>Verified</b> (Required)</td>
							<td>Verified</td>
						</tr>
						<tr>
							<td>9</td>
							<td><b>Status</b> (Required)</td>
							<td>Status</td>
						</tr>
						<tr>
							<td>10</td>
							<td><b>Role</b> (Required)</td>
							<td>Role</td>
						</tr>
                        <tr>
							<td>11</td>
							<td><b>Password</b> (Required)</td>
							<td>Password</td>
						</tr>
                    </tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	  </div>
	</div>
</div>

</div>	


@endsection
