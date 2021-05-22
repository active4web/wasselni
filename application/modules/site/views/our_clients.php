<?php 
	foreach($site_info as $siteinfo)
	?>
<div class="container">
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-6">
							<div class="title">
								<h3><?= lang("clients");?></h3>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<ol class="breadcrumb text-center">
							  <li><a href="<?= DIR?>site/"><?= lang("home_page");?></a></li>
							  <li class="active"><a href="#"><?= lang("clients");?></a></li>
							</ol>	
						</div>
					</div>
				</div>		
				<div class="clearfix"></div>
			</div>
		</div>
			<div class="trin three hidden-xs hidden-sm">
			</div>			
			</div>
		</div>

<div class="wrapper">
			<div class="container">
				<div class="row">
					<div class="our-clints">
					<?php if($result_amount>0){
						foreach($results as $prod) {
						?>
						<div class="clint">
							<?php
							if($prod->link!=""&&$prod->link!="#"){
							?>
			<a href="<?=$prod->link;?>" target="_blank" title="<?=$prod->title_ar;?>">
			<img class="img-responsive img-block" src="<?= DIR_DES_STYLE ?>clients/<?= $prod->img?>"></a>
							<?} else {?>
			<img class="img-responsive img-block" src="<?= DIR_DES_STYLE ?>clients/<?= $prod->img?>">
							<?php }?>

						</div>
						<?php }?>
						<?php } else {?>
							<div class="col-md-12"><?= lang("no_data");?></div>
						<?php }?>
				
					</div>
					<div class="col-md-12" style="text-align:center;min-height:140px"><?php foreach($links as $link){?><?php echo $link;?><?php } ?></div>
					</div>
			</div>
		</div>