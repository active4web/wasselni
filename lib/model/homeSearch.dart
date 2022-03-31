// To parse this JSON data, do
//
//     final homeSearch =
import 'dart:convert';

import 'package:flutter/cupertino.dart';
import 'package:dio/dio.dart' as Dio;
import 'package:wassalny/network/auth/dio.dart';

HomeSearch homeSearchFromJson(String str) =>
    HomeSearch.fromJson(json.decode(str));

String homeSearchToJson(HomeSearch data) => json.encode(data.toJson());

class HomeSearch {
  HomeSearch({
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

  factory HomeSearch.fromJson(Map<String, dynamic> json) => HomeSearch(
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
    this.allProducts,
  });

  List<AllProductss> allProducts;

  factory Result.fromJson(Map<String, dynamic> json) => Result(
        allProducts: List<AllProductss>.from(
            json["all_products"].map((x) => AllProductss.fromJson(x))),
      );

  Map<String, dynamic> toJson() => {
        "all_products": List<dynamic>.from(allProducts.map((x) => x.toJson())),
      };
}

class AllProductss {
  AllProductss({
    this.productImage,
    this.productName,
    this.phone,
    this.prodId,
    this.delivery,
  });

  String productImage;
  String productName;
  String phone;
  int prodId;
  int delivery;

  factory AllProductss.fromJson(Map<String, dynamic> json) => AllProductss(
        productImage: json["product_image"],
        productName: json["product_name"],
        phone: json["phone"],
        prodId: json["prod_id"],
        delivery: json["delivery"],
      );

  Map<String, dynamic> toJson() => {
        "product_image": productImage,
        "product_name": productName,
        "phone": phone,
        "prod_id": prodId,
        "delivery": delivery,
      };
}

class SearchName with ChangeNotifier {
  String token;
  SearchName({this.token});

  List<AllProductss> searchName = [];
  bool doneSearching = false;
  Future<bool> fetchSearch(
      String name, int limt, int pageNumber, String lang) async {
    try {
      Dio.Response response = await dio().post(
        'user_api/get_search_name',
        data: Dio.FormData.fromMap(
          {
            'key': 1234567890,
            'token_id': token,
            'limit': limt,
            'page_number': pageNumber,
            'name': name,
            'lang': lang
          },
        ),
      );
      print(response);
      if (response.data['status'] == true) {
        searchName = homeSearchFromJson(response.toString()).result.allProducts;
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
