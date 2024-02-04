import 'package:flutter/material.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:wassalny/Components/CustomWidgets/MyText.dart';
import 'package:wassalny/Components/CustomWidgets/appBar.dart';

import '../../Components/constants.dart';

class Terms extends StatefulWidget {
  @override
  _TermsState createState() => _TermsState();
}

class _TermsState extends State<Terms> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
        appBar: AppBar(
          title: Text("الشروط و الأحكام"),
        ),
        body: ListView(padding: EdgeInsets.all(20), children: [
          SizedBox(height: 50.h),
          Padding(
              padding: const EdgeInsets.symmetric(horizontal: 60),
              child: Image.asset(appLogo)),
          SizedBox(height: 30.h),
          MyText(title: "الشروط و الأحكام", weight: FontWeight.w500, size: 25)
        ]));
  }
}
