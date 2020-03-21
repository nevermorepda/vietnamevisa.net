<div class="container" style="margin-bottom: 40px;">
	<div class="row clearfix">
	<?
		$requirement = $this->m_requirement->load($nation->alias);
		
		$info = new stdClass();
		$info->nation = $nation->name;
		$tips = $this->m_tips->items($info, 1);
		
		if (!empty($item)) {
	?>
		<div class="col-sm-9 embassy-l">
			<h1 class="page-title"><?=$item->title?></h1>
			<div><?=$item->content?></div>
			<p>--&gt;</p>
			<? if (!empty($requirement)) {?>
			<p><a title="<?=$requirement->title?>" href="<?=site_url("visa-requirements/".$nation->alias)?>"><?=$requirement->title?></a></p>
			<? } ?>
			<? if (!empty($tips)) {?>
			<p><a title="<?=$tips[0]->title?>" href="<?=site_url("vietnam-visa-tips/view/{$tips[0]->alias}")?>"><?=$tips[0]->title?></a></p>
			<? } ?>
		</div>
	<?
		} else {
	?>
		<div class="col-sm-9 embassy-l">
			<h1 class="page-title">Vietnam Embassy in <?=$nation->name?></h1>
			<p>At present, there is no information about the Embassy of Vietnam in <?=$nation->name?>. </p>
			<p>- Visit the nearest Vietnam Embassy in the neighboring country to apply for a visa by yourself, or </p>
			<p>- Apply online at <a title="<?=SITE_NAME?>" href="<?=BASE_URL_HTTPS."/apply-visa.html"?>"><?=SITE_NAME?></a> for a Vietnam visa on arrival (picked up at the arrival airport in Vietnam) </p>
			<p>--&gt;</p>
			<? if (!empty($requirement)) {?>
			<p><a title="<?=$requirement->title?>" href="<?=site_url("visa-requirements/".$nation->alias)?>"><?=$requirement->title?></a></p>
			<? } ?>
			<? if (!empty($tips)) {?>
			<p><a title="<?=$tips[0]->title?>" href="<?=site_url("vietnam-visa-tips/view/{$tips[0]->alias}")?>"><?=$tips[0]->title?></a></p>
			<? } ?>
			<div style="margin-top:20px;">
				<p>If you have any queries or comments, kindly <a title="contact us" href="<?=site_url("contact")?>">contact us</a> to get support.</p>
			</div>
		</div>
	<?
		}
	?>
		<?
			$regions = array();
			foreach ($nations as $value) {
				if (!in_array($value->region, $regions)) {
					$regions[] = $value->region;
				}
			}
			sort($regions);
		?>
		<div class="col-sm-3 d-none d-sm-none d-md-block">
			<div class="embassy-region">
				<div class="title">REGIONS</div>
				<ul class="list">
					<? foreach ($regions as $region) { 
						$info = new stdClass();
						$info->region = $region;
						$countries = $this->m_country->items($info, 1);
					?>
					<li class="item" stt="<?=($nation->region != $region) ? '0' : '1' ?>">
						<a><i class="fa fa-caret-right transition <?=($nation->region != $region) ? '' : 'rotate' ?>"></i><?=$region?></a>
						<ul class="sub-list" <?=($nation->region != $region) ? 'style="display: none;"' : '' ?>>
							<? foreach ($countries as $countrie) { ?>
							<li class="sub-item"><a href="<?=site_url("vietnam-embassies/view/{$countrie->alias}")?>" class="<?=($countrie->alias == $nation->alias) ? 'active' : ''?>"><?=$countrie->name?></a></li>
							<? } ?>
						</ul>
					</li>
					<? } ?>
				</ul>
			</div>
		</div>
		<script type="text/javascript">
			$(document).ready(function() {
				$('.item').click(function(event) {
					var st = $(this).attr('stt');
					// $('.sub-list').css('display', 'none');
					// $('.fa-caret-right').removeClass('rotate');
					// $('.item').attr('stt', '0');
					if (parseInt(st) == 0) {
						$(this).find('.sub-list').css('display', 'block');
						$(this).attr('stt','1');
						$(this).find('.fa-caret-right').addClass('rotate');
					} else {
						$(this).find('.sub-list').css('display', 'none');
						$(this).attr('stt','0');
						$(this).find('.fa-caret-right').removeClass('rotate');
					}
					
				});
			});
		</script>
	</div>
</div>