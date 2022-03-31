// To parse this JSON data, do
//
//     final offerDetails =

import 'dart:convert';

import 'package:dio/dio.dart' as Dio;
import 'package:flutter/cupertino.dart';
import 'package:wassalny/network/auth/dio.dart';

// To parse this JSON data, do
//
//     final offerDetail = offerDetailFromJson(jsonString);

OfferDetail offerDetailFromJson(String str) =>
    OfferDetail.fromJson(json.decode(str));

String offerDetailToJson(OfferDetail data) => json.encode(data.toJson());

class OfferDetail {
  OfferDetail({
    this.message,
    this.codenum,
    this.status,
    this.result,
  });

  String message;
  int codenum;
  bool status;
  Result result;

  factory OfferDetail.fromJson(Map<String, dynamic> json) => OfferDetail(
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
    this.offerDetails,
  });

  List<OfferDetailElement> offerDetails;

  factory Result.fromJson(Map<String, dynamic> json) => Result(
        offerDetails: List<OfferDetailElement>.from(
            json["offer_details"].map((x) => OfferDetailElement.fromJson(x))),
      );

  Map<String, dynamic> toJson() => {
        "offer_details":
            List<dynamic>.from(offerDetails.map((x) => x.toJson())),
      };
}

class OfferDetailElement {
  OfferDetailElement({
    this.offersImage,
    this.facebook,
    this.phone,
    this.whatsapp,
    this.twitter,
    this.instagram,
    this.oldPrice,
    this.newPrice,
    this.serviceId,
    this.serviceName,
    this.offersName,
    this.offersDescription,
    this.offersId,
  });

  String offersImage;
  String facebook;
  String phone;
  String whatsapp;
  String twitter;
  String instagram;
  String oldPrice;
  String newPrice;
  String serviceId;
  dynamic serviceName;
  String offersName;
  String offersDescription;
  int offersId;

  factory OfferDetailElement.fromJson(Map<String, dynamic> json) =>
      OfferDetailElement(
        offersImage: json["offers_image"],
        facebook: json["facebook"],
        phone: json["phone"],
        whatsapp: json["whatsapp"],
        twitter: json["twitter"],
        instagram: json["instagram"],
        oldPrice: json["old_price"],
        newPrice: json["new_price"],
        serviceId: json["service_id"],
        serviceName: json["service_name"],
        offersName: json["offers_name"],
        offersDescription: json["offers_description"],
        offersId: json["offers_id"],
      );

  Map<String, dynamic> toJson() => {
        "offers_image": offersImage,
        "facebook": facebook,
        "phone": phone,
        "whatsapp": whatsapp,
        "twitter": twitter,
        "instagram": instagram,
        "old_price": oldPrice,
        "new_price": newPrice,
        "service_id": serviceId,
        "service_name": serviceName,
        "offers_name": offersName,
        "offers_description": offersDescription,
        "offers_id": offersId,
      };
}

class OfferDetailsProvider with ChangeNotifier {
  String token;

  OfferDetailsProvider({this.token});

  List<OfferDetailElement> offerDetailsList = [];
  String offerName = '';
  String serviceName = '';
  String offerImage = '';
  String oldPrice = '';
  String newPrice = '';
  String offersDescription = '';
  String phone = '';
  String instagram = "";
  String twitter = "";
  String whatsapp = "";
  String serviceId = '';
  Future<void> orderDeatails(String lang, int id) async {
    try {
      Dio.Response response = await dio().post(
        'user_api/get_offer_details',
        data: Dio.FormData.fromMap(
          {'key': 1234567890, 'lang': lang, 'token_id': token, 'offer_id': id},
        ),
      );
      print(response);
      offerDetailsList =
          offerDetailFromJson(response.toString()).result.offerDetails;

      for (var i = 0; i < offerDetailsList.length; i++) {
        offerName = offerDetailsList[i].offersName;
        serviceName = offerDetailsList[i].serviceName;
        oldPrice = offerDetailsList[i].oldPrice;
        newPrice = offerDetailsList[i].newPrice;
        offersDescription = offerDetailsList[i].offersDescription;
        phone = offerDetailsList[i].phone;
        instagram = offerDetailsList[i].instagram;
        twitter = offerDetailsList[i].twitter;
        whatsapp = offerDetailsList[i].whatsapp;
        serviceId = offerDetailsList[i].serviceId;
      }
    } catch (err) {
      // ignore: unnecessary_brace_in_string_interps
      print('${err} error from offers list');
    }
  }
}
