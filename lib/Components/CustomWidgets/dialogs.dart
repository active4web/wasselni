import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';

import 'MyText.dart';
import 'myColors.dart';

Future<bool> displayLogoutDialog(
  BuildContext context,
  String title,
  String body,
) async {
  var currentLanguage = Localizations.localeOf(context);
  return showCupertinoDialog(
      context: context,
      builder: (BuildContext context) {
        return CupertinoAlertDialog(
            title: Text(
              title,
              style: TextStyle(
                fontFamily: "Cairo",
                fontSize: 13,
              ),
            ),
            content:
                Text(body, style: TextStyle(fontFamily: "Cairo", fontSize: 13)),
            actions: <Widget>[
              CupertinoButton(
                  onPressed: () => Navigator.of(context).pop(false),
                  child: Text(
                      currentLanguage.languageCode == 'ar' ? "الغاء" : "Cancel",
                      style: TextStyle(fontFamily: "Cairo", fontSize: 13))),
              CupertinoButton(
                  onPressed: () {
                    Navigator.of(context).pop(true);
                  },
                  child: Text(
                      currentLanguage.languageCode == 'ar'
                          ? "اغلاق التطبيق"
                          : "Exit",
                      style: TextStyle(fontFamily: "Cairo", fontSize: 13)))
            ]);
      });
}

Future modalBottomSheetMenu(BuildContext context) {
  return showModalBottomSheet(
      backgroundColor: Colors.transparent,
      context: context,
      builder: (builder) {
        return StatefulBuilder(builder: (context, setState) {
          return LanguageWidget();
        });
      });
}

class LanguageWidget extends StatefulWidget {
  @override
  _LanguageWidgetState createState() => _LanguageWidgetState();
}

class _LanguageWidgetState extends State<LanguageWidget> {
  @override
  Widget build(BuildContext context) {
    var currentLanguage = Localizations.localeOf(context);
    return Stack(children: [
      Container(
          height: 180,
          margin: EdgeInsets.only(top: 30),
          padding: EdgeInsets.fromLTRB(15, 50, 15, 15),
          decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.only(
                  topLeft: Radius.circular(20), topRight: Radius.circular(20))),
          child: Column(children: [
            InkWell(
                onTap: () {
                  setState(() {});
                },
                child: Row(children: [
                  Image.asset('assets/images/saFlag.png'),
                  SizedBox(width: 10),
                  Expanded(
                      child: Padding(
                          padding: const EdgeInsets.only(top: 8),
                          child: MyText(
                              title: "اللغة العربية",
                              weight: FontWeight.bold))),
                  Offstage(
                      offstage:
                          currentLanguage.languageCode == 'ar' ? false : true,
                      child: Icon(Icons.check_circle, color: MyColors.primary)),
                ])),
            SizedBox(height: 15),
            Divider(thickness: 1, color: MyColors.primary.withOpacity(.3)),
            SizedBox(height: 15),
            InkWell(
                onTap: () {
                  setState(() {});
                },
                child: Row(children: [
                  Image.asset('assets/images/usFlag.png'),
                  SizedBox(width: 10),
                  Expanded(
                      child: Padding(
                          padding: const EdgeInsets.only(top: 8),
                          child: MyText(
                              title: "English", weight: FontWeight.bold))),
                  Offstage(
                      offstage:
                          currentLanguage.languageCode == 'en' ? false : true,
                      child: Icon(Icons.check_circle, color: MyColors.primary))
                ]))
          ])),
      Row(mainAxisAlignment: MainAxisAlignment.center, children: [
        Container(
            padding: EdgeInsets.all(20),
            decoration:
                BoxDecoration(color: MyColors.primary, shape: BoxShape.circle),
            child: Icon(Icons.brightness_1, color: Colors.white))
      ])
    ]);
  }
}
