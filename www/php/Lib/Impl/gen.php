<?php

class Gen
{
	public static function Textbox($mID, $mLabel)
	{
		print("
		<div class=\"form-group\">
			<label for=\"$mID\">$mLabel</label>
			<input type=\"text\" class=\"form-control\" id=\"$mID\" placeholder=\"$mLabel\">
		</div>
		");
	}

	public static function Textarea($mID, $mLabel)
	{
		print("
		<div class=\"form-group\">
			<label for=\"$mID\">$mLabel</label>
			<textarea rows=\"3\" class=\"form-control\" id=\"$mID\" placeholder=\"$mLabel\"></textarea>
		</div>
		");
	}

	public static function LinkIcon($mID, $mIcon)
	{
		print('
		<a id="'.$mID.'">
			<span class="glyphicon '.$mIcon.'" aria-hidden="true"></span>
		</a>
		');
	}

	public static function LinkBtn($mID, $mIcon, $mText = '', $mCSS = '', $mDismissModal = false)
	{
		print('
		<a class="btn btn-default '.$mCSS.'" href="#" role="button" id="'.$mID.'"'.($mDismissModal ? ' data-dismiss="modal"' : '').'>
			<span class="glyphicon '.$mIcon.'" aria-hidden="true"></span>
			'.$mText.'
		</a>
		');
	}

	public static function PanelTitle($mTitle)
	{
		print('<div class="panel-heading"><h4 class="panel-title">'.$mTitle.'</h4></div>');
	}

	public static function BtnCloseModal()
	{
		print('
		<a role="button" class="btn btn-default" data-dismiss="modal">
			<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
		</a>');
	}

	public static function CheckBox($mID, $mLabel, $mChecked = false)
	{
		print('
		<div class="checkbox">
			<label>
				<input id="'.$mID.'" type="checkbox" '.($mChecked ? 'checked="true"' : '').'>
				'.$mLabel.'
			</label>
		</div>');
	}	

	public static function JS_PostAction($mFnName, $mAction, $mKVArray, $mFnOk = '', $mFnFail = '')
	{
		print('<script>
			function '.$mFnName.'
			{
				var url = "php/Core/content/actions.php";
				var sentData = 
				{ 
					action: '."\"$mAction\"");
		
		foreach($mKVArray as $k => $v)
		{
			print(', '.$k.': '.$v);			
		}
		
		print('
				};

				$.post(url, sentData, 
					function(mOut, mTS, mJQXHR){'.$mFnOk.'})
				.fail(
					function(mJQXHR, mTS, mErr){'.$mFnFail.'});
			}
		</script>');
	}

	public static function JS_OnBtnClick($mID, $mX)
	{
		print('<script>
		$("#'.$mID.'").click(function(e)
		{
			e.preventDefault();
			'.$mX.'
		});
		</script>'); 
	}

	public static function JS_OnBtnClickDynamic($mID, $mX)
	{
		print('<script>
		$(document).on("click", "#'.$mID.'", function(e)
		{
			e.preventDefault();
			'.$mX.'
		});
		</script>'); 
	}
}

?>	