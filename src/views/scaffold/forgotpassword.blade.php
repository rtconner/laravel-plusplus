<div class="panel panel-default">

	<div class="panel-heading">
		<h3 class="panel-title">Password Recovery</h3>
	</div>

	<div class="panel-body">
		{{ Form::open(array()) }}

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="form-group">
					<label>Enter Your Email Address</label>
					<div class="input-group" id="password-field">
						<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
						{{Form::email('email', '', ['id' => 'email', 'class' => 'form-control input-lg', 'placeholder' => 'Your account email', 'required', 'autocomplete' => 'off'])}}
					</div>
				</div>
			</div>
		</div>
                
		<input type="submit" value="Recover" class="btn btn-lg btn-primary btn-block">

		{{Form::close()}}

		<hr>
		
		<p><a href="{{ URL::route('login') }}">Back to login</a></p>
		<p><a href="/register">Create New Account</a></p>
		
	</div>
</div>
    