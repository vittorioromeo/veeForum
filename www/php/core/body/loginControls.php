<?php
	require_once("$root/php/core/content/register/modalRegister.php");

	(new Container())
		->inDiv(['class' => 'navbar-form navbar-right'])
			->bsNavbarTextbox('tbUser', 'Username')
			->inBSNavbarTextbox('tbPass', 'Password')
				->addAttribute('type', 'password')
				->out()
			->inBSLinkBtnActive('btnSignIn', 'signIn()')
				->literal('Sign in')
				->out()
			->inBSLinkBtnActive('btnRegister', 'register()')
				->literal('Register')
				->out()
	->printRoot();

	Gen::JS_PostAction('trySignIn(mUser, mPass)', 'trySignIn',
		[ 'user' => 'mUser', 'pass' => 'mPass' ],
		'reloadNavbar(); reloadPage();'
	);
?>

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