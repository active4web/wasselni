// To parse this JSON data, do
//
//     final cart = cartFromJson(jsonString);

import 'dart:convert';

import 'package:dio/dio.dart' as Dio;
import 'package:flutter/material.dart';
import 'package:get_storage/get_storage.dart';
import 'package:wassalny/network/auth/dio.dart';

Cart cartFromJson(String str) => Cart.fromJson(json.decode(str));

String cartToJson(Cart data) => json.encode(data.toJson());

class Cart {
  Cart({
    this.message,
    this.codenum,
    this.status,
    this.result,
  });

  String message;
  int codenum;
  bool status;
  Result result;

  factory Cart.fromJson(Map<String, dynamic> json) => Cart(
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
    this.allProducts,
  });

  List<AllProduct> allProducts;

  factory Result.fromJson(Map<String, dynamic> json) => Result(
        allProducts: List<AllProduct>.from(
            json["all_products"].map((x) => AllProduct.fromJson(x))),
      );

  Map<String, dynamic> toJson() => {
        "all_products": List<dynamic>.from(allProducts.map((x) => x.toJson())),
      };
}

class AllProduct {
  AllProduct({
    this.idOrder,
    this.idProduct,
    this.productName,
    this.price,
    this.quantity,
    this.currencyName,
    this.serviceName,
    this.image,
  });

  int idOrder;
  int idProduct;
  String productName;
  String price;
  int quantity;
  String currencyName;
  String image;
  String serviceName;

  factory AllProduct.fromJson(Map<String, dynamic> json) => AllProduct(
        idOrder: json["id_order"],
        idProduct: json["id_product"],
        productName: json["product_name"],
        price: json["price"] == "حسب الطلب" || json["price"] == ""
            ? '0'
            : json["price"],
        quantity: json["quantity"],
        currencyName: json["currency_name"],
        image: json["image"],
        serviceName: json["service_name"],
      );

  Map<String, dynamic> toJson() => {
        "id_order": idOrder,
        "id_product": idProduct,
        "product_name": productName,
        "price": price,
        "quantity": quantity,
        "currency_name": currencyName,
        "image": image,
        "service_name": serviceName,
      };
}

class CartListProvider with ChangeNotifier {
  String token;
  CartListProvider({this.token});
  GetStorage storage = GetStorage();

  Future<List<AllProduct>> fetchCart(String lang) async {
    try {
      Dio.Response response = await dio().post(
        'store/get_cart',
        data: Dio.FormData.fromMap(
          {'key': 1234567890, 'token_id': token, "lang": lang},
        ),
      );
      print(response.data);
      var homeData = json.encode(response.data);
      storage.write("allProducts", homeData);
      return cartFromJson(response.data).result.allProducts;
    } catch (err) {
      // ignore: unnecessary_brace_in_string_interps
      var model = storage.read("allProducts");
      print(model);
      return cartFromJson(model).result.allProducts;
    }
  }

  Future<List<AllProduct>> fetchProductCart(String lang, ServiceId) async {
    try {
      Dio.Response response = await dio().post(
        'store/get_cart_select_service',
        data: Dio.FormData.fromMap(
          {
            'key': 1234567890,
            'token_id': token,
            "lang": lang,
            "service_id": ServiceId
          },
        ),
      );
      print(response.data);
      var homeData = json.encode(response.data);
      storage.write("allProducts", homeData);
      return cartFromJson(response.data).result.allProducts;
    } catch (err) {
      // ignore: unnecessary_brace_in_string_interps
      var model = storage.read("allProducts");
      print(model);
      return cartFromJson(model).result.allProducts;
    }
  }

  Future emptyCart(String lang, orderId) async {
    try {
      Dio.Response response = await dio().post(
        'store/empty_cart',
        data: Dio.FormData.fromMap(
          {
            'key': 1234567890,
            'token_id': token,
            "lang": lang,
            "id_order": orderId
          },
        ),
      );
      print(response.data);
      return response.data;
    } catch (err) {
      // ignore: unnecessary_brace_in_string_interps
      print(err.toString());
    }
  }
}
