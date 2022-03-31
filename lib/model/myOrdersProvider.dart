import 'package:dio/dio.dart' as Dio;
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:wassalny/network/auth/dio.dart';

// To parse this JSON data, do
//
//     final myOrdersModel = myOrdersModelFromJson(jsonString);

import 'dart:convert';

MyOrdersModel myOrdersModelFromJson(String str) =>
    MyOrdersModel.fromJson(json.decode(str));

String myOrdersModelToJson(MyOrdersModel data) => json.encode(data.toJson());

class MyOrdersModel {
  MyOrdersModel({
    this.message,
    this.codenum,
    this.status,
    this.result,
  });

  String message;
  int codenum;
  bool status;
  Result result;

  factory MyOrdersModel.fromJson(Map<String, dynamic> json) => MyOrdersModel(
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
    this.orderDetails,
  });

  List<OrderDetail> orderDetails;

  factory Result.fromJson(Map<String, dynamic> json) => Result(
        orderDetails: List<OrderDetail>.from(
            json["order_details"].map((x) => OrderDetail.fromJson(x))),
      );

  Map<String, dynamic> toJson() => {
        "order_details":
            List<dynamic>.from(orderDetails.map((x) => x.toJson())),
      };
}

class OrderDetail {
  OrderDetail({
    this.codeName,
    this.idOrder,
    this.totalPrice,
    this.totalProduct,
    this.shippingCharges,
    this.currencyName,
    this.date,
    this.viewStore,
    this.viewId,
  });

  int codeName;
  int idOrder;
  String totalPrice;
  String totalProduct;
  String shippingCharges;
  String currencyName;
  String date;
  bool viewStore;
  int viewId;

  factory OrderDetail.fromJson(Map<String, dynamic> json) => OrderDetail(
        codeName: json["code_name"],
        idOrder: json["id_order"],
        totalPrice: json["total_price"],
        totalProduct: json["total_product"],
        shippingCharges: json["shipping_charges"],
        currencyName: json["currency_name"],
        date: json["date"],
        viewStore: json["view_store"],
        viewId: json["view_id"],
      );

  Map<String, dynamic> toJson() => {
        "code_name": codeName,
        "id_order": idOrder,
        "total_price": totalPrice,
        "total_product": totalProduct,
        "shipping_charges": shippingCharges,
        "currency_name": currencyName,
        "date": date,
        "view_store": viewStore,
        "view_id": viewId,
      };
}

class MyOrdersProvider with ChangeNotifier {
  String token;
  MyOrdersProvider({this.token});

  Future<List<OrderDetail>> fetchMyOrders() async {
    try {
      Dio.Response response = await dio().post(
        'store/get_list_myorders',
        data: Dio.FormData.fromMap(
          {
            'key': 1234567890,
            'token_id': token,
            'lang': Get.locale.languageCode,
          },
        ),
      );
      print(response.data);
      return myOrdersModelFromJson(response.toString()).result.orderDetails;
    } catch (err) {
      // ignore: unnecessary_brace_in_string_interps
      print('${err}');
    }
  }
}
