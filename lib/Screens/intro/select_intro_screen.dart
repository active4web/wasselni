import 'package:flutter/material.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:get/get.dart';
import 'package:wassalny/Components/CustomWidgets/CustomButton.dart';
import 'package:wassalny/Components/constants.dart';
import 'package:wassalny/Screens/intro/view.dart';
import 'package:wassalny/Screens/login/view.dart';
import 'package:wassalny/Screens/register/register.dart';


class SelectIntroScreen extends StatelessWidget {
  const SelectIntroScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return SafeArea(
      child: Scaffold(
        body: Padding(
          padding:  EdgeInsets.symmetric(horizontal: 20.0.w),
          child: Column(
            children: [
              SizedBox(height: 80.h,),
              Image.asset(appLogo,width: 200.w,),
              SizedBox(height: 100.h,),
              CustomButton(borderColor: Colors.white,label: "تسجيل الدخول",onTap: (){
                Get.to(Login());
              },),
              SizedBox(height: 20.h,),
              CustomButton(borderColor: Colors.white,label: "انشاء حساب",onTap: (){
                Get.to(Register());
              },),
              SizedBox(height: 20.h,),
              CustomButton(borderColor: Colors.white,label: "الدخول كزائر",onTap: (){
                Get.to(IntroScreen());
              },),
            ],
          ),
        ),
      ),
    );
  }
}
