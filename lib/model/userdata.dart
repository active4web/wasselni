// To parse this JSON data, do
//
//     final userData = userDataFromJson(jsonString);

import 'dart:convert';

UserData userDataFromJson(String str) => UserData.fromJson(json.decode(str));

String userDataToJson(UserData data) => json.encode(data.toJson());

class UserData {
    UserData({
        this.message,
        this.codenum,
        this.status,
        this.result,
    });

    String? message;
    dynamic codenum;
    bool? status;
    Result? result;

    factory UserData.fromJson(Map<String, dynamic> json) => UserData(
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
        this.clientData,
    });

    List<ClientDatum>? clientData;

    factory Result.fromJson(Map<String, dynamic> json) => Result(
        clientData: List<ClientDatum>.from(json["client_data"].map((x) => ClientDatum.fromJson(x))),
    );

    Map<String, dynamic> toJson() => {
        "client_data": List<dynamic>.from(clientData!.map((x) => x.toJson())),
    };
}

class ClientDatum {
    ClientDatum({
        this.phone,
        this.id,
        this.fullname,
        this.lang,
        this.token,
    });

    String? phone;
    int? id;
    String? fullname;
    String? lang;
    String? token;

    factory ClientDatum.fromJson(Map<String, dynamic> json) => ClientDatum(
        phone: json["phone"],
        id: json["id"],
        fullname: json["fullname"],
        lang: json["lang"],
        token: json["token"],
    );

    Map<String, dynamic> toJson() => {
        "phone": phone,
        "id": id,
        "fullname": fullname,
        "lang": lang,
        "token": token,
    };
}
