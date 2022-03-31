import 'dart:convert';

import 'package:flutter/cupertino.dart';
import 'package:dio/dio.dart' as Dio;
import 'package:wassalny/network/auth/dio.dart';

// To parse this JSON data, do
//
//     final ticketsList =
TicketsList ticketsListFromJson(String str) =>
    TicketsList.fromJson(json.decode(str));

String ticketsListToJson(TicketsList data) => json.encode(data.toJson());

class TicketsList {
  TicketsList({
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

  factory TicketsList.fromJson(Map<String, dynamic> json) => TicketsList(
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
    this.myTickets,
  });

  List<MyTicket> myTickets;

  factory Result.fromJson(Map<String, dynamic> json) => Result(
        myTickets: List<MyTicket>.from(
            json["my_tickets"].map((x) => MyTicket.fromJson(x))),
      );

  Map<String, dynamic> toJson() => {
        "my_tickets": List<dynamic>.from(myTickets.map((x) => x.toJson())),
      };
}

class MyTicket {
  MyTicket({
    this.id,
    this.title,
    this.type,
    this.senderType,
    this.color,
    this.content,
    this.createdAt,
  });

  int id;
  String title;
  Type type;
  String senderType;
  Color color;
  String content;
  DateTime createdAt;

  factory MyTicket.fromJson(Map<String, dynamic> json) => MyTicket(
        id: json["id"],
        title: json["title"],
        type: typeValues.map[json["type"]],
        senderType: json["sender_type"],
        color: colorValues.map[json["color"]],
        content: json["content"],
        createdAt: DateTime.parse(json["created_at"]),
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "title": title,
        "type": typeValues.reverse[type],
        "sender_type": senderType,
        "color": colorValues.reverse[color],
        "content": content,
        "created_at":
            "${createdAt.year.toString().padLeft(4, '0')}-${createdAt.month.toString().padLeft(2, '0')}-${createdAt.day.toString().padLeft(2, '0')}",
      };
}

enum Color { F01_D28, F06800, THE_5_E0_F4_C }

final colorValues = EnumValues({
  "f01d28": Color.F01_D28,
  "f06800": Color.F06800,
  "5e0f4c": Color.THE_5_E0_F4_C
});

enum Type { EMPTY, TYPE, PURPLE }

final typeValues = EnumValues(
    {"مشكلة": Type.EMPTY, "اقتراح": Type.PURPLE, "استفسار": Type.TYPE});

class EnumValues<T> {
  Map<String, T> map;
  Map<T, String> reverseMap;

  EnumValues(this.map);

  Map<T, String> get reverse {
    if (reverseMap == null) {
      reverseMap = map.map((k, v) => new MapEntry(v, k));
    }
    return reverseMap;
  }
}

class TicketsLisstProvider with ChangeNotifier {
  String token;
  TicketsLisstProvider({this.token});
  List<MyTicket> myTickets = [];
  int total;
  Future<void> fetchAllTickets(String lang, int limt, int pageNumber) async {
    try {
      Dio.Response response = await dio().post(
        'pages/tickets',
        data: Dio.FormData.fromMap(
          {
            'key': 1234567890,
            'lang': lang,
            'token_id': token,
            'limit': limt,
            'page_number': pageNumber,
          },
        ),
      );
      print(response);
      total = ticketsListFromJson(response.toString()).total;
      myTickets
          .addAll(ticketsListFromJson(response.toString()).result.myTickets);
    } catch (err) {
      throw (err);
    }
  }
}
