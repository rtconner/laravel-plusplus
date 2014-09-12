@if(\Session::has('success'))
	
 <div class="alert alert-success alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	{{ \Session::get('success') }}
</div>

@elseif(\Session::has('error'))

<div class="alert alert-danger alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	{{  \Session::get('error') }}
</div>

@elseif(\Session::has('message'))

<div class="alert alert-info alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	{{  \Session::get('message') }}
</div>

@elseif(\Session::has('info'))

<div class="alert alert-info alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	{{  \Session::get('info') }}
</div>

@elseif(\Session::has('warning'))

<div class="alert alert-warning alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	{{  \Session::get('warning') }}
</div>

@endif