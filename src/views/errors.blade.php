<?php

if(!empty($errors) && get_class($errors) == 'Illuminate\Support\ViewErrorBag' && $errors->any()) {
	
	$messages = $errors->all();
	
	if($messages) {
		echo '<div class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
				.implode('<br>', $messages)
				.'</div>';
	};
	
}
