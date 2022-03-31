import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:get/get.dart';
import 'package:get/get_utils/src/extensions/internacionalization.dart';
import 'package:provider/provider.dart';
import 'package:wassalny/Components/CustomWidgets/CustomButton.dart';
import 'package:wassalny/Components/CustomWidgets/customTextField.dart';
import 'package:wassalny/Components/CustomWidgets/showdialog.dart';
import 'package:wassalny/network/auth/auth.dart';
import 'otp_screen.dart';

class ForgetPasswordScreen extends StatelessWidget {
  var phoneNumber = TextEditingController();
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Directionality(
        textDirection: TextDirection.rtl,
        child: Padding(
          padding: const EdgeInsets.all(20),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.center,
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Image.asset(
                "assets/images/logo.png",
              ),
              SizedBox(
                height: 20,
              ),
              Padding(
                padding: const EdgeInsets.all(20),
                child: CustomTextField(
                    controller: phoneNumber,
                    hint: "الهاتف",
                    inputFormatters: <TextInputFormatter>[
                      FilteringTextInputFormatter.allow(RegExp('[a-z A-Z 0-9]'))
                    ],
                    type: TextInputType.phone),
              ),
              CustomButton(
                  backgroundColor: Colors.blue,
                  borderColor: Colors.blue,
                  isShadow: 1,
                  onTap: () async {
                    bool auth =
                        Provider.of<Auth>(context, listen: false).sendCode;
                    showDaialogLoader(context);
                    try {
                      auth = await Provider.of<Auth>(context, listen: false)
                          .forgetPassword(phoneNumber.text);
                    } catch (error) {
                      print(error);
                      Navigator.of(context).pop();
                      showErrorDaialog('No internet connection', context);
                    } finally {}
                    if (auth) {
                      Get.to(OtpScreen());
                    }
                  },
                  textColor: Colors.white,
                  label: 'send'.tr),
            ],
          ),
        ),
      ),
    );
  }
}
