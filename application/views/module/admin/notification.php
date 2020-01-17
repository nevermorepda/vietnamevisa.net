<?
	if (!empty($this->session->flashdata("error"))) {
		?>
			<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<p><?=$this->session->flashdata("error")?></p>
			</div>
		<?
	}
	else if (!empty($this->session->flashdata("success"))) {
		?>
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<p><?=$this->session->flashdata("success")?></p>
			</div>
		<?
	}
?>