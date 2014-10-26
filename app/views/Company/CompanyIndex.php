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
									<li><a href="#">Home</a></li>
									<li class="active">About Us</li>
								</ul>
							</div>
						</div>
						
					</div>
				</section>

				<div class="container">

					<h2 class="word-rotator-title">
						The New Way to <strong>
							<span class="word-rotate">
								<span class="word-rotate-items">
									<span>success.</span>
									<span>advance.</span>
									<span>progress.</span>
								</span>
							</span>
						</strong>
					</h2>

					<div class="row">
						<div class="col-md-10">
							<p class="lead">
								<span class="alternative-font">ETA</span> has impacted the design and development of numerous products - autos, trains, aircraft, household appliances, and consumer electronics.  By enabling engineers to simulate the behavior of these products during manufacture or during their use, ETA has been involved in making these products safer, more durable, lighter weight, and less expensive to develop. 
								
							</p>
						</div>
						<div class="col-md-2">
							<a href="<?php echo URL::to('career/index'); ?>" class="btn btn-lg btn-primary push-top">加入ETA!</a>
						</div>
					</div>

					<hr class="tall">

					<div class="row">
						<div class="col-md-8">
							<h3><strong>Who</strong> We Are</h3>
							
							<?php if(isset($companyData[0]->content)){echo $companyData[0]->content;} ?>
						</div>
						<div class="col-md-4">
							<div class="featured-box featured-box-secundary">
								<div class="box-content">
									<h4>分支机构  |  Branches</h4>
									<?php foreach ($branchData as $key => $value) { ?>
										<div class="img-thumbnail">
											<a title="<?php echo $value->branchName; ?>" href="<?php echo $value->url; ?>">
												<img class="img-responsive" width="288" height="113" src="<?php echo $value->branchImgUrl; ?>" alt="">
											</a>
										</div>
									<?php } ?>
									
								</div>
							</div>
						</div>
					</div>

					<hr class="tall">

					
				</div>

			</div>

			<!-- footer html-->
			<?php echo $footer; ?>
		</div>

	</body>
</html>
