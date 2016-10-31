<?php
	/**
	* Template Name: Form Signup Thank You Template
	* @author: Alejandro Orta (alejandro@mytinysecrets.com)
	*/

	get_template_part('templates/mts-header');

	$course_name = array(
		'penis_magic_course' => 'Penis Magic Course',
		'energy_orgasm_course' => 'Energy Orgasm Course',
		'pussy_empowerment_course' => 'Pussy Empowerment Course'
	);
?>

<section id="form-sign-up-thanks">
	<div class="intro-img">
		<img src="<?php echo get_stylesheet_directory_uri().'/images/signup-pages/amazing.gif' ?>" alt="you are amazing">
	</div>

	<strong>Hi there,</strong>
	<p>It’s me Adina. Thank you so much for signing up for my <?php echo $course_name[$_GET['course']]; ?>.</p>
	<p>The course is not ready yet! I am still working on it. And you know me. I don’t half-ass anything.</p>
	<p>I am creating something really unique and empowering for you; something that will truly and deeply impact you on every level – sex, love & life.</p>
	<p>Please bare with me.</p>
	<p>As soon as the course is ready I will send you another email.</p>
	<br>

	<strong>Oh .. and please make sure to keep these two things in mind:</strong>
	<ul>
		<li>Please add my email address to your contact list. This way you make sure my emails will make it into your inbox once the course is done.</li>
		<li>If you ever decide you don’t want to hear from me any more, please don’t mark my email as SPAM. Use the unsubscribe link (you can find it in the footer of every email I send you).</li>
	</ul>

	<p>If you ever decide you don’t want to hear from me any more, please don’t mark my email as SPAM. Use the unsubscribe link (you can find it in the footer of every email I send you).</p>
	<p>I am always happy to hear from you.</p>
	<strong>Much Love, Adina</strong>

	<hr>
	<a href="<?php echo get_home_url(); ?>" class="btn" target="_self">Visit my blog »</a>
</section>

<?php get_template_part('templates/mts-footer'); ?>
