<?php 
	foreach($site_info as $siteinfo)
	?>
<div class="container">
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-6">
							<div class="title">
								<h3><?= lang("system_page");?></h3>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<ol class="breadcrumb text-center">
							  <li><a href="<?= DIR?>site/"><?= lang("home_page");?></a></li>
							  <li class="active"><a href="#"><?= lang("system_page");?></a></li>
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
					<div class="systems">
                    <?php if($result_amount>0){
						foreach($results as $prod) {
						?>
					<div class="col-md-3 col-sm-4 col-xs-6">
					<?php
					if($prod->link!=""&&$prod->link!="#"){
					?>
					<a href="<?=$prod->link;?>" target="_blank">
					<?php } else {?>
					<a>
					<?php }?>
					<div class="system">
							<h5>
<?php 
if($lang == 'arabic'){
    if(strlen($prod->title_ar)>120){	echo mb_substr($prod->title_ar,0,120)."...";}
    else {echo mb_substr($prod->title_ar,0,120);}
}
else {
if(strlen($prod->title_eng)>120){	echo mb_substr($prod->title_eng,0,120)."...";}
    else {echo mb_substr($prod->title_eng,0,120);}    
}
?>
</h5>
						</div></a>
                    </div>
                    <?php }?>
						<?php } else {?>
							<div class="col-md-12"><?= lang("no_data");?></div>
						<?php }?>
                
                    </div>
                    <div class="col-md-12" style="text-align:center;min-height:140px"><?php foreach($links as $link){?><?php echo $link;?><?php } ?></div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>