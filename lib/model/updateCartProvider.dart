import 'package:dio/dio.dart' as Dio;
import 'package:flutter/material.dart';
import 'package:wassalny/network/auth/dio.dart';

class UpdateIndexOfCartProvider with ChangeNotifier {
  String token;
  UpdateIndexOfCartProvider({this.token});

  Future<void> updateIndex(
      {String lang, int idKey, int idOrder, int quantity}) async {
    Map<String, dynamic> map = {
      'key': 1234567890,
      'token_id': token,
      "lang": lang,
      "id_key": idKey,
      "id_order": idOrder,
      "quantity_new": quantity,
    };
    print(map);
    try {
      Dio.Response response = await dio().post(
        'store/update_order',
        data: Dio.FormData.fromMap(
          map,
        ),
      );
      print(response.data);
    } catch (err) {
      // ignore: unnecessary_brace_in_string_interps
      print('${err}');
    }
  }
}
