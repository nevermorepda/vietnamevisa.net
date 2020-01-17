<link rel="stylesheet" type="text/css" media="screen,all" href="<?=CSS_URL?>member.css" />

<?
	$bookings = $this->m_visa_booking->book_by_user($this->session->userdata("user")->id);
?>

<div class="container">
	<div class="info-bar">
		<h1><span class="glyphicon glyphicon-user"></span> <?=$this->session->userdata("user")->user_fullname?> <span class="right-panel"><a href="<?=site_url("member/logout")?>"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></span></h1>
	</div>
	<div class="myaccount">
		<? require_once(APPPATH."views/member/nav_bar.php"); ?>
		<div class="panel-account">
			<div class="detail">
				<div class="row">
					<div class="col-sm-5" style="border-right: 1px solid #eceff1;">
						<div class="wrap-level-account">
							<? $level = $this->util->level_account(); ?>
							<div class="level-badge">
								<img src="<?=IMG_URL.'badge/'.$level[0].'.png'?>" alt="">
							</div>
							<div class="info">
								<h4 class="name"><?=$this->session->userdata('user')->user_login?></h4>
								<div class="title">Level: <?=$level[1]?></div>
								<div class="book-fee"><span><?=$level[3]?> <sup style="font-size: 12px;top: -1.5em;">Points</sup></span></div>
								<div class="discount">Discount : <?=$level[2]?>%</div>
								<div style="margin-top: 20px;">
									<a href="<?=site_url("apply-visa")?>" class="btn btn-danger">Apply Visa</a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-7">
						<table class="level">
							<tr>
								<td class="text-center"><img style="width: 35px;" src="<?=IMG_URL.'badge/1.png'?>" alt="Normal"></td>
								<td class="text-center"><div class="title-account">Normal</div></td>
								<td>Points: 0 -> 100</td>
								<td></td>
							</tr>
							<tr>
								<td class="text-center"><img style="width: 35px;" src="<?=IMG_URL.'badge/2.png'?>" alt="Silver"></td>
								<td class="text-center"><div class="title-account">Silver</div></td>
								<td>Points: 100 -> 200</td>
								<td>Discount: <b class="text-color-red">20%</b></td>
							</tr>
							<tr>
								<td class="text-center"><img style="width: 35px;" src="<?=IMG_URL.'badge/3.png'?>" alt="Gold"></td>
								<td class="text-center"><div class="title-account">Gold</div></td>
								<td>Points: 200 -> 500</td>
								<td>Discount: <b class="text-color-red">30%</b></td>
							</tr>
							<tr>
								<td class="text-center"><img style="width: 35px;" src="<?=IMG_URL.'badge/4.png'?>" alt="Diamond"></td>
								<td class="text-center"><div class="title-account">Diamond</div></td>
								<td>Points: 500 -> 2000</td>
								<td>Discount: <b class="text-color-red">40%</b></td>
							</tr>
							<tr>
								<td class="text-center"><img style="width: 35px;" src="<?=IMG_URL.'badge/5.png'?>" alt="Vip"></td>
								<td class="text-center"><div class="title-account">Vip</div></td>
								<td>Points: 2000</td>
								<td>Discount: <b class="text-color-red">50%</b></td>
							</tr>
						</table>
						<div class="text-center text-color-red">
							<i style="font-size: 14px;">*Discount use for applying visa 1 month and 3 months</i>
						</div>
					</div>
				</div>
				<br>
				<? if (sizeof($bookings)) { ?>
				<table class="table table-bordered">
					<tr>
						<th>Application ID</th>
						<th>Applied Date</th>
						<th>Arrival Date</th>
						<th class="text-right">Total Fee</th>
						<th>Status</th>
					</tr>
					<?
						foreach ($bookings as $booking) {
							$rush = $this->util->detect_rush_visa($booking->arrival_date, $booking->visa_type, $booking->visit_purpose);
					?>
						<tr>
							<td class="col-application-id"><a class="collapsed" stt="0" data-toggle="collapse" data-id="<?=$booking->book_id?>" href="<?="#".$booking->book_id?>" aria-expanded="false" aria-controls="collapse<?=$booking->book_id?>"> <?=BOOKING_PREFIX.$booking->book_id?></a></td>
							<td><?=date("M/d/Y", strtotime($booking->booking_date))?></td>
							<td><?=date("M/d/Y", strtotime($booking->arrival_date))?></td>
							<td class="text-right"><?=$booking->total_fee?> USD</td>
							<td>
								<? if ($booking->status==1 || $booking->other_payment == 1) { ?>
								<span class="text-success">Completed</span>
								<? } else if ((date("Y-m-d", strtotime($booking->arrival_date)) < date("Y-m-d")) || ($rush == 3 && $booking->rush_type < 3) || ($rush == 2 && $booking->rush_type < 2)) { ?>
								<span class="text-muted">Expired</span>
								<? } else { ?>
								<div class="clearfix">
									<span class="text-danger">UnPaid</span>
									<div class="pull-right">
										<a class="btn btn-xs btn-success" href="<?=site_url("member/payment/{$booking->book_id}")?>">Pay Now</a>
									</div>
								</div>
								<? } ?>
							</td>
						</tr>
						<tr class="collapse" id="<?=$booking->book_id?>">
							<td colspan="5" style="background: #efefef;">
								<h4>Visa Options</h4>
								<table class="table table-bordered">
									<tr>
										<th>Type of Visa</th>
										<th>Number of Visa</th>
										<th>Date of Arrival</th>
										<th>Port of Arrival</th>
										<th>Processing Time</th>
									</tr>
									<tr>
										<td><?=$booking->visa_type?></td>
										<td><?=$booking->group_size?> applicant<?=(($booking->group_size>1)?"s":"")?></td>
										<td><?=date("M/d/Y", strtotime($booking->arrival_date))?></td>
										<td><?=$booking->arrival_port?></td>
										<td><?=(($booking->rush_type == 1) ? "Urgent" : (($booking->rush_type == 2) ? "Emergency" : (($booking->rush_type == 3) ? "Holiday" : "Normal")))?> </td>
									</tr>
								</table>
								<h4>Applicant details</h4>
								<table class="table table-bordered">
									<tr>
										<th>&nbsp;</th>
										<th>Full Name</th>
										<th>Gender</th>
										<th>Date of Birth</th>
										<th>Nationality</th>
										<th>Passport Number</th>
									</tr>
									<?
										$paxs = $this->m_visa_booking->booking_travelers($booking->book_id);
										$paxNo = 1;
										foreach ($paxs as $pax) {
									?>
										<tr>
											<td width="20" align="center"><?=$paxNo++?></td>
											<td><?=$pax->fullname?></td>
											<td><?=$pax->gender?></td>
											<td><?=date("M/d/Y", strtotime($pax->birthday))?></td>
											<td><?=$pax->nationality?></td>
											<td><?=$pax->passport?></td>
										</tr>
									<? } ?>
								</table>
							</td>
						</tr>
					<?
						}
					?>
				</table>
				<? } else { ?>
				<p>You have no application yet.</p>
				<? } ?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('.collapsed').click(function(event) {
		var st = $(this).attr('stt');
		var id = $(this).attr('data-id');
		if (st == "0") {
			$('#'+id).css('display', 'contents');
			$(this).attr('stt',"1");
		} else {
			$('#'+id).css('display', 'none');
			$(this).attr('stt',"0");
		}
	});
</script>
