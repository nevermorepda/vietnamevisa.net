<div class="container">
	<div class="panel panel-default panel-login">
		<div class="panel-heading">
			<h3 class="panel-title text-center">Agency Authenticate</h3>
		</div>
		<div class="panel-body">
			<?
				if ($this->session->flashdata("error")) {
			?>
				<div class="alert alert-warning" role="alert">
					<p class="alert-message">
						<?=$this->session->flashdata("error");?>
					</p>
				</div>
			<?
				}
			?>
			<form class="frm-login" action="<?=site_url("syslog/login")?>" method="POST">
				<div class="form-group">
					<label class="form-label">Agent ID <span class="text-color-red">*</span></label>
					<input type="text" name="agent_id" class="form-control">
				</div>
				<div class="form-group">
					<label class="form-label">Email <span class="text-color-red">*</span></label>
					<input type="text" name="email" class="form-control">
				</div>
				<div class="form-group">
					<label class="form-label">Password <span class="text-color-red">*</span></label>
					<input type="password" name="password" class="form-control">
				</div>
				<div class="form-group">
					<button type="button" class="form-control btn btn-primary btn-login" data-loading-text="Loading..." autocomplete="off">Log In</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
	$(".btn-login").click(function(){
		$(".alert").hide();
		$(".frm-login").submit();
	});
});
</script>