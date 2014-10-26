<!DOCTYPE html>
<!--[if IE 8]>			<html class="ie ie8"> <![endif]-->
<!--[if IE 9]>			<html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->	<html> <!--<![endif]-->
	<?php echo $header; ?>
	<body>

		<div class="body">
			<!-- menu html -->
			<?php echo $menu; ?>

			<div role="main" class="main">

				<section class="page-top">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<ul class="breadcrumb">
									<li><a href="#">首页</a></li>
									<li class="active">新闻发布</li>
								</ul>
							</div>
						</div>
						
					</div>
				</section>

				<div class="container">

					<div class="row">
						<div class="col-md-9">
							<div class="blog-posts single-post">

								<article class="post post-large blog-single-post">
									

									<div class="post-date">
										<span class="day"><?php echo  $currentNewsData[0]->day; ?></span>
										<span class="month"><?php echo $currentNewsData[0]->month; ?></span>
									</div>

									<div class="post-content">

										<h2><a href="<?php echo $currentNewsData[0]->url; ?>"><?php echo $currentNewsData[0]->title; ?></a></h2>

										<div class="post-meta">
											<span><i class="icon icon-user"></i> By <a href="javascript:void(0);"><?php echo $currentNewsData[0]->userName; ?></a> </span>
											
										</div>

										<?php echo $currentNewsData[0]->content; ?>


										<div class="post-block post-share">
											<h3><i class="icon icon-share"></i>Share this post</h3>

											<!-- AddThis Button BEGIN -->
											<div class="addthis_toolbox addthis_default_style ">
												<a class="addthis_button_facebook_like" ></a>
												<a class="addthis_button_tweet"></a>
												<a class="addthis_button_pinterest_pinit"></a>
												<a class="addthis_counter addthis_pill_style"></a>
											</div>
											
											<!-- AddThis Button END -->

										</div>
									</div>
								</article>

							</div>
						</div>

						<div class="col-md-3">
							<aside class="sidebar">

								<form>
									<div class="input-group input-group-lg">
										<input class="form-control" placeholder="Search..." name="s" id="s" type="text">
										<span class="input-group-btn">
											<button type="submit" class="btn btn-primary btn-lg"><i class="icon icon-search"></i></button>
										</span>
									</div>
								</form>

								<hr />

								<h4>Categories</h4>
								<ul class="nav nav-list primary push-bottom">
									<li><a href="#">Design</a></li>
									<li><a href="#">Photos</a></li>
									<li><a href="#">Videos</a></li>
									<li><a href="#">Lifestyle</a></li>
									<li><a href="#">Technology</a></li>
								</ul>

								<div class="tabs">
									<ul class="nav nav-tabs">
										<li class="active"><a href="#popularPosts" data-toggle="tab"><i class="icon icon-star"></i> Popular</a></li>
										<li><a href="#recentPosts" data-toggle="tab">Recent</a></li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane active" id="popularPosts">
											<ul class="simple-post-list">
												<li>
													<div class="post-image">
														<div class="img-thumbnail">
															<a href="blog-single.html">
																<img src="img/blog/blog-thumb-1.jpg" alt="">
															</a>
														</div>
													</div>
													<div class="post-info">
														<a href="blog-single.html">Nullam Vitae Nibh Un Odiosters</a>
														<div class="post-meta">
															 Jan 10, 2013
														</div>
													</div>
												</li>
												<li>
													<div class="post-image">
														<div class="img-thumbnail">
															<a href="blog-single.html">
																<img src="img/blog/blog-thumb-2.jpg" alt="">
															</a>
														</div>
													</div>
													<div class="post-info">
														<a href="blog-single.html">Vitae Nibh Un Odiosters</a>
														<div class="post-meta">
															 Jan 10, 2013
														</div>
													</div>
												</li>
												<li>
													<div class="post-image">
														<div class="img-thumbnail">
															<a href="blog-single.html">
																<img src="img/blog/blog-thumb-3.jpg" alt="">
															</a>
														</div>
													</div>
													<div class="post-info">
														<a href="blog-single.html">Odiosters Nullam Vitae</a>
														<div class="post-meta">
															 Jan 10, 2013
														</div>
													</div>
												</li>
											</ul>
										</div>
										<div class="tab-pane" id="recentPosts">
											<ul class="simple-post-list">
												<li>
													<div class="post-image">
														<div class="img-thumbnail">
															<a href="blog-single.html">
																<img src="img/blog/blog-thumb-2.jpg" alt="">
															</a>
														</div>
													</div>
													<div class="post-info">
														<a href="blog-single.html">Vitae Nibh Un Odiosters</a>
														<div class="post-meta">
															 Jan 10, 2013
														</div>
													</div>
												</li>
												<li>
													<div class="post-image">
														<div class="img-thumbnail">
															<a href="blog-single.html">
																<img src="img/blog/blog-thumb-3.jpg" alt="">
															</a>
														</div>
													</div>
													<div class="post-info">
														<a href="blog-single.html">Odiosters Nullam Vitae</a>
														<div class="post-meta">
															 Jan 10, 2013
														</div>
													</div>
												</li>
												<li>
													<div class="post-image">
														<div class="img-thumbnail">
															<a href="blog-single.html">
																<img src="img/blog/blog-thumb-1.jpg" alt="">
															</a>
														</div>
													</div>
													<div class="post-info">
														<a href="blog-single.html">Nullam Vitae Nibh Un Odiosters</a>
														<div class="post-meta">
															 Jan 10, 2013
														</div>
													</div>
												</li>
											</ul>
										</div>
									</div>
								</div>

								<hr />

								<h4>About Us</h4>
								<p>Nulla nunc dui, tristique in semper vel, congue sed ligula. Nam dolor ligula, faucibus id sodales in, auctor fringilla libero. Nulla nunc dui, tristique in semper vel. Nam dolor ligula, faucibus id sodales in, auctor fringilla libero. </p>

							</aside>
						</div>
					</div>

				</div>

			</div>

			<!-- footer html-->
			<?php echo $footer; ?>
		</div>

	</body>
</html>
