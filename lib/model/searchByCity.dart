import 'package:flutter/cupertino.dart';
import 'package:dio/dio.dart' as Dio;

// To parse this JSON data, do
//
//     final searchC =

import 'dart:convert';

import 'package:wassalny/network/auth/dio.dart';

SearchC searchCFromJson(String str) => SearchC.fromJson(json.decode(str));

String searchCToJson(SearchC data) => json.encode(data.toJson());

class SearchC {
  SearchC({
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

  factory SearchC.fromJson(Map<String, dynamic> json) => SearchC(
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
    this.allProductsCC,
  });

  List<AllProductCC> allProductsCC;

  factory Result.fromJson(Map<String, dynamic> json) => Result(
        allProductsCC: List<AllProductCC>.from(
            json["all_products"].map((x) => AllProductCC.fromJson(x))),
      );

  Map<String, dynamic> toJson() => {
        "all_products":
            List<dynamic>.from(allProductsCC.map((x) => x.toJson())),
      };
}

class AllProductCC {
  AllProductCC({
    this.productImage,
    this.productName,
    this.phone,
    this.prodId,
    this.favExit,
    this.totalRate,
    this.delivery,
  });

  String productImage;
  String productName;
  String phone;
  int prodId;
  int delivery;
  String totalRate;
  int favExit;

  factory AllProductCC.fromJson(Map<String, dynamic> json) => AllProductCC(
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
        "prod_id": prodId,
        "total_rate": totalRate,
        "fav_exit": favExit,
        "delivery": delivery,
      };
}

class SearchCity with ChangeNotifier {
  String token;
  SearchCity({this.token});

  List<AllProductCC> searchName = [];
  bool doneSearching = false;

  Future<bool> fetchSearch(String name, int limt, int pageNumber, int catID,
      int city, int state, int searchType, String lang) async {
    print("$catID id");
    print('$city city');
    print("$state state");
    print("$searchType type");
    try {
      Dio.Response response = await dio().post(
        'user_api/get_search_city',
        data: Dio.FormData.fromMap(
          {
            'key': 1234567890,
            'token_id': token,
            'limit': limt,
            'page_number': pageNumber,
            // 'name': name,
            'state': state,
            'city': city,
            'cat_id': catID,
            'dep_type': searchType,
            'lang': lang
          },
        ),
      );
      searchName = searchCFromJson(response.toString()).result.allProductsCC;
      print(response);
      if (response.data['status'] == true) {
        doneSearching = true;
      }
      return doneSearching;
    } catch (err) {
      // ignore: unnecessary_brace_in_string_interps
      print('${err} error from offers list');
      throw (err);
    }
  }
}
