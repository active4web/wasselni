import 'package:auto_size_text/auto_size_text.dart';
import 'package:carousel_pro/carousel_pro.dart';
import 'package:dotted_border/dotted_border.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:provider/provider.dart';
import 'package:wassalny/Components/CustomWidgets/showdialog.dart';
import 'package:wassalny/Screens/service_details/servicesDetails.dart';
import 'package:wassalny/Screens/service_details/services_offer.dart';
import 'package:wassalny/model/addToFavourite.dart';
import 'package:wassalny/model/searchByCity.dart';
import 'package:wassalny/model/searchByCityOffers.dart';

// package:wasalny/Screens/service_details/servicesDetails.dart

class SearchCityOfferScreen extends StatefulWidget {
  final List<AllOffer> search;
  SearchCityOfferScreen({
    this.search,
  });
  @override
  _SearchCityOfferScreenState createState() => _SearchCityOfferScreenState();
}

class _SearchCityOfferScreenState extends State<SearchCityOfferScreen> {
  @override
  Widget build(BuildContext context) {
    final width = (MediaQuery.of(context).size.width);
    final hight = (MediaQuery.of(context).size.height -
        MediaQuery.of(context).padding.top);
    print(widget.search.toString());
    List<AllGallery> allGalleries =
        Provider.of<SearchOffersByCity>(context, listen: false).allGalery;
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
      body: Padding(
        padding: EdgeInsets.symmetric(vertical: 10, horizontal: 8),
        child: widget.search.isEmpty
            ? Center(
                child: Text(
                  "NoSearch".tr,
                  style: TextStyle(
                      fontSize: 30,
                      fontWeight: FontWeight.bold,
                      color: Colors.blue),
                ),
              )
            : ListView(
                shrinkWrap: true,
                children: [
                  widget.search.isEmpty
                      ? Center(
                          child: Padding(
                            padding: EdgeInsets.only(
                                top: MediaQuery.of(context).size.height * 0.4),
                            child: Text(
                              "NoOffres".tr,
                              style:
                                  TextStyle(fontSize: 30, color: Colors.blue),
                            ),
                          ),
                        )
                      : Padding(
                          padding: EdgeInsets.only(bottom: hight * 0.13),
                          child: ListView.builder(
                            physics: NeverScrollableScrollPhysics(),
                            shrinkWrap: true,
                            itemCount: widget.search.length,
                            itemBuilder: (context, index) {
                              return Container(
                                width: width,
                                // margin: EdgeInsets.only(bottom: hight * 0.02),
                                decoration: BoxDecoration(
                                  borderRadius: BorderRadius.circular(15),
                                  border: Border.all(color: Colors.black),
                                ),

                                child: Column(children: [
                                  Center(
                                    child: Text(
                                      "${"to".tr} : ${widget.search[index].endDate}",
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
                                      crossAxisAlignment:
                                          CrossAxisAlignment.start,
                                      mainAxisAlignment:
                                          MainAxisAlignment.spaceBetween,
                                      children: [
                                        Column(
                                          children: [
                                            GestureDetector(
                                              onTap: () {
                                                Get.to(
                                                  ServicesOffers(
                                                      widget.search[index]
                                                          .serviceImage,
                                                      int.parse(widget
                                                          .search[index]
                                                          .serviceId),
                                                      widget.search[index]
                                                          .serviceName),
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
                                                    widget.search[index]
                                                        .serviceImage,
                                                    fit: BoxFit.fill,
                                                  ),
                                                ),
                                              ),
                                            ),
                                            Text(
                                              widget.search[index].serviceName,
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
                                                            const EdgeInsets
                                                                .all(2.5),
                                                        child: AutoSizeText(
                                                            widget.search[index]
                                                                .description),
                                                      ),
                                                      Container(
                                                        child: Row(
                                                          // mainAxisAlignment: MainAxisAlignment.center,
                                                          children: [
                                                            Row(
                                                              children: [
                                                                Text(
                                                                  widget
                                                                      .search[
                                                                          index]
                                                                      .oldPrice,
                                                                  style: TextStyle(
                                                                      fontWeight:
                                                                          FontWeight
                                                                              .bold,
                                                                      fontSize:
                                                                          20,
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
                                                                  widget
                                                                      .search[
                                                                          index]
                                                                      .newPrice,
                                                                  style:
                                                                      TextStyle(
                                                                    fontWeight:
                                                                        FontWeight
                                                                            .bold,
                                                                    fontSize:
                                                                        20,
                                                                    color: Colors
                                                                        .blue,
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
                                                        BorderRadius.circular(
                                                            15),
                                                  ),
                                                  child: InkWell(
                                                    onTap: () {
                                                      return showDialog(
                                                        useSafeArea: true,
                                                        context: context,
                                                        builder: (context) {
                                                          return Carousel(
                                                            images: allGalleries
                                                                .map(
                                                                    (e) =>
                                                                        Padding(
                                                                          padding:
                                                                              const EdgeInsets.all(8.0),
                                                                          child:
                                                                              Container(
                                                                            child:
                                                                                Image.network(
                                                                              e.offersImage,
                                                                            ),
                                                                          ),
                                                                        ))
                                                                .toList(),
                                                            autoplay: false,
                                                          );
                                                        },
                                                      );
                                                    },
                                                    child: Image.network(widget
                                                        .search[index]
                                                        .offerImage),
                                                  )),
                                            ),
                                            Text(
                                                widget.search[index].offerName),
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
                ],
              ),
      ),
    );
  }
}
