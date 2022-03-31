import 'package:carousel_pro/carousel_pro.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:provider/provider.dart';
import 'package:auto_size_text/auto_size_text.dart';
import 'package:dotted_border/dotted_border.dart';
import 'package:wassalny/model/sirv_offers.dart';

class ServicesOffers extends StatefulWidget {
  final String image;
  final int id;
  final String name;
  ServicesOffers(this.image, this.id, this.name);

  @override
  _ServicesOffersState createState() => _ServicesOffersState();
}

class _ServicesOffersState extends State<ServicesOffers> {
  bool loader = false;

  Future<void> future() async {
    loader = true;
    try {
      await Provider.of<SirvOfferProvider>(context, listen: false)
          .fetchinfo(widget.id);
      setState(() {
        loader = false;
      });
    } catch (error) {
      print(error);
      setState(() {
        loader = false;
      });
      throw (error);
    }
  }

  @override
  void initState() {
    future();
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    final width = (MediaQuery.of(context).size.width);
    final higt = (MediaQuery.of(context).size.height -
        MediaQuery.of(context).padding.top);
    final List<AllOffer> offers =
        Provider.of<SirvOfferProvider>(context, listen: false).offers;

    return Scaffold(
      appBar: AppBar(
        backgroundColor: Colors.white,
        title: Text(
          "offers".tr,
          style: TextStyle(fontSize: 20, color: Colors.blue),
        ),
        centerTitle: true,
        iconTheme: IconThemeData(color: Colors.blue),
        elevation: 0,
      ),
      backgroundColor: Colors.grey[100],
      body: loader
          ? Center(child: CircularProgressIndicator())
          : Padding(
              padding: EdgeInsets.all(width * 0.03),
              child: offers.isEmpty
                  ? Center(
                      child: Text(
                        'NoOffres'.tr,
                        style: TextStyle(
                            color: Colors.blue,
                            fontSize: 25,
                            fontWeight: FontWeight.bold),
                      ),
                    )
                  : ListView.builder(
                      itemCount: offers.length,
                      itemBuilder: (contex, index) {
                        print(offers.length);
                        return Container(
                          margin: EdgeInsets.only(bottom: higt * 0.02),
                          decoration: BoxDecoration(
                            borderRadius: BorderRadius.circular(15),
                            border: Border.all(color: Colors.black),
                          ),
                          child: Column(children: [
                            Center(
                              child: Text(
                                "${"to".tr} : ${offers[index].endDate}",
                                style: TextStyle(
                                  fontWeight: FontWeight.bold,
                                  fontSize: 18,
                                  color: Colors.blue,
                                ),
                                maxLines: 1,
                              ),
                            ),
                            Container(
                              width: width,
                              child: Padding(
                                padding: EdgeInsets.all(width * 0.03),
                                child: Row(
                                  crossAxisAlignment: CrossAxisAlignment.start,
                                  mainAxisAlignment:
                                      MainAxisAlignment.spaceBetween,
                                  children: [
                                    Column(
                                      children: [
                                        Container(
                                          width: width * 0.28,
                                          height: higt * 0.17,
                                          decoration: BoxDecoration(
                                            borderRadius:
                                                BorderRadius.circular(15),
                                          ),
                                          child: ClipRRect(
                                            borderRadius:
                                                BorderRadius.circular(15),
                                            child: Image.network(
                                              widget.image,
                                              fit: BoxFit.fill,
                                            ),
                                          ),
                                        ),
                                        Text(widget.name),
                                        SizedBox(
                                          height: higt * 0.01,
                                        ),
                                        DottedBorder(
                                          color: Colors.black,
                                          borderType: BorderType.RRect,
                                          radius: Radius.circular(15),
                                          padding: EdgeInsets.all(6),
                                          child: Container(
                                            height: higt * 0.2,
                                            width: width * 0.3,
                                            child: ListView(
                                              children: [
                                                Padding(
                                                  padding: const EdgeInsets
                                                          .symmetric(
                                                      vertical: 2,
                                                      horizontal: 2.5),
                                                  child: AutoSizeText(
                                                      offers[index]
                                                          .description),
                                                ),
                                                Container(
                                                  child: Row(
                                                    // mainAxisAlignment:
                                                    //     MainAxisAlignment
                                                    //         .center,
                                                    children: [
                                                      Row(
                                                        children: [
                                                          Text(
                                                            offers[index]
                                                                .oldPrice,
                                                            style: TextStyle(
                                                                fontWeight:
                                                                    FontWeight
                                                                        .bold,
                                                                fontSize: 20,
                                                                color:
                                                                    Colors.blue,
                                                                decoration:
                                                                    TextDecoration
                                                                        .lineThrough),
                                                          ),
                                                          SizedBox(
                                                              width:
                                                                  width * 0.03),
                                                          Text(
                                                            offers[index]
                                                                .newPrice,
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
                                            ),
                                          ),
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
                                              height: MediaQuery.of(context)
                                                      .size
                                                      .height *
                                                  0.4,
                                              width: width * 0.5,
                                              decoration: BoxDecoration(
                                                borderRadius:
                                                    BorderRadius.circular(15),
                                              ),
                                              child: InkWell(
                                                onTap: () {
                                                  showDialog(
                                                    useSafeArea: true,
                                                    context: context,
                                                    builder: (context) {
                                                      return Carousel(
                                                        images: offers[index]
                                                            .allGalleries
                                                            .map((e) => Padding(
                                                                  padding:
                                                                      const EdgeInsets
                                                                              .all(
                                                                          8.0),
                                                                  child:
                                                                      Container(
                                                                    child: Image
                                                                        .network(
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
                                                child: Image.network(
                                                  offers[index].offerImage,
                                                  fit: BoxFit.fill,
                                                  errorBuilder: (context, error,
                                                          stackTrace) =>
                                                      Image.asset(
                                                          'assets/images/logo.png'),
                                                ),
                                              )),
                                        ),
                                        Text(offers[index].offerName)
                                      ],
                                    )
                                  ],
                                ),
                              ),
                            ),
                            // Container(
                            //   child: Row(
                            //     mainAxisAlignment: MainAxisAlignment.center,
                            //     children: [
                            //       Row(
                            //         children: [
                            //           Text(
                            //             "${"startDate".tr} ${offers[index].startDate}",
                            //             style: TextStyle(
                            //               fontWeight: FontWeight.bold,
                            //               fontSize: 12,
                            //               color: Colors.blue,
                            //             ),
                            //             maxLines: 1,
                            //           ),
                            //           SizedBox(width: width * 0.03),
                            //           Text(
                            //             "${"to".tr} ${offers[index].endDate}",
                            //             style: TextStyle(
                            //               fontWeight: FontWeight.bold,
                            //               fontSize: 12,
                            //               color: Colors.blue,
                            //             ),
                            //             maxLines: 1,
                            //           ),
                            //         ],
                            //       ),
                            //     ],
                            //   ),
                            // ),
                            // SizedBox(
                            //   height: higt * 0.01,
                            // )
                          ]),
                        );
                      }),
            ),
    );
  }
}
