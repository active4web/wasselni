
<script>
$(document).ready(function(){
$(".agentbutton").click(function(){
$(".mainbutton").attr("disabled", "disabled");
var name=$("#name").val();
var phone=$("#phone").val();
var email=$("#email").val();

if(name==""){
    toastr.error("من فضلك ادخل الاسم صحيح"); 
    $(".mainbutton").prop('disabled', false); 
    idname=1;
}
if(phone==""){
    toastr.error("من فضلك ادخل رقم التليفون "); 
    $(".mainbutton").prop('disabled', false);
    idphone=1;
}

if(email==""){
    toastr.error("البريد الألكترونى مطلوب"); 
    $(".mainbutton").prop('disabled', false); 
    idcity=1;
}


var service_type=$("#service_type").val();
if(service_type==1){
  var url= "<?= base_url()?>admin/agents/agent_action";
  }
else   if(service_type==2){
var url= "<?= base_url()?>admin/agents/edit_action"; 
  }
var form=$("#form");
var data=form.serialize();
    
  if(email!=""&&phone!=""&&email!=""){

$.ajax({
        type:"POST",
        url:url,
       data:data,
    success: function(response){
//alert(response);
     if(response==1){
        if(service_type==1){
            $(":input").val('');
        }
        toastr.success("تم تسجيل البيانات بنجاح"); 
        $(".mainbutton").prop('disabled', false);
     }
     
          if(response==2){
        toastr.success("نأسف,رقم التليفون موجود سابقا"); 
        $(".mainbutton").prop('disabled', false);
     }
     
          if(response==3){
        toastr.success("نأسف البريد الألكترونى موجود سابقا"); 
        $(".mainbutton").prop('disabled', false);
     }
        }

    });
  }

});
});
</script>
<!--State Function to add ot update-->
<script>
$(document).ready(function(){
$(".statebutton").click(function(){
$(".mainbutton").attr("disabled", "disabled");
var title=$("#title").val();
var title_en=$("#title_en").val();

if(title==""){
    toastr.error("من فضلك حدد اسم المحافظة"); 
    $(".mainbutton").prop('disabled', false); 
    idname=1;
}
if(title_en==""){
    toastr.error("Please enter title of state"); 
    $(".mainbutton").prop('disabled', false);
    idphone=1;
}



var service_type=$("#service_type").val();
if(service_type==1){
  var url= "<?= base_url()?>admin/places/state_action";
  }
else   if(service_type==2){
var url= "<?= base_url()?>admin/places/state_edit_action"; 
  }
var form=$("#myForm");
var data=form.serialize();
    
  if(title_en!=""&&title!=""){

$.ajax({
        type:"POST",
        url:url,
       data:data,
    success: function(response){
//alert(response);
     if(response==1){
        if(service_type==1){
            $(":input").val('');
        }
        toastr.success("تم تسجيل البيانات بنجاح"); 
        $(".mainbutton").prop('disabled', false);
     }

        }

    });
  }

});
});
</script>
<!--End Function of State-->


<!--Cities Function to add ot update-->
<script>
$(document).ready(function(){
$(".citybutton").click(function(){
$(".mainbutton").attr("disabled", "disabled");
var title=$("#title").val();
var title_en=$("#title_en").val();

if(title==""){
    toastr.error("من فضلك حدد المنطقة"); 
    $(".mainbutton").prop('disabled', false); 
    idname=1;
}
if(title_en==""){
    toastr.error("Please enter title of city"); 
    $(".mainbutton").prop('disabled', false);
    idphone=1;
}



var service_type=$("#service_type").val();
if(service_type==1){
  var url= "<?= base_url()?>admin/places/city_action";
  }
else   if(service_type==2){
var url= "<?= base_url()?>admin/places/edit_city_action"; 
  }
var form=$("#myForm");
var data=form.serialize();
    
  if(title_en!=""&&title!=""){

$.ajax({
        type:"POST",
        url:url,
       data:data,
    success: function(response){

     if(response==1){
        if(service_type==1){
            $(":input").val('');
        }
        toastr.success("تم تسجيل البيانات بنجاح"); 
        $(".mainbutton").prop('disabled', false);
     }

        }

    });
  }

});
});
</script>
<!--End Function of Cities-->




<!--Cities Function to add ot update-->
<script>
$(document).ready(function(){
$(".categorybutton").click(function(){
$(".mainbutton").attr("disabled", "disabled");
var title=$("#title").val();
var title_en=$("#title_en").val();

if(title==""){
    toastr.error("من فضلك حدد اسم القسم الرئيسى"); 
    $(".mainbutton").prop('disabled', false); 
}
if(title_en==""){
    toastr.error("Please enter title of departmetn"); 
    $(".mainbutton").prop('disabled', false);
}



var service_type=$("#service_type").val();
if(service_type==1){
  var url= "<?= base_url()?>admin/products/category_action";
  }
else   if(service_type==2){
var url= "<?= base_url()?>admin/products/edit_category_action"; 
  }
var formData = new FormData(data);
var form = $('#form')[0];
var data = new FormData(form);
    
  if(title_en!=""&&title!=""){

$.ajax({
        type:"POST",
        enctype: 'multipart/form-data',
        url:url,
        data:data,
         processData: false,
            contentType: false,
            cache: false,
    success: function(response){
//alert(response);
     if(response==1){
        if(service_type==1){
            $(":input").val('');
        }
        toastr.success("تم تسجيل البيانات بنجاح"); 
        $(".mainbutton").prop('disabled', false);
     }

        }

    });
  }

});
});
</script>
<!--End Function of Cities-->




<!--Cities Function to add ot update-->
<script>
$(document).ready(function(){
$(".departmentbutton").click(function(){
$(".mainbutton").attr("disabled", "disabled");
var title=$("#title").val();
var title_en=$("#title_en").val();

if(title==""){
    toastr.error("من فضلك حدد اسم القسم الرئيسى"); 
    $(".mainbutton").prop('disabled', false); 
}
if(title_en==""){
    toastr.error("Please enter title of departmetn"); 
    $(".mainbutton").prop('disabled', false);
}



var service_type=$("#service_type").val();
if(service_type==1){
  var url= "<?= base_url()?>admin/products/departments_action";
  }
else   if(service_type==2){
var url= "<?= base_url()?>admin/products/edit_departments_action"; 
  }


var formData = new FormData(data);
var form = $('#form')[0];
var data = new FormData(form);

  if(title_en!=""&&title!=""){

$.ajax({
         type:"POST",
        enctype: 'multipart/form-data',
        url:url,
        data:data,
         processData: false,
            contentType: false,
            cache: false,
    success: function(response){
//alert(response);
     if(response==1){
        if(service_type==1){
            $(":input").val('');
        }
        toastr.success("تم تسجيل البيانات بنجاح"); 
        $(".mainbutton").prop('disabled', false);
     }

        }

    });
  }

});
});
</script>
<!--End Function of Cities-->
