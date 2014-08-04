@extends('layouts.admin')

@section('content')

<style>
pre { margin: 0; }
.alert {padding-right: 14px;margin-bottom: 0;}
.alert + .alert{margin-top: 20px;}
.alert .close{top: 0;right: 0;}
.alert-emergency{background-color: #dca7a7;border-color: #d89ca6;color: #833332;}
.alert-emergency h4{color: #833332;}
.alert-alert{background-color: #e4b9b9;border-color: #dfaeb7;color: #953b39;}
.alert-alert h4{color: #953b39;}
.alert-critical{background-color: #ebcccc;border-color: #e6c1c7;color: #a74240;}
.alert-critical h4{color: #a74240;}
.alert-error{background-color: #f2dede;border-color: #eed3d7;color: #b94a48;}
.alert-error h4{color: #b94a48;}
.alert-warning{background-color: #faf2cc;border-color: #f8e5be;color: #b78c43;}
.alert-warning h4{color: #b78c43;}
.alert-notice{background-color: #fcf8e3;border-color: #fbeed5;color: #c09853;}
.alert-notice h4{color: #c09853;}
.alert-info{background-color: #d9edf7;border-color: #bce8f1;color: #3a87ad;}
.alert-info h4{color: #3a87ad;}
.alert-debug{background-color: #eef7fb;border-color: #d1eff5;color: #4196bf;}
.alert-debug h4 {color: #4196bf;}
.toggle-stack {font-size: 18px;color: #000000;cursor: pointer;}
</style>

<ul class="nav nav-pills" style="height: 64px;">
	{{ HTML::nav_item($url.'/'.$path.'/'.$sapi_plain.'/'.$date.'/all', ucfirst(Lang::get('logviewer::logviewer.levels.all'))) }}
	@foreach ($levels as $level)
		{{ HTML::nav_item($url.'/'.$path.'/'.$sapi_plain.'/'.$date.'/'.$level, ucfirst(Lang::get('logviewer::logviewer.levels.'.$level))) }}
	@endforeach
	
	@if ( ! $empty)
		<li class="pull-right">
			{{ HTML::link('#delete_modal', 'Delete '.$date, array('class' => 'btn btn-danger', 'data-toggle' => 'modal', 'data-target' => '#delete_modal')) }}
		</li>
	@endif
</ul>

<div class="row">

	<div class="col-sm-10">
		{{ $paginator->links() }}
		@if ( ! $empty && ! empty($log))
			@foreach ($log as $l)
				@if (strlen($l['stack']) > 1)
					<div class="alert alert-block alert-{{ $l['level'] }}">
						<span title="Click to toggle stack trace" class="toggle-stack"><i
							class="fa fa-plus-square-o"></i></span> <span class="stack-header">{{ $l['header'] }}</span>
						<pre class="stack-trace">{{ $l['stack'] }}</pre>
					</div>
				@else
					<div class="alert alert-block alert-{{ $l['level'] }}">
						<span class="toggle-stack">&nbsp;&nbsp;</span>
						<span class="stack-header">{{ $l['header'] }}</span>
					</div>
				@endif
			@endforeach
		@elseif ( ! $empty && empty($log))
			<div class="alert alert-block">{{ Lang::get('logviewer::logviewer.empty_file', array('sapi' => $sapi, 'date' => $date)) }}</div>
		@else
			<div class="alert alert-block">{{ Lang::get('logviewer::logviewer.no_log', array('sapi' => $sapi, 'date' => $date)) }}</div>
		@endif {{ $paginator->links() }}
	</div>

	<div class="col-md-2">
		<ul class="nav nav-list">
        @if ($logs)
        	@foreach ($logs as $type => $files)
        		@if ( ! empty($files['logs']))
        			<?php $count = count($files['logs'])?>
                    @foreach ($files['logs'] as $app => $file)
                    	@if ( ! empty($file))
	                        <li class="nav-header">{{ ($count > 1 ? $app.' - '.$files['sapi'] : $files['sapi']) }}</li>
	                        <ul class="nav nav-list">
	                        <?php
							foreach ($file as $index => $f) :
								if ($index > 50) {
									break;
								}
								echo HTML::decode(HTML::nav_item($url . '/' . $app . '/' . $type . '/' . $f, $f));
							endforeach
							;
							?>
							</ul>
						@endif
					@endforeach
				@endif
			@endforeach
		@endif
		</ul>
	</div>

	<div id="delete_modal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<i class="fa fa-times"></i>
					</button>
					<h3>{{ Lang::get('logviewer::logviewer.delete.modal.header') }}</h3>
				</div>
				<div class="modal-body">
					<p>{{ Lang::get('logviewer::logviewer.delete.modal.body') }}</p>
				</div>
				<div class="modal-footer">
					{{ HTML::link($url.'/'.$path.'/'.$sapi_plain.'/'.$date.'/delete', Lang::get('logviewer::logviewer.delete.modal.btn.yes'), array('class' => 'btn btn-success')) }}
					<button class="btn btn-danger" data-dismiss="modal">{{ Lang::get('logviewer::logviewer.delete.modal.btn.no') }}</button>
				</div>
			</div>
		</div>
	</div>

@stop

@section('scripts')
	<script>
	$(document).ready(function() {
	
		$('.stack-trace').hide();
		$('.toggle-stack').on('click', function(e) {
	
			var stack = $(this).siblings('.stack-trace');
			var icon = $(this).children('i');
			stack.slideToggle('fast', function() {
				icon.toggleClass('fa-plus-square-o fa-minus-square-o');
			});
			
		});
	});
	</script>
@stop