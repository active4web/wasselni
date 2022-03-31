import 'package:auto_size_text/auto_size_text.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:provider/provider.dart';

import 'dart:async';
import 'package:dotted_border/dotted_border.dart';
import 'package:wassalny/Components/CustomWidgets/appBar.dart';
import 'package:wassalny/Screens/service_details/servicesDetails.dart';
import 'package:wassalny/model/offerDetails.dart';

class Details extends StatefulWidget {
  final int id;
  final String name;
  final String image;
  const Details({this.id, this.name, this.image});
  @override
  _DetailsState createState() => _DetailsState();
}

class _DetailsState extends State<Details> {
  bool loader = false;
  String lang = Get.locale.languageCode;
  // Completer<GoogleMapController> _controller = Completer();
  // Set<Marker> marker = {};
  // ignore: override_on_non_overriding_member
  Future<void> future() async {
    print(widget.id);
    loader = true;
    try {
      await Provider.of<OfferDetailsProvider>(context, listen: false)
          .orderDeatails(lang, widget.id);
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
    final info = Provider.of<OfferDetailsProvider>(context, listen: false);

    return Scaffold(
      appBar: newAppBar(context, "OffersDetails".tr),
      body: loader
          ? Center(child: CircularProgressIndicator())
          : Padding(
              padding: EdgeInsets.only(top: higt * 0.05),
              child: Column(
                children: [
                  Container(
                    width: width,
                    margin: EdgeInsets.only(bottom: higt * 0.02),
                    decoration: BoxDecoration(
                      borderRadius: BorderRadius.circular(15),
                    ),
                    child: Padding(
                      padding: EdgeInsets.all(width * 0.03),
                      child: Row(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                        children: [
                          Column(
                            children: [
                              InkWell(
                                onTap: () {
                                  Get.to(
                                    ServicesDetails(
                                      id: int.parse(info.serviceId),
                                    ),
                                  );
                                },
                                child: Container(
                                  width: width * 0.28,
                                  height: higt * 0.17,
                                  decoration: BoxDecoration(
                                    borderRadius: BorderRadius.circular(15),
                                  ),
                                  child: ClipRRect(
                                    borderRadius: BorderRadius.circular(15),
                                    child: Image.network(
                                      widget.image,
                                      fit: BoxFit.fill,
                                    ),
                                  ),
                                ),
                              ),
                              Text(info.serviceName),
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
                                    width: width * 0.35,
                                    child: ListView(
                                      children: [
                                        Padding(
                                          padding: const EdgeInsets.all(2.5),
                                          child: AutoSizeText(
                                              info.offersDescription),
                                        ),
                                        Container(
                                          child: Row(
                                            // mainAxisAlignment: MainAxisAlignment.center,
                                            children: [
                                              Row(
                                                children: [
                                                  Text(
                                                    info.oldPrice,
                                                    style: TextStyle(
                                                        fontWeight:
                                                            FontWeight.bold,
                                                        fontSize: 20,
                                                        color: Colors.blue,
                                                        decoration:
                                                            TextDecoration
                                                                .lineThrough),
                                                  ),
                                                  SizedBox(width: width * 0.03),
                                                  Text(
                                                    info.newPrice,
                                                    style: TextStyle(
                                                      fontWeight:
                                                          FontWeight.bold,
                                                      fontSize: 20,
                                                      color: Colors.blue,
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
                                borderRadius: BorderRadius.circular(15),
                                child: Container(
                                    height: higt * 0.4,
                                    width: width * 0.5,
                                    decoration: BoxDecoration(
                                      borderRadius: BorderRadius.circular(15),
                                    ),
                                    child: Image.network(
                                      info.offerImage,
                                      fit: BoxFit.fill,
                                    )),
                              ),
                              Text(info.offerName),
                              SizedBox(
                                height: higt * 0.02,
                              ),
                            ],
                          ),
                        ],
                      ),
                    ),
                  ),
                  SizedBox(
                    height: higt * 0.15,
                  ),
                ],
              ),
            ),
    );
  }
}
// Row(mainAxisAlignment: MainAxisAlignment.center, children: [
//   Container(
//     padding: EdgeInsets.all(
//       width * 0.02,
//     ),
//     decoration: BoxDecoration(
//       color: Colors.grey[300],
//       borderRadius: BorderRadius.circular(15),
//     ),
//     child: IntrinsicHeight(
//       child: Center(
//         child: Row(
//           mainAxisAlignment: MainAxisAlignment.center,
//           children: [
//             info.phone.isEmpty
//                 ? Container()
//                 : InkWell(
//                     child: Image.asset(
//                       'assets/images/phoneicon.png',
//                       width: width * 0.12,
//                       height: higt * 0.07,
//                       fit: BoxFit.fill,
//                     ),
//                     onTap: () async {
//                       await launch('tel:${info.phone}');
//                     },
//                   ),
//             info.instagram.isEmpty
//                 ? Container()
//                 : VerticalDivider(
//                     color: Colors.black,
//                     thickness: 2,
//                   ),
//             info.instagram.isEmpty
//                 ? Container()
//                 : InkWell(
//                     child: Image.asset(
//                       'assets/images/instagram.png',
//                       width: width * 0.12,
//                       height: higt * 0.07,
//                       fit: BoxFit.fill,
//                     ),
//                     onTap: () async {
//                       await launch('http:${info.instagram}');
//                     },
//                   ),
//             info.twitter.isEmpty
//                 ? Container()
//                 : VerticalDivider(
//                     color: Colors.black,
//                     thickness: 2,
//                   ),
//             info.twitter.isEmpty
//                 ? Container()
//                 : InkWell(
//                     child: Container(
//                       width: width * 0.12,
//                       height: higt * 0.07,
//                       child: Image.asset(
//                         'assets/images/twitter.png',
//                         width: width * 0.12,
//                         height: higt * 0.07,
//                         fit: BoxFit.fill,
//                       ),
//                     ),
//                     onTap: () async {
//                       await launch('http:${info.twitter}');
//                     },
//                   ),
//             info.whatsapp.isEmpty
//                 ? Container()
//                 : VerticalDivider(
//                     color: Colors.black,
//                     thickness: 2,
//                   ),
//             info.whatsapp.isEmpty
//                 ? Container()
//                 : InkWell(
//                     child: Image.asset(
//                       'assets/images/whatsapp.png',
//                       width: width * 0.12,
//                       height: higt * 0.07,
//                       fit: BoxFit.fill,
//                     ),
//                     onTap: () async {
//                       await launch('tel:${info.whatsapp}');
//                     },
//                   ),
//           ],
//         ),
//       ),
//     ),
//   ),
// ]),
