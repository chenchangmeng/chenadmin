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
								<ul class="history">
								<?php foreach ($productItem as $key => $value) { ?>
									<li >
										<div class="featured-box" style="margin-left:0px;">
											<div class="box-content">
												<h4><strong><a title="<?php echo $value['name']; ?>" href="<?php echo $value['url']; ?>"><?php echo $value['name']; ?>  <?php if(strlen($value['enName'])> 0){echo '|';} ?>    <?php echo $value['enName']; ?></a></strong></h4>
												<hr class="tall">
												<?php echo $value['description']; ?>
											</div>
										</div>
									</li>
								<?php }  ?>								
								</ul>

							</div>
						</div>

						<div class="col-md-3">
							<aside class="sidebar">

								<hr />

								<h4>Categories</h4>
								<ul class="nav nav-list primary push-bottom">
									<?php foreach ($productItem as $key => $value) { ?>
										<li>
											<a title="<?php echo $value['name']; ?>" href="<?php echo $value['url']; ?>">
												<?php echo $value['name']; ?>
											</a>
										</li>
									<?php } ?>
								</ul>

								

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
