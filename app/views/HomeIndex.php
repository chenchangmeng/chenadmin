<!DOCTYPE html>
<!--[if IE 8]>			<html class="ie ie8"> <![endif]-->
<!--[if IE 9]>			<html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->	<html> <!--<![endif]-->
<!-- header html -->
<?php echo $header; ?>	
	<body>
	<!-- Current Page CSS -->
	<?php echo HTML::style('vendor/circle-flip-slideshow/css/component.css'); ?>
	<?php echo HTML::style('vendor/nivo-slider/nivo-slider.css'); ?>
	<?php echo HTML::style('vendor/nivo-slider/themes/default/default.css'); ?>
			
		<div class="body">
			<!-- menu html -->
			<?php echo $menu; ?>

			<div role="main" class="main">

				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="nivo-slider">
								<div class="slider-wrapper theme-default">
									<div id="nivoSlider" class="nivoSlider">
										
										<?php foreach ($bannerData as $key => $value) { ?>
											<a href="<?php echo $value['url']; ?>">
												<img title="<?php echo $value['title']; ?>" src="<?php echo $value['promoteUrl']; ?>" data-thumb="<?php echo $value['promoteUrl']; ?>" alt="" />
											</a>
										<?php } ?>
									</div>
									<div id="htmlcaption" class="nivo-html-caption"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="home-intro home-intro-compact">
								
							</div>
						</div>
					</div>
				</div>

				<div class="container">

					<div class="row center">
						<div class="col-md-12">
							<h2 class="short word-rotator-title">
								Porto is
								<strong class="inverted">
									<span class="word-rotate">
										<span class="word-rotate-items">
											<span>incredibly</span>
											<span>especially</span>
											<span>extremely</span>
										</span>
									</span>
								</strong>
								beautiful and fully responsive.
							</h2>
							<p class="featured lead">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce elementum, nulla vel pellentesque consequat, ante nulla hendrerit arcu, ac tincidunt mauris lacus sed leo. vamus suscipit molestie vestibulum.
							</p>
						</div>
					</div>

				</div>

				<div class="home-concept">
					<div class="container">

						<div class="row center">
							<span class="sun"></span>
							<span class="cloud"></span>
							
							<?php foreach ($psData['pData'] as $key => $value) { ?>
								<div class="col-md-2 <?php if($key == 0){echo 'col-md-offset-1';} ?>">
									<div class="process-image" data-appear-animation="bounceIn" data-appear-animation-delay="<?php echo $key * 200; ?>">
										<a href="<?php echo $value['url']; ?>">
											<img src="<?php echo $value['recommendUrl']; ?>" alt="" />
										</a>
										<strong>											
												<a style="text-decoration:none;" href="<?php echo $value['url']; ?>">
													<?php echo $value['title']; ?>	
												</a>						
										</strong>
									</div>
								</div>
							<?php } ?>
							
							<div class="col-md-4 col-md-offset-1">
								<div class="project-image">
									<div id="fcSlideshow" class="fc-slideshow">
										<ul class="fc-slides">
											
											<?php foreach ($psData['sData'] as $key => $value) { ?>
												<li>
													<a href="<?php echo $value['url']; ?>">
														<img title="<?php echo $value['title']; ?>" class="img-responsive" src="<?php echo $value['recommendUrl']; ?>" />
													</a>
												</li>
											<?php } ?>
											
										</ul>
									</div>
									<strong class="our-work">Our Service</strong>
								</div>
							</div>
						</div>

					</div>
				</div>

				<div class="container">

					<!-- <div class="row">
						<hr class="tall" />
					</div> -->
					<hr class="tall" />
				</div>

				<!-- logo -->
				<div class="container">

					<div class="row center">
						<div class="owl-carousel" data-plugin-options='{"items": 6, "singleItem": false, "autoPlay": true, "pagination": false}'>
							
							<?php foreach ($customerData as $key => $value) { ?>
								<div>
									<img class="img-responsive" title="<?php echo $value->name; ?>" src="<?php echo $value->customerUrl; ?>" alt="">
								</div>
							<?php } ?>
							
						</div>
					</div>

				</div>

				<div class="map-section">
					<section class="featured footer map">
						<div class="container">
							<div class="row">
								<div class="col-md-6">
									<div class="recent-posts push-bottom">
										<h2>Latest <strong>News</strong> Posts</h2>
										<div class="row">
											<div class="owl-carousel" data-plugin-options='{"items": 1, "autoHeight": true}'>
												<div>
												<?php foreach ($newsData as $key => $value) { ?>
													
														
														<div class="col-md-6">
															<article>
																<div class="date">
																	<span class="day"><?php echo $value['day']; ?></span>
																	<span class="month"><?php echo $value['month']; ?></span>
																</div>
																<h4><a href="<?php echo $value['url']; ?> "><?php echo $value['title']; ?></a></h4>
																<p> <?php echo $value['overview']; ?> <a href="<?php echo $value['url']; ?> " class="read-more">read more <i class="icon icon-angle-right"></i></a></p>
															</article>
														</div>
														
													<?php if($key % 2 == 1) echo '</div><div>'; ?>
												<?php } ?>
												</div>
												
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<h2><strong>What</strong> Client’s Say</h2>
									<div class="row">
										<div class="owl-carousel push-bottom" data-plugin-options='{"items": 1, "autoHeight": true}'>
											<div>
												<div class="col-md-12">
													<blockquote class="testimonial">
													<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec hendrerit vehicula est, in consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec hendrerit vehicula est, in consequat.  Donec hendrerit vehicula est, in consequat.  Donec hendrerit vehicula est, in consequat.</p>
													</blockquote>
													<div class="testimonial-arrow-down"></div>
													<div class="testimonial-author">
														<div class="img-thumbnail img-thumbnail-small">
															<img src="img/clients/ceo_1.png" alt="">
														</div>
														<p><strong>John Smith</strong><span>CEO & Founder - Okler</span></p>
													</div>
												</div>
											</div>
											<div>
												<div class="col-md-12">
													<blockquote class="testimonial">
													<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec hendrerit vehicula est, in consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
													</blockquote>
													<div class="testimonial-arrow-down"></div>
													<div class="testimonial-author">
														<div class="img-thumbnail img-thumbnail-small">
															<img src="img/clients/ceo_2.png" alt="">
														</div>
														<p><strong>John Smith</strong><span>CEO & Founder - Okler</span></p>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
				</div>
			</div>

			<!-- footer html-->
			<?php echo $footer; ?>
			<!-- Current Page JS -->
			<?php echo HTML::script('vendor/circle-flip-slideshow/js/jquery.flipshow.js'); ?>
			<?php echo HTML::script('vendor/nivo-slider/jquery.nivo.slider.js'); ?>
			<?php echo HTML::script('js/views/view.home.js'); ?>

		</div>
	</body>
</html>
			
