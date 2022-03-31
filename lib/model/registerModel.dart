// To parse this JSON data, do
//
//     final registerModel = registerModelFromJson(jsonString);

import 'dart:convert';

RegisterModel registerModelFromJson(String str) => RegisterModel.fromJson(json.decode(str));

String registerModelToJson(RegisterModel data) => json.encode(data.toJson());

class RegisterModel {
    RegisterModel({
        this.message,
        this.codenum,
        this.status,
        this.result,
    });

    String message;
    int codenum;
    bool status;
    Result result;

    factory RegisterModel.fromJson(Map<String, dynamic> json) => RegisterModel(
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
        this.clientData,
    });

    List<ClientDatumR> clientData;

    factory Result.fromJson(Map<String, dynamic> json) => Result(
        clientData: List<ClientDatumR>.from(json["client_data"].map((x) => ClientDatumR.fromJson(x))),
    );

    Map<String, dynamic> toJson() => {
        "client_data": List<dynamic>.from(clientData.map((x) => x.toJson())),
    };
}

class ClientDatumR {
    ClientDatumR({
        this.name,
        this.phone,
        this.id,
        this.fullname,
        this.lang,
        this.token,
    });

    String name;
    String phone;
    int id;
    String fullname;
    String lang;
    String token;

    factory ClientDatumR.fromJson(Map<String, dynamic> json) => ClientDatumR(
        name: json["name"],
        phone: json["phone"],
        id: json["id"],
        fullname: json["fullname"],
        lang: json["lang"],
        token: json["token"],
    );

    Map<String, dynamic> toJson() => {
        "name": name,
        "phone": phone,
        "id": id,
        "fullname": fullname,
        "lang": lang,
        "token": token,
    };
}
