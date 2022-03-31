// To parse this JSON data, do
//
//     final minSirv =

import 'dart:convert';

import 'package:flutter/cupertino.dart';
import 'package:dio/dio.dart' as Dio;
import 'package:wassalny/network/auth/dio.dart';

// To parse this JSON data, do
//
//     final minSirv = minSirvFromJson(jsonString);

MinSirv minSirvFromJson(String str) => MinSirv.fromJson(json.decode(str));

String minSirvToJson(MinSirv data) => json.encode(data.toJson());

class MinSirv {
  MinSirv({
    this.message,
    this.codenum,
    this.status,
    this.total,
    this.result,
  });

  String message;
  int codenum;
  bool status;
  int total;
  Result result;

  factory MinSirv.fromJson(Map<String, dynamic> json) => MinSirv(
        message: json["message"],
        codenum: json["codenum"],
        status: json["status"],
        total: json["total"],
        result: Result.fromJson(json["result"]),
      );

  Map<String, dynamic> toJson() => {
        "message": message,
        "codenum": codenum,
        "status": status,
        "total": total,
        "result": result.toJson(),
      };
}

class Result {
  Result({
    this.allProductService,
  });

  List<AllProductService> allProductService;

  factory Result.fromJson(Map<String, dynamic> json) => Result(
        allProductService: List<AllProductService>.from(
            json["all_product_service"]
                .map((x) => AllProductService.fromJson(x))),
      );

  Map<String, dynamic> toJson() => {
        "all_product_service":
            List<dynamic>.from(allProductService.map((x) => x.toJson())),
      };
}

class AllProductService {
  AllProductService({
    this.name,
    this.id,
    this.description,
    this.image,
    this.oldPrice,
    this.newPrice,
  });

  String name;
  int id;
  String description;
  String image;
  String oldPrice;
  String newPrice;

  factory AllProductService.fromJson(Map<String, dynamic> json) =>
      AllProductService(
        name: json["name"],
        id: json["id"],
        description: json["description"],
        image: json["image"],
        oldPrice: json["old_price"],
        newPrice: json["new_price"],
      );

  Map<String, dynamic> toJson() => {
        "name": name,
        "id": id,
        "description": description,
        "image": image,
        "old_price": oldPrice,
        "new_price": newPrice,
      };
}

class AllMinProvider with ChangeNotifier {
  String token;
  String lang;
  int id;
  AllMinProvider({
    this.id,
    this.token,
    this.lang,
  });

  List<AllProductService> allminu = [];
  String image = '';
  Future<void> fetchAllMin(String language, int sirvId) async {
    try {
      Dio.Response response = await dio().post(
        'services/get_all_product_service',
        data: Dio.FormData.fromMap(
          {
            'key': 1234567890,
            'lang': language,
            'token_id': token,
            "limit": 100,
            "page_number": 0,
            "service_id": sirvId,
          },
        ),
      );
      print(response);
      allminu = minSirvFromJson(response.toString()).result.allProductService;
      for (var i = 0; i < allminu.length; i++) {
        image = allminu[i].image;
      }
    } catch (err) {
      // ignore: unnecessary_brace_in_string_interps
      print('${err} error from SirvMin list');

      throw (err);
    }
  }
}
