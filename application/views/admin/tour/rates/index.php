<?
	$arrduration = array();
	$arrtype = array();
	$hassupplement = false;
	$arrdurationmerger = array();
	foreach($items as $rate){
		$duartion = array();
		if ($rate->single_supplement==1) {
			$hassupplement = true;
		} else {
			if (!array_key_exists($rate->type_passenger, $arrduration)) {
				// $arrduration[1]: Adults
				// $arrduration[2]: Children
				// $arrduration[3]: Infants
				$arrduration[$rate->type_passenger] = array();
			}
			if (!in_array($rate->group_size, $arrduration[$rate->type_passenger])) {
				$arrduration[$rate->type_passenger][$rate->group_size] = $rate->group_size;
			}
			if (!in_array($rate->type_passenger,$arrtype)) {
				$arrtype[$rate->type_passenger]["type_passenger"] = $rate->type_passenger;
				$arrtype[$rate->type_passenger]["name"] = $rate->name;
			}
			if (!in_array($rate->group_size, $arrdurationmerger)) {
				$arrdurationmerger[] = $rate->group_size;
			}
		}
	}
	//type_passenger: 1: Adults, 2: Children, 3: Infants
	ksort($arrduration);
	ksort($arrdurationmerger);
?>
<section>
	<div class="container-fluid">
		<div class="tool-bar clearfix">
			<h1 class="page-title">
				Tour Rates
				<div class="pull-right">
					<ul class="action-icon-list">
						<li><a href="#" class="btn-unpublish"><i class="fa fa-eye-slash" aria-hidden="true"></i> Hide</a></li>
						<li><a href="#" class="btn-publish"><i class="fa fa-eye" aria-hidden="true"></i> Show</a></li>
						<li><a href="#" class="btn-delete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a></li>
						<li><a href="<?=site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/{$tour->id}/add")?>"><i class="fa fa-plus" aria-hidden="true"></i>Add</a></li>
					</ul>
				</div>
			</h1>
		</div>
		<form id="frm-admin" name="adminForm" action="" method="POST">
			<input type="hidden" id="task" name="task" value="">
			<input type="hidden" id="boxchecked" name="boxchecked" value="0" />
			<input type="hidden" name="tour_id" value="<?=$tour->id?>" />
			<table class="table table-bordered table-hover">
				<? if (!empty($arrdurationmerger)) {?>
				<tr>
					<th>Group Size</th>
					<th>Type Passenger</th>
					<? foreach ($arrdurationmerger as $duration => $val) { ?>
					<th>fr. <?=(($val < 2) ? $val." person" : $val." persons")?></th>
					<? } ?>
					<? if ($hassupplement) { ?>
					<th>Single Supp'</th>
					<? } ?>
				</tr>
				<tr>
					<?
						$irow = 0;
						/* 
							$arrtype
								1: Adults
								2: Children
						*/
						foreach ($arrtype as $type => $valtype) {
							if ($irow++) {
								echo '</tr><tr>';
							}
							switch($valtype["type_passenger"]) {
								case "1":
									$passenger = "Adults"; break;
								case "2":
									$passenger = "Children (5-12 age)"; break;
								case "3":
									$passenger = "Infants"; break;
								default: 
									$passenger = "Adults"; break;
							}
							echo '<td class="first"><a href="'.site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/".$tour->id.'/edit/'.base64_encode($valtype["name"]."_".$valtype["type_passenger"])).'">'.$valtype["name"].'</a></td>';
							echo '<td class="first"><a href="'.site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/".$tour->id.'/edit/'.base64_encode($valtype["name"]."_".$valtype["type_passenger"])).'">'.$passenger.'</a></td>';
							foreach ($arrdurationmerger as $valduration) { //1,2,3,4,5,6,8
								$hasrate = 0;
								if (!in_array($valduration, $arrduration[$valtype["type_passenger"]])) {
									echo '<td>-</td>';
									continue;
								}
								foreach ($items as $rate) {
									if ($rate->name == $valtype["name"] && $rate->group_size == $valduration && $rate->single_supplement==0 && $rate->type_passenger == $valtype["type_passenger"]) {
										echo '<td><a href="'.site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/".$tour->id.'/edit/'.base64_encode($valtype["name"]."_".$valtype["type_passenger"])).'">$'.number_format($rate->price,2,'.',',').'</a></td>';
										$hasrate = 1;
										unset($rate);
										break;
									}
								}
								if ($hasrate==0) {
									echo '<td>-</td>';
								}
							}
							if ($hassupplement) {
								$hasrate = 0;
								foreach ($items as $rate) {
									if ($rate->name == $valtype["name"] && $rate->single_supplement==1 && $rate->type_passenger == $valtype["type_passenger"]) {
										echo '<td><a href="'.site_url("{$this->util->slug($this->router->fetch_class())}/{$this->util->slug($this->router->fetch_method())}/".$tour->id.'/edit/'.base64_encode($valtype["name"]."_".$valtype["type_passenger"])).'">+ $'.number_format($rate->price,2,'.',',').'</a></td>';
										$hasrate = 1;
										break;
									}
								}
								if ($hasrate==0) {
									echo '<td>-</td>';
								}
							}
						}
					?>
				</tr>
				<? } ?>
			</table>
		</form>
	</div>
</section>

<script>
$(document).ready(function() {
	$(".btn-publish").click(function(e){
		e.preventDefault();
		if ($("#boxchecked").val() == 0) {
			messageBox("ERROR", "Error", "Please make a selection from the list to publish.");
		}
		else {
			submitButton("publish");
		}
	});
	$(".btn-unpublish").click(function(e){
		e.preventDefault();
		if ($("#boxchecked").val() == 0) {
			messageBox("ERROR", "Error", "Please make a selection from the list to unpublish.");
		}
		else {
			submitButton("unpublish");
		}
	});
	$(".btn-delete").click(function(e){
		e.preventDefault();
		if ($("#boxchecked").val() == 0) {
			messageBox("ERROR", "Error", "Please make a selection from the list to delete.");
		}
		else {
			confirmBox("Delete items", "Are you sure you want to delete the selected items?", "submitButton", "delete");
		}
	});
});
</script>

