// To parse this JSON data, do
//
//     final searchCity =

import 'dart:convert';

import 'package:flutter/cupertino.dart';
import 'package:dio/dio.dart' as Dio;
import 'package:wassalny/network/auth/dio.dart';

SearchCity searchCityFromJson(String str) =>
    SearchCity.fromJson(json.decode(str));

String searchCityToJson(SearchCity data) => json.encode(data.toJson());

class SearchCity {
  SearchCity({
    this.message,
    this.codenum,
    this.status,
    this.result,
  });

  String message;
  int codenum;
  bool status;
  Result result;

  factory SearchCity.fromJson(Map<String, dynamic> json) => SearchCity(
        message: json["message"],
        codenum: json["codenum"],
        status: json["status"],
        result: Result.fromJson(json["result"]),
      );

  Map<String, dynamic> toJson() => {
        "message": message,
        "codenum": codenum,
        "status": status,
        "result": result.toJson(),
      };
}

class Result {
  Result({
    this.allStates,
  });

  List<AllState> allStates;

  factory Result.fromJson(Map<String, dynamic> json) => Result(
        allStates: List<AllState>.from(
            json["all_states"].map((x) => AllState.fromJson(x))),
      );

  Map<String, dynamic> toJson() => {
        "all_states": List<dynamic>.from(allStates.map((x) => x.toJson())),
      };
}

class AllState {
  AllState({
    this.stateName,
    this.stateId,
    this.allCities,
  });

  String stateName;
  int stateId;
  List<AllCity> allCities;

  factory AllState.fromJson(Map<String, dynamic> json) => AllState(
        stateName: json["state_name"],
        stateId: json["state_id"],
        allCities: List<AllCity>.from(
            json["all_cities"].map((x) => AllCity.fromJson(x))),
      );

  Map<String, dynamic> toJson() => {
        "state_name": stateName,
        "state_id": stateId,
        "all_cities": List<dynamic>.from(allCities.map((x) => x.toJson())),
      };
}

class AllCity {
  AllCity({
    this.cityName,
    this.cityId,
  });

  String cityName;
  int cityId;

  factory AllCity.fromJson(Map<String, dynamic> json) => AllCity(
        cityName: json["city_name"],
        cityId: json["city_id"],
      );

  Map<String, dynamic> toJson() => {
        "city_name": cityName,
        "city_id": cityId,
      };
}

class SearchStatesProvider with ChangeNotifier {
  String token;
  SearchStatesProvider({
    this.token,
  });

  List<AllState> states = [];
  Future<void> fetchAllOffers(String language) async {
    try {
      Dio.Response response = await dio().post(
        'user_api/preparation_search',
        data: Dio.FormData.fromMap(
          {'key': 1234567890, 'lang': language, 'token_id': token},
        ),
      );
      print(response);
      states = searchCityFromJson(response.toString()).result.allStates;
    } catch (err) {
      // ignore: unnecessary_brace_in_string_interps
      print('${err} error from Search');
    }
  }
}
