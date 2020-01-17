<div class="embassy">
	<div class="embassy-banner">
		<div class="container">
			<div class="alternative-breadcrumb">
			<? require_once(APPPATH."views/module/breadcrumb.php"); ?>
			</div>
		</div>
	</div>
	<div class="">
		<div class="container center" style="margin-top: 20px; margin-bottom: 20px">
			<h1>Vietnam Visa Tips</h1>
			<h2 class="f24">How to get the Vietnam visa from your nation.</h2>
			<p class="f18">Please click on the link below to get started.</p>
		</div>
	</div>
	<div class="container">
		<div class="pagination center">
		<?
			$char = "A";
			do {
				?>
				<a title="<?=$char?>" href="#eb_<?=$char?>"><?=$char?></a>
				<?
			} while ($char++ < "Z");
		?>
		</div>
		
		<div class="nations clearfix">
			<?
				$char = "A";
				do {
					?>
					<div class="row embassies" id="eb_<?=$char?>">
						<div class="col-sm-1 col-xs-2 number"><?=$char?></div>
						<div class="col-sm-11 col-xs-10">
							<ul class="row list">
							<?
							if (!empty($items) && sizeof($items)) {
								foreach ($items as $item) {
									if (substr($item->nation, 0, 1) == $char) {
									?>
									<li class="col-sm-3 col-xs-6">
										<a title="<?=$item->title?>" href="<?=site_url("vietnam-visa-tips/view/{$item->alias}")?>"><img src="<?=IMG_URL?>flags/<?=$item->nation?>.png"/> <?=$item->nation?></a>
									</li>
									<?
									}
								}
							}
							?>
							</ul>
						</div>
					</div>
					<?
				} while ($char++ < "Z");
			?>
		</div>
	</div>
</div>