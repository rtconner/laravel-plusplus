

	{{ Form::open(array('class'=>'form-horizontal', 'role'=>'form')) }}
		<div class="form-group">
			<label class="control-label sr-only" for="username">Username</label>
			<div class="col-sm-12">
				<div class="input-group">
					{{ Form::text('username', null, array('class'=>'form-control input-lg', 'placeholder'=>'Username / Email')) }}
					<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
				</div>
			</div>
		</div>
		<label class="control-label sr-only" for="password">Password</label>
		<div class="form-group">
			<div class="col-sm-12">
				<div class="input-group">
					{{ Form::password('password', array('class'=>'form-control input-lg', 'placeholder'=>'Password')) }}
					<span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
				</div>
			</div>
		</div>
		<div class="checkbox">
			<label for="RememberMe">
				{{ Form::check('remember', 1, null, array('id'=>'RememberMe')) }}
				Remember me next time</label>
		</div>
		<button class="btn btn-lg btn-primary btn-block" style="margin: 15px 0;"><i class="fa fa-arrow-circle-o-right"></i> Login</button>
	{{ Form::close() }}
	
	<hr>

	<p><a href="/forgotpassword">Forgot Username or Password?</a></p>
	<p><a href="/register">Create New Account</a></p>
	