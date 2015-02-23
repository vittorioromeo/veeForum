<?php

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once("$root/php/lib/lib.php");

$action = $_POST["action"];
if(!isset($action)) exit(1);

class SectionData
{
	public $row;
	public $collapseID; 
	public $newThreadID;
	public $delSectionID;

	public function __construct($mRow)
	{
		$this->row = $mRow;
		$this->collapseID = 'btn_section_'.$this->row['id'].'collapse';
		$this->newThreadID = 'btn_section_'.$this->row['id'].'newThread';
		$this->delSectionID = 'btn_section_'.$this->row['id'].'delSection';
	}

	private function printThread($mRow)
	{
		print('<div class="panel panel-default">');
			print('<div class="panel-body">');
				print('<strong>'.$mRow['title'].'</strong><br/>');

				$rowCD = TBS::$cntBase->findByID($mRow['id_base']);
				$authorName = TBS::$user->findByID($rowCD['id_author'])['username'];
				$date = $rowCD['creation_timestamp'];
				print("By: $authorName<br/>");
				print("On: $date");

				print('<div class="btn-group-vertical pull-right">');
						
					$threadID = $mRow['id'];
					$btnID = 'btnScGotoThread_'.$threadID;
					Gen::LinkBtn($btnID, 'glyphicon-arrow-right');

					Gen::JS_OnBtnClick($btnID, 'gotoThread('.$threadID.');');
						
		
				print('</div>');
			print('</div>');
		print('</div>');
	}

	private function printHeaderBtns()
	{		
		print('<div class="btn-group pull-right">');
			
		if(Creds::hasCUPerm($this->row['id'], Perms::addThread))
			Gen::LinkBtn($this->newThreadID, "glyphicon-plus", "New thread", "btn-xs");

		if(Creds::hasCUPerm($this->row['id'], Perms::delSection))
			Gen::LinkBtn($this->delSectionID, "glyphicon-remove", "Delete section", "btn-xs");
		
			print('
				<a class="btn btn-default btn-xs" data-toggle="collapse" href="#'.$this->collapseID.'" aria-expanded="true" aria-controls="'.$this->collapseID.'">
					<span class="glyphicon glyphicon-collapse-down"></span>
				</a>');

		print('</div>');
	}

	private function printHeader()
	{
		print('<div class="panel-heading">');
			print('<div class="panel-title">');
				print($this->row['name']);
				$this->printHeaderBtns();
			print('</div>');
		print('</div>');
	}

	private function printBody()
	{
		$id = $this->row['id'];

		print('<div class="collapse in" id="'.$this->collapseID.'">');
			print('<div class="panel-body">');

			$this->printSubsections();					
		
		TBS::$cntThread->forWhere(function($mRow)
		{
			$this->printThread($mRow);
		}, "id_section = $id");

			print('</div>');
		print('</div>');
	}

	private function printContents()
	{
		$this->printHeader();
		$this->printBody();
	}

	private function printScripts()
	{
		$ids = $this->row['id'];
		Gen::JS_PostAction('delSection(mX)', 'scDel', [ 'id' => "mX" ], 'refreshAll();');
		Gen::JS_OnBtnClick($this->newThreadID, 'showNewThreadModal('.$ids.');');
		Gen::JS_OnBtnClick($this->delSectionID, 'delSection('.$ids.');');
	}

	public function printSubsections()
	{
		$id = $this->row['id'];
		TBS::$section->forWhere(function($mRow)
		{
			$sd = new SectionData($mRow);
			$sd->printAll();			
		}, "id_parent = $id");
	}

	public function printAll()
	{
		if(!Creds::hasCUPerm($this->row['id'], Perms::view)) return;

		print('<div class="panel panel-default">');					
			$this->printContents();
		print('</div>');
	
		$this->printScripts();
	}
}

class ActionUtils
{
	public static function printQuerySuccess($mRes)
	{
		print($mRes ? "Success." : DB::$lastError);
	}

	public static function printPost($mRow)
	{
		$id = $mRow['id'];	

		$rowCD = TBS::$cntBase->findByID($mRow['id_base']);
		$authorName = TBS::$user->findByID($rowCD['id_author'])['username'];
		$postDate = $rowCD['creation_timestamp'];

		print('<div class="panel panel-default">');
			print('<div class="panel-body">');

			print('<strong>');
			print("Post ID: $id<br/>Author: $authorName<br/>Posted on: $postDate");
			print('</strong>');

			print('<br/><br/>');

			print('<div style="word-wrap: break-word;">');
			print($mRow['contents']);
			print('</div>');

			print('</div>');
		print('</div>');
	}

	public static function printNtfs($mXs)
	{
		while($row = $mXs->fetch_assoc())
		{			
			$idNtf = $row['id'];
			$idNtfBase = $row['id_base'];
			$idThread = $row['id_thread'];
			$idPost = $row['id_post'];
			$seen = $row['seen'];


			$threadTitle = TBS::$cntThread->findByID($idThread)['title'];
			$idPostBase = TBS::$cntPost->findByID($idPost)['id_base'];
			$idPostAuthor = TBS::$cntBase->findByID($idPostBase)['id_author'];
			$postAuthor = TBS::$user->findByID($idPostAuthor)['username'];

			$btnIdPrefix = 'btnNtfThread'.$idNtf.$idThread.$idPost;
			$btnIdGo = $btnIdPrefix.'go';
			$btnIdDel = $btnIdPrefix.'del';
			$btnIdMark = $btnIdPrefix.'mark';

			$bf = (new Container());
			$bpb = $bf->inBSPanelNoHeader()
					->inBSBtnGroup('pull-left')
						->inBSLinkBtnActive($btnIdDel, 'delNtfByID('.$idNtfBase.');', 'btn-xs')
							->bsIcon('remove')
							->out()
						->inBSLinkBtnActive($btnIdMark, 'markNtfByID('.$idNtfBase.');', 'btn-xs')
							->bsIcon('pushpin')
							->out()
						->inBSLinkBtnActive($btnIdGo, 'gotoThread('.$idThread.'); refreshAll();', 'btn-xs')					
							->bsIcon('arrow-right')
							->out()
						->out();



			$bfdiv = $bpb->inDiv(['style' => 'float: left; padding-left: 10px;']);
				
			$str = 'New post in thread <strong>'.$threadTitle.'</strong> by <strong>'.$postAuthor.'</strong>';

			if(!$seen)
			{
				$bfdiv->literal($str);
			}
			else
			{
				$bpb->addAttribute('style', 'background-color: rgb(220, 220, 220)');
				$bfdiv->literal($str);
			}


			$bf->printRoot();
		}
	}
}

class Actions
{
	public static function markAllNtfs()
	{
		$res = TBS::$ntfBase->markAllCU();
		return ActionUtils::printQuerySuccess($res);
	}

	public static function delAllNtfs()
	{
		$res = TBS::$ntfBase->delAllCU();
		return ActionUtils::printQuerySuccess($res);	
	}

	public static function delNtfByID()
	{
		$id = $_POST["id"];
		TBS::$ntfThread->deleteWhere('id_base = '.$id);
		TBS::$ntfUser->deleteWhere('id_base = '.$id);
		TBS::$ntfTag->deleteWhere('id_base = '.$id);		
	}

	public static function markNtfByID()
	{
		$id = $_POST["id"];
		$currentSeen = TBS::$ntfBase->findByID($id)['seen'];		
		$res = DB::query("UPDATE tbl_notification_base SET seen = ".($currentSeen ? 'false' : 'true')." where id = $id");
		return ActionUtils::printQuerySuccess($res);
	}

	public static function refreshNotificationsModal()
	{	
		ActionUtils::printNtfs(TBS::$ntfThread->getUnseen());
		ActionUtils::printNtfs(TBS::$ntfThread->getSeen());
	}


	public static function refreshThread()
	{
		$idThread = Session::get(SK::$threadID);
		$tr = TBS::$cntThread->findByID($idThread);
		$title = $tr['title'];

		$rowCD = TBS::$cntBase->findByID($tr['id_base']);
		$authorName = TBS::$user->findByID($rowCD['id_author'])['username'];
		$date = $rowCD['creation_timestamp'];

		print("<h2>$title</h2>");
		print("<strong>");
		print("ID: $idThread<br/>");
		print("Author: $authorName<br/>");
		print("Date: $date<br/>");
		print("</strong>");
	}

	public static function refreshThreadCtrls()
	{
		$tid = Session::get(SK::$threadID);
		$sid = TBS::$cntThread->findByID($tid)['id_section'];

		if(Creds::hasCUPerm($sid, Perms::post))
			Gen::LinkBtn('btnNewPost', 'glyphicon-plus', 'New post'); 

		// TODO: if(TODO)

		if(!TBS::$subThread->has(Creds::getCUID(), $tid))
		{
			Gen::LinkBtn('btnSubThread', 'glyphicon-star', 'Subscribe'); 
		}
		else
		{
			Gen::LinkBtn('btnUnsubThread', 'glyphicon-star-empty', 'Unsubscribe'); 
		}
		
		if(Creds::hasCUPerm($sid, Perms::delPost))
			Gen::LinkBtn('btnDelPosts', 'glyphicon-remove', 'Delete all posts'); 

		if(Creds::hasCUPerm($sid, Perms::delThread))
			Gen::LinkBtn('btnDelThread', 'glyphicon-remove', 'Delete thread'); 
	}

	public static function deleteCurrentPosts()
	{
		$idThread = Session::get(SK::$threadID);
		TBS::$cntPost->deleteWhere("id_thread = $idThread");
	}

	public static function subCurrentThread()
	{
		$idThread = Session::get(SK::$threadID);
		$res = TBS::$subThread->mkCU($idThread);

		Debug::lo("FIRINGACTION");

		header("Content-type: application/json; charset=ISO-8859-1");
		if(!$res) print('false');
		else print('true');
	}

	public static function unsubCurrentThread()
	{
		$idThread = Session::get(SK::$threadID);
		$res = TBS::$subThread->delCU($idThread);

		header("Content-type: application/json; charset=ISO-8859-1");
		if(!$res) print('false');
		else print('true');
	}

	public static function deleteCurrentThread()
	{
		$idThread = Session::get(SK::$threadID);
		$res = TBS::$cntThread->deleteByID($idThread);

		header("Content-type: application/json; charset=ISO-8859-1");
		if(!$res) print('false');
		else print('true');
	}

	public static function refreshSections()
	{
		TBS::$section->forWhere(function($mRow)
		{
		 	print('<div class="row">');
				print('<div class="col-md-12">');

					$sd = new SectionData($mRow);
					$sd->printAll();			

				print('</div>');
			print('</div>');
		}, "id_parent is null");
	}

	public static function refreshPosts()
	{
		$idThread = Session::get(SK::$threadID);

		TBS::$cntPost->forWhere(function($mRow)
		{
			ActionUtils::printPost($mRow);		
		}, "id_thread = $idThread");
	}

	public static function gotoThread()
	{
		$idThread = $_POST["idThread"];
		Session::set(SK::$threadID, $idThread);
	}

	public static function newPost()
	{		
		$contents = $_POST["contents"];			
		$res = TBS::$cntPost->mkCU(Session::get(SK::$threadID), $contents);

		ActionUtils::printQuerySuccess($res);
	}

	public static function newThread()
	{
		$sectionId = $_POST["sectionId"];
		$title = $_POST["title"];		
		$res = TBS::$cntThread->mkCU($sectionId, $title);

		ActionUtils::printQuerySuccess($res);
	}




	public static function setDebugEnabled()
	{
		Debug::setEnabled($_POST["enabled"] == "true");		
	}

	public static function refreshDebugLo()
	{
		Debug::echoLo();
	}


	
	public static function tryRegister()
	{
		$groupId = TBS::$group->getFirst()['id'];
		$username = $_POST['username'];
		$passwordHash = Utils::getPwdHash($_POST['password']);
		$email = $_POST['email'];
		$registrationDate = date('Y-m-d');
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$birthdate = $_POST['birthdate'];

		$res = TBS::$user->insertValues($groupId, $username, $passwordHash, $email, $registrationDate, $firstname, $lastname, $birthname);			
		
		print($res ? "Success." : DB::$lastError);
	}



	public static function trySignIn()
	{
		print(Creds::tryLogin($_POST["user"], $_POST["pass"]));
	}

	public static function trySignOut()
	{
		print(Creds::tryLogout());
	}		

	public static function getCurrentPage()
	{
		if(Creds::isLoggedIn() && Creds::canCUViewCurrentPage())
		{
			print(Pages::getCurrent()->getURL());
		}
		else
		{
			print('php/core/content/forbidden.php');		
		}
	}



	public static function scAdd()
	{
		$idParent = $_POST["idParent"];
		if($idParent == -1) $idParent = 'null';

		$res = TBS::$section->insertValues($idParent, $_POST["name"]);
		ActionUtils::printQuerySuccess($res);
	}
	
	public static function changeCurrentPage()
	{
		Pages::setCurrent($_POST["idpage"]);		
	}

	public static function scDel()
	{
		$res = TBS::$section->deleteByID($_POST["id"]);
		ActionUtils::printQuerySuccess($res);
	}

	public static function scDelRecursive()
	{		
		$res = TBS::$section->deleteRecursiveByID($_POST["id"]);
		ActionUtils::printQuerySuccess($res);
	}

	public static function getSectionOptions()
	{
		$nullRow = $_POST["nullRow"];

		if($nullRow == "true")
		{
			print('<option value="-1">NULL</option>');
		}

		foreach(TBS::$section->getAll() as $x)
		{
			print("<option value=".$x["id"].">(ID: ".$x["id"].") ".$x["name"]."</option>");
		}
	}

	public static function getSectionHierarchyStr()
	{
		print(nl2br(TBS::$section->getHierarchyStr()));
	}





	public static function grAdd()
	{
		$idParent = $_POST["idParent"];
		$name = $_POST["name"];
		$privileges = $_POST["privileges"];
		$msg = "";

		$pset = new PrivSet();
		if($privileges) foreach($privileges as $x) $pset->add($x);

		$res = TBS::$group->mkGroup($idParent, DB::v($name), $pset);
		print($res ? "Success." : DB::$lastError);	
	}

	public static function grDel()
	{
		$res = TBS::$group->deleteByID($_POST["id"]);
		print($res ? "Success." : DB::$lastError);
	}

	public static function grDelRecursive()
	{
		$res = TBS::$group->deleteRecursiveByID($_POST["id"]);
		print($res ? "Success." : DB::$lastError);
	}

	public static function getGroupOptions()
	{
		$nullRow = $_POST["nullRow"];

		if($nullRow == "true")
		{
			print('<option value="-1">NULL</option>');
		}

		foreach(TBS::$group->getAll() as $x)
		{
			print("<option value=".$x["id"].">(ID: ".$x["id"].") ".$x["name"]."</option>");
		}
	}

	public static function getGroupHierarchyStr()
	{
		print(nl2br(TBS::$group->getHierarchyStr()));
	}

	public static function usAdd()
	{
		$id = $_POST['id'];

		$groupId = $_POST['groupId'];
		$username = $_POST['username'];
		$passwordHash = Utils::getPwdHash($_POST['password']);
		$email = $_POST['email'];
		$registrationDate = date('Y-m-d');
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$birthdate = $_POST['birthdate'];

		$res = "";

		if($id == -1)
		{
			$res = TBS::$user->insertValues($groupId, $username, $passwordHash, $email, $registrationDate, $firstname, $lastname, $birthname);			
		}
		else
		{
			$res = TBS::$user->updateByID($id, 
			[			
				'id_group' => $groupId,
				'username' => $username,
				'email' => $email,
				'registration_date' => $registrationDate,
				'firstname' => $firstname,
				'lastname' => $lastname,
				'birth_date' => $birthdate
			]);
		}

		print($res ? "Success." : DB::$lastError);
	}

	public static function usDel()
	{
		$id = $_POST["id"];

		TBS::$user->deleteByID($id);

		print("Success.");
	}

	public static function usGetData()
	{
		$id = $_POST["id"];
		$r = TBS::$user->getFirstWhere('id = '.DB::v($id));
		$res = 
		[
			'username' => $r['username'],
			'email' => $r['email'],
			'groupid' => $r['id_group'],
			'firstname' => $r['firstname'],
			'lastname' => $r['lastname'],
			'registrationdate' => $r['registration_date'],
			'birthdate' => $r['birth_date']
		];

		$tj = json_encode($res);
		print($tj);
	}

	public static function getTblUsers()
	{
		print('
		<thead>
			<tr>
				<th>');
					Gen::LinkBtn('btnUsAdd', 'glyphicon-plus', '', 'btn-xs');
		print('</th>
				<th>ID</th>
				<th>Username</th>
				<th>Email</th>
				<th>Group</th>
				<th>First name</th>
				<th>Last name</th>
				<th>Registration date</th>
				<th>Birth date</th>
			</tr>
		</thead>');

		print('<tbody>');

			foreach(TBS::$user->getAll() as $x)
			{
				print('<tr>');

				$userId = $x['id'];
				$groupId = $x['id_group'];
				$groupName = TBS::$group->getFirstWhere('id = '.DB::v($groupId))['name'];
				$btnActionsId = 'btnUsActions_' . $userId;
				$btnEditId = 'btnUsEdit_' . $userId;

				print('<td>');
					Gen::LinkBtn($btnActionsId, 'glyphicon-asterisk', '', 'btn-xs');
					Gen::JS_OnBtnClick($btnActionsId, 'showUsActionsModal('.$userId.');');
					
					Gen::LinkBtn($btnEditId, 'glyphicon-pencil', '', 'btn-xs');
					Gen::JS_OnBtnClick($btnEditId, 'showUsEditModal('.$userId.');');
				print('</td>');

				print('<td>'.$userId.'</td>');
				print('<td>'.$x['username'].'</td>');
				print('<td>'.$x['email'].'</td>');
				print('<td>'.$groupName.'</td>');
				print('<td>'.$x['firstname'].'</td>');
				print('<td>'.$x['lastname'].'</td>');
				print('<td>'.$x['registration_date'].'</td>');
				print('<td>'.$x['birth_date'].'</td>');
			
				print('</tr>');
			}
				
		print('</tbody>');
	}

	public static function getGSPData()
	{
		$idGroup = $_POST["idgroup"];
		$idSection = $_POST["idsection"];
		$where = 'id_group = '.DB::v($idGroup).' AND id_section = '.DB::v($idSection);

		if(!TBS::$gsperms->hasAnyWhere($where))
		{
			TBS::$gsperms->insertValues($idGroup, $idSection, false, false, false, false, false, false);
		}

		$r = TBS::$gsperms->getFirstWhere($where);
		$res = 
		[
			'cpost' => $r['can_post'],
			'cview' => $r['can_view'],
			'ccreatethread' => $r['can_create_thread'],
			'cdeletepost' => $r['can_delete_post'],
			'cdeletethread' => $r['can_delete_thread'],
			'cdeletesection' => $r['can_delete_section']
		];

		$tj = json_encode($res);
		print($tj);
	}

	public static function setGSPData()
	{
		$idGroup = $_POST["idgroup"];
		$idSection = $_POST["idsection"];;

		$cpost = $_POST["cpost"];
		$cview = $_POST["cview"];
		$ccreatethread = $_POST["ccreatethread"];
		$cdeletepost = $_POST["cdeletepost"];
		$cdeletethread = $_POST["cdeletethread"];
		$cdeletesection = $_POST["cdeletesection"];

		$where = 'id_group = '.DB::v($idGroup).' AND id_section = '.DB::v($idSection);
		$r = TBS::$gsperms->getFirstWhere($where);
		$id = $r['id'];

		$res = TBS::$gsperms->updateByID($id,
		[
			'can_post' => $cpost,
			'can_view' => $cview,
			'can_create_thread' => $ccreatethread,
			'can_delete_post' => $cdeletepost,
			'can_delete_thread' => $cdeletethread,
			'can_delete_section' => $cdeletesection
		]);

		ActionUtils::printQuerySuccess($res);
	}
}

Actions::$action();

?>
		