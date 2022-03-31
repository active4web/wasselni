import 'dart:ui';

import 'package:flutter/material.dart';

//e6e9e9 grey
class MyColors {
  static final primary = Color.fromRGBO(0, 114, 184, 1);
  static const lightBlue = Color.fromRGBO(67, 179, 255, 1);
  static const orange = Color.fromRGBO(245, 115, 18, 1);
  static const blue = Color.fromRGBO(25, 142, 207, 1);
  static const green = Color.fromRGBO(0, 197, 26, 1);
  static const lightGrey = Color.fromRGBO(235, 235, 235, 1);
  // static const lightGrey = Color.fromRGBO(240, 240, 240, 1);
  static const grey = Color.fromRGBO(112, 112, 112, 1);
  static const rose = Color(0xffFCB55626);
  static const text = Color.fromRGBO(60, 60, 60, 1);
  static var move = Color(0xff89168B);
  static var greyText = Color.fromRGBO(199, 199, 199, 1);
}

int getColorHexFromStr(String colorStr) {
  colorStr = "FF" + colorStr;
  colorStr = colorStr.replaceAll("#", "");
  int val = 0;
  int len = colorStr.length;
  for (int i = 0; i < len; i++) {
    int hexDigit = colorStr.codeUnitAt(i);
    if (hexDigit >= 48 && hexDigit <= 57) {
      val += (hexDigit - 48) * (1 << (4 * (len - 1 - i)));
    } else if (hexDigit >= 65 && hexDigit <= 70) {
      val += (hexDigit - 55) * (1 << (4 * (len - 1 - i)));
    } else if (hexDigit >= 97 && hexDigit <= 102) {
      val += (hexDigit - 87) * (1 << (4 * (len - 1 - i)));
    } else {
      throw new FormatException("An error occurred when converting a color");
    }
  }
  return val;
}
