// To parse this JSON data, do
//
//     final favouriteModel = favouriteModelFromJson(jsonString);

import 'dart:convert';

import 'package:dio/dio.dart' as Dio;
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:wassalny/network/auth/dio.dart';

FavouriteModel favouriteModelFromJson(String str) =>
    FavouriteModel.fromJson(json.decode(str));

String favouriteModelToJson(FavouriteModel data) => json.encode(data.toJson());

class FavouriteModel {
  FavouriteModel({
    this.message,
    this.errNum,
    this.status,
    this.total,
    this.result,
  });

  String message;
  int errNum;
  bool status;
  int total;
  Result result;

  factory FavouriteModel.fromJson(Map<String, dynamic> json) => FavouriteModel(
        message: json["message"],
        errNum: json["errNum"],
        status: json["status"],
        total: json["total"],
        result: Result.fromJson(json["result"]),
      );

  Map<String, dynamic> toJson() => {
        "message": message,
        "errNum": errNum,
        "status": status,
        "total": total,
        "result": result.toJson(),
      };
}

class Result {
  Result({
    this.allFavourites,
  });

  List<AllFavourite> allFavourites;

  factory Result.fromJson(Map<String, dynamic> json) => Result(
        allFavourites: List<AllFavourite>.from(
            json["all_favourites"].map((x) => AllFavourite.fromJson(x))),
      );

  Map<String, dynamic> toJson() => {
        "all_favourites":
            List<dynamic>.from(allFavourites.map((x) => x.toJson())),
      };
}

class AllFavourite {
  AllFavourite({
    this.favExit,
    this.totalRate,
    this.productImage,
    this.productName,
    this.phone,
    this.prodId,
    this.delivery,
  });

  int favExit;
  String totalRate;
  String productImage;
  String productName;
  String phone;
  int prodId;
  int delivery;

  factory AllFavourite.fromJson(Map<String, dynamic> json) => AllFavourite(
        favExit: json["fav_exit"],
        totalRate: json["total_rate"],
        productImage: json["product_image"],
        productName: json["product_name"],
        phone: json["phone"],
        prodId: json["prod_id"],
        delivery: json["delivery"],
      );

  Map<String, dynamic> toJson() => {
        "fav_exit": favExit,
        "total_rate": totalRate,
        "product_image": productImage,
        "product_name": productName,
        "phone": phone,
        "prod_id": prodId,
        "delivery": delivery,
      };
}

class FavouriteListProvider with ChangeNotifier {
  String token;
  FavouriteListProvider({this.token});

  // ignore: missing_return
  Future<List<AllFavourite>> fetchCart() async {
    try {
      Dio.Response response = await dio().post(
        'user_api/get_all_myfavorite',
        data: Dio.FormData.fromMap(
          {
            'key': 1234567890,
            'token_id': token,
            "lang": Get.locale.languageCode,
            'limit': 500,
            'page_number': 0
          },
        ),
      );
      print(response.data);
      return favouriteModelFromJson(response.toString()).result.allFavourites;
    } catch (err) {
      // ignore: unnecessary_brace_in_string_interps
      print('${err}');
    }
  }
}
