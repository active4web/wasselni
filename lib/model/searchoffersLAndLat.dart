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

class Offers {
  Offers({
    this.message,
    this.codenum,
    this.status,
    this.result,
  });

  String? message;
  int? codenum;
  bool? status;
  Result? result;

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
        "result": result?.toJson(),
      };
}

class Result {
  Result({
    this.allOffers,
  });

  List<AllOffer>? allOffers;

  factory Result.fromJson(Map<String, dynamic> json) => Result(
        allOffers: List<AllOffer>.from(
            json["all_offers"].map((x) => AllOffer.fromJson(x))),
      );

  Map<String, dynamic> toJson() => {
        "all_offers": List<dynamic>.from(allOffers!.map((x) => x.toJson())),
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

  List<AllGallery>? allGalleries;
  String? offerImage;
  String? serviceImage;
  String? serviceId;
  String? serviceName;
  String? offerName;
  String? description;
  String? phone;
  String? whatsapp;
  String? oldPrice;
  String? newPrice;
  String? startDate;
  String? endDate;
  int? offerId;

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
            List<dynamic>.from(allGalleries!.map((x) => x.toJson())),
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

  String? offersImage;
  String? offersId;

  factory AllGallery.fromJson(Map<String, dynamic> json) => AllGallery(
        offersImage: json["offers_image"],
        offersId: json["offers_id"] == null ? null : json["offers_id"],
      );

  Map<String, dynamic> toJson() => {
        "offers_image": offersImage,
        "offers_id": offersId == null ? null : offersId,
      };
}

class SearchLatAndLagOffersProvider with ChangeNotifier {
  String? token;
  SearchLatAndLagOffersProvider({this.token});

  List<AllOffer> searchLatAndLag = [];
  List<AllGallery> galleries = [];
  bool doneSearching = false;
  Future<bool> fetchSearch(
      {int? catId,
      int? limt,
      int? pageNumber,
      double? lat,
      double? lag,
      String? distance,
      int? departmentId,
      String? lang}) async {
    print(lat);
    print(lag);
    print(catId);
    print(departmentId);

    try {
      Dio.Response response = await dio().post(
        'user_api/get_offer_search_lat_lag',
        data: Dio.FormData.fromMap(
          {
            'key': 1234567890,
            'token_id': token,
            'limit': limt,
            'page_number': pageNumber,
            'cat_id': catId,
            'lat': lat,
            'distance': distance,
            'lag': lag,
            "dep_id": departmentId,
            "lang": lang
          },
        ),
      );
      print(response);
      if (response.data['status'] == true) {
        searchLatAndLag =
            searchLagAndlatFromJson(response.toString()).result?.allOffers??[];
        for (var i = 0; i < searchLatAndLag.length; i++) {
          galleries = searchLatAndLag[i].allGalleries??[];
        }
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
