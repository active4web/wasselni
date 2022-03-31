class StatesModel {
  String message;
  int codenum;
  bool status;
  Result result;

  StatesModel({this.message, this.codenum, this.status, this.result});

  StatesModel.fromJson(Map<String, dynamic> json) {
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
      data['result'] = this.result.toJson();
    }
    return data;
  }
}

class Result {
  List<CityDetails> cityDetails;

  Result({this.cityDetails});

  Result.fromJson(Map<String, dynamic> json) {
    if (json['city_details'] != null) {
      cityDetails = new List<CityDetails>();
      json['city_details'].forEach((v) {
        cityDetails.add(new CityDetails.fromJson(v));
      });
    }
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = new Map<String, dynamic>();
    if (this.cityDetails != null) {
      data['city_details'] = this.cityDetails.map((v) => v.toJson()).toList();
    }
    return data;
  }
}

class CityDetails {
  String stateName;
  String currencyName;
  int stateId;
  String shippingCharges;

  CityDetails(
      {this.stateName, this.currencyName, this.stateId, this.shippingCharges});

  CityDetails.fromJson(Map<String, dynamic> json) {
    stateName = json['state_name'];
    currencyName = json['currency_name'];
    stateId = json['state_id'];
    shippingCharges = json['shipping_charges'];
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = new Map<String, dynamic>();
    data['state_name'] = this.stateName;
    data['currency_name'] = this.currencyName;
    data['state_id'] = this.stateId;
    data['shipping_charges'] = this.shippingCharges;
    return data;
  }
}
