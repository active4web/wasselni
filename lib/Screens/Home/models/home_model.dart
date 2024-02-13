class HomeModel {
  String? message;
  int? codenum;
  bool? status;
  String? lang;
  Result? result;

  HomeModel({this.message, this.codenum, this.status, this.lang, this.result});

  HomeModel.fromJson(Map<String, dynamic> json) {
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
  String? titleRecommended;
  List<MainOffers>? secondOffer;
  List<AllRecommended>? allRecommended;
  List<AllCategories>? allCategories;
  List<AllFeatures>? allFeatures;

  Result(
      {this.mainOffers,
        this.titleRecommended,
        this.secondOffer,
        this.allRecommended,
        this.allCategories,
        this.allFeatures});

  Result.fromJson(Map<String, dynamic> json) {
    if (json['main_offers'] != null) {
      mainOffers = <MainOffers>[];
      json['main_offers'].forEach((v) {
        mainOffers!.add(new MainOffers.fromJson(v));
      });
    }
    titleRecommended = json['title_recommended'];
    if (json['second_offer'] != null) {
      secondOffer = <MainOffers>[];
      json['second_offer'].forEach((v) {
        secondOffer!.add(new MainOffers.fromJson(v));
      });
    }
    if (json['all_recommended'] != null) {
      allRecommended = <AllRecommended>[];
      json['all_recommended'].forEach((v) {
        allRecommended!.add(new AllRecommended.fromJson(v));
      });
    }
    if (json['all_categories'] != null) {
      allCategories = <AllCategories>[];
      json['all_categories'].forEach((v) {
        allCategories!.add(new AllCategories.fromJson(v));
      });
    }
    if (json['all_features'] != null) {
      allFeatures = <AllFeatures>[];
      json['all_features'].forEach((v) {
        allFeatures!.add(new AllFeatures.fromJson(v));
      });
    }
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = new Map<String, dynamic>();
    if (this.mainOffers != null) {
      data['main_offers'] = this.mainOffers!.map((v) => v.toJson()).toList();
    }
    data['title_recommended'] = this.titleRecommended;
    if (this.secondOffer != null) {
      data['second_offer'] = this.secondOffer!.map((v) => v.toJson()).toList();
    }
    if (this.allRecommended != null) {
      data['all_recommended'] =
          this.allRecommended!.map((v) => v.toJson()).toList();
    }
    if (this.allCategories != null) {
      data['all_categories'] =
          this.allCategories!.map((v) => v.toJson()).toList();
    }
    if (this.allFeatures != null) {
      data['all_features'] = this.allFeatures!.map((v) => v.toJson()).toList();
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

class AllRecommended {
  String? recommendedImage;
  int? recommendedPosition;
  int? serviceId;
  int? depId;
  int? catId;
  int? id;
  String? enddate;

  AllRecommended(
      {this.recommendedImage,
        this.recommendedPosition,
        this.serviceId,
        this.depId,
        this.catId,
        this.id,
        this.enddate});

  AllRecommended.fromJson(Map<String, dynamic> json) {
    recommendedImage = json['recommended_image'];
    recommendedPosition = json['recommended_position'];
    serviceId = json['service_id'];
    depId = json['dep_id'];
    catId = json['cat_id'];
    id = json['id'];
    enddate = json['enddate'];
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = new Map<String, dynamic>();
    data['recommended_image'] = this.recommendedImage;
    data['recommended_position'] = this.recommendedPosition;
    data['service_id'] = this.serviceId;
    data['dep_id'] = this.depId;
    data['cat_id'] = this.catId;
    data['id'] = this.id;
    data['enddate'] = this.enddate;
    return data;
  }
}

class AllCategories {
  List<AllDepartment>? allDepartment;
  int? totalDepartment;
  String? categoryManbanner;
  String? categoryImage;
  String? categoryName;
  int? catId;

  AllCategories(
      {this.allDepartment,
        this.totalDepartment,
        this.categoryManbanner,
        this.categoryImage,
        this.categoryName,
        this.catId});

  AllCategories.fromJson(Map<String, dynamic> json) {
    if (json['all_department'] != null) {
      allDepartment = <AllDepartment>[];
      json['all_department'].forEach((v) {
        allDepartment!.add(new AllDepartment.fromJson(v));
      });
    }
    totalDepartment = json['total_department'];
    categoryManbanner = json['category_manbanner'];
    categoryImage = json['category_image'];
    categoryName = json['category_name'];
    catId = json['cat_id'];
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = new Map<String, dynamic>();
    if (this.allDepartment != null) {
      data['all_department'] =
          this.allDepartment!.map((v) => v.toJson()).toList();
    }
    data['total_department'] = this.totalDepartment;
    data['category_manbanner'] = this.categoryManbanner;
    data['category_image'] = this.categoryImage;
    data['category_name'] = this.categoryName;
    data['cat_id'] = this.catId;
    return data;
  }
}

class AllDepartment {
  String? departmentName;
  String? catId;
  String? departmentId;
  String? departmentImage;

  AllDepartment(
      {this.departmentName,
        this.catId,
        this.departmentId,
        this.departmentImage});

  AllDepartment.fromJson(Map<String, dynamic> json) {
    departmentName = json['department_name'];
    catId = json['cat_id'];
    departmentId = json['department_id'];
    departmentImage = json['department_image'];
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = new Map<String, dynamic>();
    data['department_name'] = this.departmentName;
    data['cat_id'] = this.catId;
    data['department_id'] = this.departmentId;
    data['department_image'] = this.departmentImage;
    return data;
  }
}

class AllFeatures {
  int? categoryTotalDepartment;
  int? categoryTotalDepartmentKey;
  String? categoryManbanner;
  String? categoryImage;
  String? categoryName;
  int? catId;
  String? imgBanner;
  List<AllProducts>? allProducts;

  AllFeatures(
      {this.categoryTotalDepartment,
        this.categoryTotalDepartmentKey,
        this.categoryManbanner,
        this.categoryImage,
        this.categoryName,
        this.catId,
        this.imgBanner,
        this.allProducts});

  AllFeatures.fromJson(Map<String, dynamic> json) {
    categoryTotalDepartment = json['category_total_department'];
    categoryTotalDepartmentKey = json['category_total_department_key'];
    categoryManbanner = json['category_manbanner'];
    categoryImage = json['category_image'];
    categoryName = json['category_name'];
    catId = json['cat_id'];
    imgBanner = json['img_banner'];
    if (json['all_products'] != null) {
      allProducts = <AllProducts>[];
      json['all_products'].forEach((v) {
        allProducts!.add(new AllProducts.fromJson(v));
      });
    }
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = new Map<String, dynamic>();
    data['category_total_department'] = this.categoryTotalDepartment;
    data['category_total_department_key'] = this.categoryTotalDepartmentKey;
    data['category_manbanner'] = this.categoryManbanner;
    data['category_image'] = this.categoryImage;
    data['category_name'] = this.categoryName;
    data['cat_id'] = this.catId;
    data['img_banner'] = this.imgBanner;
    if (this.allProducts != null) {
      data['all_products'] = this.allProducts!.map((v) => v.toJson()).toList();
    }
    return data;
  }
}

class AllProducts {
  int? favExit;
  String? totalRate;
  String? productImage;
  String? productName;
  String? phone;
  int? prodId;

  AllProducts(
      {this.favExit,
        this.totalRate,
        this.productImage,
        this.productName,
        this.phone,
        this.prodId});

  AllProducts.fromJson(Map<String, dynamic> json) {
    favExit = json['fav_exit'];
    totalRate = json['total_rate'];
    productImage = json['product_image'];
    productName = json['product_name'];
    phone = json['phone'];
    prodId = json['prod_id'];
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = new Map<String, dynamic>();
    data['fav_exit'] = this.favExit;
    data['total_rate'] = this.totalRate;
    data['product_image'] = this.productImage;
    data['product_name'] = this.productName;
    data['phone'] = this.phone;
    data['prod_id'] = this.prodId;
    return data;
  }
}