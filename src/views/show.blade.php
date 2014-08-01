<table class="table table-bordered table-condensed table-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th>Value</th>
		</tr>
	</thead>
	@foreach($item['original'] as $key => $val)
	<tr>
		<td>{{{ $key }}}</td>
		<td>{{ nl2br(e($val)) }}</td>
	</tr>
	@endforeach
</table>