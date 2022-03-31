import 'dart:convert';

import 'package:dio/dio.dart' as Dio;
import 'package:flutter/cupertino.dart';
import 'package:wassalny/network/auth/dio.dart';

// To parse this JSON data, do
//
//     final ticketsType

TicketsType ticketsTypeFromJson(String str) =>
    TicketsType.fromJson(json.decode(str));

String ticketsTypeToJson(TicketsType data) => json.encode(data.toJson());

class TicketsType {
  TicketsType({
    this.message,
    this.codenum,
    this.status,
    this.result,
  });

  String message;
  int codenum;
  bool status;
  Result result;

  factory TicketsType.fromJson(Map<String, dynamic> json) => TicketsType(
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
    this.ticketsTypes,
  });

  List<TicketsTypeElement> ticketsTypes;

  factory Result.fromJson(Map<String, dynamic> json) => Result(
        ticketsTypes: List<TicketsTypeElement>.from(
            json["tickets_types"].map((x) => TicketsTypeElement.fromJson(x))),
      );

  Map<String, dynamic> toJson() => {
        "tickets_types":
            List<dynamic>.from(ticketsTypes.map((x) => x.toJson())),
      };
}

class TicketsTypeElement {
  TicketsTypeElement({
    this.id,
    this.name,
    this.color,
  });

  int id;
  String name;
  String color;

  factory TicketsTypeElement.fromJson(Map<String, dynamic> json) =>
      TicketsTypeElement(
        id: json["id"],
        name: json["name"],
        color: json["color"],
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "name": name,
        "color": color,
      };
}

class TicketsTypeProvider with ChangeNotifier {
  String token;
  TicketsTypeProvider({this.token});

  List<TicketsTypeElement> type = [];
  Future<void> fetchtype(String lang) async {
    try {
      Dio.Response response = await dio().post(
        'pages/tickets_types',
        data: Dio.FormData.fromMap(
          {'key': 1234567890, 'lang': lang, 'token_id': token},
        ),
      );
      print(response);
      type = ticketsTypeFromJson(response.toString()).result.ticketsTypes;
    } catch (err) {}
  }
}
