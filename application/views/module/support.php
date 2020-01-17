<style type="text/css">
	.subiz_online { cursor: pointer; visibility: hidden; height: 32px; width: 166px; line-height: 32px; color: white; z-index: -1}
	.subiz_offline { cursor: pointer; visibility: hidden; height: 32px; width: 166px; line-height: 32px; color: white; z-index: -1}
	.support-online-widget #subiz_status a{background: none}
</style>
<div class="support-online-widget">
	<div class="title"></div>
	<div class="content">
		<p><i>Our pleasure to support you 24/7</i></p>
		<table cellpadding="2" width="100%">
			<tr>
				<td><span class="glyphicon glyphicon-envelope"></span></td><td>&nbsp;</td>
				<td class="email" style="padding-left: 8px"><a href="mailto:<?=MAIL_INFO?>"><?=MAIL_INFO?></a></td>
			</tr>
			<tr>
				<td style="vertical-align: top"><span class="glyphicon glyphicon-earphone"></span></td><td style="vertical-align: top">&nbsp;</td>
				<td>
					<ul class="contact-number">
						<li><a href="tel:<?=HOTLINE?>" title="HOTLINE"><img alt="HOTLINE" src="<?=IMG_URL?>flags/Vietnam.png"/><span> <?=HOTLINE?></span></a></li>
						<li><a href="tel:<?=TOLL_FREE?>" title="TOLL FREE"><img alt="TOLL FREE" src="<?=IMG_URL?>flags/United States.png"/><span> <?=TOLL_FREE?></span></a></li>
					</ul>
				</td>
			</tr>
		</table>
	</div>
</div>
