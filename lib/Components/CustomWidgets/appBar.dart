import 'package:flutter/material.dart';

import 'myColors.dart';

Widget categoryAppBar(BuildContext context) {
  return AppBar(
      iconTheme: IconThemeData(color: Colors.blue),
      backgroundColor: Colors.transparent,
      elevation: 0,
      title: Image.asset('assets/images/logo.png', width: 50),
      centerTitle: true,
      automaticallyImplyLeading: true);
}

Widget titleAppBar(BuildContext context, String title) {
  return AppBar(
      iconTheme: IconThemeData(color: Colors.blue),
      backgroundColor: Colors.transparent,
      title: Text(
        title,
        style: TextStyle(color: MyColors.blue, fontWeight: FontWeight.bold),
      ),
      centerTitle: true,
      automaticallyImplyLeading: true);
}

Widget newAppBar(BuildContext context, String title) {
  return AppBar(
      elevation: 0,
      iconTheme: IconThemeData(color: Colors.blue),
      backgroundColor: Colors.white,
      title: Text(
        title,
        style: TextStyle(color: MyColors.blue, fontWeight: FontWeight.bold),
      ),
      centerTitle: true,
      automaticallyImplyLeading: true);
}
