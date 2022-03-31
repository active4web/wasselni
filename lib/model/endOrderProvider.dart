import 'package:dio/dio.dart' as Dio;
import 'package:flutter/material.dart';

import 'package:wassalny/Components/networkExeption.dart';
import 'package:wassalny/model/states_model.dart';
import 'package:wassalny/network/auth/dio.dart';

class EndOrderProvider with ChangeNotifier {
  String token;

  EndOrderProvider({
    this.token,
  });

  bool doneSub = false;
  Future<bool> subscribtion({
    String name,
    String language,
    String adress,
    String anotherAdress,
    String phone,
    double lat,
    double lng,
    int orderId,
    int stateId,
  }) async {
    try {
      Dio.Response response = await dio().post(
        'store/set_user_data',
        data: Dio.FormData.fromMap(
          {
            "key": 1234567890,
            "token_id": token,
            "fullname": name,
            "phone": phone,
            "lang": language,
            "id_order": orderId,
            "address": adress,
            "state_id": stateId,
            "anther_address": anotherAdress,
            "order_status": 1,
            "time_execution_request": DateTime.now(),
            'lat': lat,
            'long': lng,
          },
        ),
      );
      print(response);
      if (response.data['status'] == false) {
        throw HttpExeption(response.data['message']);
      } else if (response.data['status'] == true) {
        doneSub = true;
      }
      notifyListeners();
      return doneSub;
    } catch (e) {
      throw (e);
    }
  }

  Future<List<CityDetails>> getStates(String lang) async {
    try {
      Dio.Response response = await dio().post(
        'store/preperation_order_details',
        data: Dio.FormData.fromMap(
          {
            'key': 1234567890,
            'token_id': token,
            "lang": lang,
          },
        ),
      );
      print(response.data);
      return StatesModel.fromJson(response.data).result.cityDetails;
    } catch (err) {
      // ignore: unnecessary_brace_in_string_interps
      print(err);
      return err;
    }
  }
}
