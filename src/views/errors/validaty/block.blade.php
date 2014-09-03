@if(get_class($errors) == 'Illuminate\Support\ViewErrorBag' && $errors->any())

@section('scripts')
@parent
<script>
Validaty.type = 'block';
$(function(){
<?php
	foreach($errors->getMessages() as $field => $messages) {
		echo 'Validaty.error("'.jse($field).'", "'.jse(implode(' ', $messages)).'");';
	}
?>
});
</script>
@stop

@endif
