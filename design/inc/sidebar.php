<?php
$reply_counts=$this->db->get_where("tickets",array("status_id"=>'0',"sender_type"=>'0'))->result();
$vendor_tickets=$this->db->get_where("tickets",array("status_id"=>'0',"sender_type"=>'1'))->result();

?>

        <!-- BEGIN SIDEBAR -->
                <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                <div class="page-sidebar navbar-collapse collapse">
                    <!-- BEGIN SIDEBAR MENU -->
                    <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                    <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                    <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                    <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                    <li class="nav-item start <?php if($curt=='home'){echo'active open';}?>">
                        <a href="<?=$url;?>admin" class="nav-link ">
                            <i class="icon-home"></i>
                                        <span class="title">الرئيسية</span>
                                        <span class="selected"></span>
                                    </a>
                    </li>
                
<li class="nav-item start <?php if($curt=='setting'){echo'active open';}?>">
<a href="<?=$url;?>admin/setting" class="nav-link ">
<i class="icon-settings"></i>
<span class="title">الاعدادات</span>
<span class="selected"></span></a></li>



<li class="nav-item  <?php if($curt=='homepage'){echo'active open';}?>">

<a href="<?=base_url()?>admin/slider_home" class="nav-link ">
    <i class="fa fa-photo"></i>
<span class="title">البنرات الرئيسية</span>
</a>
</li>
                      
<li class="nav-item start <?php if($curt=='agents'){echo'active open';}?>">
<a href="<?=$url;?>admin/agents" class="nav-link ">
<i class="icon-users"></i>
<span class="title">المندوبين</span>
<span class="selected"></span>
</a>
</li>


<li class="nav-item start <?php if($curt=='packages'){echo'active open';}?>">
<a href="<?=$url;?>admin/packages" class="nav-link ">
<i class="fa fa-clipboard"></i>
<span class="title">الباقات</span>
<span class="selected"></span>
</a>
</li>

				
<li class="nav-item start <?php if($curt=='terms'||$curt=='about_us'){echo'active open';}?>">
						<a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-info"></i>
								<span class="title">عن التطبيق</span>
                                <span class="arrow"></span>
                            </a>
				<ul class="sub-menu">
					    <li class="nav-item  <?php if($curt=='about_us'){echo'active open';}?>">
								<a href="<?=base_url()?>admin/about/vision" class="nav-link">
                                <i class="icon-note"></i>
									<span class="title">عن التطبيق</span>
								</a>
						</li>
						<li class="nav-item  <?php if($curt=='terms'){echo'active open';}?>">
							<a href="<?=base_url()?>admin/about/show" class="nav-link ">
                            <i class="icon-note"></i>
								<span class="title">الشروط والاحكام</span>
							</a>
						</li>
	                
               </ul>
 </li>
 
 
 
 <li class="nav-item start <?php if($curt=='country'||$curt=='state'||$curt=='cities'){echo'active open';}?>">
						<a href="javascript:;" class="nav-link nav-toggle">
                                <i class="fa fa-home"></i>
								<span class="title">الاماكن</span>
                                <span class="arrow"></span>
                            </a>
				<ul class="sub-menu">
					    
					    <li class="nav-item  <?php if($curt=='country'){echo'active open';}?>">
								<a href="<?=base_url()?>admin/places/countries" class="nav-link">
                                <i class="fa fa-home"></i>
									<span class="title">الدول</span>
								</a>
						</li>
						
					    <li class="nav-item  <?php if($curt=='state'){echo'active open';}?>">
								<a href="<?=base_url()?>admin/places/" class="nav-link">
                                <i class="fa fa-home"></i>
									<span class="title">المحافظات</span>
								</a>
						</li>
						<li class="nav-item  <?php if($curt=='cities'){echo'active open';}?>">
							<a href="<?=base_url()?>admin/places/cities" class="nav-link ">
                            <i class="fa fa-home"></i>
								<span class="title">المناطق</span>
							</a>
						</li>
	                    
               </ul>
 </li>

<li class="nav-link <?php if($curt=='category'){echo'active open';}?>">
<a href="<?=base_url()?>admin/products/" class="nav-link ">
<i class="fa fa-cubes"></i>
<span class="title">الأقسام الرئيسية</span>
</a>
</li>

<li class="nav-link <?php if($curt=='departments'){echo'active open';}?>">
<a href="<?=base_url()?>admin/products/departments" class="nav-link ">
<i class="fa fa-align-justify"></i>
<span class="title">الأقسام الفرعية</span>
</a>
</li>

<li class="nav-link <?php if($curt=='recommended'){echo'active open';}?>">
<a href="<?=base_url()?>admin/products/recommended" class="nav-link ">
<i class="fa fa-align-justify"></i>
<span class="title">الموصى بيى</span>
</a>
</li>

<li class="nav-link <?php if($curt=='services'){echo'active open';}?>">
<a href="<?=base_url()?>admin/services/" class="nav-link ">
<i class="fa fa-cart-arrow-down"></i>
<span class="title">مقدمى الخدمات</span>
</a>
</li>
 <li class="nav-link <?php if($curt=='photography_requests'){echo'active open';}?>">
<a href="<?=base_url()?>admin/products/photography_requests" class="nav-link ">
<i class="fa fa-cubes"></i>
<span class="title">طلبات التصوير</span>
</a>
</li>
<li class="nav-link <?php if($curt=='offers'){echo'active open';}?>">
<a href="<?=base_url()?>admin/offers/" class="nav-link ">
<i class="fa fa-cubes"></i>
<span class="title">العروض</span>
</a>
</li>
<li class="nav-link <?php if($curt=='clients'){echo'active open';}?>">
<a href="<?=base_url()?>admin/clients/customers" class="nav-link ">
<i class="icon-users"></i>
<span class="title">المستخدمين</span>
</a>
</li>		
						


                    <li class="nav-item start <?php if($curt=='tickets'){echo'active open';}?>">
						<a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-envelope"></i>
								<span class="title">الدعم الفنى </span>
							 <span style="color:red" class="ticket_nofiy"><? if(count($reply_counts)>0){echo "(".count($reply_counts).")"; };?></span>
                                <span class="arrow"></span>
                            </a>
							<ul class="sub-menu">

                              
							 <li class="nav-item  <?php if($curt=='tickets_types'){echo'active open';}?>">
                                    <a href="<?=base_url()?>admin/tickets_types/" class="nav-link ">
                                        <i class="icon-envelope"></i>
                                        <span class="title">انواع التذاكر</span>
                                    </a>
								</li>
								
                                <li class="nav-item  <?php if($curt=='tickets'){echo'active open';}?>">
                                    <a href="<?=base_url()?>admin/tickets/" class="nav-link ">
                                        <i class="icon-envelope"></i>
                                        <span class="title">تذاكر المستخدمين<span style="color:red" class="ticket_nofiy"><? if(count($reply_counts)>0){echo "(".count($reply_counts).")"; };?></span></span>
                                    </a>
								</li>
								
								 <li class="nav-item  <?php if($curt=='vendor_tickets'){echo'active open';}?>">
                                    <a href="<?=base_url()?>admin/tickets/vendor_tickets/" class="nav-link ">
                                        <i class="icon-envelope"></i>
                                        <span class="title">تذاكر مقدم الخدمه<span style="color:red" class="vendor_tickets"><? if(count($vendor_tickets)>0){echo "(".count($vendor_tickets).")"; };?></span></span>
                                    </a>
								</li>
							</ul>
                    </li>
                    
                     <li class="nav-item  <?php if($curt=='messages'){echo'active open';}?>">
                                    <a href="<?=base_url()?>admin/messages/requested_from" class="nav-link ">
                                        <i class="icon-envelope"></i>
                                        <span class="title">رسائل الاشتراك معانا</span>
                                    </a>
                                </li>
                                
       
                            </ul>
                        </li>
                        
                            </ul>
                        </li>
                    </ul>
                    <!-- END SIDEBAR MENU -->
                </div>
                <!-- END SIDEBAR -->
