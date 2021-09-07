<?php

/**
 * The header.
 *
 * This is the template that displays all of the <head> section and everything up until main.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

?>
<!doctype html>
<html <?php language_attributes(); ?> <?php twentytwentyone_the_html_classes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
</head>

<link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>

<!--<link rel="stylesheet" href="../twentytwentyone-child/style.css">-->
<!-- <script src="https://code.jquery.com/jquery-2.1.0.js"></script> -->
<!--<script src="javascript.js"></script>-->


<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div class="container-fluid">
		<div class="wizard">
			<div class="row row-bg">
				<div class="col-lg-1 col-sm-1"></div>
				<div class="col-lg-8 col-sm-8">






					<ol class="breadcrumb breadcrumb-arrow">
						<li><span><i class="fas fa-home"></i></span></li>
						<li><span id="con" style="color:cornflowerblue"> Contact Info</span></li>
						<li><span id="qua">Quantity</span></li>
						<li><span id="pr">Price</span></li>
						<li><span id="do">Done</span></li>
					</ol>

				</div>

				<div class="col-lg-3 col-sm-3 "></div>
			</div>


			<div class="row row-bg">
				<div class="col-1"></div>
				<div class="col-10">
					<div class="page_1">
						<div class="title">Contact Info</div>
						<div class="sent_info">
							<div class="name_sent input  ">Name <input type="text" name="name" class="ph ph1">
							</div>
							<div class="email_sent input ">Email<sup class="req"> required</sup>
								<input type="email" name="email" id="emaillll" class="ph" required>
							</div>

							<div class="number_phone input ">Phone
								<input type="number" name=" " class="ph ph1">
							</div>
						</div>
						<button type="button" class="butt1 butt_main">Continue</button>
					</div>
				</div>
			</div>
			<div class="row row-bg">
				<div class="col-1"></div>
				<div class="col-10">
					<div class="page_2 hidden">


						<div class="title">Quantity</div>


						<div class="quantity">Quantity<sup class="req"> required</sup>
							<input id="innnn" type="number" class="ph" required>
						</div>
						<button type="button" class="butt2 butt_main butt_m">Continue</button>

						<button type="button" class="butt3 butt_main"><i class="fas fa-arrow-left"></i> Back</button>
					</div>
				</div>

				<div class="col-1"></div>
			</div>


			<div class="row row-bg">

				<div class="col-1"></div>
				<div class="col-10">
					<div class="page_3 hidden">
						<div class="title">Price <p id="final_price"></p>
						</div>


						<div><span class="prc"></span>
						</div>

						<button type="button" class="butt4 butt_main butt_m2">Send to Email</button>

						<button type="button" class="butt5 butt_main"><i class="fas fa-arrow-left"></i> Back</button>
					</div>
				</div>

				<div class="col-1"></div>
			</div>

			<div class="row row-bg">

				<div class="col-1"></div>
				<div class="col-10">
					<div class="page_4 hidden">

						<div class="title">Done</div>


						<div class="text_sent"><i class="fab fa-expeditedssl"></i> We cannot send you email right now.Use alternative way to contact us
						</div>

						<button type="button" class="butt6 butt_main butt_m3">Start again <i class="fas fa-arrow-right"></i></button>


					</div>
				</div>


				<div class="col-1"></div>

			</div>
		</div>
	</div>




	    <?php echo do_shortcode('[r_test title="Test Work"]This is Description[/r_test]'); ?>
    
    <?php echo add_shortcode('[r_test]This is description[/r_test]'); ?>


	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'twentytwentyone'); ?></a>

		<?php get_template_part('template-parts/header/site-header'); ?>

		<div id="content" class="site-content">
			<div id="primary" class="content-area">
				<main id="main" class="site-main" role="main">
