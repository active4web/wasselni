import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:get/get.dart';
import 'package:provider/provider.dart';
import 'package:wassalny/Components/CustomWidgets/CustomButton.dart';
import 'package:wassalny/Components/CustomWidgets/MyText.dart';
import 'package:wassalny/Components/CustomWidgets/appBar.dart';
import 'package:wassalny/Components/CustomWidgets/customTextField.dart';
import 'package:wassalny/Components/CustomWidgets/myColors.dart';
import 'package:wassalny/Components/CustomWidgets/showdialog.dart';
import 'package:wassalny/Screens/BattomBar/view.dart';
import 'package:wassalny/Screens/change_password_screen.dart';
import 'package:wassalny/Screens/login/view.dart';
import 'package:wassalny/Screens/register/county/list.dart';
import 'package:wassalny/model/user.dart';
import 'package:wassalny/network/auth/auth.dart';

class Profile extends StatefulWidget {
  @override
  _ProfileState createState() => _ProfileState();
}

class _ProfileState extends State<Profile> {
  final GlobalKey<FormState> key = GlobalKey<FormState>();
  bool loader = false;
  String lang = Get.locale?.languageCode??'';
  User user = User();
  String? city;
  String? cityId;
  String? name;
  String? phone;
  String? address;
  TextEditingController? nameController;
  TextEditingController? phoneController;
  TextEditingController? addressController;
  Future<void> getinfo() async {
    loader = true;
    try {
      await Provider.of<Auth>(context, listen: false).getUserInfo(lang);
      city = Provider.of<Auth>(context, listen: false).city;
      cityId = Provider.of<Auth>(context, listen: false).cityId;
      name = Provider.of<Auth>(context, listen: false).name;
      phone = Provider.of<Auth>(context, listen: false).phoneNumber;
      address = Provider.of<Auth>(context, listen: false).adress;
      nameController = TextEditingController(text: name);
      phoneController = TextEditingController(text: phone);
      addressController = TextEditingController(text: address);
      setState(() {
        loader = false;
      });
    } catch (error) {
      showErrorDaialog('No internet', context);
    }
  }

  Future<void> _submit() async {
    bool done = Provider.of<Auth>(context, listen: false).doneEdaite;
    if (!key.currentState!.validate()) {
      return;
    }
    key.currentState!.save();
    showDaialogLoader(context);

    // ignore: unused_element

    try {
      done = await Provider.of<Auth>(context, listen: false).edaitProfile(
        user, lang,
        // city,
        // cityId
      );
      Navigator.of(context).pop();
    } catch (e) {
      print(e);
      Navigator.of(context).pop();
      showErrorDaialog('No internet', context);
    }

    if (done) {
      // Navigator.of(context).pop();
      Get.to(
        BottomNavyView(),
      );
    }
  }

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

  @override
  void initState() {
    getinfo();
    future();
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    List<ListCountry>? list =
        Provider.of<CityDropDownProvider>(context, listen: false).list;

    return Scaffold(
      appBar: TitleAppBar(title: "Profile".tr),
      body: loader
          ? Center(
              child: CircularProgressIndicator(),
            )
          : SingleChildScrollView(
              child: Container(
                padding: EdgeInsets.all(20),
                // height: MediaQuery.of(context).size.width * 1.9,
                child: Form(
                  key: key,
                  child: Column(
                    children: [
                      SizedBox(height: 15),
                      ProfileTextField(
                        controller: nameController,
                        onSaved: (val) {
                          user.nameEdaite = val;
                          print(val);
                        },
                        onChanged: (val) {
                          user.nameEdaite = val;
                        },
                        validator: (val) {
                          if (val!.isEmpty) {
                            return "Thisfieldisrequired".tr;
                          } else if (val.length <= 4) {
                            return "NameMust4Cracters".tr;
                          } else {
                            return null;
                          }
                        },
                        hint: "name".tr,
                      ),
                      SizedBox(height: 20.h),
                      ProfileTextField(
                        controller: phoneController,
                        isEnabled: false,
                        onSaved: (val) {
                          user.phoneEdaite = val;
                        },
                        onChanged: (val) {
                          user.phoneEdaite = val;
                        },
                        validator: (val) {
                          if (val!.isEmpty) {
                            return 'هذا الحقل مطلوب';
                          } else if (val.length <= 7) {
                            return 'يجب ان يكون رقم الهاتف علي الاقل 7 ارقام';
                          } else {
                            return null;
                          }
                        },
                        hint: 'رقم التليفون',
                      ),
                      SizedBox(height: 20.h),
                      ProfileTextField(
                        controller: addressController,
                        onSaved: (val) {
                          user.adressEdaite = val;
                        },
                        onChanged: (val) {
                          user.adressEdaite = val;
                        },
                        validator: (val) {
                          if (val!.isEmpty) {
                            return "Thisfieldisrequired".tr;
                          } else if (val.length <= 10) {
                            return "AdressValidationCracters".tr;
                          } else {
                            return null;
                          }
                        },
                        hint: "adress".tr,
                      ),
                      SizedBox(height: 20.h),
                      Container(
                        height: 55,
                        padding: EdgeInsets.symmetric(horizontal: 20),
                        decoration: BoxDecoration(
                            borderRadius: BorderRadius.all(Radius.circular(10)),
                            color: Colors.grey.withOpacity(.3)),
                        child: InkWell(
                          onTap: () => showDialog(
                            context: context,
                            builder: (BuildContext context) {
                              return AlertDialog(
                                backgroundColor: Colors.blue[300],
                                content: Container(
                                  width:
                                      MediaQuery.of(context).size.width * 0.8,
                                  child: citiesWidget(
                                    context,
                                    list??[],
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
                                  child: Text(
                                      city == null ? "country".tr : city??'',
                                      maxLines: 1,
                                      overflow: TextOverflow.ellipsis,
                                      style: TextStyle(
                                          color: Colors.black,
                                          fontWeight: FontWeight.bold,
                                          fontSize: 17))),
                              Icon(Icons.keyboard_arrow_down,
                                  color: Colors.white, size: 30)
                            ],
                          ),
                        ),
                      ),
                      TextButton(
                          onPressed: () {
                            Get.to((() => ChangePasswordScreen()));
                          },
                          child: Text("changePassword".tr)),
                      TextButton(
                          onPressed: () async {
                            showCupertinoDialog(
                                context: context,
                                builder: (BuildContext context) {
                                  var currentLanguage =
                                      Localizations.localeOf(context);
                                  return CupertinoAlertDialog(
                                      title: Text(
                                        "ايقاف الحساب",
                                        style: TextStyle(
                                          fontFamily: "Cairo",
                                          fontSize: 13,
                                        ),
                                      ),
                                      content: Text(
                                          "هل انت متاكد من ايقاف الحساب ؟",
                                          style: TextStyle(
                                              fontFamily: "Cairo",
                                              fontSize: 13)),
                                      actions: <Widget>[
                                        CupertinoButton(
                                            onPressed: () =>
                                                Navigator.pop(context),
                                            child: Text(
                                                currentLanguage.languageCode ==
                                                        'ar'
                                                    ? "الغاء"
                                                    : "Cancel",
                                                style: TextStyle(
                                                    fontFamily: "Cairo",
                                                    fontSize: 13))),
                                        CupertinoButton(
                                            onPressed: () async {
                                              bool auth = Provider.of<Auth>(
                                                      context,
                                                      listen: false)
                                                  .deleteAccBool;
                                              showDaialogLoader(context);
                                              try {
                                                auth = await Provider.of<Auth>(
                                                        context,
                                                        listen: false)
                                                    .deleteAcc(
                                                        phoneNumber: phone);
                                                // ignore: unused_catch_clause
                                              } catch (error) {
                                                print(error);
                                                Navigator.of(context).pop();
                                                showErrorDaialog(
                                                    'No internet connection',
                                                    context);
                                              }
                                              if (auth) {
                                                Get.offAll((() => Login()));
                                              }
                                            },
                                            child: Text(
                                                currentLanguage.languageCode ==
                                                        'ar'
                                                    ? "ايقاف الحساب"
                                                    : "Delete Account",
                                                style: TextStyle(
                                                    fontFamily: "Cairo",
                                                    fontSize: 13)))
                                      ]);
                                });
                          },
                          child: Text("deleteAccount".tr)),
                      SizedBox(
                        height: MediaQuery.of(context).size.height * 0.1,
                      ),
                      CustomButton(
                          backgroundColor: Colors.blue,
                          borderColor: Colors.blue,
                          isShadow: 1,
                          onTap: () {
                            user.phoneEdaite = phoneController?.text;
                            user.nameEdaite = nameController?.text;
                            user.adressEdaite = addressController?.text;
                            _submit();
                          },
                          textColor: Colors.white,
                          label: "save".tr)
                    ],
                  ),
                ),
              ),
            ),
    );
  }

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
// TextEditingController _name = TextEditingController();
// TextEditingController _phone = TextEditingController();
// TextEditingController _address = TextEditingController();
