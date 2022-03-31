import 'package:dio/dio.dart' as Dio;
import 'package:flutter/material.dart';
// To parse this JSON data, do
//
//     final cityDropDwon = cityDropDwonFromJson(jsonString);

// To parse this JSON data, do
//
//     final cityDropDwon = cityDropDwonFromJson(jsonString);

import 'dart:convert';

import 'package:wassalny/network/auth/dio.dart';

CityDropDwon cityDropDwonFromJson(String str) =>
    CityDropDwon.fromJson(json.decode(str));

String cityDropDwonToJson(CityDropDwon data) => json.encode(data.toJson());

class CityDropDwon {
  CityDropDwon({
    this.message,
    this.codenum,
    this.status,
    this.result,
  });

  String message;
  int codenum;
  bool status;
  Result result;

  factory CityDropDwon.fromJson(Map<String, dynamic> json) => CityDropDwon(
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
    this.listCountries,
  });

  List<ListCountry> listCountries;

  factory Result.fromJson(Map<String, dynamic> json) => Result(
        listCountries: List<ListCountry>.from(
            json["list_countries"].map((x) => ListCountry.fromJson(x))),
      );

  Map<String, dynamic> toJson() => {
        "list_countries":
            List<dynamic>.from(listCountries.map((x) => x.toJson())),
      };
}

class ListCountry {
  ListCountry({
    this.nameCountry,
    this.nameIcon,
    this.idCountry,
  });

  String nameCountry;
  String nameIcon;
  String idCountry;

  factory ListCountry.fromJson(Map<String, dynamic> json) => ListCountry(
        nameCountry: json["name_country"],
        nameIcon: json["name_icon"],
        idCountry: json["id_country"],
      );

  Map<String, dynamic> toJson() => {
        "name_country": nameCountry,
        "name_icon": nameIcon,
        "id_country": idCountry,
      };
}

class CityDropDownProvider with ChangeNotifier {
  List<ListCountry> list;
  Future<void> fetchAllCites(String lang) async {
    try {
      Dio.Response response = await dio().post(
        '/user_api/preparation_registeration',
        data: Dio.FormData.fromMap(
          {'key': 1234567890, "lang": lang},
        ),
      );
      print(response.data);
      list = cityDropDwonFromJson(response.toString()).result.listCountries;
      print(list[0].nameCountry);
    } catch (err) {
      // ignore: unnecessary_brace_in_string_interps
      print('${err}');
    }
  }
}
