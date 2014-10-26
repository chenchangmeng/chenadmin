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
						<!-- <div class="row">
							<div class="col-md-12">
								<h2>Medium Image</h2>
							</div>
						</div> -->
					</div>
				</section>

				<div class="container">

					<div class="row">
						<div class="col-md-9">
							<div class="blog-posts">
								<?php foreach ($newsData as $key => $value) { ?>
									<article class="post post-medium">
										<div class="row">
											<div class="col-md-5">
												<div class="post-image">
													<div class="owl-carousel" >
														<div>
															<div class="img-thumbnail">
																<img class="img-responsive" src="<?php echo $value['stickyUrl'];?>" alt="">
															</div>
														</div>
														
													</div>
												</div>
											</div>
											<div class="col-md-7">

												<div class="post-content">

													<h2><a href="<?php echo $value['url']; ?>"><?php echo $value['title']; ?></a></h2>
													<?php echo $value['overview']; ?>

												</div>
											</div>

										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="post-meta">
													<span><i class="icon icon-calendar"></i><?php echo $value['dateType']; ?></span>
													<span><i class="icon icon-user"></i> By <a href="#"><?php echo $value['userName']; ?></a> </span>
													
													<a href="<?php echo $value['url']; ?>" class="btn btn-xs btn-primary pull-right">Read more...</a>
												</div>
											</div>
										</div>

									</article>
								<?php } ?>

								<ul class="pagination pagination-lg pull-right">
									<li><a href="#">«</a></li>
									<li class="active"><a href="#">1</a></li>
									<li><a href="#">2</a></li>
									<li><a href="#">3</a></li>
									<li><a href="#">»</a></li>
								</ul>

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
									<?php foreach ($productItem as $key => $value) { ?>
										<li><a href="<?php echo $value['url']; ?>"><?php echo $value['name']; ?></a></li>
									<?php } ?>
									
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
														<a href="blog-single.html">2014年公开课培训安排</a>
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
														<a href="blog-single.html">2014年公开课培训安排</a>
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
														<a href="blog-single.html">2014年公开课培训安排</a>
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
