<script type="text/javascript" src="<?=JS_URL?>apply.flight.js"></script>
<div class="service-form">
	<div class="service-title">Make an Flight Booking Request</div>
	<p>
	You will need to fill some information to complete your request.<br/>
	We will confirm to you by phone or email within 2 hours.
	</p>
	<div class="clearfix">
		<form name="frmRequestService" class="form-horizontal" role="form" action="<?=site_url("booking/flight")?>" method="POST">
			<div class="row clearfix">
				<div class="col-md-6">
					<div class="clearfix">
						<div class="form-group">
							<div class="col-md-12">
								<label class="control-label">Airline <span class="required">*</span></label>
							</div>
							<div class="col-md-12">
								<select id="airline" name="airline" class="form-control">
									<option value="Vietnam Airline">Vietnam Airline</option>
									<option value="JetStar">JetStar</option>
									<option value="VietJet Air">VietJet Air</option>
								</select>
							</div>
						</div>
					</div>
					<div class="clearfix">
						<div class="form-group">
							<div class="col-md-12">
								<label class="control-label">Direction <span class="required">*</span></label>
							</div>
							<div class="col-md-12">
								<select id="direction" name="direction" class="form-control" onchange="directionChanged()">
									<option value="One-Way">One-Way</option>
									<option value="Round-Trip">Round-Trip</option>
								</select>
							</div>
						</div>
					</div>
					<div id="departure_date" class="clearfix">
						<div class="form-group">
							<div class="col-md-12">
								<label class="control-label">Departure Date <span class="required">*</span></label>
							</div>
							<div class="col-md-12">
								<input type="text" name="departureDate" class="form-control departure-date" placeholder="mm/dd/yyyy" />
								<span class="help-block">When do you want to go?</span>
							</div>
						</div>
					</div>
					<div id="return_date" class="clearfix">
						<div class="form-group">
							<div class="col-md-12">
								<label class="control-label">Return Date <span class="required">*</span></label>
							</div>
							<div class="col-md-12">
								<input type="text" name="returnDate" class="form-control return-date" placeholder="mm/dd/yyyy" />
								<span class="help-block">When do you want to return?</span>
							</div>
						</div>
					</div>
					<div class="clearfix">
						<div class="form-group">
							<div class="col-md-12">
								<label class="control-label">From City <span class="required">*</span></label>
							</div>
							<div class="col-md-12">
								<select id="from-city" title="Departure city or Airport code" name="leavingFrom" class="form-control">
									<option value=''>Select city</option>
									
									<option value=''>-----------</option>
									
									<option value='HAN'>Ha Noi (HAN)</option>
									<option value='SGN'>Ho Chi Minh City (SGN)</option>
									<option value='DAD'>Da Nang (DAD)</option>
									
									<option value=''>-----------</option>
									
									<option value='BMV'>Buon Ma Thuot (BMV)</option>
									<option value='CAH'>Ca Mau (CAH)</option>
									<option value='VCA'>Can Tho (VCA)</option>
									<option value='VCS'>Con Dao (VCS)</option>
									<option value='DLI'>Da Lat (DLI)</option>
									<option value='DIN'>Dien Bien (DIN)</option>
									<option value='VDH'>Dong Hoi (VDH)</option>
									<option value='HPH'>Hai Phong (HPH)</option>
									<option value='HUI'>Hue (HUI)</option>
									<option value='NHA'>Nha Trang (NHA)</option>
									<option value='PQC'>Phu Quoc (PQC)</option>
									<option value='PXU'>Pleiku (PXU)</option>
									<option value='UIH'>Quy Nhon (UIH)</option>
									<option value='VKG'>Rach Gia (VKG)</option>
									<option value='VCL'>Tam Ky (VCL)</option>
									<option value='TBB'>Tuy Hoa (TBB)</option>
									<option value='VII'>Vinh (VII)</option>
								</select>
							</div>
						</div>
					</div>
					<div class="clearfix">
						<div class="form-group">
							<div class="col-md-12">
								<label class="control-label">To City <span class="required">*</span></label>
							</div>
							<div class="col-md-12">
								<select id="to-city" title="Arrival city or Airport code" name="goingTo" class="form-control">
									<option value=''>Select city</option>
									
									<option value=''>-----------</option>
									
									<option value='HAN'>Ha Noi (HAN)</option>
									<option value='SGN'>Ho Chi Minh City (SGN)</option>
									<option value='DAD'>Da Nang (DAD)</option>
									
									<option value=''>-----------</option>
									
									<option value='BMV'>Buon Ma Thuot (BMV)</option>
									<option value='CAH'>Ca Mau (CAH)</option>
									<option value='VCA'>Can Tho (VCA)</option>
									<option value='VCS'>Con Dao (VCS)</option>
									<option value='DLI'>Da Lat (DLI)</option>
									<option value='DIN'>Dien Bien (DIN)</option>
									<option value='VDH'>Dong Hoi (VDH)</option>
									<option value='HPH'>Hai Phong (HPH)</option>
									<option value='HUI'>Hue (HUI)</option>
									<option value='NHA'>Nha Trang (NHA)</option>
									<option value='PQC'>Phu Quoc (PQC)</option>
									<option value='PXU'>Pleiku (PXU)</option>
									<option value='UIH'>Quy Nhon (UIH)</option>
									<option value='VKG'>Rach Gia (VKG)</option>
									<option value='VCL'>Tam Ky (VCL)</option>
									<option value='TBB'>Tuy Hoa (TBB)</option>
									<option value='VII'>Vinh (VII)</option>
								</select>
							</div>
						</div>
					</div>
					<div class="clearfix">
						<div class="form-group">
							<div class="col-md-12">
								<label class="control-label">How many Travelers or number of Tickets? <span class="required">*</span></label>
							</div>
							<div class="col-md-12">
								<input type="text" id="travelers" name="travelers" value="" class="form-control travelers" />
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="clearfix">
						<div class="form-group">
							<div class="col-md-12">
								<label class="control-label">Your Name <span class="required">*</span></label>
							</div>
							<div class="col-md-12">
								<input type="text" id="fullname" name="fullname" value="" class="form-control fullname" />
							</div>
						</div>
					</div>
					<div class="clearfix">
						<div class="form-group">
							<div class="col-md-12">
								<label class="control-label">Your Email <span class="required">*</span></label>
							</div>
							<div class="col-md-12">
								<input type="text" id="email" name="email" value="" class="form-control email" />
								<span class="help-block">Your booking status will be sent to this email</span>
							</div>
						</div>
					</div>
					<div class="clearfix">
						<div class="form-group">
							<div class="col-md-12">
								<label class="control-label">Phone Number <span class="required">*</span></label>
							</div>
							<div class="col-md-12">
								<input type="text" id="phone" name="phone" value="" class="form-control phone" />
								<span class="help-block">To contact and assist you directly in urgent case.</span>
							</div>
						</div>
					</div>
					<div class="clearfix">
						<div class="form-group">
							<div class="col-md-12">
								<label class="control-label">Special Request</label>
							</div>
							<div class="col-md-12">
								<textarea id="special-request" name="specialRequest" class="form-control" rows="6"></textarea>
							</div>
						</div>
					</div>
					<div class="clearfix">
						<div class="form-group">
							<div class="col-md-12">
								<button type="submit" class="btn btn-danger btnstep">Send Request</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script type="text/javascript" src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script type="text/javascript">
$(document).ready(function() {
	var dateoptions = {
		dateFormat : 'mm/dd/yy',
		numberOfMonths: 2,
		minDate: 0
	};
	$(".departure-date").datepicker(dateoptions);
	$(".return-date").datepicker(dateoptions);
});
</script>