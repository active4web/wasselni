import 'package:auto_size_text/auto_size_text.dart';
import 'package:dotted_border/dotted_border.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:provider/provider.dart';
import 'package:pull_to_refresh/pull_to_refresh.dart';
import 'package:wassalny/Components/CustomWidgets/showdialog.dart';
import 'package:wassalny/Screens/service_details/servicesDetails.dart';
import 'package:wassalny/Screens/service_details/services_offer.dart';
import 'package:wassalny/model/addToFavourite.dart';
import 'package:wassalny/model/searchLAndLat.dart';
import 'package:wassalny/model/searchoffersLAndLat.dart';

// package:wasalny/Screens/service_details/servicesDetails.dart

class SearchLatAndLagOffersScreen extends StatefulWidget {
  final int? catId;
  final double? lat;
  final double? lag;
  final String? distance;
  final int? searchType;
  const SearchLatAndLagOffersScreen(
      {this.catId, this.lag, this.lat, this.searchType, this.distance});

  @override
  _SearchLatAndLagOffersScreenState createState() =>
      _SearchLatAndLagOffersScreenState();
}

class _SearchLatAndLagOffersScreenState
    extends State<SearchLatAndLagOffersScreen> {
  RefreshController _refreshController =
      RefreshController(initialRefresh: false);
  bool loader=false;
  String lang = Get.locale?.languageCode??'';

  Future<void> future() async {
    loader = true;
    var provider =
        Provider.of<SearchLatAndLagOffersProvider>(context, listen: false);
    provider.searchLatAndLag.clear();
    // var nextLength = provider.searchLatAndLag.length + 20;
    try {
      await provider.fetchSearch(
          catId: widget.catId,
          limt: 100,
          pageNumber: 0,
          lat: widget.lat,
          lag: widget.lag,
          distance: widget.distance,
          // departmentId: widget.searchType,
          lang: lang);
      print(widget.catId);
      print(widget.lat);
      print(widget.lag);
      // Get.snackbar('الاحداثيات', "long : ${widget.lag} , lat : ${widget.lat} ",
      //     snackPosition: SnackPosition.BOTTOM,
      //     instantInit: true,
      //     duration: Duration(seconds: 10));

      setState(() {
        loader = false;
      });
      _refreshController.refreshCompleted();
      // _refreshController.loadComplete();
    } catch (error) {
      _refreshController.refreshCompleted();
      // _refreshController.loadComplete();
      print(error);
      setState(() {
        loader = false;
      });
      throw (error);
    }
  }

  void initState() {
    future();
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    final width = (MediaQuery.of(context).size.width);
    final hight = (MediaQuery.of(context).size.height -
        MediaQuery.of(context).padding.top);
    print(widget.catId);
    final List<AllOffer> list1 =
        Provider.of<SearchLatAndLagOffersProvider>(context).searchLatAndLag;
    List<AllGallery> allGalleries =
        Provider.of<SearchLatAndLagOffersProvider>(context, listen: false)
            .galleries;
    return Scaffold(
      appBar: AppBar(
        backgroundColor: Colors.white,
        title: Text(
          "researchResults".tr,
          style: TextStyle(
            color: Colors.blue,
          ),
        ),
        centerTitle: true,
        iconTheme: IconThemeData(
          color: Colors.blue,
        ),
      ),
      body: loader
          ? Center(child: CircularProgressIndicator())
          : Padding(
              padding: EdgeInsets.symmetric(vertical: 10, horizontal: 8),
              child: list1.isEmpty
                  ? Center(
                      child: Text(
                        "NoSearch".tr,
                        style: TextStyle(
                            fontSize: 30,
                            fontWeight: FontWeight.bold,
                            color: Colors.blue),
                      ),
                    )
                  : ListView.builder(
                    padding: EdgeInsets.only(bottom: hight * 0.13),
                    itemCount: list1.length,
                    itemBuilder: (context, index) {
                      return Container(
                        width: width,
                        margin: EdgeInsets.only(bottom: hight * 0.02),
                        decoration: BoxDecoration(
                          borderRadius: BorderRadius.circular(15),
                          border: Border.all(color: Colors.black),
                        ),

                        child: Column(children: [
                          Center(
                            child: Text(
                              "${"to".tr} : ${list1[index].endDate}",
                              style: TextStyle(
                                fontWeight: FontWeight.bold,
                                fontSize: 18,
                                color: Colors.blue,
                              ),
                              maxLines: 1,
                            ),
                          ),
                          Padding(
                            padding: EdgeInsets.all(width * 0.02),
                            child: Row(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              mainAxisAlignment:
                                  MainAxisAlignment.spaceBetween,
                              children: [
                                Column(
                                  children: [
                                    GestureDetector(
                                      onTap: () {
                                        Get.to(
                                          ServicesOffers(
                                              list1[index].serviceImage??'',
                                              int.parse(
                                                  list1[index].serviceId??''),
                                              list1[index].serviceName??''),
                                        );
                                      },
                                      child: Container(
                                        width: width * 0.28,
                                        height: hight * 0.17,
                                        decoration: BoxDecoration(
                                          borderRadius:
                                              BorderRadius.circular(15),
                                        ),
                                        child: ClipRRect(
                                          borderRadius:
                                              BorderRadius.circular(15),
                                          child: Image.network(
                                            list1[index].serviceImage??'',
                                            fit: BoxFit.fill,
                                          ),
                                        ),
                                      ),
                                    ),
                                    Text(
                                      list1[index].serviceName??'',
                                    ),
                                    SizedBox(
                                      height: hight * 0.01,
                                    ),
                                    DottedBorder(
                                      color: Colors.black,
                                      borderType: BorderType.RRect,
                                      radius: Radius.circular(15),
                                      padding: EdgeInsets.all(6),
                                      child: Container(
                                          height: hight * 0.2,
                                          width: width * 0.35,
                                          child: ListView(
                                            children: [
                                              Padding(
                                                padding:
                                                    const EdgeInsets.all(
                                                        2.5),
                                                child: AutoSizeText(
                                                    list1[index]
                                                        .description??''),
                                              ),
                                              Container(
                                                child: Row(
                                                  // mainAxisAlignment: MainAxisAlignment.center,
                                                  children: [
                                                    Row(
                                                      children: [
                                                        Text(
                                                          list1[index]
                                                              .oldPrice??'',
                                                          style: TextStyle(
                                                              fontWeight:
                                                                  FontWeight
                                                                      .bold,
                                                              fontSize: 20,
                                                              color: Colors
                                                                  .blue,
                                                              decoration:
                                                                  TextDecoration
                                                                      .lineThrough),
                                                        ),
                                                        SizedBox(
                                                            width: width *
                                                                0.03),
                                                        Text(
                                                          list1[index]
                                                              .newPrice??'',
                                                          style: TextStyle(
                                                            fontWeight:
                                                                FontWeight
                                                                    .bold,
                                                            fontSize: 20,
                                                            color:
                                                                Colors.blue,
                                                          ),
                                                        ),
                                                      ],
                                                    ),
                                                  ],
                                                ),
                                              ),
                                            ],
                                          )),
                                    ),
                                  ],
                                ),
                                // SizedBox(
                                //   width: width * 0.02,
                                // ),
                                Column(
                                  children: [
                                    ClipRRect(
                                      borderRadius:
                                          BorderRadius.circular(15),
                                      child: Container(
                                          height: hight * 0.4,
                                          width: width * 0.5,
                                          decoration: BoxDecoration(
                                            borderRadius:
                                                BorderRadius.circular(15),
                                          ),
                                          child: InkWell(
                                            onTap: () {
                                              //  showDialog(
                                              //   useSafeArea: true,
                                              //   context: context,
                                              //   builder: (context) {
                                              //     return Carousel(
                                              //       images: allGalleries
                                              //           .map((e) => Padding(
                                              //                 padding:
                                              //                     const EdgeInsets
                                              //                             .all(
                                              //                         8.0),
                                              //                 child:
                                              //                     Container(
                                              //                   child: Image
                                              //                       .network(
                                              //                     e.offersImage,
                                              //                   ),
                                              //                 ),
                                              //               ))
                                              //           .toList(),
                                              //       autoplay: false,
                                              //     );
                                              //   },
                                              // );
                                            },
                                            child: Image.network(
                                                list1[index].offerImage??''),
                                          )),
                                    ),
                                    Text(list1[index].offerName??''),
                                    SizedBox(
                                      height: hight * 0.02,
                                    ),
                                  ],
                                ),
                              ],
                            ),
                          ),
                        ]),
                      );
                    },
                  ),
            ),
    );
  }
}
