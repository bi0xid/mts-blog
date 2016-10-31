<?php
	/**
	* Template Name: Penis Magic Course Template
	* @author: Alejandro Orta (alejandro@mytinysecrets.com)
	*/

	get_template_part('templates/mts-header');
?>

<section id="penis-magic-course">
	<div class="header">
		<h1>THE PENIS MAGIC COURSE</h1>

		<div class="img-wrapper">
			<img src="<?php echo get_stylesheet_directory_uri().'/images/signup-pages/adinacontact-300x300.jpg'; ?>" alt="Adina avatar">
		</div>

		<em>“Over the past 5 years I’ve researched like a maniac to learn everything out there about sexuality. Mainly because I wanted to empower my own pussy and the penis of my soul mate. I felt that there was more to sex than what I had learned from my parents. And oh boy.. was I right.”</em>

		<div class="img-wrapper small">
			<img src="<?php echo get_stylesheet_directory_uri().'/images/signup-pages/signature-300x170.png'; ?>" alt="Adina avatar">
		</div>

		<h5>IN THE PENIS MAGIC COURSE YOU’LL LEARN HOW TO:</h5>
		<ul>
			<li>increase your staying power</li>
			<li>increase the size of your penis</li>
			<li>increase quantity &amp; quality of your semen</li>
			<li>use herbs and methods as a natural substitute to viagra</li>
			<li>use your penis to soar your lover to ecstas</li>
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

					<input type="hidden" name="form_id" value="penis_magic_course">

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