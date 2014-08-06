@if(\Session::has('success'))
	
	@section('scripts')
	<script>humane.log("{{{ jse(\Session::get('success')) }}}", { clickToClose: true, timeout: 7500, addnCls: 'humane-flatty-success' })</script>
	@stop

@endif
@if(\Session::has('error'))

	@section('scripts')
	<script>humane.log("{{{ jse(\Session::get('error')) }}}", { clickToClose: true, timeout: 10000, addnCls: 'humane-flatty-error' })</script>
	@stop

@endif
@if(\Session::has('message'))

	@section('scripts')
	<script>humane.log("{{{ jse(\Session::get('message')) }}}", { clickToClose: true, timeout: 5000 })</script>
	@stop

@endif
@if(\Session::has('info'))

	@section('scripts')
	<script>humane.log("{{{ jse(\Session::get('info')) }}}", { clickToClose: true, timeout: 5000 })</script>
	@stop

@endif
@if(\Session::has('warning'))

	@section('scripts')
	<script>humane.log("{{{ jse(\Session::get('warning')) }}}", { clickToClose: true, timeout: 7500, addnCls: 'humane-flatty-error' })</script>
	@stop
	
@endif