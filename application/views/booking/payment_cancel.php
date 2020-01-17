<div class="container">
	<h2 class="page-title">Submit Failure!!!</h2>
	<div style="line-height: 18px">
		<p>
			Dear <b><?=strtoupper($client_name)?></b>,
		</p>
		<p>
			Your payment was not successful because of some reasons:
			<ul style="list-style-type: disc; margin-left: 20px">
				<li>You cancelled the payment.</li>
				<li>Your bank did not approved your payment.</li>
				<li>You stopped while it was processing.</li>
				<li>Your information is incorrect while filling the credit card information.</li>
			</ul>
		</p>
		<p>
			Please <a href="<?=site_url("services")?>">click here</a> to re-apply again and try with new card or choose other method of payment.
		</p>
		<p>
			You can send an email to <a href="mailto:<?=MAIL_INFO?>"><?=MAIL_INFO?></a>, we will contact you immediately.<br/>
		</p>
		<p>
			Best Regards,<br />
			Vietnam Visa Organization<br />
			Hotline: <a title="hotline" href="tel:<?=HOTLINE?>"><?=HOTLINE?></a><br />
			Tollfree: <a title="toll free" href="tel:<?=TOLL_FREE?>"><?=TOLL_FREE?></a><br />
			Email: <a title="email" href="mailto:<?=MAIL_INFO?>"><?=MAIL_INFO?></a>
		</p>
	</div>
</div>