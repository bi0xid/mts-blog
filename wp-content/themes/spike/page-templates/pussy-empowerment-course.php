<?php
	/**
	* Template Name: Pussy Empowerment Course Template
	* @author: Alejandro Orta (alejandro@mytinysecrets.com)
	*/

	get_template_part('templates/mts-header');
?>

<section id="penis-magic-course">
	<div class="header">
		<h1>THE PUSSY EMPOWERMENT COURSE</h1>

		<div class="img-wrapper">
			<img src="<?php echo get_stylesheet_directory_uri().'/images/signup-pages/adinacontact-300x300.jpg'; ?>" alt="Adina avatar">
		</div>

		<em>“I’ve been dedicating the last 5 years of my life to explore the  depth of sexuality. Mainly because I wanted to explore & heal my own sexual self. I intuitively felt that there was more to sex than what media, friends & family had shown me. I felt that <strong>my pussy could be more orgasmic, my nipples more sensitive, my sex drive higher, my body image more loving, my lover more satisfied</strong> … And oh boy was I right. What I discovered was life-altering … “</em>

		<div class="img-wrapper small">
			<img src="<?php echo get_stylesheet_directory_uri().'/images/signup-pages/signature-300x170.png'; ?>" alt="Adina avatar">
		</div>

		<h5>In the Pussy Empowerment Course you’ll learn how to:</h5>
		<ul>
			<li>use herbs and ancient methods to increase your sex drive</li>
			<li>work your lips, tongue, pussy, breasts &amp; energy to soar your lover to unknown sexual heights</li>
			<li>how to naturally enlarge your breasts&nbsp;</li>
			<li>how to naturally rejuvenate &amp; tone your breasts &amp; pussy</li>
			<li>become a sensual &amp; fascinating woman with self confidence</li>
			<li>activate the orgasmic power of your breasts, pussy &amp; whole body</li>
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

					<input type="hidden" name="form_id" value="pussy_empowerment_course">

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
