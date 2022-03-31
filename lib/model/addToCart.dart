import 'package:dio/dio.dart' as Dio;
import 'package:flutter/material.dart';
import 'package:wassalny/network/auth/dio.dart';

class AddProductProvider with ChangeNotifier {
  String token;
  AddProductProvider({this.token});

  Future<void> addToCart(
    int id,
  ) async {
    try {
      Dio.Response response = await dio().post(
        '/store/add_product_to_cart',
        data: Dio.FormData.fromMap(
          {
            'key': 1234567890,
            'token_id': token,
            'id_product': id,
          },
        ),
      );
      print('${response.data} addedToCart');
    } catch (err) {
      // ignore: unnecessary_brace_in_string_interps
      print('${err}');
    }
  }
}
