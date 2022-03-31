import 'package:dio/dio.dart' as Dio;
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:wassalny/Components/networkExeption.dart';
import 'package:wassalny/network/auth/dio.dart';

class AddRatingProvider with ChangeNotifier {
  String token;
  AddRatingProvider({this.token});

  bool doneSentRate = false;
  Future<bool> addRate({int id, String rating, String comment}) async {
    try {
      Dio.Response response = await dio().post(
        'user_api/add_review',
        data: Dio.FormData.fromMap({
          "key": 1234567890,
          "token_id": token,
          "service_id": id,
          "lang": Get.locale.languageCode,
          "rating": rating,
          "comment": comment
        }),
      );
      print(response);
      if (response.data['status'] == false) {
        doneSentRate = false;
        throw HttpExeption(response.data['message']);
      }

      if (response.data['status'] == true) {
        doneSentRate = true;
      }
      notifyListeners();
      return doneSentRate;
    } catch (error) {
      throw (error);
    }
  }
}
