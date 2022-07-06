import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';
import 'package:get/get.dart';
import 'package:provider/provider.dart';
import 'package:wassalny/Components/CustomWidgets/CustomButton.dart';
import 'package:wassalny/Components/CustomWidgets/MyText.dart';
import 'package:wassalny/Components/CustomWidgets/customTextField.dart';
import 'package:wassalny/Components/CustomWidgets/myColors.dart';
import 'package:wassalny/Components/CustomWidgets/showdialog.dart';
import 'package:wassalny/Components/networkExeption.dart';
import 'package:wassalny/Screens/BattomBar/view.dart';
import 'package:wassalny/Screens/login/view.dart';
import 'package:wassalny/model/user.dart';
import 'package:wassalny/network/auth/auth.dart';

import 'county/list.dart';

class Register extends StatefulWidget {
  @override
  _RegisterState createState() => _RegisterState();
}

class _RegisterState extends State<Register> {
  Widget dropList() {
    return InkWell(
      // onTap: () => languageWidget(context),
      child: Container(
        height: 55,
        padding: EdgeInsets.symmetric(horizontal: 20),
        decoration: BoxDecoration(
          borderRadius: BorderRadius.all(Radius.circular(30)),
          border: Border.all(color: Colors.blue, width: 2),
        ),
        child: Row(
          children: [
            Expanded(
              child: MyText(
                  title: "ChoseLang".tr,
                  weight: FontWeight.bold,
                  color: Colors.red,
                  size: 17),
            ),
            Icon(
              Icons.keyboard_arrow_down,
              size: 30,
            )
          ],
        ),
      ),
    );
  }

  String lang = Get.locale.languageCode;
  bool isPassword = true;
  IconData icon = Icons.visibility;
  String city;
  String cityId;
  bool loader = false;
  Future<void> future() async {
    loader = true;
    try {
      await Provider.of<CityDropDownProvider>(context, listen: false)
          .fetchAllCites(lang);
      setState(() {
        loader = false;
      });
    } catch (error) {
      print(error);
      setState(() {
        loader = false;
      });
      throw (error);
    }
  }

  User user = User();
  final GlobalKey<FormState> key = GlobalKey<FormState>();

  Future<void> _submit() async {
    bool auth = Provider.of<Auth>(context, listen: false).doneSentRegister;

    if (!key.currentState.validate()) {
      return;
    }
    key.currentState.save();
    showDaialogLoader(context);
    try {
      auth = await Provider.of<Auth>(context, listen: false)
          .register(user, lang, cityId);
      Get.updateLocale(Locale(lang));
      // ignore: unused_catch_clause
    } on HttpExeption catch (error) {
      Navigator.of(context).pop();
      print(error);
      showErrorDaialog("FoundedUser".tr, context);
    } catch (error) {
      print(error);
      Navigator.of(context).pop();
      showErrorDaialog('NoInternet'.tr, context);
    } finally {
      if (auth) {
        Navigator.of(context).pop();
        Get.offAll(BottomNavyView());
      }
    }
  }

  @override
  void initState() {
    future();
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    print(lang);
    List<ListCountry> list =
        Provider.of<CityDropDownProvider>(context, listen: false).list;
    print(list);
    return Scaffold(
      body: Form(
        key: key,
        child: loader
            ? Center(child: CircularProgressIndicator())
            : ListView(
                padding: EdgeInsets.all(30),
                children: [
                  Align(
                    alignment: Alignment.topRight,
                    child: IconButton(
                      onPressed: () {
                        _modalBottomSheetMenu(context);
                      },
                      icon: Container(
                          width: 30,
                          height: 30,
                          decoration: BoxDecoration(
                              color: Colors.blue, shape: BoxShape.circle),
                          child: Icon(
                            FontAwesomeIcons.globe,
                            color: Colors.white,
                          )),
                    ),
                  ),
                  SizedBox(height: 50),
                  Padding(
                      padding: const EdgeInsets.symmetric(horizontal: 60),
                      child: Image.asset('assets/images/logo.png')),
                  SizedBox(height: 80),
                  // dropList(),
                  // SizedBox(height: 10),
                  CustomTextField(
                      onSaved: (val) {
                        user.newname = val;
                      },
                      valid: (val) {
                        if (val.isEmpty) {
                          return "Thisfieldisrequired".tr;
                        } else {
                          return null;
                        }
                      },
                      hint: "name".tr),
                  SizedBox(height: 10),
                  CustomTextField(
                      onSaved: (val) {
                        user.newphone = val;
                      },
                      inputFormatters: <TextInputFormatter>[
                        FilteringTextInputFormatter.allow(
                            RegExp('[a-z A-Z 0-9]'))
                      ],
                      valid: (val) {
                        if (val.isEmpty) {
                          return "Thisfieldisrequired".tr;
                        } else {
                          return null;
                        }
                      },
                      hint: "phoneNumber".tr,
                      textDirection: TextDirection.ltr,
                      type: TextInputType.phone),
                  SizedBox(height: 10),
                  CustomTextField(
                      onSaved: (val) {
                        user.newAdress = val;
                      },
                      valid: (val) {
                        if (val.isEmpty) {
                          return "Thisfieldisrequired".tr;
                        } else {
                          return null;
                        }
                      },
                      hint: "address".tr),
                  SizedBox(height: 10),
                  Container(
                    height: 55,
                    padding: EdgeInsets.symmetric(horizontal: 20),
                    decoration: BoxDecoration(
                      borderRadius: BorderRadius.all(Radius.circular(30)),
                      border: Border.all(color: Colors.blue, width: 2),
                    ),
                    child: InkWell(
                      onTap: () => showDialog(
                        context: context,
                        builder: (BuildContext context) {
                          return AlertDialog(
                            backgroundColor: Colors.blue[300],
                            content: Container(
                              width: MediaQuery.of(context).size.width * 0.8,
                              child: citiesWidget(
                                context,
                                list,
                              ),
                            ),
                            shape: RoundedRectangleBorder(
                              borderRadius: BorderRadius.all(
                                Radius.circular(
                                  20,
                                ),
                              ),
                            ),
                          );
                        },
                      ),
                      // _modalBottomSheetMenu(context, cities),
                      child: Row(
                        children: [
                          Expanded(
                              child: Text(city == null ? "country".tr : city,
                                  maxLines: 1,
                                  overflow: TextOverflow.ellipsis,
                                  style: TextStyle(
                                      color: Colors.red,
                                      fontWeight: FontWeight.bold,
                                      fontSize: 17))),
                          Icon(Icons.keyboard_arrow_down,
                              color: Colors.white, size: 30)
                        ],
                      ),
                    ),
                  ),
                  SizedBox(height: 10),
                  CustomTextField(
                      inputFormatters: <TextInputFormatter>[
                        FilteringTextInputFormatter.allow(
                            RegExp('[a-z A-Z 0-9]'))
                      ],
                      isPassword: isPassword,
                      suffixIcon: icon,
                      suffixPress: () {
                        isPassword = !isPassword;
                        isPassword
                            ? icon = Icons.visibility
                            : icon = Icons.visibility_off_outlined;
                        setState(() {});
                      },
                      onSaved: (val) {
                        print(val);
                        user.password = val;
                      },
                      valid: (val) {
                        if (val.isEmpty) {
                          return "Thisfieldisrequired".tr;
                        } else {
                          return null;
                        }
                      },
                      hint: "password".tr,
                      textDirection: TextDirection.ltr,
                      type: TextInputType.visiblePassword),
                  SizedBox(height: 50),
                  CustomButton(
                      backgroundColor: Colors.blue,
                      borderColor: Colors.blue,
                      isShadow: 1,
                      onTap: cityId == null
                          ? () => Get.snackbar('انتباه', 'يرجي اختيار الدوله')
                          : _submit,
                      textColor: Colors.white,
                      label: "login".tr),
                  InkWell(
                    onTap: () {
                      Get.to(
                        Login(),
                      );
                    },
                    child: Center(
                      child: Text(
                        "do you have account".tr,
                        style: TextStyle(
                            color: Colors.blue,
                            fontSize: 20,
                            decoration: TextDecoration.underline),
                      ),
                    ),
                  ),
                ],
              ),
      ),
    );
  }

  void _modalBottomSheetMenu(BuildContext context) {
    showMenu(
      context: context,
      position: RelativeRect.fill,
      items: [
        PopupMenuItem(
          child: InkWell(
            onTap: () {
              Get.updateLocale(Locale('ar'));
              lang = 'ar';
              Navigator.pop(context);
              setState(() {});
            },
            child: Container(
              padding: EdgeInsets.all(15),
              child: Row(
                children: [
                  Expanded(
                      child: MyText(
                          title: "اللغة العربية", weight: FontWeight.bold)),
                  Offstage(
                    offstage: Get.locale.languageCode == 'ar' ? false : true,
                    child: Icon(Icons.check_circle, color: MyColors.primary),
                  ),
                ],
              ),
            ),
          ),
        ),
        PopupMenuItem(
          child: InkWell(
            onTap: () {
              Get.updateLocale(Locale('tr'));
              lang = 'tr';

              Navigator.pop(context);
              setState(() {});
            },
            child: Container(
              padding: EdgeInsets.all(15),
              child: Row(
                children: [
                  Expanded(
                      child: MyText(title: "Türkçe", weight: FontWeight.bold)),
                  Offstage(
                    offstage: Get.locale.languageCode == 'tr' ? false : true,
                    child: Icon(Icons.check_circle, color: MyColors.primary),
                  ),
                ],
              ),
            ),
          ),
        ),
        PopupMenuItem(
          child: InkWell(
            onTap: () {
              Get.updateLocale(
                Locale('en'),
              );
              lang = 'en';

              Navigator.pop(context);

              setState(() {});
            },
            child: Row(
              children: [
                Expanded(
                  child: MyText(title: "English", weight: FontWeight.bold),
                ),
                Offstage(
                  offstage: Get.locale.languageCode == 'en' ? false : true,
                  child: Icon(Icons.check_circle, color: MyColors.primary),
                )
              ],
            ),
          ),
        ),
      ],
    ).then((value) {
      print('lld');
      future();
    });
  }

  // Widget languageWidget(BuildContext context) {
  //   return Container(
  //     height: MediaQuery.of(context).size.width * .65,
  //     margin: EdgeInsets.only(top: 0),
  //     padding: EdgeInsets.fromLTRB(15, 15, 15, 15),
  //     decoration: BoxDecoration(
  //         color: Colors.white,
  //         borderRadius: BorderRadius.only(
  //             topLeft: Radius.circular(20), topRight: Radius.circular(20))),
  //     child: Column(
  //       children: [
  //         InkWell(
  //           onTap: () {
  //             Get.updateLocale(Locale('ar'));
  //             lang = 'ar';
  //             Navigator.pop(context);
  //             setState(() {});
  //           },
  //           child: Container(
  //             padding: EdgeInsets.all(15),
  //             child: Row(
  //               children: [
  //                 Expanded(
  //                     child: MyText(
  //                         title: "اللغة العربية", weight: FontWeight.bold)),
  //                 Offstage(
  //                   offstage: Get.locale.languageCode == 'ar' ? false : true,
  //                   child: Icon(Icons.check_circle, color: MyColors.primary),
  //                 ),
  //               ],
  //             ),
  //           ),
  //         ),
  //         Divider(
  //           thickness: 1,
  //           color: MyColors.primary.withOpacity(.3),
  //         ),
  //         InkWell(
  //           onTap: () {
  //             Get.updateLocale(Locale('tr'));
  //             lang = 'tr';
  //
  //             Navigator.pop(context);
  //             setState(() {});
  //           },
  //           child: Container(
  //             padding: EdgeInsets.all(15),
  //             child: Row(
  //               children: [
  //                 Expanded(
  //                     child: MyText(title: "Türkçe", weight: FontWeight.bold)),
  //                 Offstage(
  //                   offstage: Get.locale.languageCode == 'tr' ? false : true,
  //                   child: Icon(Icons.check_circle, color: MyColors.primary),
  //                 ),
  //               ],
  //             ),
  //           ),
  //         ),
  //         Divider(
  //           thickness: 1,
  //           color: MyColors.primary.withOpacity(.3),
  //         ),
  //         Container(
  //           padding: EdgeInsets.all(15),
  //           child: InkWell(
  //             onTap: () {
  //               // Get.updateLocale(
  //               //   Locale('en'),
  //               // );
  //               lang = 'en';
  //
  //               Navigator.pop(context);
  //
  //               setState(
  //                 () {},
  //               );
  //             },
  //             child: Row(
  //               children: [
  //                 Expanded(
  //                   child: MyText(title: "English", weight: FontWeight.bold),
  //                 ),
  //                 Offstage(
  //                   offstage: Get.locale.languageCode == 'en' ? false : true,
  //                   child: Icon(Icons.check_circle, color: MyColors.primary),
  //                 )
  //               ],
  //             ),
  //           ),
  //         ),
  //       ],
  //     ),
  //   );
  // }

  Widget citiesWidget(BuildContext context, List<ListCountry> cities) {
    return ListView.builder(
      itemCount: cities.length,
      shrinkWrap: true,
      itemBuilder: (context, index) {
        return InkWell(
          onTap: () {
            setState(() {
              city = cities[index].nameCountry;
              cityId = cities[index].idCountry;
            });
            Navigator.pop(context);
          },
          child: Container(
            padding: EdgeInsets.all(5),
            decoration: BoxDecoration(
              color: Colors.blue[800],
              borderRadius: BorderRadius.circular(10),
            ),
            margin: EdgeInsets.symmetric(vertical: 5),
            child: Row(
              crossAxisAlignment: CrossAxisAlignment.center,
              children: [
                Offstage(
                    offstage: city == cities[index].nameCountry ? false : true,
                    child: Icon(Icons.check_circle, color: MyColors.green)),
                // SizedBox(width: 10),
                Expanded(
                  child: Padding(
                    padding: EdgeInsets.only(bottom: 5),
                    child: Center(
                      child: MyText(
                        title: cities[index].nameCountry,
                        size: 18,
                        weight: FontWeight.bold,
                        color: Colors.white,
                      ),
                    ),
                  ),
                ),
              ],
            ),
          ),
        );
      },
    );
  }
}
