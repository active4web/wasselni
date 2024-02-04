import 'dart:convert';

import 'package:flutter/cupertino.dart';
import 'package:dio/dio.dart' as Dio;
import 'package:get_storage/get_storage.dart';
import 'package:wassalny/model/home.dart';
import 'package:wassalny/network/auth/dio.dart';

// To parse this JSON data, do
//
//     final itemSirv = itemSirvFromJson(jsonString);

ItemSirv itemSirvFromJson(String str) => ItemSirv.fromJson(json.decode(str));

String itemSirvToJson(ItemSirv data) => json.encode(data.toJson());

class ItemSirv {
  ItemSirv({
    this.message,
    this.codenum,
    this.status,
    this.result,
  });

  String? message;
  int? codenum;
  bool? status;
  Result? result;

  factory ItemSirv.fromJson(Map<String, dynamic> json) => ItemSirv(
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
    this.allSlider,
    this.allRate,
    this.serviceDetails,
  });

  List<AllSlider>? allSlider;
  List<AllRate>? allRate;
  List<ServiceDetail>? serviceDetails;

  factory Result.fromJson(Map<String, dynamic> json) => Result(
        allSlider: List<AllSlider>.from(
            json["all_slider"].map((x) => AllSlider.fromJson(x))),
        allRate: List<AllRate>.from(
            json["all_rate"].map((x) => AllRate.fromJson(x))),
        serviceDetails: List<ServiceDetail>.from(
            json["service_details"].map((x) => ServiceDetail.fromJson(x))),
      );

  Map<String, dynamic> toJson() => {
        "all_slider": List<dynamic>.from(allSlider!.map((x) => x.toJson())),
        "all_rate": List<dynamic>.from(allRate!.map((x) => x.toJson())),
        "service_details":
            List<dynamic>.from(serviceDetails!.map((x) => x.toJson())),
      };
}

class AllRate {
  AllRate({
    this.username,
    this.userrate,
    this.usercomment,
    this.rateId,
  });

  String? username;
  String? userrate;
  String? usercomment;
  int? rateId;

  factory AllRate.fromJson(Map<String, dynamic> json) => AllRate(
        username: json["username"],
        userrate: json["userrate"],
        usercomment: json["usercomment"],
        rateId: json["rate_id"],
      );

  Map<String, dynamic> toJson() => {
        "username": username,
        "userrate": userrate,
        "usercomment": usercomment,
        "rate_id": rateId,
      };
}

class AllSlider {
  AllSlider({
    this.img,
    this.depId,
  });

  String? img;
  int? depId;

  factory AllSlider.fromJson(Map<String, dynamic> json) => AllSlider(
        img: json["img"],
        depId: json["dep_id"],
      );

  Map<String, dynamic> toJson() => {
        "img": img,
        "dep_id": depId,
      };
}

class ServiceDetail {
  ServiceDetail({
    this.favExit,
    this.totalRate,
    this.offersImage,
    this.serviceName,
    this.scanDisplay,
    this.pointsDisplay,
    this.copounDisplay,
    this.offersDisplay,
    this.branchesDisplay,
    this.sliderType,
    this.deliveryOn,
    this.totalPoints,
    this.videoLink,
    this.facebook,
    this.phone,
    this.location,
    this.phoneSecond,
    this.phoneThird,
    this.menuTitle,
    this.whatsapp,
    this.twitter,
    this.instagram,
    this.email,
    this.website,
    this.lat,
    this.rateView,
    this.shareView,
    this.lag,
    this.address,
    this.description,
    this.id,
    this.shareLink,
    this.locationDisplay,
    this.viewMin,
  });

  int? favExit;
  String? totalRate;
  String? offersImage;
  String? serviceName;
  String? scanDisplay;
  String? rateView;
  String? shareView;
  String? pointsDisplay;
  String? shareLink;
  String? copounDisplay;
  String? locationDisplay;
  String? offersDisplay;
  String? branchesDisplay;
  String? sliderType;
  String? deliveryOn;
  String? totalPoints;
  String? videoLink;
  String? facebook;
  String? phone;
  String? location;
  String? phoneSecond;
  String? phoneThird;
  String? menuTitle;
  String? whatsapp;
  String? twitter;
  String? instagram;
  String? email;
  String? website;
  String? lat;
  String? lag;
  String? address;
  String? description;
  int? id;
  String? viewMin;
  factory ServiceDetail.fromJson(Map<String, dynamic> json) => ServiceDetail(
        favExit: json["fav_exit"],
        totalRate: json["total_rate"],
        offersImage: json["offers_image"],
        serviceName: json["service_name"],
        scanDisplay: json["scan_display"],
        pointsDisplay: json["points_display"],
        copounDisplay: json["copoun_display"],
        offersDisplay: json["offers_display"],
        branchesDisplay: json["branches_display"],
        locationDisplay: json["location_display"],
        sliderType: json["slider_type"],
        deliveryOn: json["delivery_on"],
        totalPoints: json["total_points"],
        videoLink: json["video_link"],
        shareLink: json["share_link"],
        facebook: json["facebook"],
        phone: json["phone"],
        location: json["location"],
        phoneSecond: json["phone_second"],
        phoneThird: json["phone_third"],
        menuTitle: json["menu_title"],
        whatsapp: json["whatsapp"],
        twitter: json["twitter"],
        instagram: json["instagram"],
        email: json["email"],
        website: json["website"],
        lat: json["lat"],
        lag: json["lag"],
        address: json["address"],
        description: json["description"],
        id: json["id"],
        viewMin: json["menu_display"],
        rateView: json["rate_view"],
        shareView: json["share_view"],
      );
  Map<String, dynamic> toJson() => {
        "menu_display": viewMin,
        "fav_exit": favExit,
        "total_rate": totalRate,
        "offers_image": offersImage,
        "service_name": serviceName,
        "scan_display": scanDisplay,
        "points_display": pointsDisplay,
        "copoun_display": copounDisplay,
        "offers_display": offersDisplay,
        "branches_display": branchesDisplay,
        "location_display": locationDisplay,
        "slider_type": sliderType,
        "delivery_on": deliveryOn,
        "total_points": totalPoints,
        "video_link": videoLink,
        "share_link": shareLink,
        "facebook": facebook,
        "phone": phone,
        "location": location,
        "phone_second": phoneSecond,
        "phone_third": phoneThird,
        "menu_title": menuTitle,
        "whatsapp": whatsapp,
        "twitter": twitter,
        "instagram": instagram,
        "email": email,
        "website": website,
        "lat": lat,
        "share_view": shareView,
        "rate_view": rateView,
        "lag": lag,
        "address": address,
        "description": description,
        "id": id,
      };
}

class ItemServicesDetail with ChangeNotifier {
  String? token;
  ItemServicesDetail({this.token});

  String offersImage = '';
  String facebook = '';
  String phone = '';
  String phoneSecond = '';
  String phoneThird = '';
  String whatsapp = '';
  String twitter = '';
  String instagram = '';
  String email = '';
  String lat = '';
  String lag = '';
  String address = '';
  String description = '';
  String serviceName = '';
  String mainImg = '';
  String viewOffer = '';
  String viewCobon = '';
  String viewPoints = '';
  String viewMin = '';
  String viewBranches = '';
  String viewScan = '';
  String viewLocation = '';
  String img1 = '';
  String img2 = '';
  String img3 = '';
  String? sliderType;
  String? web;
  String? delivary;
  String? videoLink;
  String? shareLink;
  String? totalRate;
  int? isFav;
  List<ServiceDetail> serviceDetail = [];
  List<AllRate> allRate = [];
  String points = '';
  List<AllSlider> allslider = [];
  String loctaation = '';
  int? idd;
  String menuTilte = '';
  String? rateView;
  String? shareView;
  GetStorage storage = GetStorage();
  bool isCache = false;
  Future<void> fetchAllDetails(int id, String lang) async {
    try {
      Dio.Response response = await dio().post(
        'user_api/get_service_details',
        data: Dio.FormData.fromMap(
          {
            'key': 1234567890,
            'token_id': token,
            'service_id': id,
            'lang': lang
          },
        ),
      );
      isCache = false;
      allslider = itemSirvFromJson(response.toString()).result?.allSlider??[];
      allRate = itemSirvFromJson(response.toString()).result?.allRate??[];
      serviceDetail =
          itemSirvFromJson(response.toString()).result?.serviceDetails??[];
        viewBranches = serviceDetail[0].branchesDisplay??'';
        viewOffer = serviceDetail[0].offersDisplay??'';
        viewPoints = serviceDetail[0].pointsDisplay??'';
        viewScan = serviceDetail[0].scanDisplay??'';
        viewCobon = serviceDetail[0].copounDisplay??'';
        viewLocation = serviceDetail[0].locationDisplay??'';
        isFav = serviceDetail[0].favExit;
        totalRate = serviceDetail[0].totalRate;
        offersImage = serviceDetail[0].offersImage??'';
        facebook = serviceDetail[0].facebook??'';
        phone = serviceDetail[0].phone??'';
        phoneSecond = serviceDetail[0].phoneSecond??'';
        phoneThird = serviceDetail[0].phoneThird??'';
        whatsapp = serviceDetail[0].whatsapp??'';
        twitter = serviceDetail[0].twitter??'';
        instagram = serviceDetail[0].instagram??'';
        email = serviceDetail[0].email??'';
        lat = serviceDetail[0].lat??'';
        lag = serviceDetail[0].lag??'';
        address = serviceDetail[0].address??'';
        web = serviceDetail[0].website;
        description = serviceDetail[0].description??'';
        serviceName = serviceDetail[0].serviceName??'';
        mainImg = serviceDetail[0].offersImage??'';
        sliderType = serviceDetail[0].sliderType;
        delivary = serviceDetail[0].deliveryOn;
        videoLink = serviceDetail[0].videoLink;
        shareLink = serviceDetail[0].shareLink;
        loctaation = serviceDetail[0].location??'';
        points = serviceDetail[0].totalPoints??'';
        idd = serviceDetail[0].id;
        menuTilte = serviceDetail[0].menuTitle??'';
        viewMin = serviceDetail[0].viewMin??'';
        rateView = serviceDetail[0].rateView;
        shareView = serviceDetail[0].shareView;

      if(storage.read("servicesDetails")==null){
        List result = [];
        result.add(Result(allRate: allRate,allSlider: allslider,serviceDetails: serviceDetail));
        storage.write("servicesDetails", json.encode(result));
      }else{
        int hasId = 0;
        List cachedServicesDetails = json.decode(storage.read("servicesDetails"));
        cachedServicesDetails.forEach((element) {
          if(id.toString()==element['service_details'][0]['id'].toString()){
            hasId=1;
          }
        });
        if(hasId==0){
          cachedServicesDetails.add(Result(allRate: allRate,allSlider: allslider,serviceDetails: serviceDetail));
        }
        storage.write("servicesDetails", json.encode(cachedServicesDetails));

        print("kjbjkhbj  ${cachedServicesDetails.length}");

        // print("iiiiii ${cachedServices.length}");
      }
    } catch (err) {
      // ignore: unnecessary_brace_in_string_interps
      serviceDetail = [];
      if(storage.read("servicesDetails")!=null) {
        List servicesDetails = json.decode(storage.read("servicesDetails"));
        print("biuygyu ${servicesDetails}");
        servicesDetails.forEach((element) {
          print("biuygyu ${element}");
          if (id.toString() == element['service_details'][0]['id'].toString()) {
            serviceDetail.add(ServiceDetail.fromJson(element['service_details'][0]));
            element['all_rate'].forEach((e){
              allRate.add(AllRate.fromJson(e));
            });
            element['all_slider'].forEach((e){
              allslider.add(AllSlider.fromJson(e));
            });
          }
        });

        if(serviceDetail.isNotEmpty) {
          viewBranches = serviceDetail[0].branchesDisplay??'';
          viewOffer = serviceDetail[0].offersDisplay??'';
          viewPoints = serviceDetail[0].pointsDisplay??'';
          viewScan = serviceDetail[0].scanDisplay??'';
          viewCobon = serviceDetail[0].copounDisplay??'';
          viewLocation = serviceDetail[0].locationDisplay??'';
          isFav = serviceDetail[0].favExit;
          totalRate = serviceDetail[0].totalRate;
          offersImage = serviceDetail[0].offersImage??'';
          facebook = serviceDetail[0].facebook??'';
          phone = serviceDetail[0].phone??'';
          phoneSecond = serviceDetail[0].phoneSecond??'';
          phoneThird = serviceDetail[0].phoneThird??'';
          whatsapp = serviceDetail[0].whatsapp??'';
          twitter = serviceDetail[0].twitter??'';
          instagram = serviceDetail[0].instagram??'';
          email = serviceDetail[0].email??'';
          lat = serviceDetail[0].lat??'';
          lag = serviceDetail[0].lag??'';
          address = serviceDetail[0].address??'';
          web = serviceDetail[0].website??'';
          description = serviceDetail[0].description??'';
          serviceName = serviceDetail[0].serviceName??'';
          mainImg = serviceDetail[0].offersImage??'';
          sliderType = serviceDetail[0].sliderType;
          delivary = serviceDetail[0].deliveryOn;
          videoLink = serviceDetail[0].videoLink;
          shareLink = serviceDetail[0].shareLink;
          loctaation = serviceDetail[0].location??'';
          points = serviceDetail[0].totalPoints??'';
          idd = serviceDetail[0].id;
          menuTilte = serviceDetail[0].menuTitle??'';
          viewMin = serviceDetail[0].viewMin??'';
        }else{
          offersImage = '';
          facebook = '';
          phone = '';
          phoneSecond = '';
          phoneThird = '';
          whatsapp = '';
          twitter = '';
          instagram = '';
          email = '';
          lat = '';
          lag = '';
          address = '';
          description = '';
          serviceName = '';
          mainImg = '';
          viewOffer = '';
          viewCobon = '';
          viewPoints = '';
          viewMin = '';
          viewBranches = '';
          viewScan = '';
          viewLocation = '';
          img1 = '';
          img2 = '';
          img3 = '';
          sliderType;
          web;
          delivary;
          videoLink;
          shareLink;
          totalRate;
          isFav;
          serviceDetail = [];
          allRate = [];
          points = '';
          allslider = [];
          loctaation = '';
          idd;
          menuTilte = '';
        }
      }
      throw (err);
    }
  }

  int? cobon;
  Future<void> getCobon(int id) async {
    try {
      Dio.Response response = await dio().post(
        'services/generate_coupon',
        data: Dio.FormData.fromMap(
          {
            'key': 1234567890,
            'token_id': token,
            'service_id': id,
          },
        ),
      );
      cobon = response.data['result']['service_coupon'];
      print(response);
      print(cobon.toString());
    } catch (err) {
      // ignore: unnecessary_brace_in_string_interps
      print('${err}');
    }
  }

  String message = '';
  dynamic number = 0;
  Future<void> qr(int id,var qrId, String lang) async {
    try {
      Dio.Response response = await dio().post(
        'user_api/scan_qr',
        data: Dio.FormData.fromMap(
          {
            'key': 1234567890,
            'token_id': token,
            'service_id': id,
            'qr_id': qrId,
            'lang': lang
          },
        ),
      );
      print(response.data);
      message = response.data['message'];
      print( message);
      if(response.data["status"]){
        number = response.data['result']['total_points'];
      }else{
        number = 0;
      }
      print(number);
    } catch (err) {
      // ignore: unnecessary_brace_in_string_interps
      var model = jsonDecode(storage.read("serviceDetailsCoupon"));
      print(model);
      number = model.data['result']['your_coupon'];
      print(number);
      message = model.data['message'];
      print(message);
      print('${err}');
    }
  }
}
