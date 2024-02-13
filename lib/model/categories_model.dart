class CategoriesModel {
  String? message;
  int? codenum;
  bool? status;
  String? lang;
  Result? result;

  CategoriesModel(
      {this.message, this.codenum, this.status, this.lang, this.result});

  CategoriesModel.fromJson(Map<String, dynamic> json) {
    message = json['message'];
    codenum = json['codenum'];
    status = json['status'];
    lang = json['$lang'];
    result =
    json['result'] != null ? new Result.fromJson(json['result']) : null;
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = new Map<String, dynamic>();
    data['message'] = this.message;
    data['codenum'] = this.codenum;
    data['status'] = this.status;
    data['$lang'] = this.lang;
    if (this.result != null) {
      data['result'] = this.result!.toJson();
    }
    return data;
  }
}

class Result {
  List<MainOffers>? mainOffers;
  List<ListCats>? listCats;

  Result({this.mainOffers, this.listCats});

  Result.fromJson(Map<String, dynamic> json) {
    if (json['main_offers'] != null) {
      mainOffers = <MainOffers>[];
      json['main_offers'].forEach((v) {
        mainOffers!.add(new MainOffers.fromJson(v));
      });
    }
    if (json['list_cats'] != null) {
      listCats = <ListCats>[];
      json['list_cats'].forEach((v) {
        listCats!.add(new ListCats.fromJson(v));
      });
    }
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = new Map<String, dynamic>();
    if (this.mainOffers != null) {
      data['main_offers'] = this.mainOffers!.map((v) => v.toJson()).toList();
    }
    if (this.listCats != null) {
      data['list_cats'] = this.listCats!.map((v) => v.toJson()).toList();
    }
    return data;
  }
}

class MainOffers {
  String? image;
  String? link;
  String? serviceId;

  MainOffers({this.image, this.link, this.serviceId});

  MainOffers.fromJson(Map<String, dynamic> json) {
    image = json['image'];
    link = json['link'];
    serviceId = json['service_id'];
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = new Map<String, dynamic>();
    data['image'] = this.image;
    data['link'] = this.link;
    data['service_id'] = this.serviceId;
    return data;
  }
}

class ListCats {
  String? catId;
  String? categoryImage;
  String? categoryName;

  ListCats({this.catId, this.categoryImage, this.categoryName});

  ListCats.fromJson(Map<String, dynamic> json) {
    catId = json['cat_id'];
    categoryImage = json['category_image'];
    categoryName = json['category_name'];
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = new Map<String, dynamic>();
    data['cat_id'] = this.catId;
    data['category_image'] = this.categoryImage;
    data['category_name'] = this.categoryName;
    return data;
  }
}