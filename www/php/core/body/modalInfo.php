<div class="modal fade" id="modalInfo">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"></span>
				</button>
				<h4 class="modal-title" id="modalInfoHeader"></h4>
			</div>	
			<div class="modal-body">
				<p id="modalInfoText"></p>
			</div>
			<div class="modal-footer">
				<?php Gen::BtnCloseModal(); ?>   
			</div>
		</div>
	</div>
</div>

<script>
function showModalInfo(mHeader, mText)
{
	$("#modalInfoHeader").text(mHeader);
	$("#modalInfoText").html(mText);
	$("#modalInfo").modal('show');
}
</script>