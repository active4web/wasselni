//{====================about========================}
import 'dart:convert';

import 'package:flutter/cupertino.dart';

import 'package:dio/dio.dart' as Dio;
import 'package:wassalny/Components/CustomWidgets/showdialog.dart';
import 'package:wassalny/network/auth/dio.dart';

About aboutFromJson(String str) => About.fromJson(json.decode(str));

String aboutToJson(About data) => json.encode(data.toJson());

class About {
  About({
    this.message,
    this.codenum,
    this.status,
    this.result,
  });

  String message;
  int codenum;
  bool status;
  Result result;

  factory About.fromJson(Map<String, dynamic> json) => About(
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
    this.about,
  });

  String about;

  factory Result.fromJson(Map<String, dynamic> json) => Result(
        about: json["about"],
      );

  Map<String, dynamic> toJson() => {
        "about": about,
      };
}

class AboutAndContactUS with ChangeNotifier {
  String token;
  AboutAndContactUS({this.token});

  String about = '';
  Future<void> fetchAboutAndContactUs(String lang) async {
    try {
      Dio.Response response = await dio().post(
        'pages/about',
        data: Dio.FormData.fromMap(
          {'key': 1234567890, 'lang': lang, 'token_id': token},
        ),
      );

      about = aboutFromJson(response.toString()).result.about;
    } catch (err) {
      // ignore: unnecessary_brace_in_string_interps
      print('${err} error from offers list');
    }
  }
}
//{====================about========================}
// To parse this JSON data, do
//
//     final contact =

Contact contactFromJson(String str) => Contact.fromJson(json.decode(str));

String contactToJson(Contact data) => json.encode(data.toJson());

class Contact {
  Contact({
    this.message,
    this.codenum,
    this.status,
    this.result,
  });

  String message;
  int codenum;
  bool status;
  ResultContact result;

  factory Contact.fromJson(Map<String, dynamic> json) => Contact(
        message: json["message"],
        codenum: json["codenum"],
        status: json["status"],
        result: ResultContact.fromJson(json["result"]),
      );

  Map<String, dynamic> toJson() => {
        "message": message,
        "codenum": codenum,
        "status": status,
        "result": result.toJson(),
      };
}

class ResultContact {
  ResultContact({
    this.hotline,
    this.nameSite,
    this.address,
    this.supportEmail,
    this.gmailEmail,
    this.infoEmail,
    this.supportPhone,
    this.secondPhone,
    this.whatsapp,
    this.facebook,
    this.twitter,
    this.instagram,
    this.linkedin,
    this.map,
  });

  String hotline;
  String nameSite;
  String address;
  String supportEmail;
  String gmailEmail;
  String infoEmail;
  String supportPhone;
  String secondPhone;
  String whatsapp;
  String facebook;
  String twitter;
  String instagram;
  String linkedin;
  String map;

  factory ResultContact.fromJson(Map<String, dynamic> json) => ResultContact(
        hotline: json["hotline"],
        nameSite: json["name_site"],
        address: json["address"],
        supportEmail: json["support_email"],
        gmailEmail: json["gmail_email"],
        infoEmail: json["info_email"],
        supportPhone: json["support_phone"],
        secondPhone: json["second_phone"],
        whatsapp: json["whatsapp"],
        facebook: json["facebook"],
        twitter: json["twitter"],
        instagram: json["instagram"],
        linkedin: json["linkedin"],
        map: json["map"],
      );

  Map<String, dynamic> toJson() => {
        "hotline": hotline,
        "name_site": nameSite,
        "address": address,
        "support_email": supportEmail,
        "gmail_email": gmailEmail,
        "info_email": infoEmail,
        "support_phone": supportPhone,
        "second_phone": secondPhone,
        "whatsapp": whatsapp,
        "facebook": facebook,
        "twitter": twitter,
        "instagram": instagram,
        "linkedin": linkedin,
        "map": map,
      };
}

class ContactUsModel with ChangeNotifier {
  String token;
  ContactUsModel({this.token});

  ResultContact contacts;
  String site;
  Future<void> getContactUs(String lang, BuildContext context) async {
    try {
      Dio.Response response = await dio().post(
        'pages/get_contact_info',
        data: Dio.FormData.fromMap(
          {'key': 1234567890, 'lang': lang, 'token_id': token},
        ),
      );
      contacts = contactFromJson(response.toString()).result;
      site = response.data['result']['website_link'];
    } catch (e) {
      showErrorDaialog('No internet', context);
    }
  }
}
