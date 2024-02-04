class AllPointsModel {
  String? message;
  int? messageid;
  bool? status;
  int? total;
  Result? result;

  AllPointsModel(
      {this.message, this.messageid, this.status, this.total, this.result});

  AllPointsModel.fromJson(Map<String, dynamic> json) {
    message = json['Message'];
    messageid = json['Messageid'];
    status = json['status'];
    total = json['total'];
    result =
        json['result'] != null ? new Result.fromJson(json['result']) : null;
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = new Map<String, dynamic>();
    data['Message'] = this.message;
    data['Messageid'] = this.messageid;
    data['status'] = this.status;
    data['total'] = this.total;
    if (this.result != null) {
      data['result'] = this.result?.toJson();
    }
    return data;
  }
}

class Result {
  List<AllProviders>? allProviders;

  Result({this.allProviders});

  Result.fromJson(Map<String, dynamic> json) {
    if (json['all_providers'] != null) {
        allProviders =  <AllProviders>[];
      json['all_providers'].forEach((v) {
        allProviders?.add( AllProviders.fromJson(v));
      });
    }
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = new Map<String, dynamic>();
    final allProviders = this.allProviders;
    if (allProviders != null) {
      data['all_providers'] = allProviders.map((v) => v.toJson()).toList();
    }
    return data;
  }
}

class AllProviders {
  String? userName;
  String? totalPoints;
  String? userPhone;

  AllProviders({this.userName, this.totalPoints, this.userPhone});

  AllProviders.fromJson(Map<String, dynamic> json) {
    userName = json['user_name'];
    totalPoints = json['total_points'];
    userPhone = json['user_phone'];
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = new Map<String, dynamic>();
    data['user_name'] = this.userName;
    data['total_points'] = this.totalPoints;
    data['user_phone'] = this.userPhone;
    return data;
  }
}
