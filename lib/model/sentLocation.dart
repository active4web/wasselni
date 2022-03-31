import 'package:dio/dio.dart' as Dio;
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:wassalny/Components/networkExeption.dart';
import 'package:wassalny/network/auth/dio.dart';

class SentLocationgProvider with ChangeNotifier {
  String token;
  SentLocationgProvider({this.token});

  bool doneSentLocation = false;
  Future<bool> sentLocationgProvider({int id, String lat, String lag}) async {
    try {
      Dio.Response response = await dio().post(
        'user_api/send_location',
        data: Dio.FormData.fromMap({
          "key": 1234567890,
          "token_id": token,
          "service_id": id,
          "lang": Get.locale.languageCode,
          "lag": lag,
          "lat": lat,
        }),
      );
      print(response);
      if (response.data['status'] == false) {
        doneSentLocation = false;
        throw HttpExeption(response.data['message']);
      }

      if (response.data['status'] == true) {
        doneSentLocation = true;
      }
      notifyListeners();
      return doneSentLocation;
    } catch (error) {
      throw (error);
    }
  }
}
