import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:get/get.dart';
import 'package:provider/provider.dart';
import 'package:wassalny/Components/CustomWidgets/CustomButton.dart';
import 'package:wassalny/Components/CustomWidgets/customTextField.dart';
import 'package:wassalny/Components/CustomWidgets/showdialog.dart';
import 'package:wassalny/Components/constants.dart';
import 'package:wassalny/Screens/BattomBar/view.dart';

import 'package:wassalny/network/auth/auth.dart';


class ChangePasswordScreen extends StatefulWidget {
  @override
  State<ChangePasswordScreen> createState() => _ChangePasswordScreenState();
}

class _ChangePasswordScreenState extends State<ChangePasswordScreen> {
  var oldPassword = TextEditingController();
  var phone = TextEditingController();
  var newPassword = TextEditingController();
  var confirmNewPassword = TextEditingController();
  final _formKey = GlobalKey<FormState>();
  String lang = Get.locale?.languageCode??"ar";

  IconData icon = Icons.visibility;
  IconData icon2 = Icons.visibility;

  bool isPassword = true;
  bool confirmPassword = true;

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Form(
        key: _formKey,
        child: Directionality(
          textDirection: TextDirection.rtl,
          child: Padding(
            padding: const EdgeInsets.all(20),
            child: ListView(
              children: [
                Align(
                  alignment: Alignment.center,
                  child: Image.asset(
                    appLogo,
                    width: 80,
                  ),
                ),
                SizedBox(
                  height: 20,
                ),
                // CustomTextField(
                //     controller: phone,
                //     hint: "phoneNumber".tr,
                //     type: TextInputType.phone),
                // SizedBox(
                //   height: 10,
                // ),
                CustomTextField(
                    controller: oldPassword,
                    hint: "oldPassword".tr,
                    inputFormatters: <TextInputFormatter>[
                      FilteringTextInputFormatter.allow(RegExp('[a-z A-Z 0-9]'))
                    ],
                    valid: ( value){
                      if(value!.isEmpty){
                        return "يجب ادخال كلمة السر القديمة";
                      }return null;
                    },
                    type: TextInputType.visiblePassword),
                SizedBox(
                  height: 10,
                ),
                CustomTextField(
                    controller: newPassword,
                    hint: "newPassword".tr,
                    suffixIcon: icon,
                    isPassword: isPassword,
                    inputFormatters: <TextInputFormatter>[
                      FilteringTextInputFormatter.allow(RegExp('[a-z A-Z 0-9]'))
                    ],
                    valid: (  value){
                               if(value!.isEmpty){
                                 return "يجب ادخال كلمة السر الجديدة";
                               }return null;
                    },
                    suffixPress: () {
                      isPassword = !isPassword;
                      isPassword
                          ? icon = Icons.visibility
                          : icon = Icons.visibility_off_outlined;
                      setState(() {});
                    },
                    type: TextInputType.visiblePassword),
                SizedBox(
                  height: 10,
                ),
                CustomTextField(
                    controller: confirmNewPassword,
                    hint: "confirmNewPassword".tr,
                    suffixIcon: icon2,
                    isPassword: confirmPassword,
                    suffixPress: () {
                      confirmPassword = !confirmPassword;
                      confirmPassword
                          ? icon2 = Icons.visibility
                          : icon2 = Icons.visibility_off_outlined;
                      setState(() {});
                    },
                    valid: (  value){
                      if(confirmNewPassword.text != newPassword.text) {
                        return " كلمة السر لا تطابق";
                      }
                      return null;
                    },
                    inputFormatters: <TextInputFormatter>[
                      FilteringTextInputFormatter.allow(RegExp('[a-z A-Z 0-9]'))
                    ],
                    type: TextInputType.visiblePassword),
                SizedBox(
                  height: 10,
                ),
                CustomButton(
                    backgroundColor: Colors.blue,
                    borderColor: Colors.blue,
                    isShadow: 1,
                    onTap: () async {
                     if(_formKey.currentState!.validate()){

                       try {
                         var auth = await Provider.of<Auth>(context, listen: false)
                             .updatePassword(
                             oldPassword: oldPassword.text,
                             password: newPassword.text,
                             confirmPassword: confirmNewPassword.text);
                         if (auth["status"]) {
                           Get.snackbar(
                             "تم تغيير بنجاح",
                             "تم تغيير بنجاح",
                             titleText: Text(
                               auth["message"],
                               textDirection: lang == 'ar' ? TextDirection.rtl : TextDirection.ltr,
                               style: TextStyle(
                                 color: Colors.black,
                                 fontWeight: FontWeight.bold,
                                 fontSize: 20,
                               ),
                             ),
                             // messageText: Text(
                             //   auth["message"],
                             //   textDirection: lang == 'ar' ? TextDirection.rtl : TextDirection.ltr,
                             //   style: TextStyle(
                             //     color: Colors.black,
                             //     fontWeight: FontWeight.bold,
                             //     fontSize: 18,
                             //   ),
                             // ),
                           );
                           Get.offAll(BottomNavyView());
                         }else{
                           Get.snackbar(
                             "تاكد من البيانات",
                             "تاكد من البيانات",
                             titleText: Text(
                               auth["message"],
                               textDirection: lang == 'ar' ? TextDirection.rtl : TextDirection.ltr,
                               style: TextStyle(
                                 color: Colors.black,
                                 fontWeight: FontWeight.bold,
                                 fontSize: 20,
                               ),
                             ),
                             // messageText: Text(
                             //   auth["message"],
                             //   textDirection: lang == 'ar' ? TextDirection.rtl : TextDirection.ltr,
                             //   style: TextStyle(
                             //     color: Colors.black,
                             //     fontWeight: FontWeight.bold,
                             //     fontSize: 18,
                             //   ),
                             // ),
                           );
                         }
                         // ignore: unused_catch_clause
                       } catch (error) {
                         showErrorDaialog('No internet connection', context);
                       }

                     }
                    },
                    textColor: Colors.white,
                    label: 'changePassword'.tr),
              ],
            ),
          ),
        ),
      ),
    );
  }
}
