@extends('customer.template')
@section('title', "Login")


@section('css')

@endsection()

@section('body')
	<main>
		<div class="I-login">
			<div class="login-wrapper is-open" id="login-form">
				<h2 class="login-title">Login to Tsana</h2>
				<div class="notification-wrapper"> </div>	
				<div class="form-wrapper">
					<label for="">Email</label>
					<input type="text" placeholder="Email">
				</div>
				<div class="form-wrapper">
					<label for="">Password</label>
					<input type="text" placeholder="Password">
				</div>
				<div class="form-wrapper button-action">
					<a href="#" class="button submit">Login</a>
					or
					<a href="#" class="button cancel open-register-form">Register</a>
				</div>
			</div>	
			<div class="login-wrapper" id="register-form">
				<h2 class="login-title">Register to Tsana</h2>
				<div class="notification-wrapper">  </div>	
				<div class="form-wrapper">
					<label for="">Username</label>
					<input type="text" class="data-name" placeholder="Username">
				</div>
				<div class="form-wrapper">
					<label for="">Email</label>
					<input type="text" class="data-email" placeholder="Email">
				</div>
				<div class="form-wrapper">
					<label for="">Password</label>
					<input type="password" class="data-password" placeholder="Password">
				</div>
				<div class="form-wrapper button-action">
					<a href="#" class="button cancel open-login-form">Login</a>
					or
					<a href="#" class="button submit action-register" atr="Push">Register</a>
				</div>
			</div>	
			<div class="login-wrapper" id="success-form">
				<h2 class="login-title">Register successful</h2>
				<div class="form-wrapper">
					<p class="form-content">Active account at your email</p> 
				</div>
				<div class="form-wrapper button-action"> 
					<a href="https://mail.google.com/mail/u/0/?ogbl" target="_blank" class="button submit">Open Email</a>
				</div>
			</div>	
		</div>
	</main> 
@endsection()

@section('sub_layout')

@endsection()


@section('js')
<script type="text/javascript" src="{{ asset('customer/assets/js/page/auth.js') }}"></script>
@endsection()