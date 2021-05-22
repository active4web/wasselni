<?php
$url=base_url();
ob_start();
if(!isset($_SESSION['admin_name'])||$_SESSION['admin_name']==""){ 
header("Location:$url"."admin/login"); 
}
else{
$id_admin=$_SESSION['id_admin'];
$admin_name=$_SESSION['admin_name'];
$last_login=$_SESSION['last_login'];
$curt='services';
}
foreach($data as $res)
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" dir="rtl">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8">
<title>تعديل</title>
<?php include ("design/inc/header.php");?>
</head>

<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-md">
		<!-- BEGIN HEADER -->
        <?php include ("design/inc/topbar.php");?>
        <!-- END HEADER -->
		<!-- BEGIN HEADER & CONTENT DIVIDER -->
		<div class="clearfix"> </div>
		<!-- END HEADER & CONTENT DIVIDER -->
		<!-- BEGIN CONTAINER -->
		<div class="page-container">
			<!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
                <!-- BEGIN SIDEBAR -->
                <?php include ("design/inc/sidebar.php");?>
                <!-- END SIDEBAR -->
            </div>
            <!-- END SIDEBAR -->
			<!-- BEGIN CONTENT -->
			<div class="page-content-wrapper">
			<div class="page-content" style="min-height: 1261px;">
                    <!-- BEGIN PAGE HEAD-->
                    
                    <!-- END PAGE HEAD-->
                    <!-- BEGIN PAGE BREADCRUMB -->
                   	<ul class="page-breadcrumb breadcrumb">
<li>
							<a href="<?=$url.'admin';?>">الرئيسية</a>
							<i class="fa fa-circle"></i>
						</li>
						
						<li>	<a href="<?=$url.'admin/services/home';?>">
							    مقدمى الخدمة</a>
							<i class="fa fa-circle"></i>
						</li>
							<li>
							    	<a href="<?=$url?>admin/services/service_products?id=<?= $this->input->get("id_tab")?>">
							    	     المنتجات
                                               </a>
								<i class="fa fa-circle"></i>
						</li>
							<li>
							<span class="active">تعديل</span>
						</li>
					</ul>
                    <!-- END PAGE BREADCRUMB -->
                    <!-- BEGIN PAGE BASE CONTENT -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN PROFILE SIDEBAR -->
                            <div class="profile-sidebar">
                                <!-- PORTLET MAIN -->

                                <!-- END PORTLET MAIN -->
                            </div>
                            <!-- END BEGIN PROFILE SIDEBAR -->
                            <!-- BEGIN PROFILE CONTENT -->
                            <div class="profile-content">
                                <div class="row">
                                    <div class="col-md-12">
                                       <!--Start from-->	
                                <div class="tab-content">					
                                    <div class="tab-pane active" id="tab_5">
                                        <div class="portlet">
                                      
                                        <div class="portlet ">
                                           
                                            <div class="portlet-body form">
                                                <!-- BEGIN FORM-->
                 <form action="<?=$url;?>admin/services/edit_product_action" class="form-horizontal form-bordered"  method="post" enctype="multipart/form-data">
                <input type="hidden" value="<?= $this->input->get("id_tab");?>" name="id_tab">
                <input type="hidden" value="<?= $res->id;?>" name="id_prod">
                <div class="form-body">
													
                                                      

<div class="form-group">

<div class="col-md-3">
<span class="help-block" style="float:left">اسم المنتج</span>
<span class="caption-subject font-red bold uppercase">
<input type="text" value="<?= $res->name?>" placeholder="اسم المنتج" class="form-control " name="title">
</div>

<div class="col-md-3">
<span class="help-block" style="float:left">Title of product</span>
<span class="caption-subject font-red bold uppercase">
<input type="text" value="<?= $res->name_en?>" placeholder="Title of product" class="form-control ltr" name="title_en">
</div>

<div class="col-md-3">
<span class="help-block" style="float:left">Current Price</span>
<span class="caption-subject font-red bold uppercase">
<input type="text" value="<?= $res->new_price?>" placeholder="Current Price" class="form-control ltr" name="current_price">
</div>

<div class="col-md-3">
<span class="help-block" style="float:left">Başlık</span>
<input type="text"  placeholder="Başlık" class="form-control ltr" name="title_tr">
</div>


</div>

<div class="form-group">

<div class="col-md-12">
<span class="help-block" >وصف المنتج</span>
<span class="caption-subject font-red bold uppercase">
<textarea name="description_ar" style="width:100%;height:60px" class="form-control"  placeholder="وصف المنتج">
    <?= $res->description?>
</textarea>
</div>

</div>


<div class="form-group">
<div class="col-md-12">
<span class="help-block" style="float:left">Description Product</span>
<span class="caption-subject font-red bold uppercase">
<textarea name="description_en" style="width:100%;height:60px" class="form-control ltr" placeholder="Description Product">
    <?= $res->description_en?>
</textarea>
</div>
</div>


<div class="form-group">

<div class="col-md-12">
<span class="help-block" style="float:left">Ürün Tanımı</span>
<span class="caption-subject font-red bold uppercase">
<textarea name="description_tr" style="width:100%;height:60px" class="form-control ltr" placeholder="Ürün Tanımı">
    <?= $res->description_tr?>
</textarea>
</div>

</div>
                                                     
<div class="form-group">
<div class="col-md-3" style="text-align:center"></div>
<div class="col-md-6" style="text-align:center">
<div class="fileinput fileinput-new" data-provides="fileinput">
<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
    <img src="<?= base_url()?>uploads/service/products/<?= $res->img?>">
    
</div>
<div class="fileinput-preview fileinput-exists thumbnail" style="width: 200px;height: 150px;"> </div>
<div>
<span class="btn default btn-file">
<span class="fileinput-new"> الصورة</span>
<span class="fileinput-exists">تغير</span>
<input type="file" name="file" > </span>
<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput">حذف </a>
</div>
</div>
</div>
<div class="col-md-3" style="text-align:center"></div>
</div>




<div class="col-md-12" style="text-align:center">
            <div class="btn-group">    
                <button type="submit" class="btn green">
                    
                    <i class="fa fa-save"></i> حفظ التغيرات  																			
                </button>
            </div>
            <div class="btn-group">  
                <button type="button" class="btn default cancelbutton">
                    <i class="fa fa-trash"></i><?=lang('cancel');?>																				
                </button>
            </div>
            </div>
														
                                                    
                                                </form>
                                                <!-- END FORM-->
                                            </div>
                                        </div>
                                       
									</div>	
<!---END FROM-->
												
                                            
                                      
                                </div>
                            </div>
                            <!-- END PROFILE CONTENT -->
                        </div>
                    </div>
                    <!-- END PAGE BASE CONTENT -->
                </div>
            </div>
            </div>
            </div>
            </div>
            </div>
            </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <div class="footer">
        <?php include ("design/inc/footer.php");?>
        <!-- END FOOTER -->
</div>
        <?php include ("design/inc/footer_js.php");?>
<?php 
if(isset($_SESSION['msg'])){
?>
<script>
$(document).ready(function(e) {
 toastr.success("<?php echo $_SESSION['msg']?>");
});
</script>
<?php }?>
</body></html>
