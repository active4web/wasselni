import 'package:flutter/material.dart';
import 'package:get/get.dart';

import 'package:pin_code_fields/pin_code_fields.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:wassalny/Components/CustomWidgets/showdialog.dart';

import 'edit_password_screen.dart';

class OtpScreen extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    var pinController = TextEditingController();
    return Scaffold(
        body: Padding(
      padding: const EdgeInsets.all(15),
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Align(
            alignment: Alignment.center,
            child: Image.asset(
              "assets/images/logo.png",
            ),
          ),
          Align(
            alignment: Alignment.centerRight,
            child: Text(
              "من فضلك ادخل الكود",
            ),
          ),
          SizedBox(
            height: 20,
          ),
          Directionality(
            textDirection: TextDirection.ltr,
            child: PinCodeTextField(
              appContext: context,
              controller: pinController,
              obscureText: false,
              obscuringCharacter: '*',
              pinTheme: PinTheme(
                shape: PinCodeFieldShape.box,
                selectedColor: Colors.grey,
                activeColor: Colors.grey,
                inactiveColor: Colors.grey,
                borderRadius: BorderRadius.circular(5),
                fieldHeight: 40,
                fieldWidth: 40,
                activeFillColor: Colors.white,
              ),
              length: 8,
              onChanged: (String value) {},
              onSubmitted: (value) async {
                final preferences = await SharedPreferences.getInstance();
                if (preferences.getString("code") == pinController.text) {
                  Get.to(EditPassword());
                } else {
                  showErrorDaialog('Code is Wrong', context);
                }
              },
              onCompleted: (value) async {
                final preferences = await SharedPreferences.getInstance();
                if (preferences.getString("code") == pinController.text) {
                  Get.to(EditPassword());
                }
              },
            ),
          ),
        ],
      ),
    ));
  }
}
