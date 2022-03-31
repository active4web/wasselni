import 'dart:convert';

import 'package:flutter/cupertino.dart';
import 'package:dio/dio.dart' as Dio;
import 'package:wassalny/network/auth/dio.dart';

// To parse this JSON data, do
//
//     final braches =

Braches brachesFromJson(String str) => Braches.fromJson(json.decode(str));

String brachesToJson(Braches data) => json.encode(data.toJson());

class Braches {
  Braches({
    this.message,
    this.messageid,
    this.status,
    this.result,
  });

  String message;
  int messageid;
  bool status;
  Result result;

  factory Braches.fromJson(Map<String, dynamic> json) => Braches(
        message: json["Message"],
        messageid: json["Messageid"],
        status: json["status"],
        result: Result.fromJson(json["result"]),
      );

  Map<String, dynamic> toJson() => {
        "Message": message,
        "Messageid": messageid,
        "status": status,
        "result": result.toJson(),
      };
}

class Result {
  Result({
    this.categoryDetails,
    this.allProducts,
  });

  List<CategoryDetail> categoryDetails;
  List<AllProducts> allProducts;

  factory Result.fromJson(Map<String, dynamic> json) => Result(
        categoryDetails: List<CategoryDetail>.from(
            json["category_details"].map((x) => CategoryDetail.fromJson(x))),
        allProducts: List<AllProducts>.from(
            json["all_products"].map((x) => AllProducts.fromJson(x))),
      );

  Map<String, dynamic> toJson() => {
        "category_details":
            List<dynamic>.from(categoryDetails.map((x) => x.toJson())),
        "all_products": List<dynamic>.from(allProducts.map((x) => x.toJson())),
      };
}

class AllProducts {
  AllProducts({
    this.productImage,
    this.productName,
    this.phone,
    this.phoneSecond,
    this.phoneThird,
    this.prodId,
    this.favExit,
    this.lat,
    this.lag,
    this.address,
    this.delivery,
  });

  String productImage;
  String productName;
  String phone;
  String phoneSecond;
  String phoneThird;
  int prodId;
  int favExit;
  String lat;
  String lag;
  String address;
  int delivery;

  factory AllProducts.fromJson(Map<String, dynamic> json) => AllProducts(
        productImage: json["product_image"],
        productName: json["product_name"],
        phone: json["phone"],
        phoneSecond: json["phone_second"],
        phoneThird: json["phone_third"],
        prodId: json["prod_id"],
        favExit: json["fav_exit"],
        lat: json["lat"],
        lag: json["lag"],
        address: json["address"],
        delivery: json["delivery"],
      );

  Map<String, dynamic> toJson() => {
        "product_image": productImage,
        "product_name": productName,
        "phone": phone,
        "phone_second": phoneSecond,
        "phone_third": phoneThird,
        "prod_id": prodId,
        "fav_exit": favExit,
        "lat": lat,
        "lag": lag,
        "address": address,
        "delivery": delivery,
      };
}

class CategoryDetail {
  CategoryDetail({
    this.categoryImage,
    this.categoryName,
    this.catId,
  });

  String categoryImage;
  String categoryName;
  int catId;

  factory CategoryDetail.fromJson(Map<String, dynamic> json) => CategoryDetail(
        categoryImage: json["category_image"],
        categoryName: json["category_name"],
        catId: json["cat_id"],
      );

  Map<String, dynamic> toJson() => {
        "category_image": categoryImage,
        "category_name": categoryName,
        "cat_id": catId,
      };
}

class BranchesProvider with ChangeNotifier {
  String token;
  BranchesProvider({this.token});
  List<AllProducts> branches = [];

  Future<void> fetchAllBranches(
    int id,
  ) async {
    try {
      Dio.Response response = await dio().post(
        'services/get_other_branches',
        data: Dio.FormData.fromMap(
          {
            'key': 1234567890,
            'token_id': token,
            'service_id': id,
          },
        ),
      );
      print(response.data);
      branches = brachesFromJson(response.toString()).result.allProducts;
    } catch (err) {
      // ignore: unnecessary_brace_in_string_interps
      print('${err}');
    }
  }
}
