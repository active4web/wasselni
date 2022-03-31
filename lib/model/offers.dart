import 'dart:convert';

import 'package:flutter/cupertino.dart';
import 'package:dio/dio.dart' as Dio;
import 'package:wassalny/network/auth/dio.dart';
// To parse this JSON data, do
//
//     final offers = offersFromJson(jsonString);

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

//{========================Get From server=======================}

class AllOffersProvider with ChangeNotifier {
  String token;
  String lang;
  int id;
  AllOffersProvider({
    this.id,
    this.token,
    this.lang,
  });

  List<AllOffer> allOffers = [];
  // List<AllGallery> allGalleries;

  // List<SliderOffer> slideOffers=[];
  Future<void> fetchAllOffers(String language) async {
    try {
      Dio.Response response = await dio().post(
        'user_api/get_offers',
        data: Dio.FormData.fromMap(
          {'key': 1234567890, 'lang': language, 'token_id': token},
        ),
      );
      print(response);
      allOffers = offersFromJson(response.toString()).result.allOffers;
      // for (var i = 0; i < allOffers.length; i++) {
      //   allGalleries = allOffers[i].allGalleries;
      //   print(allOffers[i].allGalleries[i].offersImage);
      // }
      // slideOffers = offersFromJson(response.toString()).result.sliderOffers;
    } catch (err) {
      // ignore: unnecessary_brace_in_string_interps
      print('${err} error from offers list');
    }
  }
}
