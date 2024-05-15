<div class="dropdown">
    <button class="btn btn-round btn-outline-primary" type="button"
        id="CustomdropdownMenuButton1" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false"><i
            class="feather icon-more-vertical-"></i></button>
    <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
        @can('users.edit')
        <a class="dropdown-item" href="{{ route('user.edit',$id) }}"><i
                class="feather icon-edit mr-2"></i>Edit</a>
        @endcan
        @can('users.delete')
        <a class="dropdown-item btn btn-link" data-toggle="modal"
            data-target="#delete{{ $id }}">
            <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
        </a>
        @endcan
        @can('users.view')
        <button type="button" class="dropdown-item" data-toggle="modal"
            data-target="#exampleStandardModal{{ $id }}">
            <i class="feather icon-eye mr-2"></i>View
        </button>
        @endcan
    </div>
</div>

<!-- delete Modal start -->
<div class="modal fade bd-example-modal-sm" id="delete{{$id}}"
    tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleSmallModalLabel">Delete</h5>
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h4>{{ __('Are You Sure ?')}}</h4>
                <p>{{ __('Do you really want to delete')}}
                    <b>{{$fname}}</b>?
                    {{ __('This process cannot be undone.')}}</p>
            </div>
            <div class="modal-footer">
                <form method="post"
                    action="{{ route('user.delete',$id) }}"
                    class="pull-right">
                    {{csrf_field()}}
                    {{method_field("DELETE")}}
                    <button type="reset" class="btn btn-secondary"
                        data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- delete Model ended -->