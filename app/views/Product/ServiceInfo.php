<!DOCTYPE html>
<!--[if IE 8]>			<html class="ie ie8"> <![endif]-->
<!--[if IE 9]>			<html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->	<html> <!--<![endif]-->
	<?php echo $header; ?>	
	<body>

		<div class="body">
			<!-- menu html -->
			<?php echo $menu; ?>

			<div role="main" class="main shop">

				<div class="container">

					<div class="row">
						<div class="col-md-9">

							<div class="row">
								<div class="col-md-12">
									<h4><strong><?php if(isset($currInfo[0]->name)){echo $currInfo[0]->name;} ?></strong></h4>
									
									<?php if(isset($currInfo[0]->description)){echo $currInfo[0]->description;} ?>
								</div>
							</div>
							<?php foreach ($sData as $key => $value) { ?>
								<hr class="tall">
								<div class="row">
									<div class="col-md-12">
										<h5><?php echo $value['name']; ?></h5>
										<?php echo $value['productInfo']; ?>
										<div class="tabs tabs-product">
											<ul class="nav nav-tabs">
												<?php foreach ($value['termChild'] as $tcKey => $tcValue) { ?>
													<li class="<?php if($tcKey == 0){echo 'active';} ?>">
														<a href="#nav-tabs-<?php echo $tcValue['tid'] . '_' . $value['tid']; ?>" data-toggle="tab"><?php echo $tcValue['name']; ?></a>
													</li>
												<?php } ?>
												
												
											</ul>
											<div class="tab-content">
												<?php foreach ($value['termChild'] as $tcKey => $tcValue) { ?>
													<div class="tab-pane <?php if($tcKey == 0){echo 'active';} ?>" id="nav-tabs-<?php echo $tcValue['tid']. '_' . $value['tid']; ?>">
														<?php foreach ($tcValue['child'] as $kkey => $kvalue) { ?>
															<section class="toggle ">
																<label><?php echo $kvalue['infoName']; ?></label>
																<div class="toggle-content" style="margin-left:15px;">
																	
																	<?php echo $kvalue['infoContent']; ?>
													
																</div>
															</section>
														<?php } ?>
													</div>
												<?php } ?>
			
											</div>
										</div>
									</div>
								</div>

							<?php } ?>

						</div>
						<div class="col-md-3">
							<aside class="sidebar">
								<hr />

								<h4>Categories</h4>
								<ul class="nav nav-list primary push-bottom">
									<li><a href="#">VPG</a></li>
									<li><a href="#">3DCS</a></li>
									<li><a href="#">DYNAFORM</a></li>
									<li><a href="#">LS-DYNA</a></li>
									<li><a href="#">DTM</a></li>
									<li><a href="#">Presys</a></li>
									<li><a href="#">咨询服务</a></li>
									<li><a href="#">培训服务</a></li>
									<li><a href="#">高性能计算</a></li>
								</ul>
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
