<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Registration Form</h3>
	</div>

	<div class="panel-body">
		{{ Form::open(array('autocomplete'=>'off')) }}
		
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6">
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
						{{Form::text('username', null, ['class' => 'form-control', 'placeholder' => 'Username', 'required', 'autocomplete' => 'off'])}}
					</div>
					<span class="text-danger">{{$errors->first('username')}}</span>
				</div>
			</div>

			<div class="col-xs-6 col-sm-6 col-md-6">
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-envelope fa-fw"></i></span>
						{{Form::email('email', null, ['id' => 'email', 'class' => 'form-control', 'placeholder' => 'Email address', 'required', 'autocomplete' => 'off'])}}
					</div>
					<span class="text-danger">{{$errors->first('email')}}</span>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6">
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-male fa-fw"></i></span>
						{{Form::text('first_name', null, ['id' => 'first_name', 'class' => 'form-control', 'placeholder' => 'First Name', 'required', 'autocomplete' => 'off'])}}
					</div>
					<span class="text-danger">{{$errors->first('first_name')}}</span>
				</div>
			</div>

			<div class="col-xs-6 col-sm-6 col-md-6">
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-male fa-fw"></i></span>
						{{Form::text('last_name', null, ['id' => 'last_name', 'class' => 'form-control', 'placeholder' => 'Last Name', 'required', 'autocomplete' => 'off'])}}
					</div>
					<span class="text-danger">{{$errors->first('last_name')}}</span>
				</div>
			</div>
		</div>
		
		<div class="row">
		
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
						{{Form::password('password', ['id' => 'password1', 'class' => 'form-control', 'placeholder' => 'Password', 'required', 'autocomplete' => 'off'])}}
					</div>
					<span class="text-danger">{{$errors->first('password')}}</span>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
						{{Form::password('confirm', ['class' => 'form-control', 'placeholder' => 'Confirm password', 'required'])}}
					</div>
				</div>
			</div>
			
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="form-group">
					<div id="pass-info"></div>
				</div>
			</div>
				
			@if($captcha)
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="form-group">
					<div class="input-group">
						<img src="{{$captcha->getImageSrcTag()}}">
						<a href="{{URL::current()}}" class="btn btn-small btn-info margin-left-5"><i class="fa fa-refresh"></i></a>
					</div>
				</div>
			</div>
			
			<div class="col-xs-12 col-sm-12 col-md-12">
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-picture-o"></i></span>
						{{Form::text('captcha_text',null, ['class'=> 'form-control', 'placeholder' => 'Fill in with the text of the image', 'required', 'autocomplete' => 'off'])}}
					</div>
				</div>
				<span class="text-danger">{{$errors->first('captcha_text')}}</span>
			</div>
			@endif
			
		</div>
		
		<button type="submit" class="btn btn-lg btn-primary btn-block">Register</button>
		{{ Form::close() }}
	
		<hr>
	
		<p>Already have an account? <a href="{{ URL::route('login') }}">Log in</a></p>
		<p><a href="/forgotpassword">Forgot Username or Password?</a></p>
		
	
	</div>
</div>