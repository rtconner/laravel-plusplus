<?php

$route = \Route::currentRouteName();

$matches = array();
preg_match('/^(.*[\.])/', $route, $matches);
$route = $matches[0].'destroy';

?>

<a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirm-delete-{{{$item->id}}}">
	<i class="fa fa-trash-o"></i> Delete Record</a>

{{ Form::open(array('route'=>[$route, $item->id], 'method'=>'delete')) }}
<div class="modal fade" id="confirm-delete-{{{$item->id}}}" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            	<h4 class="modal-title">Delete Record</h4>
            </div>
            <div class="modal-body">
            	<p>
	                Are you sure you want to delete the record <code>{{{$item->name or $item->id}}}</code>.
	                <br/>You can't undo this action.
                </p>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger pull-left"><i class="fa fa-trash-o"></i> Delete</button>
                <a class="btn btn-default" data-dismiss="modal">Cancel</a>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}

@section('scripts')
	@parent
<script>
$(function () {
	$('#confirm-delete-{{{$item->id}}}').on('show.bs.modal', function(e) {
		$(this).find('.btn-danger').attr('href', $(e.relatedTarget).data('href'));
	});
});
</script>
@stop