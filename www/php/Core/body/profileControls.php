<ul class="nav navbar-nav">
	<li><a id="btnNavSections" href="#">Sections</a></li>
	<?php
		if(Credentials::hasCUPrivilege(Privs::$superAdmin))
		{
			print('<li><a id="btnNavAdministration" href="#">Administration</a></li>');
		}
	?>   
</ul>

<ul class="nav navbar-nav navbar-right">
	<li>
		<a href="#">
			Logged in as: 
			<strong> <?php print(Credentials::getCURow()['username']); ?> </strong>
		</a>
	</li>   
	<li>
		<div class="navbar-form">
			<?php Gen::LinkBtn('btnSignOut', '', 'Sign out'); ?>			
		</div>
	</li>   		
</ul>

<?php

Gen::JS_PostAction('trySignOut()', 'trySignOut',
			[],
			'reloadNavbar(); reloadPage();');

Gen::JS_PostAction('changeCurrentPage(mX)', 'changeCurrentPage',
			[ 'idpage' => 'mX' ],
			'reloadNavbar(); reloadPage();');

Gen::JS_PostAction('gotoThread(mX)', 'gotoThread',
			[ 'idThread' => 'mX' ],
			'changeCurrentPage('.PK::$threadView.');');

Gen::JS_OnBtnClick('btnSignOut', 'trySignOut(); ');
Gen::JS_OnBtnClick('btnNavSections', 'changeCurrentPage('.PK::$sections.'); ');
Gen::JS_OnBtnClick('btnNavAdministration', 'changeCurrentPage('.PK::$administration.'); ');

?>