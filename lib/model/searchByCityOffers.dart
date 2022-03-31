import 'package:flutter/cupertino.dart';
import 'package:dio/dio.dart' as Dio;
import 'package:provider/provider.dart';
import 'package:wassalny/model/home.dart';
import 'package:wassalny/model/offers.dart';

// To parse this JSON data, do
//
//     final searchC =

import 'dart:convert';

import 'package:wassalny/network/auth/dio.dart';

Offers offersFromJson(String str) => Offers.fromJson(json.decode(str));

String offersToJson(Offers data) => json.encode(data.toJson());

class Offers {
  Offers({
    this.message,
    this.codenum,
    this.status,
    this.result,
  });

  String message;
  int codenum;
  bool status;
  Result result;

  factory Offers.fromJson(Map<String, dynamic> json) => Offers(
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
    this.allOffers,
  });

  List<AllOffer> allOffers;

  factory Result.fromJson(Map<String, dynamic> json) => Result(
        allOffers: List<AllOffer>.from(
            json["all_offers"].map((x) => AllOffer.fromJson(x))),
      );

  Map<String, dynamic> toJson() => {
        "all_offers": List<dynamic>.from(allOffers.map((x) => x.toJson())),
      };
}

class AllOffer {
  AllOffer({
    this.allGalleries,
    this.offerImage,
    this.serviceImage,
    this.serviceId,
    this.serviceName,
    this.offerName,
    this.description,
    this.phone,
    this.whatsapp,
    this.oldPrice,
    this.newPrice,
    this.startDate,
    this.endDate,
    this.offerId,
  });

  List<AllGallery> allGalleries;
  String offerImage;
  String serviceImage;
  String serviceId;
  String serviceName;
  String offerName;
  String description;
  String phone;
  String whatsapp;
  String oldPrice;
  String newPrice;
  String startDate;
  String endDate;
  int offerId;

  factory AllOffer.fromJson(Map<String, dynamic> json) => AllOffer(
        allGalleries: List<AllGallery>.from(
            json["all_galleries"].map((x) => AllGallery.fromJson(x))),
        offerImage: json["offer_image"],
        serviceImage: json["service_image"],
        serviceId: json["service_id"],
        serviceName: json["service_name"],
        offerName: json["offer_name"],
        description: json["description"],
        phone: json["phone"],
        whatsapp: json["whatsapp"],
        oldPrice: json["old_price"],
        newPrice: json["new_price"],
        startDate: json["start_date"],
        endDate: json["end_date"],
        offerId: json["offer_id"],
      );

  Map<String, dynamic> toJson() => {
        "all_galleries":
            List<dynamic>.from(allGalleries.map((x) => x.toJson())),
        "offer_image": offerImage,
        "service_image": serviceImage,
        "service_id": serviceId,
        "service_name": serviceName,
        "offer_name": offerName,
        "description": description,
        "phone": phone,
        "whatsapp": whatsapp,
        "old_price": oldPrice,
        "new_price": newPrice,
        "start_date": startDate,
        "end_date": endDate,
        "offer_id": offerId,
      };
}

class AllGallery {
  AllGallery({
    this.offersImage,
    this.offersId,
  });

  String offersImage;
  String offersId;

  factory AllGallery.fromJson(Map<String, dynamic> json) => AllGallery(
        offersImage: json["offers_image"],
        offersId: json["offers_id"] == null ? null : json["offers_id"],
      );

  Map<String, dynamic> toJson() => {
        "offers_image": offersImage,
        "offers_id": offersId == null ? null : offersId,
      };
}

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
  ProductResult result;

  factory SearchC.fromJson(Map<String, dynamic> json) => SearchC(
    message: json["message"],
    codenum: json["codenum"],
    status: json["status"],
    total: json["total"],
    result: ProductResult.fromJson(json["result"]),
  );

  Map<String, dynamic> toJson() => {
    "message": message,
    "codenum": codenum,
    "status": status,
    "total": total,
    "result": result.toJson(),
  };
}

class ProductResult {
  ProductResult({
    this.allProductsCC,
  });

  List<AllProducts> allProductsCC;

  factory ProductResult.fromJson(Map<String, dynamic> json) => ProductResult(
    allProductsCC: List<AllProducts>.from(
        json["all_products"].map((x) => AllProducts.fromJson(x))),
  );

  Map<String, dynamic> toJson() => {
    "all_products":
    List<dynamic>.from(allProductsCC.map((x) => x.toJson())),
  };
}

class AllProducts {
  AllProducts({
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

  factory AllProducts.fromJson(Map<String, dynamic> json) => AllProducts(
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

class SearchOffersByCity with ChangeNotifier {
  String token;
  SearchOffersByCity({this.token});

  List<AllOffer> searchName = [];
  List<AllGallery> allGalery = [];
  List<AllProducts> searchProductName = [];

  bool doneSearching = false;

  Future<bool> fetchSearch(
      {String name,
      int limt,
      int pageNumber,
      int city,
      String departmentId,
      int catId,
      int state,
      String lang}) async {
    print('$city city');
    print("$state state");

    try {
      Dio.Response response = await dio().post(
        'user_api/get_offer_search_city',
        data: Dio.FormData.fromMap(
          {
            'key': 1234567890,
            'token_id': token,
            'limit': limt,
            'page_number': pageNumber,
            'dep_id': departmentId,
            'cat_id': catId,
            'state': state,
            'city': city,
            'lang': lang
          },
        ),
      );
      searchName = offersFromJson(response.toString()).result.allOffers;
      for (var i = 0; i < searchName.length; i++) {
        allGalery = searchName[i].allGalleries;
      }
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

  bool doneCitySearching = false;
  Future<bool> fetchCitySearch(
      {String name,
      int limt,
      int pageNumber,
      int city,
      String departmentId,
      int catId,
      int state,
      String lang}) async {
    print('$city city');
    print("$state state");

    try {
      Dio.Response response = await dio().post(
        'user_api/get_search_city_filter',
        data: Dio.FormData.fromMap(
          {
            'key': 1234567890,
            'token_id': token,
            'limit': limt,
            'page_number': pageNumber,
            'dep_id': departmentId,
            'cat_id': catId,
            'state': state,
            'city': city,
            'lang': lang
          },
        ),
      );
      searchProductName = searchCFromJson(response.toString()).result.allProductsCC;

      print(response);
      if (response.data['status'] == true) {
        doneCitySearching = true;
      }
      return doneCitySearching;
    } catch (err) {
      // ignore: unnecessary_brace_in_string_interps
      print('${err} error from offers list');
      throw (err);
    }
  }
}
