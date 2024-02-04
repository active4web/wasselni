import 'package:dio/dio.dart' as Dio;
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:wassalny/Components/networkExeption.dart';
import 'package:wassalny/network/auth/dio.dart';

class UpdateFavProvider with ChangeNotifier {
  String? token;
  UpdateFavProvider({this.token});

  bool doneSenting = false;
  Future<bool> updateFav({int? id, String? key}) async {
    try {
      Dio.Response response = await dio().post(
        'user_api/update_myfavorite',
        data: Dio.FormData.fromMap({
          "key": 1234567890,
          "token_id": token,
          "service_id": id,
          "lang": Get.locale?.languageCode,
          "id_key": key
        }),
      );
      print(response);
      if (response.data['status'] == false) {
        doneSenting = false;
        throw HttpExeption(response.data['message']);
      }

      if (response.data['status'] == true) {
        doneSenting = true;
      }
      notifyListeners();
      return doneSenting;
    } catch (error) {
      throw (error);
    }
  }
}
