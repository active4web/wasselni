import 'package:get_storage/get_storage.dart';

class User {
  //{============To Sent Login============}
  String phone;
  num key = 1234567890;
  String oldPassword = "0";

  final saveToken = GetStorage();
  Map<String, dynamic> sentPhoneToLogin(String fireBaseToken) {
    return {
      'phone': phone,
      'key': 1234567890,
      'firebase_id': fireBaseToken,
      "password": oldPassword
    };
  }

  //{============To Sent Edait Profile============}
  String phoneEdaite;
  String adressEdaite;
  String nameEdaite;

  Map<String, dynamic> sentEdaitProfile(
      String token, String lang, String city, String cityId) {
    return {
      'key': 1234567890,
      'phone': phoneEdaite,
      'name': nameEdaite,
      'address': adressEdaite,
      'lang': lang,
      'token_id': token,
      'country_name': city,
      'country_id': cityId
    };
  }

  //{============To Sent  Subscribtion============}
  String subPhone;
  int subId;
  String subName;
  String subAdress;
  String subdetails;

  Map<String, dynamic> sentSub(String token, String lang) {
    return {
      'key': 1234567890,
      'token_id': token,
      'name': subName,
      'phone': subPhone,
      'address': subAdress,
      'cat_id': subId,
      'details': subdetails,
      'lang': lang,
    };
  }

  //{============To Sent tickets============}
  int ticId;
  String title;
  String content;

  Map<String, dynamic> sentTickets(String token, String lang) {
    return {
      'token_id': token,
      'key': 1234567890,
      'lang': lang,
      'ticket_type_id': ticId,
      'title': title,
      'content': content
    };
  }
  //{============To Sent register============}

  String newname;
  String newphone;
  String newAdress;

  String password;

  Map<String, dynamic> sentRegister(
      String token, String lang, String country, String fireBaseToken) {
    return {
      'key': 1234567890,
      'lang': lang,
      'fullname': newname,
      'phone': newphone,
      'address': newAdress,
      'firebase_id': fireBaseToken,
      'Country': country,
      "password": password
    };
  }
}
