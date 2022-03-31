import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:provider/provider.dart';
import 'package:wassalny/Components/CustomWidgets/CustomButton.dart';
import 'package:wassalny/Components/CustomWidgets/MyText.dart';
import 'package:wassalny/Components/CustomWidgets/appBar.dart';
import 'package:wassalny/Components/CustomWidgets/customTextField.dart';
import 'package:wassalny/Components/CustomWidgets/myColors.dart';
import 'package:wassalny/Components/CustomWidgets/showdialog.dart';
import 'package:wassalny/Components/networkExeption.dart';
import 'package:wassalny/Screens/BattomBar/view.dart';
import 'package:wassalny/model/home.dart';
import 'package:wassalny/model/user.dart';
import 'package:wassalny/network/auth/auth.dart';

class Subscribe extends StatefulWidget {
  @override
  _SubscribeState createState() => _SubscribeState();
}

class _SubscribeState extends State<Subscribe> {
  String city;
  int cityId;
  User user = User();

  final GlobalKey<FormState> key = GlobalKey<FormState>();
  String lang = Get.locale.languageCode;

  Future<void> _submit() async {
    if (!key.currentState.validate()) {
      return;
    }
    key.currentState.save();
    showDaialogLoader(context);

    try {
      var done = await Provider.of<Auth>(context, listen: false)
          .subscribtion(user, lang);
      if(!done["status"]){
        Navigator.of(context).pop();
       Get.snackbar(done["message"], done["message"]);
      }
      else{
        Navigator.of(context).pop();
        Get.offAll(BottomNavyView());
      }
    } catch (e) {
      print(e);
      Navigator.of(context).pop();
      showErrorDaialog("NoInternet".tr, context);
    }
  }

  @override
  Widget build(BuildContext context) {
    List<AllCategories> allCategories =
        Provider.of<HomeLists>(context).allCategories;

    List<AllCategories> cities = allCategories;
    return Scaffold(
      appBar: titleAppBar(context, "SubscribeWithUs".tr),
      body: SingleChildScrollView(
        child: Container(
          padding: EdgeInsets.all(20),
          // height: MediaQuery.of(context).size.width * 1.9,
          child: Form(
            key: key,
            child: Column(
              children: [
                SizedBox(height: 10),
                Container(
                  padding: EdgeInsets.symmetric(horizontal: 17, vertical: 10),
                  height: 50,
                  decoration: BoxDecoration(
                    color: Colors.grey.withOpacity(.3),
                    borderRadius: BorderRadius.all(Radius.circular(8)),
                    // border: Border.all(color: Colors.blue, width: 2),
                  ),
                  child: InkWell(
                    onTap: () => showDialog(
                      context: context,
                      builder: (BuildContext context) {
                        return AlertDialog(
                          backgroundColor: Colors.blue[300],
                          content: citiesWidget(context, cities),
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.all(
                              Radius.circular(
                                20,
                              ),
                            ),
                          ),
                        );
                      },
                    ), //_modalBottomSheetMenu(context, cities),
                    child: Row(
                      children: [
                        Expanded(
                          child: Text(
                            city == null ? "categories".tr : city,
                            maxLines: 2,
                            overflow: TextOverflow.ellipsis,
                            style: TextStyle(
                                fontWeight: FontWeight.bold, fontSize: 17),
                          ),
                        ),
                        Icon(Icons.keyboard_arrow_down, size: 30)
                      ],
                    ),
                  ),
                ),
                SizedBox(height: 20),
                ProfileTextField(
                    onSaved: (val) {
                      user.subName = val;
                      user.subId = cityId;
                    },
                    validator: (val) {
                      if (val.isEmpty) {
                        return "Thisfieldisrequired".tr;
                      } else if (val.length <= 4) {
                        return "NameMust4Cracters".tr;
                      } else {
                        return null;
                      }
                    },
                    hint: "name".tr),
                SizedBox(height: 20),
                ProfileTextField(
                    onSaved: (val) {
                      user.subPhone = val;
                      user.subId = cityId;
                    },
                    validator: (val) {
                      if (val.isEmpty) {
                        return "Thisfieldisrequired".tr;
                      } else if (val.length <= 7) {
                        return "NumberValidation".tr;
                      } else {
                        return null;
                      }
                    },
                    hint: "phone".tr),
                SizedBox(height: 20),
                ProfileTextField(
                    onSaved: (val) {
                      user.subAdress = val;
                      user.subId = cityId;
                    },
                    validator: (val) {
                      if (val.isEmpty) {
                        return "Thisfieldisrequired".tr;
                      } else if (val.length <= 10) {
                        return "AdressValidationCracters".tr;
                      } else {
                        return null;
                      }
                    },
                    hint: "adress".tr),
                SizedBox(height: 20),
                ProfileTextField(
                    onSaved: (val) {
                      user.subdetails = val;
                      user.subId = cityId;
                    },
                    validator: (val) {
                      if (val.isEmpty) {
                        return "Thisfieldisrequired".tr;
                      } else if (val.length <= 10) {
                        return "DescriptionVal".tr;
                      } else {
                        return null;
                      }
                    },
                    hint: 'Details'.tr),
                SizedBox(
                  height: MediaQuery.of(context).size.height * 0.24,
                ),
                CustomButton(
                    backgroundColor: Colors.blue,
                    borderColor: Colors.blue,
                    isShadow: 1,
                    onTap: _submit,
                    textColor: Colors.white,
                    label: "subscribe".tr)
              ],
            ),
          ),
        ),
      ),
    );
  }

  // void _modalBottomSheetMenu(BuildContext context, List<AllCategory> cityyy) {
  //   showModalBottomSheet(
  //       shape: RoundedRectangleBorder(
  //         borderRadius: BorderRadius.only(
  //           topLeft: Radius.circular(20),
  //           topRight: Radius.circular(20),
  //         ),
  //       ),
  //       context: context,
  //       builder: (builder) {
  //         return StatefulBuilder(builder: (context, setState) {
  //           return citiesWidget(context, cityyy);
  //         });
  //       });
  // }

  Widget citiesWidget(BuildContext context, List<AllCategories> cities) {
    return Container(
      height: 300.0, // Change as per your requirement
      width: 300.0,
      child: ListView.builder(
        itemCount: cities.length,
        shrinkWrap: true,
        itemBuilder: (context, index) {
          return InkWell(
            onTap: () {
              setState(() {
                city = cities[index].categoryName;
                cityId = cities[index].catId;
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
                      offstage: city == cities[index].categoryName ? false : true,
                      child: Icon(Icons.check_circle, color: MyColors.green)),
                  // SizedBox(width: 10),
                  Expanded(
                    child: Padding(
                      padding: EdgeInsets.only(bottom: 5),
                      child: Center(
                        child: MyText(
                          title: cities[index].categoryName,
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
      ),
    );
  }
}
