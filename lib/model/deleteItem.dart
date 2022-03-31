import 'package:dio/dio.dart' as Dio;
import 'package:flutter/material.dart';
import 'package:wassalny/network/auth/dio.dart';

class RemoveFromCartProvider with ChangeNotifier {
  String token;
  RemoveFromCartProvider({this.token});

  Future<void> removeProduct(
    int id,
  ) async {
    try {
      Dio.Response response = await dio().post(
        'store/delete_product_from_cart',
        data: Dio.FormData.fromMap(
          {
            'key': 1234567890,
            'token_id': token,
            'id_product': id,
          },
        ),
      );
      print(response.data);
    } catch (err) {
      // ignore: unnecessary_brace_in_string_interps
      print('${err}');
    }
  }
}
