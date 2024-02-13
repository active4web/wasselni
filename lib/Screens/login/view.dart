import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:get/get.dart';
import 'package:provider/provider.dart';
import 'package:wassalny/Components/CustomWidgets/CustomButton.dart';
import 'package:wassalny/Components/CustomWidgets/MyText.dart';
import 'package:wassalny/Components/CustomWidgets/customTextField.dart';
import 'package:wassalny/Components/CustomWidgets/myColors.dart';
import 'package:wassalny/Components/CustomWidgets/showdialog.dart';
import 'package:wassalny/Components/constants.dart';
import 'package:wassalny/Components/networkExeption.dart';
import 'package:wassalny/Screens/BattomBar/view.dart';
import 'package:wassalny/Screens/forget_password/forget_password_screen.dart';
import 'package:wassalny/Screens/intro/view.dart';
import 'package:wassalny/Screens/register/register.dart';
import 'package:wassalny/model/user.dart';
import 'package:wassalny/network/auth/auth.dart';

class Login extends StatefulWidget {
  @override
  _LoginState createState() => _LoginState();
}

class _LoginState extends State<Login> {
  TextEditingController _phone = TextEditingController();
  TextEditingController _Password = TextEditingController();

  User user = User();
  String? language;
  bool isPassword = true;
  IconData icon = Icons.visibility;

  Widget dropList() {
    return InkWell(
      onTap: () => _modalBottomSheetMenu(context),
      child: Container(
        height: 55,
        padding: EdgeInsets.symmetric(horizontal: 20),
        decoration: BoxDecoration(
          borderRadius: BorderRadius.all(Radius.circular(30)),
          border: Border.all(color: Colors.blue, width: 2),
        ),
        child: Row(
          children: [
            MyText(
                title: "اختيار اللغة",
                weight: FontWeight.bold,
                color: Colors.red,
                size: 17),
            Icon(
              Icons.keyboard_arrow_down,
              size: 30,
            )
          ],
        ),
      ),
    );
  }

  Future<void> _submit() async {
    user.phone = _phone.text;
    user.oldPassword = _Password.text;
    showDaialogLoader(context);
    try {
     var auth = await Provider.of<Auth>(context, listen: false).signIn(user);
      if(auth["status"]){
        Get.offAll(IntroScreen());
      }else{
        Navigator.pop(context);
        showErrorDaialog(auth["message"], context);
      }
      // ignore: unused_catch_clause
    } catch (error) {
      print(error);
      Navigator.of(context).pop();
      showErrorDaialog('No internet connection', context);
    }

  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: ListView(
        padding: EdgeInsets.all(30.r),
        children: [
          SizedBox(height: 50.h),
          Image.asset(appLogo,width: 150.w,height: 150.h,),
          SizedBox(height: 70.h),
          // CustomTextField(controller: _name, hint: 'name'.tr),
          CustomTextField(
              controller: _phone,
              hint: "phoneNumber".tr,
              valid: ( value){
                if(value!.isEmpty){
                  return "ادخل رقم الجوال";
                }
                return "";
              },
              inputFormatters: <TextInputFormatter>[
                FilteringTextInputFormatter.allow(RegExp('[a-z A-Z 0-9]'))
              ],
              textDirection: TextDirection.ltr,
              type: TextInputType.phone),
          SizedBox(height: 10),
          CustomTextField(
              controller: _Password,
              hint: "password".tr,
              isPassword: isPassword,
              suffixIcon: icon,
              suffixPress: () {
                isPassword = !isPassword;
                isPassword
                    ? icon = Icons.visibility
                    : icon = Icons.visibility_off_outlined;
                setState(() {});
              },
              valid: ( value){
                if(value!.isEmpty){
                  return "ادخل كلمة السر";
                }
                return "";
              },
              inputFormatters: <TextInputFormatter>[
                FilteringTextInputFormatter.allow(RegExp('[a-z A-Z 0-9]'))
              ],
              textDirection: TextDirection.ltr,
              type: TextInputType.visiblePassword),
          // CustomTextField(controller: _address, hint: 'العنوان'),
          // SizedBox(height: 10),
          // dropList(),
          SizedBox(height: 20.h),
          CustomButton(
              backgroundColor: Colors.blue,
              borderColor: Colors.blue,
              isShadow: 1,
              onTap: _submit,
              textColor: Colors.white,
              label: 'login'.tr),
          SizedBox(
            height: 30.h,
          ),
          Center(
            child: TextButton(
              onPressed: () {
                Get.to(ForgetPasswordScreen());
              },
              child: Text(
                "forgetPassword".tr,
                style: TextStyle(
                    fontWeight: FontWeight.bold,
                    fontSize: 22,
                    color: Colors.red,
                    fontFamily: 'GE-Snd-Book'),
              ),
            ),
          ),
          InkWell(
            onTap: () {
              Get.to(
                Register(),
              );
            },
            child: Center(
              child: Text(
                "signUp".tr,
                style: TextStyle(
                    color: Colors.blue,
                    fontSize: 20,
                    decoration: TextDecoration.underline),
              ),
            ),
          ),
          SizedBox(
            height: 10.h,
          ),
          InkWell(
            onTap: () {
              Get.to(
                IntroScreen(),
              );
            },
            child: Center(
              child: Text(
                "الدخول كزائر".tr,
                style: TextStyle(
                    color: Colors.blue,
                    fontSize: 20.sp,
                    decoration: TextDecoration.underline),
              ),
            ),
          ),
        ],
      ),
    );
  }

  void _modalBottomSheetMenu(BuildContext context) {
    showModalBottomSheet(
        backgroundColor: Colors.transparent,
        context: context,
        builder: (builder) {
          return StatefulBuilder(builder: (context, setState) {
            return languageWidget(context);
          });
        });
  }

  Widget languageWidget(BuildContext context) {
    return Container(
      height: MediaQuery.of(context).size.width * .45,
      margin: EdgeInsets.only(top: 0),
      padding: EdgeInsets.fromLTRB(15, 15, 15, 15),
      decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.only(
              topLeft: Radius.circular(20), topRight: Radius.circular(20))),
      child: Column(
        children: [
          InkWell(
              onTap: () {
                Get.updateLocale(Locale('ar'));
                Navigator.pop(context);
                setState(() {});
              },
              child: Container(
                padding: EdgeInsets.all(15),
                child: Row(children: [
                  Expanded(
                      child: MyText(
                          title: "اللغة العربية", weight: FontWeight.bold)),
                  Offstage(
                      offstage: Get.locale?.languageCode == 'ar' ? false : true,
                      child: Icon(Icons.check_circle, color: MyColors.primary)),
                ]),
              )),
          Divider(thickness: 1, color: MyColors.primary.withOpacity(.3)),
          Container(
            padding: EdgeInsets.all(15),
            child: InkWell(
              onTap: () {
                Get.updateLocale(Locale('en'));
                Navigator.pop(context);
                setState(() {});
              },
              child: Row(
                children: [
                  Expanded(
                      child: MyText(title: "English", weight: FontWeight.bold)),
                  Offstage(
                      offstage: Get.locale?.languageCode == 'en' ? false : true,
                      child: Icon(Icons.check_circle, color: MyColors.primary))
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }
}
