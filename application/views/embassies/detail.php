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
			<p></p>
			<? if (!empty($requirement)) {?>
			<p>--&gt; <a style="color: #004B91;" title="<?=$requirement->title?>" href="<?=site_url("visa-requirements/".$nation->alias)?>"><?=$requirement->title?></a></p>
			<? } ?>
			<? if (!empty($tips)) {?>
			<p>--&gt; <a style="color: #004B91;" title="<?=$tips[0]->title?>" href="<?=site_url("vietnam-visa-tips/view/{$tips[0]->alias}")?>"><?=$tips[0]->title?></a></p>
			<? } ?>
		</div>
	<?
		} else {
	?>
		<div class="col-sm-9 embassy-l">
			<h1 class="page-title">Vietnam Embassy in <?=$nation->name?></h1>
			<p>We regret to inform that there is no Vietnam Embassy/Consulate in <span class="font-weight-bold red"><?=$nation->name?></span> at the present.  </p>
			<p>Please contact the <span class="font-weight-bold" style="color: #004B91;">Vietnam Embassy</span>  or Vietnam Consulate in other countries during business hours for visa issue.</p>
			<p><span class="font-weight-bold">Citizens or residents in <span class="red"> <?=$nation->name?></span> can apply for a visa to Vietnam</span> by:</p>
			<p><span class="font-weight-bold">Apply a <span class="font-weight-bold" style="color: #004B91;">Vietnam Visa Online</span> from <span class="red"> <?=$nation->name?></span> with us: </span>(The processing time is 02 working days or 4 hours under Urgent service, the visa fees depend on the type of visa that you wish to apply for)</p>
			<p>For any further information about Vietnam visa, feel free to contact us at:<br>
				- Email: <span class="red"><?=MAIL_INFO?></span><br>
				- Phone number: <span class="red"><?=HOTLINE?></span><br>
				- Website: <span class="red"><?=SITE_NAME?></span></p>
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
					<? $i=0; foreach ($regions as $region) { 
						$info = new stdClass();
						$info->region = $region;
						$countries = $this->m_country->items($info, 1);
					?>
					<li class="item" num="<?=$i?>" stt="<?=($nation->region != $region) ? '0' : '1' ?>" child-stt="0">
						<a><i class="fa fa-caret-right transition <?=($nation->region != $region) ? '' : 'rotate' ?>"></i><?=$region?></a>
					</li>
					<ul class="sub-list sub-list-<?=$i?>" <?=($nation->region != $region) ? 'style="display: none;"' : '' ?>>
						<? foreach ($countries as $countrie) { ?>
						<li class="sub-item"><a href="<?=site_url("vietnam-embassies/view/{$countrie->alias}")?>" class="<?=($countrie->alias == $nation->alias) ? 'active' : ''?>"><?=$countrie->name?></a></li>
						<? } ?>
					</ul>
					<? $i++;} ?>
				</ul>
			</div>
		</div>
		<script type="text/javascript">
			$(document).ready(function() {
				$('.item').click(function(event) {
					var st = $(this).attr('stt');
					var num = $(this).attr('num');
					if (parseInt(st) == 0) {
						$('.sub-list-'+num).css('display', 'block');
						$(this).attr('stt','1');
						$(this).find('.fa-caret-right').addClass('rotate');
					} else {
						$('.sub-list-'+num).css('display', 'none');
						$(this).attr('stt','0');
						$(this).find('.fa-caret-right').removeClass('rotate');
					}
					
				});
			});
		</script>
	</div>
</div>