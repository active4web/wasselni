// To parse this JSON data, do
//
//     final ticketsDetails =

import 'dart:convert';

import 'package:dio/dio.dart' as Dio;
import 'package:flutter/cupertino.dart';
import 'package:wassalny/network/auth/dio.dart';

TicketsDetails ticketsDetailsFromJson(String str) =>
    TicketsDetails.fromJson(json.decode(str));

String ticketsDetailsToJson(TicketsDetails data) => json.encode(data.toJson());

class TicketsDetails {
  TicketsDetails({
    this.message,
    this.codenum,
    this.status,
    this.result,
  });

  String message;
  int codenum;
  bool status;
  Result result;

  factory TicketsDetails.fromJson(Map<String, dynamic> json) => TicketsDetails(
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
    this.ticketInfo,
  });

  TicketInfo ticketInfo;

  factory Result.fromJson(Map<String, dynamic> json) => Result(
        ticketInfo: TicketInfo.fromJson(json["ticket_info"]),
      );

  Map<String, dynamic> toJson() => {
        "ticket_info": ticketInfo.toJson(),
      };
}

class TicketInfo {
  TicketInfo({
    this.ticket,
    this.repliesNumber,
    this.ticketReplies,
  });

  Ticket ticket;
  int repliesNumber;
  List<TicketReply> ticketReplies;

  factory TicketInfo.fromJson(Map<String, dynamic> json) => TicketInfo(
        ticket: Ticket.fromJson(json["ticket"]),
        repliesNumber: json["replies_number"],
        ticketReplies: List<TicketReply>.from(
            json["ticket_replies"].map((x) => TicketReply.fromJson(x))),
      );

  Map<String, dynamic> toJson() => {
        "ticket": ticket.toJson(),
        "replies_number": repliesNumber,
        "ticket_replies":
            List<dynamic>.from(ticketReplies.map((x) => x.toJson())),
      };
}

class Ticket {
  Ticket({
    this.ticketId,
    this.title,
    this.type,
    this.color,
    this.content,
    this.createdAt,
  });

  int ticketId;
  String title;
  String type;
  String color;
  String content;
  DateTime createdAt;

  factory Ticket.fromJson(Map<String, dynamic> json) => Ticket(
        ticketId: json["ticket_id"],
        title: json["title"],
        type: json["type"],
        color: json["color"],
        content: json["content"],
        createdAt: DateTime.parse(json["created_at"]),
      );

  Map<String, dynamic> toJson() => {
        "ticket_id": ticketId,
        "title": title,
        "type": type,
        "color": color,
        "content": content,
        "created_at":
            "${createdAt.year.toString().padLeft(4, '0')}-${createdAt.month.toString().padLeft(2, '0')}-${createdAt.day.toString().padLeft(2, '0')}",
      };
}

class TicketReply {
  TicketReply({
    this.id,
    this.createdAt,
    this.time,
    this.content,
    this.sender,
    this.senderType,
  });

  int id;
  DateTime createdAt;
  String time;
  String content;
  String sender;
  int senderType;

  factory TicketReply.fromJson(Map<String, dynamic> json) => TicketReply(
        id: json["id"],
        createdAt: DateTime.parse(json["created_at"]),
        time: json["time"],
        content: json["content"],
        sender: json["sender"],
        senderType: json["sender_type"],
      );

  Map<String, dynamic> toJson() => {
        "id": id,
        "created_at":
            "${createdAt.year.toString().padLeft(4, '0')}-${createdAt.month.toString().padLeft(2, '0')}-${createdAt.day.toString().padLeft(2, '0')}",
        "time": time,
        "content": content,
        "sender": sender,
        "sender_type": senderType,
      };
}

class TicketsDetailsProvider with ChangeNotifier {
  String token;
  TicketsDetailsProvider({this.token});

  Ticket ticket;
  List<TicketReply> replay = [];
  int type;
  Future<void> fetchDetails(String lan, int id) async {
    try {
      Dio.Response response = await dio().post('pages/ticket',
          data: Dio.FormData.fromMap({
            'key': 1234567890,
            'token_id': token,
            'lang': lan,
            'ticket_id': id
          }));
      print(response);
      replay = ticketsDetailsFromJson(response.toString())
          .result
          .ticketInfo
          .ticketReplies;
      ticket =
          ticketsDetailsFromJson(response.toString()).result.ticketInfo.ticket;

      for (var i = 0; i < replay.length; i++) {
        type = replay[i].senderType;
      }
    } catch (e) {
      throw (e);
    }
  }

  Future<void> sentReplay(String lang, String replay, int id) async {
    try {
      Dio.Response response = await dio().post(
        'pages/new_reply',
        data: Dio.FormData.fromMap(
          {
            'lang': lang,
            'token_id': token,
            'key': 1234567890,
            'content': replay,
            'ticket_id': id,
          },
        ),
      );
      print(response);

      notifyListeners();
    } catch (e) {
      throw (e);
    }
  }
}
