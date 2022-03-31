// To parse this JSON data, do
//
//     final sirvOffers = sirvOffersFromJson(jsonString);

import 'dart:convert';
import 'package:flutter/cupertino.dart';
import 'package:dio/dio.dart' as Dio;
import 'package:wassalny/network/auth/dio.dart';

// To parse this JSON data, do
//
//     final sirvOffers = sirvOffersFromJson(jsonString);

import 'dart:convert';

SirvOffers sirvOffersFromJson(String str) =>
    SirvOffers.fromJson(json.decode(str));

String sirvOffersToJson(SirvOffers data) => json.encode(data.toJson());

class SirvOffers {
  SirvOffers({
    this.message,
    this.codenum,
    this.status,
    this.result,
  });

  String message;
  int codenum;
  bool status;
  Result result;

  factory SirvOffers.fromJson(Map<String, dynamic> json) => SirvOffers(
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
    this.categoryDetails,
    this.allOffers,
  });

  List<CategoryDetail> categoryDetails;
  List<AllOffer> allOffers;

  factory Result.fromJson(Map<String, dynamic> json) => Result(
        categoryDetails: List<CategoryDetail>.from(
            json["category_details"].map((x) => CategoryDetail.fromJson(x))),
        allOffers: List<AllOffer>.from(
            json["all_offers"].map((x) => AllOffer.fromJson(x))),
      );

  Map<String, dynamic> toJson() => {
        "category_details":
            List<dynamic>.from(categoryDetails.map((x) => x.toJson())),
        "all_offers": List<dynamic>.from(allOffers.map((x) => x.toJson())),
      };
}

class AllOffer {
  AllOffer({
    this.allGalleries,
    this.offerImage,
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
    this.offersId,
    this.offersImage,
  });

  String offersId;
  String offersImage;

  factory AllGallery.fromJson(Map<String, dynamic> json) => AllGallery(
        offersId: json["offers_id"],
        offersImage: json["offers_image"],
      );

  Map<String, dynamic> toJson() => {
        "offers_id": offersId,
        "offers_image": offersImage,
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

class SirvOfferProvider with ChangeNotifier {
  String token;
  String lang;
  int id;
  SirvOfferProvider({
    this.id,
    this.token,
    this.lang,
  });

  List<AllOffer> offers = [];
  List<CategoryDetail> details = [];

  Future<void> fetchinfo(int sirvId) async {
    try {
      print(sirvId);
      Dio.Response response = await dio().post(
        'services/get_service_offers',
        data: Dio.FormData.fromMap(
          {
            'key': 1234567890,
            'token_id': token,
            "service_id": sirvId,
          },
        ),
      );
      print(response);
      offers = sirvOffersFromJson(response.toString()).result.allOffers;
      details = sirvOffersFromJson(response.toString()).result.categoryDetails;
    } catch (err) {
      // ignore: unnecessary_brace_in_string_interps
      print('${err} error from SirvOffers list');

      throw (err);
    }
  }
}
