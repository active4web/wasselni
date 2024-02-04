import 'package:cached_network_image/cached_network_image.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';
import 'package:get/get.dart';
import 'package:provider/provider.dart';
import 'package:pull_to_refresh/pull_to_refresh.dart';
import 'package:wassalny/Components/CustomWidgets/MyText.dart';
import 'package:wassalny/Components/CustomWidgets/appBar.dart';
import 'package:wassalny/Components/CustomWidgets/showdialog.dart';
import 'package:wassalny/Screens/Location/view.dart';
import 'package:wassalny/Screens/SetAddress/view.dart';
import 'package:wassalny/Screens/service_details/servicesDetails.dart';
import 'package:wassalny/model/addToFavourite.dart';
import 'package:wassalny/model/categoriseDetails.dart';

import '../../Components/constants.dart';

class CategoryList extends StatefulWidget {
  final int id;
  final int mainID;
  final int searchType;
  CategoryList(this.id, this.mainID, this.searchType);
  @override
  _CategoryListState createState() => _CategoryListState();
}

class _CategoryListState extends State<CategoryList> {
  bool loader = false;
  bool isSorted = false;
  String lang = Get.locale?.languageCode??'ar';
  RefreshController _refreshController =
      RefreshController(initialRefresh: false);
  TextEditingController distanceController = TextEditingController();
  int pageNumber = 0;

  // ignore: override_on_non_overriding_member
  Future<void> future() async {
    setState(() {
      loader = true;
    });
    var provider =
        Provider.of<DetailsOfServicesProvider>(context, listen: false);
    provider.allProduct?.clear();
    var nextLength = provider.allProduct?.length;
    await provider.fetchAllCategories(lang, widget.id, 50, 0, widget.mainID);
    if (provider.allProduct!.length >= nextLength!)
      _refreshController.loadComplete();
    else
      _refreshController.loadNoData();
    setState(() {
      loader = false;
    });
    _refreshController.refreshCompleted();
  }

  Future<void> fetchMore(int page) async {
    var provider =
        Provider.of<DetailsOfServicesProvider>(context, listen: false);
    var nextLength = provider.allProduct!.length;
    try {
      await provider.fetchAllCategories(lang, widget.id, 50 ,page, widget.mainID);
      if (provider.allProduct!.length >= nextLength)
        _refreshController.loadComplete();
      else
        _refreshController.loadNoData();
    } catch (error) {
      _refreshController.refreshCompleted();
      throw (error);
    }
  }

  Future<void> _sentFav(int isFav, int productId) async {
    setState(() {});
    bool done =
        Provider.of<UpdateFavProvider>(context, listen: false).doneSenting;

    try {
      done = await Provider.of<UpdateFavProvider>(context, listen: false)
          .updateFav(
        key: isFav == 0 ? '1' : '2',
        id: productId,
      );

      // ignore: unused_catch_clause
    } catch (error) {
      print(error);
      Navigator.of(context).pop();
      showErrorDaialog('No internet connection', context);
    }
    if (done) {
      future();
    }
  }

  @override
  void initState() {
    future();
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    print(widget.id);
    final width = (MediaQuery.of(context).size.width);
    final info = Provider.of<DetailsOfServicesProvider>(context, listen: false);
    var allProduct = info.allProduct;
    return Scaffold(
      appBar:CategoryAppBar(),
      body: loader
          ? Center(
              child: CircularProgressIndicator(),
            )
          : SmartRefresher(
              onRefresh: () => future(),
              onLoading: () {
                setState(() {
                  pageNumber++;
                });
                fetchMore(pageNumber);
              },
              enablePullUp: true,
        enablePullDown: true,
              controller: _refreshController,
              header: WaterDropHeader(),
              // footer: CustomFooter(
              //   builder: (BuildContext context, LoadStatus mode) {
              //     Widget body;
              //     if (mode == LoadStatus.idle) {
              //       body = Text("pull up load");
              //     } else if (mode == LoadStatus.loading) {
              //       body = CircularProgressIndicator();
              //     } else if (mode == LoadStatus.failed) {
              //       body = Text("Load Failed!Click retry!");
              //     } else if (mode == LoadStatus.canLoading) {
              //       body = Text("release to load more");
              //     } else {
              //       body = Text("");
              //     }
              //     return Container(
              //       height: 55.0,
              //       child: Center(child: body),
              //     );
              //   },
              // ),
              child: ListView(
                padding: EdgeInsets.all(15),
                children: [
                  Container(
                    width: width * 0.7,
                    child: Row(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        MaterialButton(
                          onPressed: () {
                            showDialog(context: context, builder: (context) =>  AlertDialog(
                              content: Column(
                                mainAxisSize: MainAxisSize.min,
                                children: [
                                  Text("مسافة البحث"),
                                  SizedBox(height: 10,),
                                  Row(
                                    children: [
                                      Expanded(
                                        child: TextField(
                                          controller: distanceController,
                                          keyboardType: TextInputType.number,
                                          inputFormatters: [
                                            //To remove first '0'
                                            FilteringTextInputFormatter.deny(RegExp(r'^0+')),
                                          ],
                                          decoration: InputDecoration(
                                            isDense: true,
                                            hintText: "حدد المساحة",
                                            border: OutlineInputBorder(
                                              borderRadius: BorderRadius.circular(10),

                                            ),

                                          ),
                                        ),
                                      ),
                                      SizedBox(width: 10,),
                                      Container(
                                          padding: EdgeInsets.all(10),
                                          decoration: BoxDecoration(
                                              border: Border.all(),
                                              borderRadius: BorderRadius.circular(10)
                                          ),
                                          child: Center(child: Text("كم")))
                                    ],
                                  ),
                                  MaterialButton(
                                     child: Text("متابعة"),
                                    onPressed: (){
                                      if(distanceController.text.isNotEmpty)
                                      try {
                                        Navigator.pop(context);
                                        Get.to(
                                          MapPage(
                                            id: widget.id,
                                            distance: distanceController.text,
                                            searchType: widget.searchType,
                                          ),
                                        );
                                      } catch (e) {
                                        print(e);
                                      }
                                    }
                                  )
                                ],
                              ),
                            ));
                          },
                          child: Text('searchBYMAP'.tr),
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(18.0),
                            side: BorderSide(
                              color: Colors.blue,
                            ),
                          ),
                        ),
                        IconButton(
                            onPressed: () {
                              isSorted = !isSorted;
                              isSorted
                                  ? allProduct?.sort((a, b) =>
                                      a.totalRate!.compareTo(b.totalRate!))
                                  : allProduct?.sort((a, b) =>
                                      b.totalRate!.compareTo(a.totalRate!));
                              setState(() {});
                            },
                            icon: Icon(FontAwesomeIcons.sort)),
                        MaterialButton(
                          onPressed: () {
                            Get.to(SetAddress(
                              vategory: widget.id,
                              searchType: widget.searchType,
                            ));
                          },
                          child: Text('SEARCHBYCITY'.tr),
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(18.0),
                            side: BorderSide(
                              color: Colors.blue,
                            ),
                          ),
                        ),
                      ],
                    ),
                  ),
                  ClipRRect(
                    borderRadius: BorderRadius.circular(30),
                    child: Container(
                      width: width,
                      height: MediaQuery.of(context).size.height * 0.2,
                      decoration: BoxDecoration(
                        borderRadius: BorderRadius.circular(30),
                      ),
                      child: CachedNetworkImage(
                        imageUrl: info.categoryBanner??'',
                        fit: BoxFit.fill,
                        placeholder: (context, url) =>
                            Image.asset(appLogo),
                      ),
                    ),
                  ),
                  SizedBox(
                    height: 8.h
                    ,
                  ),
                  Container(
                    padding: EdgeInsets.symmetric(horizontal: 20.w, vertical: 15.h),
                    decoration: BoxDecoration(
                        borderRadius: BorderRadius.circular(25.r),
                        color: Colors.white),
                    child: Row(
                      children: [
                        Expanded(
                          child: Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            mainAxisAlignment: MainAxisAlignment.start,
                            children: [
                              MyText(title: info.categoryName, size: 25.r),
                            ],
                          ),
                        ),
                        Container(
                            decoration: BoxDecoration(
                              borderRadius: BorderRadius.circular(8),
                              color: Colors.blue.withAlpha(40),
                              image: DecorationImage(
                                image: CachedNetworkImageProvider(
                                    info.categoryImage??''),
                              ),
                            ),
                            height: 70.h,
                            width: 70.w)
                      ],
                    ),
                  ),
                  SizedBox(height: 20.h),
                  allProduct!.isEmpty
                      ? Center(
                          child: Text(
                            "ThereAreNoServices".tr,
                            style: TextStyle(color: Colors.blue, fontSize: 30),
                          ),
                        )
                      : GridView.builder(
                          shrinkWrap: true,
                          physics: NeverScrollableScrollPhysics(),
                          scrollDirection: Axis.vertical,
                          itemCount: allProduct.length,
                          gridDelegate:
                              SliverGridDelegateWithFixedCrossAxisCount(
                            crossAxisSpacing: 0,
                            childAspectRatio: 2 / 2.3,
                            crossAxisCount: 2,
                            mainAxisSpacing: 0,
                          ),
                          itemBuilder: (context, index) {
                            return InkWell(
                              onTap: () {
                                Get.to(
                                  ServicesDetails(id: allProduct[index].prodId),
                                );
                              },
                              child: Column(
                                children: [
                                  Stack(
                                    children: [
                                      Container(
                                          decoration: BoxDecoration(
                                            borderRadius:
                                                BorderRadius.circular(15),
                                            color: Colors.white,
                                            image: DecorationImage(
                                              fit: BoxFit.cover,
                                              image: CachedNetworkImageProvider(
                                                  allProduct[index]
                                                      .productImage??''),
                                            ),
                                          ),
                                          height: 100.h,
                                          width: 100.w),
                                    ],
                                  ),
                                  Row(
                                    mainAxisAlignment: MainAxisAlignment.center,
                                    children: [
                                      IconButton(
                                          onPressed: () => _sentFav(
                                              allProduct[index].favExit!,
                                              allProduct[index].prodId!),
                                          icon: allProduct[index].favExit == 0
                                              ? Icon(
                                                  CupertinoIcons.heart,
                                                  color: Colors.red,
                                                )
                                              : Icon(
                                                  CupertinoIcons.heart_fill,
                                                  color: Colors.red,
                                                )),
                                      SizedBox(
                                        width: 8,
                                      ),
                                      Icon(
                                        Icons.star,
                                        color: Colors.yellow,
                                      ),
                                      allProduct[index].totalRate == '' ||
                                              allProduct[index].totalRate ==
                                                  null
                                          ? Text('0')
                                          : Text(allProduct[index].totalRate??''),
                                    ],
                                  ),
                                  Text(allProduct[index].productName??'',
                                      overflow: TextOverflow.ellipsis,
                                      maxLines: 1,
                                      style: TextStyle(
                                          fontWeight: FontWeight.bold,
                                          fontSize: 18),
                                      textAlign: TextAlign.center),
                                  SizedBox(
                                    height: 5,
                                  ),
                                ],
                              ),
                            );
                          },
                        ),
                ],
              ),
            ),
    );
  }
}
