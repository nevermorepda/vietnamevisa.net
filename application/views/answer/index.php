<?
	$nations = $this->m_nation->items();
	
	$question_info = new stdClass();
	$question_info->category_id	= $category_id;
	$question_info->ref_id		= $ref_id;
	$question_info->topLevel	= 1;
	$questions = $this->m_question->items($question_info, 1);
	
	$respond_info = new stdClass();
	$respond_info->sort_order = "ASC";
	$responds = $this->m_question->items($respond_info, 1);
?>
<script type="text/javascript">
$(document).ready(function() {
	$("#new-question").click(function(){
		if ($(".question-form").is(":hidden")){
			$(".question-form").slideDown("fast");
		}
		else{
			$(".question-form").slideUp("fast");
		}
	});
	$("#question-cancel-btn").click(function(){
		$(".question-form").slideUp("fast");
	});
	$("#question-submit-btn").click(function(){
		var p = {};
		p["author"]		= $("#question-fullname").val();
		p["email"]		= $("#question-email").val();
		p["nationality"]= $("#question-nationality").val();
		p["title"] 		= $("#question-title").val();
		p["content"] 	= $("#question-content").val();
		p["code"] 		= $("#question-code").val();
		p["category_id"]= '<?=$category_id?>';
		p["ref_id"] 	= '<?=$ref_id?>';

		var err = 0;
		if (p["author"] == "") {
			$("#question-fullname").addClass("error");
			err++;
		} else {
			$("#question-fullname").removeClass("error");
		}
		if (p["email"] == "") {
			$("#question-email").addClass("error");
			err++;
		} else {
			$("#question-email").removeClass("error");
		}
		if (p["nationality"] == "") {
			$("#question-nationality").addClass("error");
			err++;
		} else {
			$("#question-nationality").removeClass("error");
		}
		if (p["title"] == "") {
			$("#question-title").addClass("error");
			err++;
		} else {
			$("#question-title").removeClass("error");
		}
		if (p["content"] == "") {
			$("#question-content").addClass("error");
			err++;
		} else {
			$("#question-content").removeClass("error");
		}
		if (p["code"] == "") {
			$("#question-code").addClass("error");
			err++;
		} else {
			$("#question-code").removeClass("error");
		}

		if (err == 0) {
			$.post("<?=site_url("answer/post")?>", p);
			messageBox("INFO", "Submit a Question", "Your question has been send. We will get back to you soon.");
			$("#question-fullname").val("");
			$("#question-email").val("");
			$("#question-nationality").val("");
			$("#question-title").val("");
			$("#question-content").val("");
			$("#question-code").val("");
			$(".question-form").slideUp("fast");
		}
	});

	$.ajax({
		type: 'GET',
		url: "<?=site_url("security/ajax-code")?>",
		data: {},
		success: function(data) {
			$(".security-code").html(data);
		}
	});
});
</script>
<link type="text/css" rel="stylesheet" href="<?=CSS_URL?>pagination.css"/>
<script type="text/javascript" src="<?=JS_URL?>jquery.pagination.js"></script>
<script type="text/javascript">
	$(function() {
		var numofitem = '<?=sizeof($questions)?>';
		if ((numofitem / 5) > 1) {
			$("#items-pagination").pagination({
		        items: numofitem,
		        itemsOnPage: 5,
		        cssStyle: 'light-theme',
		        onPageClick: function(pageNumber){selectPage(pageNumber, numofitem);}
		    });
		}
	});
	function selectPage(pageNumber, items) {
		for (var i=1; i<=items; i++) {
			$("#question-page-"+i).hide();
		}
		$("#question-page-"+pageNumber).show();
	}
</script>
<div id="question-container">
	<div class="summary-box clearfix">
		<div class="left">
			<div class="count"><?=number_format(sizeof($questions))?> Questions</div>
		</div>
		<div class="right">
			<p class="f18">Have Your Question</p>
			<div class="">
				<input type="button" id="new-question" name="question-btn" class="btn btn-danger question-btn" value="Ask a Question" />
			</div>
		</div>
	</div>
	<div class="question-form none">
		<table class="tbl-question" cellpadding="4" cellspacing="0" border="0">
			<tr>
				<td>Your name<span class="required">*</span></td><td>:</td>
				<td><input type="text" id="question-fullname" name="question-fullname" /></td>
			</tr>
			<tr>
				<td>Email<span class="required">*</span></td><td>:</td>
				<td><input type="text" id="question-email" name="question-email" /></td>
			</tr>
			<tr>
				<td>Nationality<span class="required">*</span></td><td>:</td>
				<td>
					<select id="question-nationality" name="question-nationality">
						<option value="">Select...</option>
						<? foreach ($nations as $nation) { ?>
						<option value="<?=$nation->name?>"><?=$nation->name?></option>
						<? } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Subject<span class="required">*</span></td><td>:</td>
				<td><input type="text" id="question-title" name="question-title" /></td>
			</tr>
			<tr valign="top">
				<td>Detail<span class="required">*</span></td><td>:</td>
				<td><textarea rows="" cols="" id="question-content" name="question-content"></textarea></td>
			</tr>
			<tr>
				<td>Captcha<span class="required">*</span></td><td>:</td>
				<td><input type="text" id="question-code" name="question-code" style="width: 60px"/> <label class="security-code"><?=$this->util->createSecurityCode()?></label></td>
			</tr>
			<tr>
				<td colspan="2"></td>
				<td><i><span class="required">*</span>Questions & Answers are typically posted within 24 hours, pending approval.</i></td>
			</tr>
			<tr>
				<td colspan="2"></td>
				<td>
					<input type="button" id="question-submit-btn" name="question-btn" class="btn btn-danger question-btn" value="Submit" />
					<input type="button" id="question-cancel-btn" name="question-btn" class="btn btn-danger question-btn" value="Cancel" />
				</td>
			</tr>
		</table>
	</div>
	
	<div class="question-list-box">
		<ul id="question-page-1">
		<?
				$cnt  = 0;
				$page = 1;
				foreach ($questions as $question) {
					if ($cnt != 0 && ($cnt % 5) == 0) {
						$page++;
						$cnt = 0;
			?>
		</ul>
		<ul id="question-page-<?=$page?>" style="display: none;">
			<?
					}
					$cnt++;
			?>
			<li>
				<div class="item clearfix">
					<div class="qa-left">
						<img class="avatar" alt="no-avatar" src="<?=IMG_URL?>no-avatar.gif.png" />
					</div>
					<div class="qa-body">
						<h4 class="heading"><?=$question->title?></h4>
						<p class="author"><strong><?=$question->author?></strong> from <strong><?=$question->nationality?></strong>, asked on <?=date('M d, Y', strtotime($question->created_date))?></p>
						<p><?=$question->content?></p>
						<?
							if (!empty($responds)) {
								foreach ($responds as $respond) {
									if ($respond->parent_id == $question->id) {
						?>
						<div class="reply-item clearfix">
							<div class="qa-left">
								<? if (stripos(strtolower(SITE_NAME." Support"), strtolower($respond->author)) === false) { ?>
								<img class="avatar" alt="no-avatar" src="<?=IMG_URL?>no-avatar.gif.png">
								<? } else { ?>
								<img class="avatar" alt="<?=SITE_NAME?>" src="<?=IMG_URL?>logo-60x60.jpg">
								<? } ?>
							</div>
							<div class="qa-body">
								<p class="author"><strong><?=$respond->author?></strong> replied on <?=date('M d, Y', strtotime($respond->created_date))?></p>
								<p><?=$respond->content?></p>
							</div>
						</div>
						<? 			}
								}
							} ?>
					</div>
				</div>
			</li>
			<? } ?>
		</ul>
		<div class="paging">
			<div id="items-pagination"></div>
		</div>
	</div>
</div>