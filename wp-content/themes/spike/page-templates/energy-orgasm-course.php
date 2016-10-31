<?php
	/**
	* Template Name: Energy Orgasm Course Template
	* @author: Alejandro Orta (alejandro@mytinysecrets.com)
	*/

	get_template_part('templates/mts-header');
?>

<section id="form-sign-up">
	<div class="header">
		<h1>ENERGY ORGASM COURSE</h1>

		<div class="img-wrapper">
			<img src="<?php echo get_stylesheet_directory_uri().'/images/signup-pages/adinacontact-300x300.jpg'; ?>" alt="Adina avatar">
		</div>

		<em>“Over the last years I have explored my sexuality more consciously than ever before. I’ve felt things I’ve never felt before and seen things I’ve never seen before. One of these things has been the magic of exchanging energy pleasure with my partner.”</em>

		<div class="img-wrapper small">
			<img src="<?php echo get_stylesheet_directory_uri().'/images/signup-pages/signature-300x170.png'; ?>" alt="Adina avatar">
		</div>

		<h5>IN THE ENERGY ORGASM COURSE YOU’LL LEARN HOW TO:</h5>
		<ul>
			<li>improve your love and sex life with unusual techniques</li>
			<li>increase your orgasmic powers</li>
			<li>experience pleasure without physical touch</li>
			<li>exchange energy with your partner</li>
			<li>to feel energy and send energy</li>
		</ul>
		<h5>and so much more!</h5>

		<p>Once the course is online you’ll be the first to receive an email. So please make sure to leave me your name & email.</p>
	</div>

	<div id="subscribe_form_wrapper" class="course-signup-form">
		<div class="ck_form ck_naked">
			<div class="ck_form_fields">

				<?php if( $_GET['existing_email'] ) { ?>
					<div id="existing_email">
						<p>Boo, you’re already signed up 🙂</p>
					</div>
				<?php }; ?>

				<form method="POST" id="ck_subscribe_form" class="ck_subscribe_form">

					<input type="hidden" name="form_id" value="energy_orgasm_course">

					<div class="ck_control_group ck_email_field_group">
						<input type="text" required name="name" class="form-input" id="ck_firstNameField" placeholder="First Name"><br>
						<input type="email" name="email" class="form-input" id="ck_emailField" placeholder="Email Address" required><br>
					</div>

					<div class="buttons">
						<button class="subscribe_button" id="ck_subscribe_button">SIGN UP</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<?php get_template_part('templates/mts-footer'); ?>