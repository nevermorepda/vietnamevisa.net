<link rel="stylesheet" type="text/css" media="screen,all" href="<?=CSS_URL?>member.css" />
	<div class="member-l">
		<div class="menumember">
			<div class="titlemb">
				<div class="titlemb-bg"><h2> My Account</h2></div>
				<div class="titlemb-r"></div>
			</div>
			<? require_once(APPPATH."views/member/nav_bar.php"); ?>
		</div>
	</div>
	<div class="member-r">
		<span class="title-id">Visa Application</span>
		<span class="title-tb">Information for Application</span>
		<div class="linetb">
			<table width="100%" cellspacing="0" cellpadding="0" border="0" class="tablemb">
				<tbody>
					<tr class="title">
						<td>Client Name</td>
						<td>Applications ID</td>
						<td>Booking Date</td>
						<td>Status</td>
					</tr>
					<tr>
						<td><?=$this->m_user->load($item->user_id)->user_fullname?></td>
						<td><?=$item->id?></td>
						<td><?=date("d M, Y", strtotime($item->booking_date))?></td>
						<td><b style="color:#df1f26;"><?=(($item->status==1) ? "Paid" : "Under payment")?></b>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<span class="title-tb">Information for Visa</span>
		<div class="linetb">
			<table width="100%" cellspacing="0" cellpadding="0" border="0" class="tablemb">
				<tbody>
					<tr class="title">
						<td>Type of Visa</td>
						<td>Quantity</td>
						<td>Date of arrival</td>
						<td>Date of exit</td>
						<td>Port of arrival</td>
						<td>Processing time</td>
					</tr>
					<tr>
						<td><?=$item->visa_type?></td>
						<td align="center"><?=$item->group_size?></td>
						<td><?=date("d M, Y", strtotime($item->arrival_date))?></td>
						<td><?=date("d M, Y", strtotime($item->exit_date))?></td>
						<td><?=$item->arrival_port?></td>
						<td><?=(($item->rush_type == 1) ? "Urgent" : (($item->rush_type == 2) ? "Super Urgent" : "Normal"))?> </td>
					</tr>
				</tbody>
			</table>
		</div>
		<span class="title-tb">Applicant details</span>
		<div class="linetb">
			<table width="100%" cellspacing="0" cellpadding="0" border="0" class="tablemb">
				<tbody>
					<tr class="title">
						<td>&nbsp;</td>
						<td>Fullname (as in passport)</td>
						<td>Passport number</td>
						<td>Nationality</td>
						<td>Date of birth</td>
						<td>Gender</td>
					</tr>
					<?
						$paxs = $this->m_visa_booking->booking_travelers($item->id);
						$cnt = 1;
						foreach ($paxs as $pax) {
					?>
						<tr>
							<td><b><?=$cnt++?></b></td>
							<td class="min"><?=$pax->fullname?></td>
							<td><?=$pax->passport?></td>
							<td><?=$pax->nationality?></td>
							<td><?=date("d M, Y", strtotime($pax->birthday))?></td>
							<td><?=$pax->gender?> </td>
						</tr>
					<? } ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="clear"></div>
