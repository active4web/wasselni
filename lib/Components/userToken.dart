import 'dart:convert';

import 'package:get/get.dart';
import 'package:shared_preferences/shared_preferences.dart';

Future<Map<String, dynamic>> headersMap() async {
  SharedPreferences preferences = await SharedPreferences.getInstance();
  Map<String, dynamic> headersData = {
    'Authorization': "Bearer ${jsonDecode(preferences.get("token"))}",
    "Lang": Get.locale,
    "Accept": "application/json"
  };
  // print("token: headers ${jsonDecode(preferences.get("token"))}");
  return headersData;
}

Future<Map<String, dynamic>> headersMapWithoutToken() async {
  Map<String, dynamic> headersData = {
    // 'Authorization': preferences.getString("token"),
    "lang": Get.locale,
    // "Content-Type":"application/json"
    "accept": "application/json"
  };
  return headersData;
}
