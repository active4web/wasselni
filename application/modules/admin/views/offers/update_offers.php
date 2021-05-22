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
$curt='offers';
}

foreach($data as $result)
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" dir="rtl">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>تعديل </title>
<?php include ("design/inc/header.php");?>
</head>
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-md">
		<!-- BEGIN HEADER -->
        <?php include ("design/inc/topbar.php");?>
		<script type="text/javascript" src="<?=$url?>design/ckeditor/ckeditor.js"></script>
		<script type="text/javascript" src="<?=$url?>design/ckfinder/ckfinder.js"></script>

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
						<li>
                        <a href="<?=$url.'admin/offers';?>">العروض</a>
                        <i class="fa fa-circle"></i>
						</li>
                        <li>
                            <span class="active">تعديل عرض</span>
                        </li>
                    </ul>
                    <!-- END PAGE BREADCRUMB -->
                    <!-- BEGIN PAGE BASE CONTENT -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN PROFILE SIDEBAR -->
                           
                            <div class="profile-content">
                                <div class="row">
                                    <div class="col-md-12">
                                       <!--Start from-->	
                                <div class="tab-content">					
                                    <div class="tab-pane active" id="tab_5">
                                        <div class="portlet">
                                         
                                        <div class="portlet form-fit">
                                           
                                            <div class="portlet-body form">
                                                <!-- BEGIN FORM-->
    <form action="<?=$url;?>admin/offers/edit_action" class="form-horizontal form-bordered"  method="post" enctype="multipart/form-data">
                                               <input type="hidden" name="id" value="<?= $result->id?>">
											   
											        <div class="form-body">
														<div class="form-group">
														<div class="col-md-3" style="text-align:center"></div>
                                                            <div class="col-md-6" style="text-align:center">
                                                            <div class="fileinput fileinput-new" data-provides="fileinput">
																			<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
																				<img src="<?=$url;?>uploads/offers/<?= $result->img;?>" alt="" /> </div>
																			<div class="fileinput-preview fileinput-exists thumbnail" style="width: 200px;height: 150px;"> </div>
																			<div>
																				<span class="btn default btn-file">
																					<span class="fileinput-new">صورة العرض</span>
																					<span class="fileinput-exists">تغير</span>
																					<input type="file" name="file"> </span>
																				<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput">حذف </a>
																			</div>
																		</div>
															</div>
															<div class="col-md-3" style="text-align:center"></div>
                                                        </div>
                                                        
                                                        
                              <div class="form-group">
									<div class="col-md-3">
                                        <span class="help-block ltr" >Old Price</span>
                                        <input type="text"  value="<?= $result->old_price?>" placeholder="Old Price" class="form-control ltr" name="old_price">
									</div>	
									
								    <div class="col-md-3">
                                       <span class="help-block ltr" >New Price</span>
                                       <input type="text"  value="<?= $result->new_price?>" placeholder="New Price" class="form-control ltr" name="new_price">
									</div>
															
								    <div class="col-md-3">
                                       <span class="help-block ltr" >Start Date (<?= $result->start_date?>)</span>
                                        <input type="date"  placeholder="Start Date" class="form-control ltr" name="start_date">
									</div>
															
															
								    <div class="col-md-3">
                                        <span class="help-block ltr" >End Date (<?= $result->end_date?>)</span>
                                        <input type="date"   placeholder="End Date" class="form-control ltr" name="end_date">
									</div>
                                </div>
                                                        
                   <div class="form-group">									
                                    <div class="col-md-4">
                                           <span class="help-block">عنوان العرض</span>
                                           <input type="text" value="<?= $result->offer_name?>"  placeholder="عنوان العرض" class="form-control" name="title">
									</div>
                                                        
                                   <div class="col-md-4">
                                            <span class="help-block ltr" >Offer Title</span>
                                            <input type="text"  value="<?= $result->offer_name_en?>"  placeholder="Offer Title" class="form-control ltr" name="title_en">
									</div>
                                  <div class="col-md-4">
                                            <span class="help-block ltr" >Teklif Başlığı </span>
                                            <input type="text"  value="<?= $result->name_tr?>"  placeholder="Teklif Başlığı" class="form-control ltr" name="title_tr">
									</div>
                                   
    </div>                                           
                                <div class="form-group">
                                        <div class="col-md-6">
                                        <span class="help-block">حدد مقدم الخدمه (<?= get_table_filed("team_work",array("id"=>$result->service_id),"name");?>)</span>
                                         <input list="service_id" name="service_id" id="serviceid" class="form-control serviceid" >
                                         <input type="hidden" name="service_id_txt" id="serviceid_txt" class="form-control" >
                                        <datalist  id="service_id" >
                                            <option value="حدد مقدم الخدمه" data-value=""></option>
                                            <?php foreach($team_work as $teamwork){?>
                                            <option data-val="<?= $teamwork->id?>"  value="<?= $teamwork->name?>" ></option>
                                             <?php }?>
                                        </datalist>
                                        </div>
                                                
                                        <div class="col-md-6">
                                               <span class="help-block">الترتيب</span>
                                               <input type="text" value="<?= $teamwork->arrange_type?>"   placeholder="الترتيب" class="form-control" name="arrange_type">
                                       </div>        
                                                            
                                    </div>
                                                        
                                                        
                                
                                                        
													
                                                        

														<div class="form-group">
																		<div class="col-md-2"></div>
																		<div class="col-md-12" style="text-align:center">
																		<span class="help-block" style="padding:20px;"> المحتوي </span>
																		<textarea  name="description"  class="form-control" style="width:100%;height:100px;"><?= $result->description;?></textarea>
																		</div>
														</div>

                                                     
                                                     
                                                     
                                                     	<div class="form-group">
																		<div class="col-md-2"></div>
																		<div class="col-md-12" style="text-align:center">
																		<span class="help-block" style="padding:20px;">Content </span>
																		<textarea  name="description_en" class="form-control ltr"  style="width:100%;height:120px;"><?= $result->description_en;?></textarea>
																		</div>
														</div>
														<div class="form-group">
												<div class="col-md-12" style="text-align:center">
												<span class="help-block" style="padding:20px;">İçerik </span>
												<textarea  name="description_tr" class="form-control ltr"  style="width:100%;height:120px;"><?= $result->description_tr;?></textarea>
												</div>
							     	           </div>
																
     <div class="col-md-12" style="text-align:center">
            <div class="btn-group">    
                <button type="submit" class="btn green">
                    
                    <i class="fa fa-save"></i> حفظ البيانات																			
                </button>
            </div>
            <div class="btn-group">  
                <button type="button" class="btn default cancelbutton">
                    <i class="fa fa-trash"></i><?=lang('cancel');?>																				
                </button>
            </div>
   </div>
                                                </form>
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
        <?php include ("design/inc/footer.php");?>
        <!-- END FOOTER -->

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
<script type="text/javascript">
	//CKEDITOR.replace('description');
	var details_ar = CKEDITOR.replace( 'details_ar' );
	CKFinder.setupCKEditor( details_ar );
</script>


<script type="text/javascript">
$(document).ready(function(){
  
  $(".serviceid").change(function(){
    var selectedOption = $("#service_id option[value='" + $(this).val() + "']");
    var selectedPerson = parseInt(selectedOption.attr('data-val'));
     $("#serviceid_txt").val(selectedPerson);
    });
});
    </script>
</body></html>
