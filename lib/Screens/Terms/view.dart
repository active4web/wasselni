import 'package:flutter/material.dart';
import 'package:wassalny/Components/CustomWidgets/MyText.dart';
import 'package:wassalny/Components/CustomWidgets/appBar.dart';

class Terms extends StatefulWidget {
  @override
  _TermsState createState() => _TermsState();
}

class _TermsState extends State<Terms> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
        appBar: titleAppBar(context, "الشروط و الأحكام"),
        body: ListView(padding: EdgeInsets.all(20), children: [
          SizedBox(height: 50),
          Padding(
              padding: const EdgeInsets.symmetric(horizontal: 60),
              child: Image.asset('assets/images/logo.png')),
          SizedBox(height: 30),
          MyText(title: "الشروط و الأحكام", weight: FontWeight.w500, size: 25)
        ]));
  }
}
