@if(\Session::has('success'))
	
	@section('scripts')
	<script>humane.log("{{{ jse(\Session::get('success')) }}}", { clickToClose: true, timeout: 0, addnCls: 'humane-flatty-success' })</script>
	@stop
	
@elseif(\Session::has('error'))

	@section('scripts')
	<script>humane.log("{{{ jse(\Session::get('error')) }}}", { clickToClose: true, timeout: 0, addnCls: 'humane-flatty-error' })</script>
	@stop

@elseif(\Session::has('message'))

	@section('scripts')
	<script>humane.log("{{{ jse(\Session::get('message')) }}}", { clickToClose: true, timeout: 0 })</script>
	@stop

@elseif(\Session::has('info'))

	@section('scripts')
	<script>humane.log("{{{ jse(\Session::get('info')) }}}", { clickToClose: true, timeout: 0 })</script>
	@stop

@elseif(\Session::has('warning'))

	@section('scripts')
	<script>humane.log("{{{ jse(\Session::get('warning')) }}}", { clickToClose: true, timeout: 0, addnCls: 'humane-flatty-error' })</script>
	@stop
	
@endif