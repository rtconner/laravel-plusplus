@if(\Session::has('success'))
	
	@section('scripts')
	<script>humane.log("{{{ jse(\Session::get('success')) }}}", { timeout: 5000, addnCls: 'humane-original-success' })</script>
	@stop
	
@elseif(\Session::has('error'))

	@section('scripts')
	<script>humane.log("{{{ jse(\Session::get('error')) }}}", { timeout: 5000, addnCls: 'humane-original-error' })</script>
	@stop

@elseif(\Session::has('message'))

	@section('scripts')
	<script>humane.log("{{{ jse(\Session::get('message')) }}}", { timeout: 5000 })</script>
	@stop

@elseif(\Session::has('info'))

	@section('scripts')
	<script>humane.log("{{{ jse(\Session::get('info')) }}}", { timeout: 5000 })</script>
	@stop

@elseif(\Session::has('warning'))

	@section('scripts')
	<script>humane.log("{{{ jse(\Session::get('warning')) }}}", { timeout: 5000, addnCls: 'humane-original-error' })</script>
	@stop
	
@endif