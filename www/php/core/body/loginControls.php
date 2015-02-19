<div class="navbar-form navbar-right">
	<?= Gen::FC_Textbox('tbUser', 'Username'); ?>
	<?= Gen::FC_Textbox('tbPass', 'Password', 'password'); ?>

	<?= Gen::LinkBtnActive('btnSignIn', '', 'signIn()', 'Sign in'); ?>
	<?= Gen::LinkBtnActive('btnRegister', '', 'register()', 'Register'); ?>
</div>

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

require_once("$root/php/core/content/register/modalRegister.php");

Gen::JS_PostAction('trySignIn(mUser, mPass)', 'trySignIn',
			[ 'user' => 'mUser', 'pass' => 'mPass' ],
			'reloadNavbar(); reloadPage();'
			);

?>