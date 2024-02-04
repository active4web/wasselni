// To parse this JSON data, do
//
//     final searchLagAndlat =
import 'dart:convert';

import 'package:flutter/cupertino.dart';
import 'package:dio/dio.dart' as Dio;
import 'package:wassalny/network/auth/dio.dart';

SearchLagAndlat searchLagAndlatFromJson(String str) =>
    SearchLagAndlat.fromJson(json.decode(str));

String searchLagAndlatToJson(SearchLagAndlat data) =>
    json.encode(data.toJson());

class SearchLagAndlat {
  SearchLagAndlat({
    this.message,
    this.codenum,
    this.status,
    this.total,
    this.result,
  });

  String? message;
  int? codenum;
  bool? status;
  int? total;
  Result? result;

  factory SearchLagAndlat.fromJson(Map<String, dynamic> json) =>
      SearchLagAndlat(
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
        "result": result?.toJson(),
      };
}

class Result {
  Result({
    this.allProducts,
  });

  List<AllProduct>? allProducts;

  factory Result.fromJson(Map<String, dynamic> json) => Result(
        allProducts: List<AllProduct>.from(
            json["all_products"].map((x) => AllProduct.fromJson(x))),
      );

  Map<String, dynamic> toJson() => {
        "all_products": List<dynamic>.from(allProducts!.map((x) => x.toJson())),
      };
}

class AllProduct {
  AllProduct({
    this.productImage,
    this.productName,
    this.phone,
    this.favExit,
    this.totalRate,
    this.prodId,
    this.delivery,
  });

  String? productImage;
  String? productName;
  int? favExit;
  String? totalRate;
  String? phone;
  int? prodId;
  int? delivery;

  factory AllProduct.fromJson(Map<String, dynamic> json) => AllProduct(
        productImage: json["product_image"],
        productName: json["product_name"],
        phone: json["phone"],
        prodId: json["prod_id"],
        favExit: json["fav_exit"],
        totalRate: json["total_rate"],
        delivery: json["delivery"],
      );

  Map<String, dynamic> toJson() => {
        "product_image": productImage,
        "product_name": productName,
        "phone": phone,
        "fav_exit": favExit,
        "total_rate": totalRate,
        "prod_id": prodId,
        "delivery": delivery,
      };
}

class SearchLatAndLagProvider with ChangeNotifier {
  String? token;
  SearchLatAndLagProvider({this.token});

  List<AllProduct> searchLatAndLag = [];
  bool doneSearching = false;
  Future<bool> fetchSearch(
      {int? catId,
      int? limt,
      int? pageNumber,
      double? lat,
      double? lag,
      String? distance,
      int? searchType,
      String? lang}) async {
    print(lat);
    print(lag);
    print(catId);
    print(searchType);

    try {
      Dio.Response response = await dio().post(
        'user_api/get_search_lat_lag',
        data: Dio.FormData.fromMap(
          {
            'key': 1234567890,
            'token_id': token,
            'limit': limt,
            'page_number': pageNumber,
            'cat_id': catId,
            'lat': lat,
            'lag': lag,
            "dep_type": searchType,
            "distance": distance,
            "lang": lang
          },
        ),
      );
      print(response);
      if (response.data['status'] == true) {
        searchLatAndLag =
            searchLagAndlatFromJson(response.toString()).result?.allProducts??[];
        doneSearching = true;
      }
      return doneSearching;
    } catch (err) {
      // ignore: unnecessary_brace_in_string_interps
      print('${err} error from searchLat list');
      throw (err);
    }
  }

  Future<bool> fetchFilerSearch(
      {int? catId,
      int? limt,
      int? pageNumber,
      double? lat,
      double? lag,
      int? searchType,
      int? city,
      int? state,
      String? lang}) async {
    print(lat);
    print(lag);
    print(catId);
    print(searchType);

    try {
      Dio.Response response = await dio().post(
        'user_api/get_search_lat_lag_filter',
        data: Dio.FormData.fromMap(
          {
            'key': 1234567890,
            'token_id': token,
            'limit': limt,
            'page_number': pageNumber,
            'cat_id': catId,
            'lat': lat,
            'lag': lag,
            "city": city,
            "state": state,
            "dep_type": searchType,
            "lang": lang
          },
        ),
      );
      print(response);
      if (response.data['status'] == true) {
        searchLatAndLag =
            searchLagAndlatFromJson(response.toString()).result?.allProducts??[];
        doneSearching = true;
      }
      return doneSearching;
    } catch (err) {
      // ignore: unnecessary_brace_in_string_interps
      print('${err} error from searchLat list');
      throw (err);
    }
  }
}
