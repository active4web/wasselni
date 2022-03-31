// To parse this JSON data, do
//
//     final notificationDetails =

import 'dart:convert';

import 'package:flutter/cupertino.dart';
import 'package:dio/dio.dart' as Dio;
import 'package:wassalny/network/auth/dio.dart';

NotificationDetails notificationDetailsFromJson(String str) =>
    NotificationDetails.fromJson(json.decode(str));

String notificationDetailsToJson(NotificationDetails data) =>
    json.encode(data.toJson());

class NotificationDetails {
  NotificationDetails({
    this.message,
    this.codenum,
    this.status,
    this.result,
  });

  String message;
  int codenum;
  bool status;
  Result result;

  factory NotificationDetails.fromJson(Map<String, dynamic> json) =>
      NotificationDetails(
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
    this.notificationDetails,
  });

  NotificationDetailsClass notificationDetails;

  factory Result.fromJson(Map<String, dynamic> json) => Result(
        notificationDetails:
            NotificationDetailsClass.fromJson(json["notification_details"]),
      );

  Map<String, dynamic> toJson() => {
        "notification_details": notificationDetails.toJson(),
      };
}

class NotificationDetailsClass {
  NotificationDetailsClass({
    this.title,
    this.id,
    this.body,
    this.isRead,
    this.createdAt,
    this.img,
  });

  String title;
  int id;
  String body;
  int isRead;
  DateTime createdAt;
  String img;

  factory NotificationDetailsClass.fromJson(Map<String, dynamic> json) =>
      NotificationDetailsClass(
        title: json["title"],
        id: json["id"],
        body: json["body"],
        isRead: json["is_read"],
        createdAt: DateTime.parse(json["created_at"]),
        img: json["img"],
      );

  Map<String, dynamic> toJson() => {
        "title": title,
        "id": id,
        "body": body,
        "is_read": isRead,
        "created_at":
            "${createdAt.year.toString().padLeft(4, '0')}-${createdAt.month.toString().padLeft(2, '0')}-${createdAt.day.toString().padLeft(2, '0')}",
        "img": img,
      };
}

class NotificationDetailsProvider with ChangeNotifier {
  String token;
  NotificationDetailsProvider({this.token});
  String tilte = '';
  String body = '';
  Future<void> fetchDetails(int id) async {
    try {
      Dio.Response response = await dio().post(
        'pages/get_notification_details',
        data: Dio.FormData.fromMap(
          {
            'key': 1234567890,
            'token_id': token,
            'id_notify': id,
          },
        ),
      );
      tilte = response.data['result']['notification_details']['title'];
      body = response.data['result']['notification_details']['body'];
      print(tilte);
    } catch (err) {
      // ignore: unnecessary_brace_in_string_interps
      print('${err} error from offers list');
    }
  }
}
