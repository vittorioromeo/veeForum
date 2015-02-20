<?php
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);
	require_once("$root/php/lib/lib.php");

	$rootAP = "$root/php/core/content/adminPanel";

	(new Container())
		->h(1, 'Administration')
		->hr()
		->inDiv(['class' => 'row'])
			->file("$rootAP/panelDebug.php")
			->file("$rootAP/panelGroups.php")
			->out()
		->hr()
		->inDiv(['class' => 'row'])
			->file("$rootAP/panelGSPerms.php")
			->file("$rootAP/panelSections.php")
			->out()
		->hr()
		->inDiv(['class' => 'row'])
			->file("$rootAP/panelUsers.php")
	->printRoot();

	require_once("$rootAP/modalUserActions.php"); 
	require_once("$rootAP/modalUserEdit.php"); 
	require_once("$rootAP/modalGSPerms.php"); 

	Gen::JS_PostAction('setDebugEnabled(mX)', 'setDebugEnabled', [ 'enabled' => 'mX' ]);
	Gen::JS_PostAction('refreshDebugLo()', 'refreshDebugLo', [], '$("#debugLo").html(mOut);');

	Gen::JS_PostAction('refreshSectionHierarchy()', 'getSectionHierarchyStr', [], '$("#divScHierarchy").html(mOut);');
	Gen::JS_PostAction('refreshSections(mTarget, mNullRow)', 'getSectionOptions',
		[ 'nullRow' => 'mNullRow' ],
		'$(mTarget).html(mOut);');

	Gen::JS_PostAction('refreshGroupHierarchy()', 'getGroupHierarchyStr', [], '$("#divGrHierarchy").html(mOut);');
	Gen::JS_PostAction('refreshGroups(mTarget, mNullRow)', 'getGroupOptions',
		[ 'nullRow' => 'mNullRow' ],
		'$(mTarget).html(mOut);');

	Gen::JS_PostAction('refreshUsers()', 'getTblUsers',
		[],
		'$("#tblUsManage").html(mOut);',
		'showAPModal("Refresh users - error", mErr);');


	Gen::JS_PostAction('usAdd()', 'usAdd',
		[
			'id' => 'usEditModalId',
			'username' => '$("#tbUsAddUsername").val()',
			'password' => '$("#tbUsAddPassword").val()',
			'email' => '$("#tbUsAddEmail").val()',
			'firstname' => '$("#tbUsAddFirstname").val()',
			'lastname' => '$("#tbUsAddLastname").val()',
			'birthdate' => '$("#dateUsAddBirth").val()',
			'groupId' => '$("#slUsAddGroup").val()'
		],
		'showAPModal("Add/edit", mOut);',
		'showAPModal("Add/edit - error", mErr);');

	Gen::JS_PostAction('usDel(mID)', 'usDel',
		[ 'id' => 'mID' ],
		'showAPModal("Delete", mOut);',
		'showAPModal("Delete - error", mErr);');

	Gen::JS_PostAction('usGetData(mID)', 'usGetData',
		[ 'id' => 'mID' ],
		'fillUsEditModal(mID, mOut);',
		'showAPModal("Get data - error", mErr);');

	Gen::JS_PostAction('startGSPEdit(mIDGroup, mIDSection)', 'getGSPData',
		[ 'idgroup' => 'mIDGroup', 'idsection' => 'mIDSection' ],
		'fillGSPModal(mOut); showGSPModal(mIDGroup, mIDSection);',
		'showAPModal("Get data - error", mErr);');

	Gen::JS_PostAction('endGSPEdit(mIDGroup, mIDSection, mA0, mA1, mA2, mA3, mA4, mA5)', 'setGSPData',
		[
			'idgroup' => 'mIDGroup',
			'idsection' => 'mIDSection',

			'cpost' => 'mA0',
			'cview' => 'mA1',
			'ccreatethread' => 'mA2',
			'cdeletepost' => 'mA3',
			'cdeletethread' => 'mA4',
			'cdeletesection' => 'mA5'
		],
		'',
		'showAPModal("Get data - error", mErr);');

	Gen::JS_OnBtnClickDynamic('btnUsAdd',		'showUsEditModal(-1);');

	Gen::JS_OnBtnClick('btnUsAddOk', 			'usAdd(); refreshAll();');
	Gen::JS_OnBtnClick('btnUsActionsUsDel', 	'usDel(usEditModalId); refreshAll();');

	Gen::JS_OnBtnClick('btnGSPModal',			'startGSPEdit($("#slGSPGr").val(), $("#slGSPSc").val());');
	Gen::JS_OnBtnClick('btnGSPModalOK',
		'endGSPEdit
		(
			$("#slGSPGr").val(),
			$("#slGSPSc").val(),
			$("#cbGSPCPost").prop("checked"),
			$("#cbGSPCView").prop("checked"),
			$("#cbGSPCreateThread").prop("checked"),
			$("#cbGSPCDeletePost").prop("checked"),
			$("#cbGSPCDeleteThread").prop("checked"),
			$("#cbGSPCDeleteSection").prop("checked")
		);');
?>

<script>
	var usEditModalId = -1;

	function refreshAll()
	{
		refreshSections("#slScParent", true);
		refreshSections("#slScToDel", false);
		refreshSections("#slGSPSc", false);
		refreshSectionHierarchy();

		refreshGroups("#slGrParent", true);
		refreshGroups("#slGrToDel", false);
		refreshGroups("#slUsAddGroup", false);
		refreshGroups("#slGSPGr", false);
		refreshGroupHierarchy();

		refreshUsers();

		refreshDebugLo();
	}

	function showAPModal(mHeading, mBody)
	{
		if($('#cbDbModals').prop('checked'))
			showModalInfo(mHeading, mBody);
	}

	function setDebugMode(mX)
	{
		setDebugEnabled(mX);
		refreshDebugLo();
		showAPModal("Info", "Debug mode " + (mX ? "enabled." : "disabled."));
	}

	function setUsEditId(mID)
	{
		usEditModalId = mID;

		if(mID != -1)
		{
			$(".usIdDiv").text("ID: " + usEditModalId);
		}
		else
		{
			$(".usIdDiv").text("New user");
		}
	}

	function fillUsEditModal(mID, mOut)
	{
		var x = JSON.parse(mOut);

		$("#tbUsAddUsername").val(x["username"]);
		$("#tbUsAddEmail").val(x["email"]);
		$("#tbUsAddFirstname").val(x["firstname"]);
		$("#tbUsAddLastname").val(x["lastname"]);
		$("#dateUsAddBirth").val(x["birthdate"]);
		$("#slUsAddGroup").val(x["groupid"]);
	}


	function fillGSPModal(mOut)
	{
		var x = JSON.parse(mOut);

		$("#cbGSPCPost").prop("checked", x["cpost"] == "1");
		$("#cbGSPCView").prop("checked", x["cview"] == "1");
		$("#cbGSPCreateThread").prop("checked", x["ccreatethread"] == "1");
		$("#cbGSPCDeletePost").prop("checked", x["cdeletepost"] == "1");
		$("#cbGSPCDeleteThread").prop("checked", x["cdeletethread"] == "1");
		$("#cbGSPCDeleteSection").prop("checked", x["cdeletesection"] == "1");
	}

	function showUsEditModal(mID)
	{
		setUsEditId(mID);

		if(mID == -1)
		{
			$("#modalUsAddPwd").show();

			$("#tbUsAddUsername").val("");
			$("#tbUsAddPassword").val("");
			$("#tbUsAddEmail").val("");
			$("#tbUsAddFirstname").val("");
			$("#tbUsAddLastname").val("");
			$("#dateUsAddBirth").val("")
		}
		else
		{
			$("#modalUsAddPwd").hide();
			usGetData(mID);
		}

		$("#modalUsAdd").modal("show");
	}

	function showGSPModal(mIDGroup, mIDSection)
	{
		$(".gspNameDiv").text("ID Group: " + mIDGroup + " || ID Section: " + mIDSection);
		$("#modalGSPerms").modal("show");
	}

	function showUsActionsModal(mID)
	{
		setUsEditId(mID);
		$("#modalUsActions").modal("show");
	}

	$(document).ready(function(){ refreshAll(); });
</script>
