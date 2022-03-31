import 'package:cached_network_image/cached_network_image.dart';
import 'package:flutter/material.dart';
import 'package:flutter_barcode_scanner/flutter_barcode_scanner.dart';
import 'package:get/get.dart';
import 'package:location/location.dart';
import 'package:provider/provider.dart';
import 'package:share/share.dart';

import 'package:url_launcher/url_launcher.dart';
import 'package:auto_size_text/auto_size_text.dart';
import 'package:carousel_pro/carousel_pro.dart';
import 'package:wassalny/Components/CustomWidgets/customTextField.dart';
import 'package:wassalny/Components/CustomWidgets/showdialog.dart';
import 'package:wassalny/Screens/Branches/view.dart';
import 'package:wassalny/Screens/cart/order_cart.dart';
import 'package:wassalny/Screens/min/view.dart';
import 'package:wassalny/Screens/service_details/services_offer.dart';
import 'package:wassalny/model/addRatingModel.dart';
import 'package:wassalny/model/addToFavourite.dart';
import 'package:wassalny/model/cartProvider.dart';
import 'package:wassalny/model/itemServicesDetail.dart';
import 'package:wassalny/model/sentLocation.dart';
import 'package:youtube_player_flutter/youtube_player_flutter.dart';
import 'package:flutter/cupertino.dart';
import 'package:draggable_scrollbar/draggable_scrollbar.dart';
import 'package:flutter_rating_bar/flutter_rating_bar.dart';

class ServicesDetails extends StatefulWidget {
  final int id;

  const ServicesDetails({this.id});
  @override
  _ServicesDetailsState createState() => _ServicesDetailsState();
}

class _ServicesDetailsState extends State<ServicesDetails> {
  bool loader = false;
  // Completer<GoogleMapController> _controller = Completer();
  // Set<Marker> marker = {};
  ScrollController _customController = ScrollController();
  final GlobalKey qrKey = GlobalKey(debugLabel: 'QR');

  String counterr;
  Future<String> counter() async {
    counterr = await FlutterBarcodeScanner.scanBarcode(
        '#004297', 'close', true, ScanMode.DEFAULT);
    return counterr;
  }

  Widget imageCarousel() {
    final hight = (MediaQuery.of(context).size.height -
        MediaQuery.of(context).padding.top);

    List<AllSlider> sliderImageInMain =
        Provider.of<ItemServicesDetail>(context, listen: false).allslider;
    if (sliderImageInMain.isEmpty || sliderImageInMain == null) {
      return SizedBox(
        height: 0,
        width: 0,
      );
    }
    return Padding(
      padding: EdgeInsets.only(top: hight * 0.02),
      child: Container(
        height: hight * 0.3,
        decoration: BoxDecoration(
          border: Border(),
          borderRadius: BorderRadius.circular(15),
        ),
        child: ClipRRect(
          borderRadius: BorderRadius.circular(15),
          child: Carousel(
              boxFit: BoxFit.fill,
              images: sliderImageInMain.map(
                (e) {
                  return CachedNetworkImage(
                    imageUrl: e.img,
                    fit: BoxFit.fill,
                  );
                },
              ).toList(),
              autoplay: false,
              dotSize: 7.0,
              overlayShadow: true,
              dotColor: Colors.blue,
              indicatorBgPadding: 1.0,
              dotBgColor: Colors.transparent),
        ),
      ),
    );
  }

  String lang = Get.locale.languageCode;
  bool isCache = false;

  Future<void> getDetails() async {
    setState(() {
      loader = true;
      isCache = true;
    });
    Provider.of<ItemServicesDetail>(context, listen: false).cobon = 0;
    try {
      await Provider.of<ItemServicesDetail>(context, listen: false)
          .fetchAllDetails(widget.id, lang);

      setState(() {
        loader = false;
        isCache = true;
      });
    } catch (e) {
      setState(() {
        loader = false;
        isCache = false;
      });
    }
  }

  Future<void> getFav() async {
    setState(() {});
    Provider.of<ItemServicesDetail>(context, listen: false);
    try {
      await Provider.of<ItemServicesDetail>(context, listen: false)
          .fetchAllDetails(widget.id, lang);
    } catch (e) {
      setState(() {
        loader = false;
      });
    }
  }

  bool cobonLoader = false;

  Future<void> getcobon() async {
    setState(() {
      cobonLoader = true;
    });
    try {
      await Provider.of<ItemServicesDetail>(context, listen: false)
          .getCobon(widget.id);
      setState(() {
        cobonLoader = false;
      });
    } catch (e) {}
  }

  Future<void> getQr(int qr,var qrId) async {
    try {
      await Provider.of<ItemServicesDetail>(context, listen: false)
          .qr(qr, qrId,lang);
      final provider = Provider.of<ItemServicesDetail>(context, listen: false);
      qrDaialog(provider.number == 0 ?"" :provider.number.toString(), context, provider.message);
    } catch (e) {
     print(e.toString());
    }
  }

  Widget cobonNum() {
    final info = Provider.of<ItemServicesDetail>(context, listen: false);
    if (info.cobon == 0) {
      setState(() {});
      return AutoSizeText(
        'nodiscountcoupons'.tr,
        style: TextStyle(color: Colors.blue[400]),
        maxLines: 1,
      );
    } else {
      return AutoSizeText(
        info.cobon.toString(),
        style: TextStyle(color: Colors.blue[400]),
        maxLines: 1,
      );
    }
  }

  YoutubePlayerController _youtubePlayerController;
  String linnk() {
    String link =
        Provider.of<ItemServicesDetail>(context, listen: false).videoLink;
    if (link == null) {
      return 'https://www.youtube.com/watch?v=PakAvfdXi5I';
    } else if (link.isEmpty) {
      return 'https://www.youtube.com/watch?v=PakAvfdXi5I';
    }
    return link;
  }

  String url() {
    String phone =
        Provider.of<ItemServicesDetail>(context, listen: false).whatsapp;
    return "whatsapp://send?phone=$phone";
  }

  TextEditingController addComment = TextEditingController();
  double rate;
  Future<void> _submit() async {
    bool done =
        Provider.of<AddRatingProvider>(context, listen: false).doneSentRate;

    showDaialogLoader(context);
    try {
      done =
          await Provider.of<AddRatingProvider>(context, listen: false).addRate(
        comment: addComment.text,
        rating: rate.toString(),
        id: widget.id,
      );
      // ignore: unused_catch_clause
    } catch (error) {
      print(error);
      Navigator.of(context).pop();
      showErrorDaialog('No internet connection', context);
    }
    if (done) {
      Navigator.of(context).pop();
      Navigator.of(context).pop();
      Get.snackbar('تم الارسال', "تم ارسال تقيمك والتعليق بنجاح");
      getDetails();
    }
  }

  Future<void> _sentLocation({String lag, String lat}) async {
    bool done = Provider.of<SentLocationgProvider>(context, listen: false)
        .doneSentLocation;
    print(lat);
    try {
      done = await Provider.of<SentLocationgProvider>(context, listen: false)
          .sentLocationgProvider(
        lag: lag,
        lat: lat,
        id: widget.id,
      );
      // ignore: unused_catch_clause
    } catch (error) {
      print(error);
      Navigator.of(context).pop();
      showErrorDaialog('No internet connection', context);
    }
    if (done) {
      Navigator.of(context).pop();

      Get.snackbar('تم الارسال', "تم ارسال موقعك بنجاح");
    }
  }

  Future<void> _sentFav() async {
    setState(() {});
    bool done =
        Provider.of<UpdateFavProvider>(context, listen: false).doneSenting;
    int isFav = Provider.of<ItemServicesDetail>(context, listen: false).isFav;

    try {
      done = await Provider.of<UpdateFavProvider>(context, listen: false)
          .updateFav(
        key: isFav == 0 ? '1' : '2',
        id: widget.id,
      );

      // ignore: unused_catch_clause
    } catch (error) {
      print(error);
      Navigator.of(context).pop();
      showErrorDaialog('No internet connection', context);
    }
    if (done) {
      getDetails();
    }
  }

  location() async {
    Location location = new Location();
    bool _serviceEnabled;
    PermissionStatus _permissionGranted;
    LocationData _locationData;
    showDaialogLoader(context);
    _serviceEnabled = await location.serviceEnabled();
    if (!_serviceEnabled) {
      _serviceEnabled = await location.requestService();
      if (!_serviceEnabled) {
        return;
      }
    }

    _permissionGranted = await location.hasPermission();
    if (_permissionGranted == PermissionStatus.denied) {
      _permissionGranted = await location.requestPermission();
      if (_permissionGranted != PermissionStatus.granted) {
        return;
      }
    }

    _locationData = await location.getLocation();
    print('$_locationData _locationData');
    _sentLocation(
      lag: _locationData.longitude.toString(),
      lat: _locationData.latitude.toString(),
    );
  }

  @override
  void initState() {
    getDetails().then((value) {
      String videoId;
      print(Provider.of<ItemServicesDetail>(context, listen: false).videoLink);
      videoId = YoutubePlayer.convertUrlToId(
          Provider.of<ItemServicesDetail>(context, listen: false).videoLink);
      print(videoId);
      _youtubePlayerController = YoutubePlayerController(
        initialVideoId: videoId,
        flags: YoutubePlayerFlags(
          mute: false,
          autoPlay: false,
          disableDragSeek: false,
          loop: true,
          isLive: false,
          forceHD: false,
          enableCaption: true,
        ),
      )..addListener(() {});
    });
    super.initState();
  }

  @override
  void dispose() {
    super.dispose();
    _youtubePlayerController.dispose();
  }

  @override
  Widget build(BuildContext context) {
    final info = Provider.of<ItemServicesDetail>(context, listen: false);
    final width = (MediaQuery.of(context).size.width);
    final higt = (MediaQuery.of(context).size.height -
        MediaQuery.of(context).padding.top);
    int isFav = Provider.of<ItemServicesDetail>(context, listen: false).isFav;
    print('${info.viewMin} min');
    return Scaffold(
      appBar: AppBar(
          iconTheme: IconThemeData(color: Colors.blue),
          backgroundColor: Colors.transparent,
          elevation: 0,
          title: Row(
            // mainAxisAlignment: MainAxisAlignment.center,
            children: [
              SizedBox(
                width: width * 0.25,
              ),
              // SizedBox(
              //   width: 5,
              // ),
              // IconButton(onPressed: (){
              //   Navigator.pop(context);
              // }, icon: Icon(Icons.arrow_back_ios)),
              Image.asset('assets/images/logo.png', width: 50),
              // SizedBox(width: 20,),
              Spacer(),
              IconButton(
                  onPressed: _sentFav,
                  icon: isFav == 0
                      ? Icon(
                          CupertinoIcons.heart,
                          color: Colors.blue,
                          size: 30,
                        )
                      : Icon(
                          CupertinoIcons.heart_fill,
                          color: Colors.red,
                          size: 30,
                        )),
              info.viewScan == '0'
                  ? SizedBox()
                  : InkWell(
                      child: Image.asset(
                        'assets/images/qr.png',
                        width: 35,
                        height: 40,
                        fit: BoxFit.fill,
                      ),
                      onTap: () {
                            counter().then((value) {
                          print("hello" + value);
                          if (value == "-1") {
                            print('object');
                          } else {
                        print(widget.id);
                            getQr(widget.id,value);
                          }
                        });
                      }
                    ),
            ],
          ),
          centerTitle: true,
          automaticallyImplyLeading: true),
      // endDrawer: MyDrawer(),
      body: loader
          ? Center(
              child: CircularProgressIndicator(),
            )
          : Container(
              width: width,
              height: MediaQuery.of(context).size.height,
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Expanded(
                      child: Padding(
                    padding: EdgeInsets.all(width * 0.03),
                    child: ListView(
                      children: [
                        if (isCache)
                          int.parse(info.sliderType) == 0
                              ? imageCarousel()
                              : Container(
                                  decoration: BoxDecoration(
                                      borderRadius: BorderRadius.circular(15)),
                                  child: ClipRRect(
                                    borderRadius: BorderRadius.circular(15),
                                    child: YoutubePlayer(
                                      controller: _youtubePlayerController,
                                      bottomActions: [
                                        CurrentPosition(),
                                        ProgressBar(
                                          isExpanded: true,
                                        ),
                                      ],
                                    ),
                                  ),
                                ),
                        SizedBox(
                          height: higt * 0.015,
                        ),
                        Container(
                          child: Row(
                            children: [
                              Container(
                                child: Column(
                                  crossAxisAlignment: CrossAxisAlignment.start,
                                  children: [
                                    SizedBox(
                                      width: width * 0.35,
                                      child: RaisedButton(
                                        color: Colors.blue,
                                        shape: RoundedRectangleBorder(
                                          borderRadius:
                                              BorderRadius.circular(15.0),
                                          side: BorderSide(
                                              color: int.parse(info.delivary) ==
                                                          0 ||
                                                      int.parse(
                                                              info.delivary) ==
                                                          null
                                                  ? Colors.grey[300]
                                                  : Colors.blue),
                                        ),
                                        onPressed: int.parse(info.delivary) ==
                                                    0 ||
                                                int.parse(info.delivary) == null
                                            ? null
                                            : () =>
                                                // Min(
                                                //       id: info.idd,
                                                //       title: info.menuTilte ==
                                                //                   null ||
                                                //               info.menuTilte == ''
                                                //           ? "menu".tr
                                                //           : info.menuTilte,
                                                //     ),
                                                // Provider.of<CartListProvider>(
                                                //         context,
                                                //         listen: false)
                                                //     .fetchProductCart(
                                                //         lang, info.idd)
                                                //     .then((value) {
                                                //   Get.to(CartScreen());
                                                // }),
                                                Get.to(CartOrderScreen(
                                                  serviceId: info.idd,
                                                )),
                                        child: AutoSizeText(
                                          "delivery".tr,
                                          style: TextStyle(color: Colors.white),
                                        ),
                                      ),
                                    ),
                                    SizedBox(
                                      width: width * 0.02,
                                    ),
                                    Row(
                                      children: [
                                        SizedBox(
                                          width: width * 0.35,
                                          child: cobonLoader == true
                                              ? Center(
                                                  child:
                                                      CupertinoActivityIndicator(
                                                    radius: 15,
                                                  ),
                                                )
                                              : RaisedButton(
                                                  onPressed:
                                                      info.viewCobon == '0'
                                                          ? null
                                                          : getcobon,
                                                  shape: RoundedRectangleBorder(
                                                    borderRadius:
                                                        BorderRadius.circular(
                                                            15),
                                                  ),
                                                  color: info.viewCobon == '0'
                                                      ? Colors.grey[300]
                                                      : Colors.blue,
                                                  child: AutoSizeText(
                                                    '${'coupon'.tr}',
                                                    style: TextStyle(
                                                        fontWeight:
                                                            FontWeight.bold,
                                                        color: Colors.white),
                                                    maxLines: 1,
                                                  ),
                                                ),
                                        ),
                                        SizedBox(
                                          width: width * 0.025,
                                        ),
                                        cobonLoader == true
                                            ? Center(
                                                child:
                                                    CupertinoActivityIndicator(
                                                  radius: 15,
                                                ),
                                              )
                                            : info.cobon == 0
                                                ? Text('')
                                                : info.cobon == null
                                                    ? AutoSizeText(
                                                        'nodiscountcoupons'.tr,
                                                        style: TextStyle(
                                                            color: Colors
                                                                .blue[400]),
                                                        maxLines: 1,
                                                      )
                                                    : AutoSizeText(
                                                        info.cobon.toString(),
                                                        style: TextStyle(
                                                            color: Colors
                                                                .blue[400]),
                                                        maxLines: 1,
                                                      )
                                      ],
                                    ),
                                    SizedBox(
                                      width: width * 0.35,
                                      child: RaisedButton(
                                        color: Colors.blue,
                                        shape: RoundedRectangleBorder(
                                          borderRadius:
                                              BorderRadius.circular(15),
                                        ),
                                        child: AutoSizeText(
                                          "deliverMap".tr,
                                          style: TextStyle(
                                              fontWeight: FontWeight.bold,
                                              color: Colors.white),
                                          maxLines: 1,
                                        ),
                                        onPressed: () async {
                                          await launch(
                                              'http:${info.loctaation}');
                                        },
                                      ),
                                    ),
                                    // InkWell(
                                    //   onTap: () async {
                                    //     await launch('tel:${info.phone}');
                                    //   },
                                    //   child: AutoSizeText(
                                    //     info.phone,
                                    //     style: TextStyle(
                                    //       fontSize: 16,
                                    //     ),
                                    //     maxLines: 1,
                                    //   ),
                                    // ),
                                  ],
                                ),
                              ),
                              Spacer(),
                              Column(
                                children: [
                                  Container(
                                    height: higt * 0.13,
                                    width: higt * 0.12,
                                    decoration: BoxDecoration(
                                      borderRadius: BorderRadius.circular(15),
                                    ),
                                    child: ClipRRect(
                                      borderRadius: BorderRadius.circular(15),
                                      child: CachedNetworkImage(
                                        imageUrl: info.offersImage,
                                        fit: BoxFit.fill,
                                      ),
                                    ),
                                  ),
                                  AutoSizeText(
                                    info.serviceName,
                                    style: TextStyle(
                                        fontSize: 16,
                                        fontWeight: FontWeight.w700),
                                    maxLines: 1,
                                  ),
                                ],
                              ),
                            ],
                          ),
                        ),
                        Row(
                          mainAxisAlignment: MainAxisAlignment.spaceBetween,
                          children: [
                            SizedBox(
                              width: width * 0.35,
                              child: RaisedButton(
                                color: Colors.blue,
                                shape: RoundedRectangleBorder(
                                  borderRadius: BorderRadius.circular(15),
                                ),
                                child: AutoSizeText(
                                  "rate".tr,
                                  style: TextStyle(
                                      fontWeight: FontWeight.bold,
                                      color: Colors.white),
                                  maxLines: 1,
                                ),
                                onPressed: info.rateView != "0" ? () {
                                  Get.defaultDialog(
                                    title: "rate".tr,
                                    content: Container(
                                      height: higt * 0.24,
                                      child: Column(
                                        children: [
                                          RatingBar.builder(
                                            initialRating: 0,
                                            direction: Axis.horizontal,
                                            allowHalfRating: true,
                                            itemCount: 5,
                                            itemSize: 25,
                                            itemPadding: EdgeInsets.symmetric(
                                                horizontal: 4.0),
                                            itemBuilder: (context, _) => Icon(
                                              Icons.star,
                                              color: Colors.amber,
                                            ),
                                            onRatingUpdate: (rating) {
                                              rate = rating;
                                            },
                                          ),
                                          SizedBox(
                                            height: 10,
                                          ),
                                          ProfileTextField(
                                            hint: "addComment".tr,
                                            controller: addComment,
                                          ),
                                          SizedBox(
                                            height: 10,
                                          ),
                                          SizedBox(
                                            width: width * 0.35,
                                            child: RaisedButton(
                                                color: Colors.blue,
                                                shape: RoundedRectangleBorder(
                                                  borderRadius:
                                                      BorderRadius.circular(15),
                                                ),
                                                child: AutoSizeText(
                                                  "rate".tr,
                                                  style: TextStyle(
                                                      fontWeight:
                                                          FontWeight.bold,
                                                      color: Colors.white),
                                                  maxLines: 1,
                                                ),
                                                onPressed: _submit),
                                          ),
                                        ],
                                      ),
                                    ),
                                  );
                                }:null,
                              ),
                            ),
                            RatingBar.builder(
                              initialRating: info.totalRate == ''
                                  ? 0
                                  : double.parse(info.totalRate),
                              minRating: 1,
                              direction: Axis.horizontal,
                              allowHalfRating: true,
                              itemCount: 5,
                              itemSize: 17,
                              ignoreGestures: true,
                              itemPadding:
                                  EdgeInsets.symmetric(horizontal: 4.0),
                              itemBuilder: (context, _) => Icon(
                                Icons.star,
                                color: Colors.amber,
                              ),
                              onRatingUpdate: (rating) {
                                print(rating);
                              },
                            ),
                          ],
                        ),
                        SizedBox(
                          width: width * 0.35,
                          child: RaisedButton(
                            color: Colors.blue,
                            shape: RoundedRectangleBorder(
                              borderRadius: BorderRadius.circular(15),
                            ),
                            child: AutoSizeText(
                              "comments".tr,
                              style: TextStyle(
                                  fontWeight: FontWeight.bold,
                                  color: Colors.white),
                              maxLines: 1,
                            ),
                            onPressed: () {
                              Get.defaultDialog(
                                title: "comments".tr,
                                content: Container(
                                  child: Padding(
                                      padding: const EdgeInsets.all(8.0),
                                      child: Container(
                                        height: higt * 0.5,
                                        child: info.allRate.isEmpty
                                            ? Text(
                                                'لا يوجد تعليقات',
                                                style: TextStyle(
                                                    color: Colors.blue,
                                                    fontSize: 20),
                                              )
                                            : ListView.builder(
                                                itemCount: info.allRate.length,
                                                itemBuilder: (context, index) {
                                                  return Column(
                                                    crossAxisAlignment:
                                                        CrossAxisAlignment
                                                            .start,
                                                    children: [
                                                      Row(
                                                        children: [
                                                          Text(
                                                            info.allRate[index]
                                                                .username,
                                                            style: TextStyle(
                                                                fontWeight:
                                                                    FontWeight
                                                                        .bold),
                                                          ),
                                                          SizedBox(
                                                            width: 8,
                                                          ),
                                                          Icon(
                                                            Icons.star,
                                                            color:
                                                                Colors.yellow,
                                                            size: 15,
                                                          ),
                                                          SizedBox(
                                                            width: 3,
                                                          ),
                                                          Text(
                                                            info.allRate[index]
                                                                .userrate,
                                                            style: TextStyle(
                                                                fontWeight:
                                                                    FontWeight
                                                                        .bold),
                                                          ),
                                                        ],
                                                      ),
                                                      Text(info.allRate[index]
                                                          .usercomment),
                                                      Divider(
                                                        thickness: 1,
                                                      )
                                                    ],
                                                  );
                                                },
                                              ),
                                      )),
                                ),
                              );
                            },
                          ),
                        ),
                        Padding(
                          padding: EdgeInsets.symmetric(
                              horizontal: width * 0.025, vertical: higt * .01),
                          child: Container(
                            height: higt * 0.25,
                            padding: EdgeInsets.symmetric(
                                horizontal: width * 0.025,
                                vertical: higt * 0.01),
                            width: width,
                            decoration: BoxDecoration(
                              color: Colors.grey[300],
                              borderRadius: BorderRadius.circular(20),
                            ),
                            child: DraggableScrollbar.arrows(
                              alwaysVisibleScrollThumb: true,
                              backgroundColor: Colors.blue,
                              controller: _customController,
                              child: ListView(
                                padding: EdgeInsets.only(right: width * 0.06),
                                controller: _customController,
                                children: [
                                  info.phoneSecond.isEmpty ///////////
                                      ? SizedBox(
                                          height: 0,
                                          width: 0,
                                        )
                                      : InkWell(
                                          onTap: () async {
                                            await launch(
                                                'tel:${info.phoneSecond}');
                                          },
                                          child: AutoSizeText(
                                            info.phoneSecond,
                                            style: TextStyle(
                                              fontSize: 16,
                                              fontWeight: FontWeight.w700,
                                            ),
                                            // maxLines: 1,
                                          ),
                                        ),
                                  info.phoneThird.isEmpty
                                      ? SizedBox(
                                          height: 0,
                                          width: 0,
                                        )
                                      : InkWell(
                                          onTap: () async {
                                            await launch(
                                                'tel:${info.phoneThird}');
                                          },
                                          child: AutoSizeText(
                                            info.phoneThird,
                                            style: TextStyle(
                                              fontSize: 16,
                                              fontWeight: FontWeight.w700,
                                            ),
                                            // maxLines: 1,
                                          ),
                                        ),
                                  info.phoneSecond.isEmpty &&
                                          info.phoneThird.isEmpty
                                      ? SizedBox(
                                          height: 0,
                                          width: 0,
                                        )
                                      : SizedBox(
                                          height: higt * 0.01,
                                        ),
                                  info.email.isEmpty
                                      ? SizedBox(
                                          height: 0,
                                          width: 0,
                                        )
                                      : InkWell(
                                          onTap: () async {
                                            await launch(
                                                'mailto:${info.email}');
                                          },
                                          child: AutoSizeText(
                                            info.email,
                                            style: TextStyle(
                                              fontSize: 16,
                                              fontWeight: FontWeight.w700,
                                            ),
                                            // maxLines: 1,
                                          ),
                                        ),
                                  info.address == '' || info.address.isEmpty
                                      ? SizedBox(
                                          height: 0,
                                          width: 0,
                                        )
                                      : AutoSizeText(
                                          info.address,
                                          style: TextStyle(
                                            fontSize: 16,
                                            fontWeight: FontWeight.w700,
                                          ),
                                          // maxLines: 2,
                                        ),
                                  info.description.isEmpty
                                      ? SizedBox(
                                          height: 0,
                                          width: 0,
                                        )
                                      : SizedBox(
                                          height: higt * 0.01,
                                        ),
                                  info.description.isEmpty
                                      ? SizedBox(
                                          height: 0,
                                          width: 0,
                                        )
                                      : AutoSizeText(
                                          info.description,
                                          style: TextStyle(
                                            fontSize: 16,
                                            fontWeight: FontWeight.w700,
                                          ),
                                          // maxLines: 12,
                                        ),
                                ],
                              ),
                            ),
                          ),
                        ),
                        Center(
                          child: Container(
                            width: width * 0.8,
                            child: Row(
                              mainAxisAlignment: MainAxisAlignment.spaceAround,
                              children: [
                                SizedBox(
                                  width: width * 0.3,
                                  child: RaisedButton(
                                    shape: RoundedRectangleBorder(
                                      borderRadius: BorderRadius.circular(10),
                                    ),
                                    color: info.viewBranches == "0"
                                        ? Colors.grey[300]
                                        : Colors.blue,
                                    onPressed: info.viewBranches == "0"
                                        ? null
                                        : () {Get.to(Branches(info.idd));},
                                    child: AutoSizeText(
                                      "Branches".tr,
                                      style: TextStyle(
                                          fontSize: 16,
                                          fontWeight: FontWeight.bold,
                                          color: Colors.white),
                                      maxLines: 1,
                                    ),
                                  ),
                                ),
                                SizedBox(
                                  width: width * 0.3,
                                  child: RaisedButton(
                                    shape: RoundedRectangleBorder(
                                      borderRadius: BorderRadius.circular(10),
                                    ),
                                    color: Colors.blue,
                                    onPressed: info.viewMin == '0'
                                        ? null
                                        : () {
                                            Get.to(
                                              Min(
                                                id: info.idd,
                                                title: info.menuTilte == null ||
                                                        info.menuTilte == ''
                                                    ? "menu".tr
                                                    : info.menuTilte,
                                              ),
                                            );
                                          },
                                    child: AutoSizeText(
                                      info.menuTilte == null ||
                                              info.menuTilte == ''
                                          ? "menu".tr
                                          : info.menuTilte,
                                      style: TextStyle(
                                          fontSize: 16,
                                          fontWeight: FontWeight.bold,
                                          color: Colors.white),
                                      maxLines: 1,
                                    ),
                                  ),
                                ),
                              ],
                            ),
                          ),
                        ),
                        Center(
                          child: Container(
                            width: width * 0.7,
                            child: Row(
                              mainAxisAlignment: MainAxisAlignment.spaceBetween,
                              children: [
                                SizedBox(
                                  width: width * 0.3,
                                  child: RaisedButton(
                                    shape: RoundedRectangleBorder(
                                      borderRadius: BorderRadius.circular(10),
                                    ),
                                    color: info.viewOffer == "0"
                                        ? Colors.grey[300]
                                        : Colors.red,
                                    onPressed: info.viewOffer == "0"
                                        ? null
                                        : () {
                                            Get.to(
                                              ServicesOffers(info.mainImg,
                                                  info.idd, info.serviceName),
                                            );
                                            // Get.to(Offerss());
                                          },
                                    child: AutoSizeText(
                                      "offers".tr,
                                      style: TextStyle(
                                          fontSize: 16,
                                          fontWeight: FontWeight.bold,
                                          color: Colors.white),
                                      maxLines: 1,
                                    ),
                                  ),
                                ),
                                SizedBox(
                                  width: width * 0.3,
                                  child: RaisedButton(
                                    shape: RoundedRectangleBorder(
                                      borderRadius: BorderRadius.circular(10),
                                    ),
                                    color: info.viewPoints == "0"
                                        ? Colors.grey[300]
                                        : Colors.blue,
                                    onPressed: info.viewPoints == "0"
                                        ? null
                                        : () {
                                            // Get.to(ServicesOffers());
                                            // Get.to(Offerss());
                                          },
                                    child: info.points == ''
                                        ? AutoSizeText(
                                            "${"Points".tr} = 0",
                                            style: TextStyle(
                                                fontWeight: FontWeight.bold,
                                                color: Colors.white),
                                            maxLines: 1,
                                          )
                                        : AutoSizeText(
                                            "${"Points".tr} : ${info.points}",
                                            style: TextStyle(
                                                fontWeight: FontWeight.bold,
                                                color: Colors.white),
                                            maxLines: 1,
                                          ),
                                  ),
                                ),
                              ],
                            ),
                          ),
                        ),
                        Center(
                          child: Row(
                            mainAxisAlignment: MainAxisAlignment.center,
                            children: [
                              SizedBox(
                                width: width * 0.3,
                                child: RaisedButton(
                                  shape: RoundedRectangleBorder(
                                    borderRadius: BorderRadius.circular(10),
                                  ),
                                  color: info.viewLocation == "0"
                                      ? Colors.grey[300]
                                      : Colors.blue,
                                  onPressed: info.viewLocation == "0"
                                      ? null
                                      : location,
                                  child: AutoSizeText(
                                    '${'sentLocation'.tr}',
                                    style: TextStyle(
                                        fontWeight: FontWeight.bold,
                                        color: Colors.white),
                                    maxLines: 1,
                                  ),
                                ),
                              ),
                            ],
                          ),
                        )

                        // info.lag.isEmpty
                        //     ? SizedBox(
                        //         width: 0,
                        //         height: 0,
                        //       )
                        //     : Padding(
                        //         padding:
                        //             EdgeInsets.symmetric(vertical: higt * 0.01),
                        //         child: ClipRRect(
                        //           borderRadius: BorderRadius.circular(15),
                        //           child: Container(
                        //             height: higt * 0.2,
                        //             child: GoogleMap(
                        //               mapType: MapType.normal,
                        //               onMapCreated:
                        //                   (GoogleMapController controller) {
                        //                 _controller.complete(controller);
                        //               },
                        //               initialCameraPosition: CameraPosition(
                        //                 target: LatLng(double.parse(info.lat),
                        //                     double.parse(info.lag)),
                        //                 zoom: 14.4746,
                        //               ),
                        //               markers: Set.from(marker),
                        //               myLocationEnabled: true,
                        //               myLocationButtonEnabled: true,
                        //               onTap: (val) {
                        //                 print(val);
                        //               },
                        //             ),
                        //           ),
                        //         ),
                        //       ),
                      ],
                    ),
                  )),
                  Column(
                    children: [
                      Container(
                        width: width,
                        height: 50,
                        color: Colors.grey[300],
                        child: Row(
                            mainAxisAlignment: MainAxisAlignment.center,
                            children: [
                              IntrinsicHeight(
                                child: Center(
                                  child: Row(
                                    mainAxisAlignment: MainAxisAlignment.center,
                                    children: [
                                      info.phone.isEmpty
                                          ? Container()
                                          : InkWell(
                                              child: Image.asset(
                                                'assets/images/phoneicon.png',
                                                height: higt * 0.06,
                                                fit: BoxFit.fill,
                                              ),
                                              onTap: () async {
                                                await launch(
                                                    'tel:${info.phone}');
                                              },
                                            ),
                                      info.instagram.isEmpty
                                          ? Container()
                                          : VerticalDivider(
                                              color: Colors.black,
                                              thickness: 2,
                                            ),
                                      info.instagram.isEmpty
                                          ? Container()
                                          : InkWell(
                                              child: Image.asset(
                                                'assets/images/instagram.png',
                                                height: higt * 0.06,
                                                fit: BoxFit.fill,
                                              ),
                                              onTap: () async {
                                                await launch(
                                                    'http:${info.instagram}');
                                              },
                                            ),
                                      info.twitter.isEmpty
                                          ? Container()
                                          : VerticalDivider(
                                              color: Colors.black,
                                              thickness: 2,
                                            ),
                                      info.twitter.isEmpty
                                          ? Container()
                                          : InkWell(
                                              child: Container(
                                                height: higt * 0.06,
                                                child: Image.asset(
                                                  'assets/images/twitter.png',
                                                  width: width * 0.12,
                                                  height: higt * 0.07,
                                                  fit: BoxFit.fill,
                                                ),
                                              ),
                                              onTap: () async {
                                                await launch(
                                                    'http:${info.twitter}');
                                              },
                                            ),
                                      info.web == ""
                                          ? Container()
                                          : VerticalDivider(
                                              color: Colors.black,
                                              thickness: 2,
                                            ),
                                      info.web == ""
                                          ? Container()
                                          : InkWell(
                                              onTap: () async {
                                                await launch(
                                                    'http:${info.web}');
                                              },
                                              child: Image.asset(
                                                'assets/images/web.png',
                                                width: width * 0.11,
                                                height: higt * 0.06,
                                                fit: BoxFit.fill,
                                              ),
                                            ),
                                      info.facebook.isEmpty
                                          ? Container()
                                          : VerticalDivider(
                                              color: Colors.black,
                                              thickness: 2,
                                            ),
                                      info.facebook.isEmpty
                                          ? Container()
                                          : InkWell(
                                              onTap: () async {
                                                await launch(
                                                    'http:${info.facebook}');
                                              },
                                              child: Image.asset(
                                                'assets/images/facebook.png',
                                                width: width * 0.11,
                                                height: higt * 0.06,
                                                fit: BoxFit.fill,
                                              ),
                                            ),
                                      info.whatsapp.isEmpty
                                          ? Container()
                                          : VerticalDivider(
                                              color: Colors.black,
                                              thickness: 2,
                                            ),
                                      info.whatsapp.isEmpty
                                          ? Container()
                                          : InkWell(
                                              child: Image.asset(
                                                'assets/images/whatsapp.png',
                                                width: width * 0.11,
                                                height: higt * 0.06,
                                                fit: BoxFit.fill,
                                              ),
                                              onTap: () async {
                                                await launch(url());
                                              },
                                            ),
                                     info.shareView == "0"
                                          ? Container()
                                          : VerticalDivider(
                                              color: Colors.black,
                                              thickness: 2,
                                            ),
                                      info.shareView == "0"
                                          ? Container()
                                          : InkWell(
                                              child: Image.asset(
                                                'assets/images/Share icon.png',
                                                height: higt * 0.06,
                                                fit: BoxFit.fill,
                                              ),
                                              onTap: () async {
                                                await Share.share(
                                                    info.shareLink);
                                              },
                                            ),
                                    ],
                                  ),
                                ),
                              ),
                            ]),
                      ),
                      SizedBox(
                        height: 5,
                      )
                    ],
                  ),
                ],
              ),
            ),
    );
  }
}
