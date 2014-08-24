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
		<td>{{ nl2br(e($val)) }}</td>
	</tr>
	@endforeach
</table>