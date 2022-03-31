import 'package:flutter/material.dart';
import 'package:get/get.dart';

import 'package:turkish/turkish.dart';
import 'package:wassalny/Components/CustomWidgets/CustomButton.dart';
import 'package:wassalny/Components/CustomWidgets/MyText.dart';
import 'package:wassalny/Components/CustomWidgets/appBar.dart';
import 'package:wassalny/Components/CustomWidgets/myColors.dart';
import 'package:wassalny/Screens/BattomBar/view.dart';

class Language extends StatefulWidget {
  @override
  _LanguageState createState() => _LanguageState();
}

class _LanguageState extends State<Language> {
  List cities = [
    {"name": "اللغة العربية", "id": 0},
    {"name": "English", "id": 1},
    {"name": "Türkçe", "id": 2}
  ];
  String city = Get.locale.languageCode == "ar"
      ? "اللغة العربية"
      : Get.locale.languageCode == 'en'
          ? "English"
          : "Türkçe";
  int cityId = Get.locale.languageCode == "ar"
      ? 0
      : Get.locale.languageCode == "en"
          ? 1
          : 0;

  Widget filter(Widget widget) => Container(
      height: 50,
      padding: EdgeInsets.symmetric(horizontal: 20),
      decoration: BoxDecoration(
        color: Colors.blue,
        borderRadius: BorderRadius.all(Radius.circular(30)),
        border: Border.all(color: Colors.blue, width: 2),
      ),
      child: widget);

  Widget searchContainer(Function onTap, String title) => InkWell(
      onTap: onTap,
      child: Row(children: [
        Expanded(
            child: Container(
          alignment: Alignment.center,
          padding: EdgeInsets.all(40),
          // height: 100,
          // width: 100,
          decoration:
              BoxDecoration(shape: BoxShape.circle, color: Colors.pinkAccent),
          child: MyText(
              alien: TextAlign.center,
              title: title,
              color: Colors.white,
              weight: FontWeight.bold),
        ))
      ]));
  @override
  Widget build(BuildContext context) {
    return Scaffold(
        appBar: titleAppBar(context, "lang".tr),
        body: WillPopScope(
          onWillPop: () => Get.offAll(BottomNavyView()),
          child: ListView(padding: EdgeInsets.all(20), children: [
            Padding(
                padding: const EdgeInsets.symmetric(horizontal: 60),
                child: Image.asset(
                  'assets/images/logo.png',
                  width: 100,
                )),
            SizedBox(height: 15),
            Row(children: [
              Expanded(
                  child: MyText(
                      alien: TextAlign.center,
                      title: turkish.toLowerCase("TextInLangScreen".tr),
                      weight: FontWeight.w500,
                      size: 25))
            ]),
            SizedBox(height: 20),
            SizedBox(height: 20),
            filter(InkWell(
                onTap: () => _modalBottomSheetMenu(context),
                child: Row(children: [
                  Expanded(
                      child: Text(
                          Get.locale.languageCode == "ar"
                              ? "اللغة العربية"
                              : Get.locale.languageCode == "en"
                                  ? "English"
                                  : 'Türkçe',
                          maxLines: 1,
                          overflow: TextOverflow.ellipsis,
                          style: TextStyle(
                              color: Colors.white,
                              fontWeight: FontWeight.bold,
                              fontSize: 17))),
                  Icon(Icons.keyboard_arrow_down, color: Colors.white, size: 30)
                ]))),
            SizedBox(height: 20),
            CustomButton(
                backgroundColor: Colors.blue,
                borderColor: Colors.blue,
                isShadow: 0,
                onTap: () {
                  Get.offAll(BottomNavyView());
                },
                textColor: Colors.white,
                label: "save".tr)
          ]),
        ));
  }

  void _modalBottomSheetMenu(BuildContext context) {
    showModalBottomSheet(
        shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.only(
                topLeft: Radius.circular(20), topRight: Radius.circular(20))),
        context: context,
        builder: (builder) {
          return StatefulBuilder(builder: (context, setState) {
            return citiesWidget(context);
          });
        });
  }

  Widget citiesWidget(BuildContext context) {
    return ListView(
      padding: EdgeInsets.all(15),
      children: [
        ListView.builder(
          itemCount: cities.length,
          shrinkWrap: true,
          itemBuilder: (context, index) {
            return InkWell(
              onTap: () {
                setState(() {});
                setState(() {
                  city = cities[index]['name'];
                  cityId = cities[index]['id'];
                });
                Get.updateLocale(city == 'اللغة العربية'
                    ? Locale('ar')
                    : city == 'English'
                        ? Locale('en')
                        : Locale('tr'));
                print(Get.locale.languageCode);
                // Navigator.pop(context);
              },
              child: Container(
                margin: EdgeInsets.symmetric(vertical: 5),
                child: Row(
                  children: [
                    Offstage(
                        offstage: city == cities[index]['name'] ? false : true,
                        child: Icon(Icons.check_circle, color: MyColors.green)),
                    SizedBox(width: 10),
                    Expanded(
                      child: Padding(
                        padding: EdgeInsets.only(bottom: 5),
                        child: MyText(
                          title: cities[index]['name'],
                          size: 18,
                          weight: FontWeight.bold,
                        ),
                      ),
                    )
                  ],
                ),
              ),
            );
          },
        ),
      ],
    );
  }
}
