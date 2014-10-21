<?php
	$list = ($item instanceof \Eloquent) ? $item['original'] : $item;
?>

<table class="table table-bordered table-condensed table-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th>Value</th>
		</tr>
	</thead>
	@foreach($list as $key => $val)
	<tr>
		<td>{{{ $key }}}</td>
		<td>
		@if(is_array($val))
			{{{ print_r($val, true) }}}
		@elseif(is_object($val))
			{{{ print_r($val, true) }}}
		@else
			{{ nl2br(e($val)) }}
		@endif
		</td>
	</tr>
	@endforeach
</table>