class ConditionModel {
  String? message;
  int? codenum;
  bool? status;
  Result? result;

  ConditionModel({this.message, this.codenum, this.status, this.result});

  ConditionModel.fromJson(Map<String, dynamic> json) {
    message = json['message'];
    codenum = json['codenum'];
    status = json['status'];
    result =
    json['result'] != null ? new Result.fromJson(json['result']) : null;
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = new Map<String, dynamic>();
    data['message'] = this.message;
    data['codenum'] = this.codenum;
    data['status'] = this.status;
    if (this.result != null) {
      data['result'] = this.result?.toJson();
    }
    return data;
  }
}

class Result {
  String? termsConditions;
  String? hotline;
  String? nameSite;
  String? address;
  String? supportEmail;
  String? supportPhone;
  String? whatsapp;
  String? facebook;
  String? twitter;
  String? instagram;
  String? linkedin;
  String? websiteLink;

  Result(
      {this.termsConditions,
        this.hotline,
        this.nameSite,
        this.address,
        this.supportEmail,
        this.supportPhone,
        this.whatsapp,
        this.facebook,
        this.twitter,
        this.instagram,
        this.linkedin,
        this.websiteLink});

  Result.fromJson(Map<String, dynamic> json) {
    termsConditions = json['terms_conditions'];
    hotline = json['hotline'];
    nameSite = json['name_site'];
    address = json['address'];
    supportEmail = json['support_email'];
    supportPhone = json['support_phone'];
    whatsapp = json['whatsapp'];
    facebook = json['facebook'];
    twitter = json['twitter'];
    instagram = json['instagram'];
    linkedin = json['linkedin'];
    websiteLink = json['website_link'];
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = new Map<String, dynamic>();
    data['terms_conditions'] = this.termsConditions;
    data['hotline'] = this.hotline;
    data['name_site'] = this.nameSite;
    data['address'] = this.address;
    data['support_email'] = this.supportEmail;
    data['support_phone'] = this.supportPhone;
    data['whatsapp'] = this.whatsapp;
    data['facebook'] = this.facebook;
    data['twitter'] = this.twitter;
    data['instagram'] = this.instagram;
    data['linkedin'] = this.linkedin;
    data['website_link'] = this.websiteLink;
    return data;
  }
}