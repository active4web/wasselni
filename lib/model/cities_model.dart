class CitiesModel {
  String? message;
  int? codenum;
  bool? status;
  Result? result;

  CitiesModel({this.message, this.codenum, this.status, this.result});

  CitiesModel.fromJson(Map<String, dynamic> json) {
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
      data['result'] = this.result!.toJson();
    }
    return data;
  }
}

class Result {
  List<AllStates>? allStates;

  Result({this.allStates});

  Result.fromJson(Map<String, dynamic> json) {
    if (json['all_states'] != null) {
      allStates = <AllStates>[];
      json['all_states'].forEach((v) {
        allStates!.add(new AllStates.fromJson(v));
      });
    }
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = new Map<String, dynamic>();
    if (this.allStates != null) {
      data['all_states'] = this.allStates!.map((v) => v.toJson()).toList();
    }
    return data;
  }
}

class AllStates {
  String? stateName;
  String? stateId;

  AllStates({this.stateName, this.stateId});

  AllStates.fromJson(Map<String, dynamic> json) {
    stateName = json['state_name'];
    stateId = json['state_id'];
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = new Map<String, dynamic>();
    data['state_name'] = this.stateName;
    data['state_id'] = this.stateId;
    return data;
  }
}