<?php
$base_url=base_url();
$id_admin=$_SESSION['id_admin'];
$admin_name=$_SESSION['admin_name'];
$type_admin=$_SESSION['type_admin'];
$admins="compact";
$editor="compact";
$profil="compact";
if($type_admin==1){
    $admins="compact";
    $editor="compact";
    $profil="compact";
}
else if($type_admin==2){
    $admins="none";
    $editor="compact";
    $profil="none";
}
else if($type_admin==3){
    $admins="none";
    $editor="none";
    $profil="compact";
}
?>
            <div class="page-sidebar-wrapper">

<div class="page-sidebar navbar-collapse collapse">
                    <!-- BEGIN SIDEBAR MENU -->
                    <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                    <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                    <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                    <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <ul class="page-sidebar-menu   " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                        
                          <li class="nav-item start active open">
                                    <a href="<?php echo base_url()?>admin" class="nav-link ">
                                        <i class="icon-home"></i>
                                        <span class="title">Visit Website</span>
                                        <span class="selected"></span>
                                    </a>
                                </li>
                          <li class="nav-item start">
                                    <a href="<?php echo base_url()?>admin" class="nav-link ">
                                        <i class="icon-bar-chart"></i>
                                        <span class="title">Dashboard</span>
                                    <span class="badge badge-success">6</span>
                                    </a>
                                </li>

                        <li class="heading">
                            <h3 class="uppercase">Setting</h3>
                        </li>
                        <li class="nav-item  ">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-wrench"></i>
                                <span class="title">Site</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item  ">
                                    <a href="<?php echo base_url()?>admin/setting" class="nav-link ">
                                        <span class="title">Site setting</span>
                                    </a>
                                </li>
                                <li class="nav-item  ">
                                    <a href="<?php echo base_url()?>admin/slider_home" class="nav-link ">
                                        <span class="title">Slider</span>
                                    </a>
                                </li>
                                <li class="nav-item  ">
                                    <a href="<?php echo base_url()?>admin/header" class="nav-link ">
                                        <span class="title">Header Info</span>
                                    </a>
                                </li>
                                <li class="nav-item  ">
                                    <a href="<?php echo base_url()?>admin/footer_info" class="nav-link ">
                                        <span class="title">Footer Info</span>
                                    </a>
                                </li>
                                
                                <li class="nav-item  ">
                                    <a href="<?php echo base_url()?>admin/news_letter" class="nav-link ">
                                        <span class="title">NewsLetter</span>
                                    </a>
                                </li>
                                
                                
                               
                                <li class="nav-item  ">
                                    <a href="<?php echo base_url()?>admin/pages" class="nav-link ">
                                        <span class="title">Pages</span>
                                    </a>
                                </li>
                                
                            </ul>
                        </li>
                        <li class="nav-item  ">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-puzzle"></i>
                                <span class="title">Lisiting</span>
                                
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item  ">
                                    <a href="<?php echo base_url()?>admin/lisiting" class="nav-link ">
                                        <span class="title">Lisiting</span>
                                        <span class="badge badge-success">6</span>
                                    </a>
                                </li>
                                <li class="nav-item  ">
                                    <a href="<?php echo base_url()?>admin/porperty_type" class="nav-link ">
                                        <span class="title">Porperty type</span>
                                    </a>
                                </li>
                                <li class="nav-item  ">
                                    <a href="<?php echo base_url()?>admin/facilities" class="nav-link ">
                                        <span class="title">Porperty Facilities</span>
                                    </a>
                                </li>
                                <!--<li class="nav-item  ">
                                    <a href="<?php echo base_url()?>admin/interests" class="nav-link ">
                                        <span class="title">Porperty Interests</span>
                                    </a>
                                </li>-->
                              <li class="nav-item  ">
                                    <a href="<?php echo base_url()?>admin/amenities" class="nav-link ">
                                        <span class="title">Porperty Amenities</span>
                                    </a>
                                </li>
                                <li class="nav-item  ">
                                    <a href="<?php echo base_url()?>admin/rules" class="nav-link ">
                                        <span class="title">Porperty Rules</span>
                                    </a>
                                </li>
                                <!--<li class="nav-item  ">
                                    <a href="<?php echo base_url()?>admin/speaks" class="nav-link ">
                                        <span class="title">Porperty Speaks</span>
                                    </a>
                                </li>-->

                                <li class="nav-item  ">
                                    <a href="<?php echo base_url()?>admin/porperty_gallery" class="nav-link ">
                                        <span class="title">Porperty Gallery</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item  ">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-settings"></i>
                                <span class="title">Places</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item  ">
                                    <a href="<?php echo base_url()?>admin/country" class="nav-link ">
                                        <span class="title">Country</span>
                                    </a>
                                </li>
                                <li class="nav-item  ">
                                    <a href="<?php echo base_url()?>admin/state" class="nav-link ">
                                        <span class="title">State</span>
                                    </a>
                                </li>
                                <li class="nav-item  ">
                                    <a href="<?php echo base_url()?>admin/city" class="nav-link ">
                                        <span class="title">City</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item  ">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-user"></i>
                                <span class="title">User</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item  ">
                                    <a href="<?php echo base_url()?>admin/clients/type/?t=0" class="nav-link ">
                                        <span class="title">Owner</span>
                                    </a>
                                </li>
                                <li class="nav-item  ">
                                    <a href="<?php echo base_url()?>admin/clients/type/?t=1" class="nav-link ">
                                        <span class="title">Guest</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                       

                                <li class="nav-item">
                                    <a href="<?php echo base_url()?>admin/blog" class="nav-link ">
                                         <i class="icon-note"></i>
                                        <span class="title">Blog</span>
                                        <span class="badge badge-success">6</span>
                                    </a>
                                </li>

                        <li class="nav-item  ">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-basket"></i>
                                <span class="title">Reservation</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item  ">
                                    <a href="<?php echo base_url()?>admin/new_reservation" class="nav-link ">
                                        <span class="title">New Reservation</span>
                                           <span class="badge badge-success">6</span>
                                    </a>
                                </li>
                                <li class="nav-item  ">
                                    <a href="<?php echo base_url()?>admin/cancel_reservation" class="nav-link ">
                                        <span class="title">Cancel Reservation</span>
                                           <span class="badge badge-success">6</span>
                                    </a>
                                </li>
                                <li class="nav-item  ">
                                    <a href="<?php echo base_url()?>admin/accepted_reservation" class="nav-link ">
                                        <span class="title">Accepted Reservation</span>
                                           <span class="badge badge-success">6</span>
                                    </a>
                                </li>
                                <li class="nav-item  ">
                                    <a href="<?php echo base_url()?>admin/messages" class="nav-link ">
                                        <span class="title">Messages</span>
                                           <span class="badge badge-success">6</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        
                        <li class="heading">
                            <h3 class="uppercase">Contact</h3>
                        </li>
                       
                                <li class="nav-item  ">
                     <a href="<?php echo base_url()?>admin/contact" class="nav-link ">
                                        <i class="icon-envelope"></i>
                                        <span class="title">Contact</span>
                                           <span class="badge badge-success">6</span>
                                    </a>
                                </li>
                                <li class="heading">
                            <h3 class="uppercase">Options</h3>
                        </li>
                                <li class="nav-item">
                                    <a href="<?php echo base_url()?>admin/team_work" class="nav-link ">
                                        <i class="icon-users"></i>
                                        <span class="title">TeamWork</span>
                                    </a>
                                </li>

                                  <li class="nav-item">
                                    <a href="#" class="nav-link ">
                                        <i class="icon-bar-chart"></i>
                                        <span class="title">Statistics</span>
                                    </a>
                                </li>

                              <li class="nav-item">
                                    <a href="<?php echo base_url()?>admin/user_profile" class="nav-link ">
                                        <i class="icon-settings"></i>
                                        <span class="title">Profile</span>
                                    </a>
                                </li>
                                
                               
                        </li>
                    </ul>
                    <!-- END SIDEBAR MENU -->
                </div>
                <!-- END SIDEBAR -->
            </div>



