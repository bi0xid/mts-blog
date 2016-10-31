<?php
	/**
	* Template Name: Penis Magic Course Template
	* @author: Alejandro Orta (alejandro@mytinysecrets.com)
	*/

	get_template_part('templates/mts-header');
?>

<section id="penis-magic-course">
	<div class="header">
		<img src="<?php echo get_stylesheet_directory_uri().'/images/signup-pages/adinacontact-300x300.jpg'; ?>" alt="Adina avatar">
		<img src="<?php echo get_stylesheet_directory_uri().'/images/signup-pages/signature-300x170.png'; ?>" alt="Adina avatar">

		<div id="subscribe_form_wrapper">
			<div class="ck_form ck_naked">
				<div class="ck_form_fields">
					<div id="existing_email" style="display:none;">
						<p>Boo, you’re already signed up 🙂</p>
					</div>

					<div id="ck_success_msg" style="display:none;">
						<p>Success! Now check your email to confirm your subscription.</p>
					</div>

					<form method="POST" id="ck_subscribe_form" class="ck_subscribe_form" action="http://mytinysecrets.com/form_signup_penismagic.php" data-remote="true" novalidate="novalidate">

						<input type="hidden" name="api_key" value="Vl6rr4wdvvE5zlJWkPtKZg"><br>
						<input type="hidden" name="id" value="47312" id="landing_page_id"><p></p>
						<input type="hidden" name="thankyou" class="ck_email_address" id="" value="http://mytinysecrets.com/penis-magic-course-signup/"><br>
						<input type="hidden" name="form_id" class="" id="" value="penis_magic_course">

						<div class="ck_errorArea">
							<div id="ck_error_msg" style="display:none">
								<p>There was an error submitting your subscription. Please try again.</p>
							</div>
						</div>

						<div class="ck_control_group ck_email_field_group">
							<label class="ck_label" for="ck_emailField" style="display: none">Email Address</label><br>
							<input type="text" required name="name" class="ck_first_name" id="ck_firstNameField" placeholder="First Name"><br>
							<input type="email" name="email" class="ck_email_address" id="ck_emailField" placeholder="Email Address" required><br>
						</div>

						<div class="buttons">
							<button class="subscribe_button ck_subscribe_button btn fields" id="ck_subscribe_button">SIGN UP</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_template_part('templates/mts-footer'); ?>