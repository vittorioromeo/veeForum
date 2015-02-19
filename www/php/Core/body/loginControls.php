<div class="navbar-form navbar-right">
	<div class="form-group">
		<input type="text" id="tbUser" placeholder="Username" class="form-control">
	</div>
	<div class="form-group">
		<input type="password" id="tbPass" placeholder="Password" class="form-control">
	</div>
	<a role="button" id="btnSignIn" class="btn btn-default">Sign in</a>
	<a role="button" id="btnRegister" class="btn btn-default">Register</a>
</div>

<?php require_once("$root/php/Core/content/register/modalRegister.php"); ?>

<script>

function signIn()
{
	trySignIn($("#tbUser").val(), $("#tbPass").val());
}
function register()
{
	$('#modalLgRegister').modal('show');
}

</script>

<?php

Gen::JS_PostAction('trySignIn(mUser, mPass)', 'trySignIn',
			[ 'user' => 'mUser', 'pass' => 'mPass' ],
			'reloadNavbar(); reloadPage();'
			);

Gen::JS_OnBtnClick('btnSignIn', 'signIn();');
Gen::JS_OnBtnClick('btnRegister', 'register();');

?>