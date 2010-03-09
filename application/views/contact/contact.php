	<div id="content" class="about">
		
		<!-- Begin Left Column -->
		<div class="left">
			<h2>Contact Us</h2>
			<p>Do you have any questions or comments about OnlyInOldtown.com that you would like to share with us? We want to hear from you!</p>
			<h3>Send Us a Message</h3>
			<p>Send us a message instantly by using the form below. <strong>All fields are required</strong>.</p>
			<form class="form" name="contact_form" id="contact_form" action="/contact/submit" method="post">
				<div class="row">
					<label for="name">Your Name</label>
					<input id="name" name="name" class="textbox" value="<?=$form_data['name'];?>" type="text" />
					<?=isset($errors['name'])?'<span class="error">Please provide your name.</span>':'';?>
				</div>
				<div class="row">
					<label for="email">Your Email Address</label>
					<input id="email" name="email" class="textbox" value="<?=$form_data['email'];?>" type="text" />
					<?=isset($errors['email'])?'<span class="error">Please provide a valid email address.</span>':'';?>
				</div>
				<div class="row">
					<label for="message">Your Message</label>
					<textarea id="message" name="message" class="textarea"><?=$form_data['message'];?></textarea>
					<?=isset($errors['message'])?'<span class="error">Please provide a message.</span>':'';?>
				</div>
				<div class="row submit">
					<a href="#" class="btn fs bg_wht"><span>Submit</span></a>
				</div>
			</form>
		</div>
		<!-- End Left Column -->
		
		<!-- Begin Right Column -->
		<div class="right">
			
			<!-- Contact Information -->
			<h4 id="events_tab">Business Address</h4>
			<script type="text/javascript">
				swfobject.embedSWF("/public/assets/swf/tab.swf", "events_tab", "280", "50", "9.0.0","/public/assets/swf/expressinstall.swf", {this_color:"f5b70e",this_title:"Business Address"}, {wmode:"transparent", menu:"false"});
			</script>
			<div class="contact_holder">
				<h4>Rock Hill Economic Development Corporation</h4>
				<p>155 Johnston St.<br />City Hall, Room 220<br />Rock Hill, SC 29731<br /><br />Phone: 803-326-7090<br />Fax: 803-329-7007</p>
			</div>
			
			<h4 id="mail_addy">Mailing Address Address</h4>
			<script type="text/javascript">
				swfobject.embedSWF("/public/assets/swf/tab.swf", "mail_addy", "280", "50", "9.0.0","/public/assets/swf/expressinstall.swf", {this_color:"f5b70e",this_title:"Business Address"}, {wmode:"transparent", menu:"false"});
			</script>
			<div class="contact_holder">
				<p>PO Box 11706<br />155 Johnston St.<br />Rock Hill, SC 29731</p>
			</div>
		</div>
		<!-- End Right Column -->
	</div>
