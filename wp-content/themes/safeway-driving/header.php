<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>
  <?php
    if( ! is_home() ):
      wp_title( '|', true, 'right' );
    endif;
    bloginfo( 'name' );
  ?>
</title>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<!-- Code for Facebook like/share buttons -->
<?php if(!is_front_page() ) : ?>
<div id="fb-root"></div>
	<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>
<? endif; ?>


	<header class="header container-fluid">
		<div class="header__top-row navbar-fixed-top">
			<div class="container">
				<?php wp_nav_menu( array('menu' => 'Top Nav' , 'container' => false , 'menu_class' => 'header__top-row__nav utility-nav col-sm-12' )); ?>
			</div>
			</div>
		</div>
	
		<!--Container for interior page hero section- this is done to allow for background image with navbar transparency-->
		<div class="header__interior__container" style="background-image: url('<?php the_field('hero_background'); ?>');">
	
			<nav class="navbar navbar-default navbar row navbar-fixed-top">
			  <div class="container">
			    <!-- Brand and toggle get grouped for better mobile display -->
			    <div class="navbar-header">
			      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				      <span class="icon-bar"></span>
				      <span class="icon-bar"></span>
				      <span class="icon-bar"></span>
			      </button>
			      <a class="navbar-brand" href="<?php bloginfo('url')?>"><img src="<?php bloginfo('template_directory'); ?>/assets/img/header/safeway-logo.png"/></a>
			      <a href="tel:844-374-8372"><span class="phone-number hidden-md hidden-lg hidden-xl">844.DRIVE.SAFE</span></a>
			    </div>

			    <!-- Collect the nav links, forms, and other content for toggling -->
			    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			      <?php wp_nav_menu( array('menu' => 'Main Nav' , 'container' => false , 'menu_class' => 'nav navbar-nav navbar-right links-white' )); ?>
			      <?php wp_nav_menu( array('menu' => 'Top Nav' , 'container' => false , 'menu_class' => 'mobile-utility-nav links-black hidden-md hidden-lg hidden-xl' )); ?>
			    </div><!-- /.navbar-collapse -->
			  </div><!-- /.container-fluid -->
			</nav>
			<?php if(!is_front_page() ) : ?>
			<div class="container">
				<div class="hidden-xs hidden-sm col-md-12 breadcrumbs container">
					<div class="col-sm-6 col-md-8">
						<?php if ( function_exists('yoast_breadcrumb') ) {
						  yoast_breadcrumb('<p id="breadcrumbs">','</p>');
						} ?>
					</div>
					<div class="fb-like col-sm-6 col-md-4" data-href="https://developers.facebook.com/docs/plugins/" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true">
					</div>
				</div><!--/ .breadcrumbs-->
			</div>
			<?php endif; ?>

			<?php if( !is_front_page() ) : ?>
			<div class="container header__interior__hero__container">
				<!--Custom field hero section. Changes with hero format.-->
				<?php $white = ( get_field( 'white_underlay' ) ) ? 'white-underlay' : ''; ?>
				<div class="header__interior__hero <?php echo $white; ?>">
					<?php if (get_field('hero_format') == 'copy_and_img') : ?>
						<div class="header__interior__hero__image col-md-6">
							<img src="<?php the_field('hero_image'); ?>" />
						</div>
						<div class="header__interior__hero__headline col-md-5">
							<h1><span><?php the_field('hero_small_headline'); ?></span><br><?php the_field('hero_large_headline'); ?></h1>
							<h5><?php the_field('hero_sub_headline'); ?></h5>
						</div>
					<?php elseif (get_field('hero_format') == 'copy_and_video') : ?>
						<div class="col-sm-12 copy_and_video">
							<div class="header__interior__hero__video col-xs-12 col-sm-6">
								<a id="videoLink" data-youtube="<?php the_field('hero_video'); ?>"><img class="col-xs-12 col-sm-12 col-md-12" src="<?php the_field('hero_video_thumbnail'); ?>" alt=""></a>
							</div>
							<div class="header__interior__hero__headline copy_and_video_headline col-xs-12 col-sm-6">
								<h1><span><?php the_field('hero_small_headline'); ?></span><br><?php the_field('hero_large_headline'); ?></h1>
								<h5><?php the_field('hero_sub_headline'); ?></h5>
							</div>
						</div>
					<?php elseif (get_field('hero_format') == 'copy') : ?>
						<div class="header__interior__hero__headline">
							<?php if (get_field('hero_small_headline')) : ?>
								<h1 class="copy-only-hero small-headline"><span><?php the_field('hero_small_headline'); ?></span></h1>
							<?php endif; ?>
							<h1 class="copy-only-hero"><?php the_field('hero_large_headline'); ?></h1>
							<h6 class="copy-only-hero"><?php the_field('hero_sub_headline'); ?></h6>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<?php endif; ?>
		</div><!--/ .header__interior__container-->
	<?php get_template_part('partials/video-modal'); ?>
	</header>

	<?php if (get_field('scroll_widget') == true ) : ?>
		<?php get_template_part('partials/scroll-widget'); ?>
	<?php endif; ?>