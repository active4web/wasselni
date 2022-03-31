import 'dart:convert';

import 'package:flutter/cupertino.dart';
import 'package:dio/dio.dart' as Dio;
import 'package:wassalny/network/auth/dio.dart';

// To parse this JSON data, do
//
//     final notifications = notificationsFromJson(jsonString);

Notifications notificationsFromJson(String str) =>
    Notifications.fromJson(json.decode(str));

String notificationsToJson(Notifications data) => json.encode(data.toJson());

class Notifications {
  Notifications({
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
  Result result;

  factory Notifications.fromJson(Map<String, dynamic> json) => Notifications(
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
        "result": result.toJson(),
      };
}

class Result {
  Result({
    this.allNotifications,
  });

  List<AllNotification> allNotifications;

  factory Result.fromJson(Map<String, dynamic> json) => Result(
        allNotifications: List<AllNotification>.from(
            json["all_notifications"].map((x) => AllNotification.fromJson(x))),
      );

  Map<String, dynamic> toJson() => {
        "all_notifications":
            List<dynamic>.from(allNotifications.map((x) => x.toJson())),
      };
}

class AllNotification {
  AllNotification({
    this.title,
    this.id,
    this.body,
    this.isRead,
    this.type,
    this.createdAt,
    this.img,
  });

  String title;
  int id;
  String body;
  int type;
  int isRead;
  DateTime createdAt;
  String img;

  factory AllNotification.fromJson(Map<String, dynamic> json) =>
      AllNotification(
        title: json["title"],
        id: json["id"],
        body: json["body"],
        isRead: json["is_read"],
        type: json["type"],
        createdAt: DateTime.parse(json["created_at"]),
        img: json["img"],
      );

  Map<String, dynamic> toJson() => {
        "title": title,
        "id": id,
        "body": body,
        "is_read": isRead,
        "type": type,
        "created_at":
            "${createdAt.year.toString().padLeft(4, '0')}-${createdAt.month.toString().padLeft(2, '0')}-${createdAt.day.toString().padLeft(2, '0')}",
        "img": img,
      };
}

class NotificationsProvider with ChangeNotifier {
  String token;

  NotificationsProvider({this.token});

  List<AllNotification> allNotification = [];
  int total = 0;
  Future<void> fetchNotifications(int limt, int pageNumber) async {
    try {
      Dio.Response response = await dio().post(
        'pages/get_list_notifications',
        data: Dio.FormData.fromMap(
          {
            'key': 1234567890,
            'token_id': token,
            'limit': limt,
            'page_number': pageNumber,
          },
        ),
      );
      print(response);
      allNotification.addAll(
          notificationsFromJson(response.toString()).result.allNotifications);
      total = notificationsFromJson(response.toString()).total;
    } catch (err) {
      // ignore: unnecessary_brace_in_string_interps
      print('${err} error from offers list');
    }
  }

  Future<void> deleteNotifications(int notificationsId, String lang) async {
    print(notificationsId);
    print(lang);
    try {
      Dio.Response response = await dio().post(
        'pages/delete_notification',
        data: Dio.FormData.fromMap(
          {
            'key': 1234567890,
            'token_id': token,
            'id_notfy': notificationsId,
            'lang': lang
          },
        ),
      );
      print(response);
    } catch (err) {
      // ignore: unnecessary_brace_in_string_interps
      print('${err} error from delete notifications');
    }
  }
}
