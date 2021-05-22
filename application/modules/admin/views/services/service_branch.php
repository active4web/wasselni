<?php
//session_start();
ob_start();
if(!isset($_SESSION['admin_name'])||$_SESSION['admin_name']==""){ 
header("Location:".base_url()."admin/login"); 
}
else{
$id_admin=$_SESSION['id_admin'];
$admin_name=$_SESSION['admin_name'];
$last_login=$_SESSION['last_login'];
$curt='services';
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" dir="rtl">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    
<link rel="stylesheet" href="<?=base_url();?>design/lightbox2-master/dist/css/lightbox.min.css" type="text/css" media="screen" />
<script src="<?=base_url();?>design/lightbox2-master/dist/js/lightbox-plus-jquery.min.js"></script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>الفروع</title>
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
				<!-- BEGIN CONTENT BODY -->
				<div class="page-content">
					<!-- BEGIN PAGE BREADCRUMB -->
					<ul class="page-breadcrumb breadcrumb">
<li>
							<a href="<?=$url.'admin';?>">الرئيسية</a>
							<i class="fa fa-circle"></i>
						</li>
						
						<li>
							<a href="<?=$url.'admin/services/home';?>">مقدم الخدمة</a>
							<i class="fa fa-circle"></i>
							
						</li>
						<li>
							<span class="active">الفروع</span>
						</li>
						
					</ul>
					<!-- END PAGE BREADCRUMB -->

					<!-- Start Table Data -->
					<div class="row">
						<div class="col-md-12">
							<!-- BEGIN EXAMPLE TABLE PORTLET-->
							<div class="portlet">
								
								<span class="portlet-body">
									<div class="table-toolbar">
										<div class="row">
										
										<div class="col-md-6">
												<div class="btn-group">
													<button id="sample_editable_1_2_new" class="btn sbold green addbutton"> <?=lang('add');?>
														<i class="fa fa-plus"></i>
													</button>
												</div>
												<div class="btn-group">
													<button id="sample_editable_1_2_new" class="btn sbold red delbutton"> <?=lang('del_group');?>
														<i class="fa fa-remove"></i>
													</button>
												</div>
											</div>
										
										</div>
									</div>
									<?php if(!empty($results)){?>
									<form action="<?= base_url()?>admin/services/delete_service" method="POST" id="form">
									    <input type="hidden" name="id_tab" value="<?= $this->input->get("id")?>">
									<div>
									
									</div>
									<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1_2">
										<thead>
											<tr>
												<th>
													<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
														<input id="checkAll" type="checkbox" class="group-checkable" data-set="#sample_1_2 .checkboxes" />
														<span></span>
													</label>
												</th>
												<th> الأسم </th>
												<th> التليفون </th>
												<th> الواتس </th>
												<th> عدد المشاهدات </th>
												<th> مقدم الخدمة </th>
												<th> الصورة </th>
												<th> الحالة</th>
												<th> العمليات </th>
											</tr>
										</thead>
										<tfoot>
											<tr>
											    <th> </th>
											    <th> </th>
												<th> </th>
												<th> </th>
												<th> </th>
												<th> </th>
												<th> </th>
												<th> </th>
											</tr>
										</tfoot>
										<tbody>
                                        <?php
                                            foreach($results as $data) {
												$view=$data->view;
												switch($view){
													case 0:
													  $view="<span class='label label-sm label-danger'>غير مفعل</span>";
													  break;
													case 1:
													  $view="<span class='label label-sm label-success'>مفعل</span>";
													  break;
													default:
													  break; 
												}
												
												$image=$data->img;
												$base=base_url();
												$img=$base."uploads/service/branches/".$image; 
												$name_cat=get_table_filed("team_work",array("id"=>$data->service_id),'name');
                                        ?>
                                        
											<tr class="odd gradeX">
												<td>
													<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
														<input name="check[]" type="checkbox" class="checkboxes" value="<?=$data->id;?>" />
														<span></span>
													</label>
												</td>

												<td> <?=$data->name;?> </td>
												<td> <?=$data->phone;?> </td>
												<td> <?=$data->whatsapp;?> </td>
												<td> <?=$data->views;?> </td>
												
												<td> <?= $name_cat;?> </td>
												
										     	<td><a title="view image" class="example-image-link" href="<?php echo $img;?>" data-lightbox="example-1"><?=lang('view');?></a></td>

											
												<td>
											    	<a  data-id="<?php echo $data->id;?>" class="btn btn-xs purple table-icon edit" title="change status" >
												<span class="code_actvation-<?php echo $data->id;?>"><?php echo $view;?></span>
											        </a> 
											   </td> 
										
										
												<td>
													<div class="btn-group">
														<button class="btn btn-xs dropdownbtn-new dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> العمليات
															<i class="fa fa-angle-down"></i>
														</button>
														<ul class="dropdown-menu pull-left" role="menu">
                                                            <li><a href="<?= base_url()?>admin/services/details_branches_service?id_tab=<?= $this->input->get("id")?>&id=<?=$data->id;?>"><i class="fa fa-eye"></i> تفاصيل </a></li>
															<li><a href="<?= base_url()?>admin/services/delete_branches_service?id_tab=<?= $this->input->get("id")?>&id=<?=$data->id;?>"><i class="fa fa-remove"></i> حذف </a></li>

														</ul>
													</div>
												</td>
											</tr>
                                            <?php }?>
										</tbody>
									</table>
									</form>
									<?php }else{?>
									<center><span class="caption-subject font-red bold uppercase">عفوا لاتوجد بيانات للعرض</span></center>
									<?php }?>
								<div class="row">
                                    <div class="col-md-5 col-sm-5">
									<br>
                                        <div class="dataTables_info" id="sample_1_2_info" role="status" aria-live="polite">
                                        <ul class="nav nav-pills">
                                            <li>
                                            <a href="javascript:;"> مجموع السجلات :
                                                <span class="badge badge-success pull-right"> <?php echo $result_amount; ?> </span>
                                            </a>
                                            </li>
                                        </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-7 col-sm-7">
                                        <div style="text-align: right;" class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_2_paginate">
                                            <ul class="pagination" style="visibility: visible;">
                                                <?php echo $pagination; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
								</div>
							</div>
							<!-- END EXAMPLE TABLE PORTLET-->
						</div>
					</div>
					<!-- END Table Data-->

				</div>
				<!-- END CONTENT -->
		</div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <div class="footer">
        <?php include ("design/inc/footer.php");?>
        <!-- END FOOTER -->
</div>
        <?php include ("design/inc/footer_js.php");?>
		<script>
$(document).ready(function(e) {
	
    $(".addbutton").click(function(e) {
        window.location.assign("<?= DIR?>admin/services/add_branch?id=<?= $this->input->get("id")?>");
    });

});
</script>

<script>
$(document).ready(function(e) {
    $("#checkAll").change(function(){
		$("input[type=checkbox]").not("#checkAll").each(function() {
            this.checked=!this.checked;
        });
	});
	$(".delbutton").click(function(){
		if($('input[type=checkbox]:not("#checkAll"):checked').length>0){
			$('#form').unbind('submit').submit();//renable submit
		}
	
	});
});
</script>

<?php echo "dsfsdf".$this->session->userdata('msg'); #endregion
if($this->session->userdata('msg')!=""){
	 
	?>
<script>
	$(document).ready(function(e) {
toastr.success("<?=$_SESSION['msg']?>");
});
</script>
<?php }?>
<script>
$(document).ready(function(e) {
$(".edit").click(function(e) {
var id = $(this).data("id");
var data={id:id};
			$.ajax({
				url: '<?php echo base_url("admin/services/check_view_branches") ?>',
                type: 'POST',
                data: data,				
                success: function( data ) {
                	if (data == "1") {
					// alert(data);
                		$(".code_actvation-"+id).html("<span class='label label-sm label-success'> مفعل</span>");
                	}
                	if (data == "0") {
                		$(".code_actvation-"+id).html("<span class='label label-sm label-danger'>غير مفعل</span>");
                	}
				}
         });
	});
});
</script>


</body>
</html>
