import 'package:auto_size_text/auto_size_text.dart';
import 'package:badges/badges.dart';
import 'package:cached_network_image/cached_network_image.dart';
import 'package:flutter/material.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:geocode/geocode.dart';
import 'package:get/get.dart';
import 'package:get_storage/get_storage.dart';
import 'package:location/location.dart';
import 'package:provider/provider.dart';
import 'package:badges/badges.dart' as badges;
import 'package:card_swiper/card_swiper.dart';

import 'package:url_launcher/url_launcher.dart';
import 'package:wassalny/Components/CustomWidgets/customTextField.dart';
import 'package:wassalny/Components/CustomWidgets/showdialog.dart';
import 'package:wassalny/Components/constants.dart';
import 'package:wassalny/Screens/cart/cart.dart';
import 'package:wassalny/Screens/searchScreen/searchScreen.dart' as Search;
import 'package:wassalny/model/addToFavourite.dart';
import 'package:wassalny/model/cartProvider.dart' as Cart;
import 'package:wassalny/model/home.dart';
import 'package:wassalny/model/homeSearch.dart';

import '../searchLatAndLag/searchLatAndLagScreen.dart';
import 'drawer.dart';
import 'gridWidget.dart';

class Home extends StatefulWidget {
  @override
  _HomeState createState() => _HomeState();
}

class _HomeState extends State<Home> {
  GlobalKey<ScaffoldState> _scafold2 = GlobalKey<ScaffoldState>();
  TextEditingController _search = TextEditingController();
  String lang = Get.locale?.languageCode??'ar';

  List<Cart.AllProduct> allProducts = [];
  String? currncy;
  bool _loader = true;
  var location = Location();
  double? currentLat;
  double? currentLong;
  bool? _serviceEnabled;
  PermissionStatus? _permissionGranted;
  LocationData? _locationData;
  Future _getCurrentLocation() async {
    _serviceEnabled = await location.serviceEnabled();
    if (!_serviceEnabled!) {
      _serviceEnabled = await location.requestService();
      if (!_serviceEnabled!) {
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
    // GeoCode geoCode = GeoCode();

    // final coordinates =
    //     new Coordinates(latitude:_locationData?.latitude, longitude:_locationData?.longitude);
    // var addresses =await geoCode.forwardGeocoding(address: address);
    // var first = addresses.first;
    // print(
    //     'locationsss: ${first.locality}, ${first.adminArea},${first.subLocality}, ${first.subAdminArea},${first.addressLine}, ${first.featureName},${first.thoroughfare}, ${first.subThoroughfare}');
    // setState(() {
    //   currentLat = _locationData?.latitude;
    //   currentLong = _locationData?.longitude;
    // });
    // setState(() {
    //   _loader = false;
    // });
    // print(currentLat);
    // print(currentLong);
  }

  Future<void> future() async {
    loader = true;
    // try {
    allProducts =
        (await Provider.of<Cart.CartListProvider>(context, listen: false)
            .fetchCart(lang))!;
    for (var i = 0; i < allProducts.length; i++) {
      print('${allProducts[i].price} price');
      currncy = allProducts[i].currencyName;
    }
    // } catch (error) {
    //   print(error);
    //   setState(() {
    //     loader = false;
    //   });
    //   throw (error);
    // }
  }

  Widget restaurant(String image) => Expanded(
        child: Container(
          height: 120.h,
          width: 120.w,
          decoration: BoxDecoration(
            borderRadius: BorderRadius.circular(15),
            color: Colors.white,
            image: DecorationImage(
              fit: BoxFit.fill,
              image: AssetImage("assets/images/$image.png"),
            ),
          ),
        ),
      );
  final GlobalKey<FormState> key = GlobalKey<FormState>();

  Future<void> _submit() async {
    bool doneSearching =
        Provider.of<SearchName>(context, listen: false).doneSearching;
    final provider = Provider.of<SearchName>(context, listen: false);
    provider.searchName.clear();
    if (!key.currentState!.validate()) {
      return;
    }
    key.currentState!.save();
    showDaialogLoader(context);
    try {
      doneSearching =
          await provider.fetchSearch(_search.text.toString(), 100, 0, lang);
      // ignore: unused_catch_clause
    } catch (error) {
      print(error);
      Navigator.of(context).pop();
      showErrorDaialog("NoInternet".tr, context);
    } finally {
      if (doneSearching) {
        Future.delayed(Duration(seconds: 2)).then((value) {
          Navigator.of(context).pop();
          Get.to(Search.SearchScreen(
            name: _search.text,
            search: Provider.of<SearchName>(context, listen: false).searchName,
            searchText: _search.text.toString(),
          ));
        });
      }
    }
  }

  Widget imageCarousel() {
    final width = (MediaQuery.of(context).size.width);
    final hight = (MediaQuery.of(context).size.height -
        MediaQuery.of(context).padding.top);
    List<MainOffers> sliderImageInMain =
        Provider.of<HomeLists>(context, listen: false).sliderImageInMain;
    sliderImageInMain.shuffle();

    return Padding(
      padding: EdgeInsets.only(
          top: hight * 0.048, left: width * 0.048, right: width * 0.048),
      child: Column(
        children: [
          Container(
            padding: EdgeInsets.all(5),
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.all(
                Radius.circular(10),
              ),
            ),
            child: Row(
              children: [
                InkWell(
                  onTap: () => _scafold2.currentState?.openDrawer(),
                  child: Icon(Icons.menu, color: Colors.blue),
                ),
                SizedBox(
                  width: 10,
                ),
                Expanded(
                  child: Container(
                    height: 30,
                    child: Form(
                      key: key,
                      child: TransparentTextFieldColorText(
                          controller: _search,
                          validator: (val) {
                            if (val!.isEmpty) {
                              return 'PleaseEnterTheSearchWord'.tr;
                            } else {
                              return null;
                            }
                          },
                          hint: "SearchOffers".tr),
                    ),
                  ),
                ),
                SizedBox(width: 20),
                InkWell(
                  onTap: _submit,
                  child: Icon(Icons.search, color: Colors.blue),
                ),
                InkWell(
                    onTap: () => Get.to(
                          () => CartScreen(),
                        ),
                    child: badges.Badge(
                      badgeContent: Text(
                        allProducts.length.toString(),
                        style: TextStyle(
                          color: Colors.white,
                        ),
                      ),
                      child: Icon(Icons.shopping_cart_outlined,
                          color: Colors.blue),
                    )),
              ],
            ),
          ),
          Padding(
            padding: EdgeInsets.only(top: hight * 0.02),
            child: Container(
              height: hight * 0.25,
              decoration: BoxDecoration(
                border: Border(),
                borderRadius: BorderRadius.circular(15),
              ),
              child: ClipRRect(
                borderRadius: BorderRadius.circular(15),
                child: Swiper(
                  itemCount: sliderImageInMain.length,
                    itemBuilder:(context,index)=>
                         InkWell(
                          onTap:
                          sliderImageInMain[index].link!.isEmpty || sliderImageInMain[index].link == null || sliderImageInMain[index].link == ''
                                  ? () {}
                                  : () async {
                                      await launch('http:${sliderImageInMain[index].link}');
                                    },
                          child: CachedNetworkImage(
                            imageUrl: sliderImageInMain[index].image??'',
                            fit: BoxFit.fill,
                          ),

                    ),
                    autoplay: true,
              ),
            ),
          ))
        ],
      ),
    );
  }

  AllRecommended chonsenOne(int position) {
    List<AllRecommended> allrecommended =
        Provider.of<HomeLists>(context, listen: false).recomended;
    AllRecommended selected = allrecommended.firstWhere(
        (element) => element.recommendedPosition == position,
        orElse: () => AllRecommended());
    return selected;
  }

  bool loader = false;
  final savedLang = GetStorage();

  // Future<void> fetchLocalDatabase() async {
  //   loader = true;
  //   try {
  //     await Provider.of<HomeLists>(context, listen: false)
  //         .fetchLocalDataBase(lang)
  //         .then((_) {
  //       setState(() {
  //         loader = false;
  //       });
  //     });
  //   } catch (error) {
  //     // showErrorDaialog("NoInternet".tr, context);
  //   }
  // }

  Future<void> fechHome() async {
    loader = true;
    try {
      await Provider.of<HomeLists>(context, listen: false)
          .fetchHome(lang)
          .then((_) {
        setState(() {
          loader = false;
        });
      });
    } catch (error) {
      // showErrorDaialog("NoInternet".tr, context);
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
      fechHome();
    }
  }

  @override
  void initState() {
    future().then((value) {
      _getCurrentLocation();
      // fetchLocalDatabase();
      fechHome();
    });

    savedLang.write('lang', lang);
    super.initState();
  }

  int? mainIDN;
  @override
  Widget build(BuildContext context) {
    final width = (MediaQuery.of(context).size.width);
    final hight = (MediaQuery.of(context).size.height -
        MediaQuery.of(context).padding.top);
    List<AllCategories> allCategories =
        Provider.of<HomeLists>(context).allCategories;
    List<AllFeatures> allfeature =
        Provider.of<HomeLists>(context, listen: false).allfeature;
    print(allfeature);
    List<MainOffers> secondSlider =
        Provider.of<HomeLists>(context, listen: false).secondSlider;
    secondSlider.shuffle();
    String recomendedString =
        Provider.of<HomeLists>(context, listen: false).recomendedString;
    return Scaffold(
      // backgroundColor: Colors.grey[100],
      key: _scafold2,
      drawer: MyDrawer(
        products: allProducts,
      ),
      body:  ListView(
              padding: EdgeInsets.only(bottom: 100),
              children: <Widget>[
                SizedBox(
                  height: 15,
                ),
                imageCarousel(),
                SizedBox(height: 8),
                Padding(
                  padding: EdgeInsets.symmetric(horizontal: width * 0.048),
                  child: AutoSizeText(
                    recomendedString,
                    style: TextStyle(fontSize: 20),
                  ),
                ),
                SizedBox(height: 5),
                Padding(
                  padding: EdgeInsets.symmetric(horizontal: width * 0.048),
                  child: Container(
                    height: hight * 0.15,
                    width: width,
                    decoration:
                        BoxDecoration(border: Border.all(color: Colors.black)),
                    child: Row(
                      children: [
                        Padding(
                          padding: EdgeInsets.symmetric(
                              horizontal: width * 0.02, vertical: hight * 0.01),
                          child: GestureDetector(
                            onTap: () {
                              // if (chonsenOne(1).depId != null)
                              //   Get.to(
                              //       // ServicesDetails(
                              //       //   id: chonsenOne(1).serviceId,
                              //       // ),
                              //       SearchLatAndLagScreen(
                              //     catId: chonsenOne(1).depId,
                              //     lat: currentLat,
                              //     lag: currentLong,
                              //     distance: "10",
                              //     searchType: 2,
                              //   ));
                            },
                            child: Container(
                              width: width * 0.4,
                              child: CachedNetworkImage(
                                placeholder: (context, url) =>
                                    Image.asset(appLogo),
                                imageUrl: chonsenOne(1).recommendedImage??'',
                                fit: BoxFit.fill,
                              ),
                            ),
                          ),
                        ),
                        SizedBox(
                          width: 1,
                        ),
                        Padding(
                          padding: EdgeInsets.symmetric(vertical: hight * 0.01),
                          child: Column(
                            mainAxisAlignment: MainAxisAlignment.spaceBetween,
                            children: [
                              GestureDetector(
                                onTap: () {
                                  // if (chonsenOne(2).depId != null)
                                  //   Get.to(SearchLatAndLagScreen(
                                  //     catId: chonsenOne(2).depId,
                                  //     lat: currentLat,
                                  //     distance: "10",
                                  //     lag: currentLong,
                                  //     searchType: 2,
                                  //   ));
                                },
                                child: Container(
                                  height: hight * 0.06,
                                  width: width * 0.20,
                                  child: CachedNetworkImage(
                                    placeholder: (context, url) =>
                                        Image.asset(appLogo),
                                    imageUrl: chonsenOne(2).recommendedImage??'',
                                    fit: BoxFit.fill,
                                  ),
                                ),
                              ),
                              GestureDetector(
                                onTap: () {
                                  // if (chonsenOne(6).depId != null)
                                  //   Get.to(SearchLatAndLagScreen(
                                  //     catId: chonsenOne(6).depId,
                                  //     lat: currentLat,
                                  //     distance: "10",
                                  //     lag: currentLong,
                                  //     searchType: 2,
                                  //   ));
                                },
                                child: Container(
                                  color: Colors.red,
                                  height: hight * 0.06,
                                  width: width * 0.20,
                                  child: CachedNetworkImage(
                                    placeholder: (context, url) =>
                                        Image.asset(appLogo),
                                    imageUrl: chonsenOne(6).recommendedImage??'',
                                    fit: BoxFit.fill,
                                  ),
                                ),
                              ),
                            ],
                          ),
                        ),
                        Padding(
                          padding: EdgeInsets.symmetric(
                              horizontal: width * 0.015,
                              vertical: hight * 0.01),
                          child: Column(
                            mainAxisAlignment: MainAxisAlignment.spaceBetween,
                            children: [
                              Container(
                                width: width * 0.22,
                                child: Row(
                                  mainAxisAlignment:
                                      MainAxisAlignment.spaceBetween,
                                  children: [
                                    GestureDetector(
                                      onTap: () {
                                        // if (chonsenOne(3).depId != null)
                                        //   Get.to(SearchLatAndLagScreen(
                                        //     catId: chonsenOne(3).depId,
                                        //     lat: currentLat,
                                        //     lag: currentLong,
                                        //     distance: "10",
                                        //     searchType: 2,
                                        //   ));
                                      },
                                      child: Container(
                                        child: CachedNetworkImage(
                                          placeholder: (context, url) =>
                                              Image.asset(
                                                  appLogo),
                                          imageUrl:
                                              chonsenOne(3).recommendedImage??"",
                                          fit: BoxFit.fill,
                                        ),
                                        width: width * 0.1,
                                        height: hight * 0.06,
                                      ),
                                    ),
                                    GestureDetector(
                                      onTap: () {
                                        // if (chonsenOne(4).depId != null)
                                        //   Get.to(SearchLatAndLagScreen(
                                        //     catId: chonsenOne(4).depId,
                                        //     lat: currentLat,
                                        //     lag: currentLong,
                                        //     distance: "10",
                                        //     searchType: 2,
                                        //   ));
                                      },
                                      child: Container(
                                        child: CachedNetworkImage(
                                          placeholder: (context, url) =>
                                              Image.asset(
                                                  appLogo),
                                          imageUrl:
                                              chonsenOne(4).recommendedImage??'',
                                          fit: BoxFit.fill,
                                        ),
                                        width: width * 0.1,
                                        height: hight * 0.06,
                                      ),
                                    ),
                                  ],
                                ),
                              ),
                              GestureDetector(
                                onTap: () {
                                  // if (chonsenOne(5).depId != null)
                                  //   Get.to(SearchLatAndLagScreen(
                                  //     catId: chonsenOne(5).depId,
                                  //     lat: currentLat,
                                  //     lag: currentLong,
                                  //     distance: "10",
                                  //     searchType: 1,
                                  //   ));
                                },
                                child: Container(
                                  height: hight * 0.06,
                                  width: width * 0.22,
                                  child: CachedNetworkImage(
                                    placeholder: (context, url) =>
                                        Image.asset(appLogo),
                                    imageUrl: chonsenOne(5).recommendedImage??'',
                                    fit: BoxFit.fill,
                                  ),
                                ),
                              ),
                            ],
                          ),
                        ),
                      ],
                    ),
                  ),
                ),
                customGridView(
                  context,
                  allCategories,
                ),
                Container(
                  padding: EdgeInsets.symmetric(horizontal: 15),
                  child: Column(
                    children: [
                      // Padding(
                      //   padding: EdgeInsets.only(top: hight * 0.02),
                      //   child: Container(
                      //     height: hight * 0.25,
                      //     decoration: BoxDecoration(
                      //       border: Border(),
                      //       borderRadius: BorderRadius.circular(15),
                      //     ),
                      //     child: ClipRRect(
                      //       borderRadius: BorderRadius.circular(15),
                      //       child: Carousel(
                      //           boxFit: BoxFit.fill,
                      //           images: secondSlider.map(
                      //             (e) {
                      //               return InkWell(
                      //                 onTap: e.link.isEmpty ||
                      //                         e.link == null ||
                      //                         e.link == ''
                      //                     ? () {}
                      //                     : () async {
                      //                         await launch('http:${e.link}');
                      //                       },
                      //                 child: CachedNetworkImage(
                      //                   imageUrl: e.image,
                      //                   fit: BoxFit.fill,
                      //                 ),
                      //               );
                      //             },
                      //           ).toList(),
                      //           autoplay: true,
                      //           dotSize: 7.0,
                      //           autoplayDuration: Duration(seconds: 6),
                      //           overlayShadow: true,
                      //           dotColor: Colors.blue,
                      //           indicatorBgPadding: 1.0,
                      //           dotBgColor: Colors.transparent),
                      //     ),
                      //   ),
                      // ),


                      // Container(
                      //   padding: EdgeInsets.all(10),
                      //   decoration: BoxDecoration(
                      //     color: Colors.grey.shade200,
                      //     borderRadius: BorderRadius.all(
                      //       Radius.circular(15),
                      //     ),
                      //   ),
                      //   child: GestureDetector(
                      //     onTap: () {
                      //       Get.to(Filter(1));
                      //     },
                      //     child: Row(
                      //       children: [
                      //         Text(
                      //           'FastSearch'.tr,
                      //           style: TextStyle(
                      //               fontWeight: FontWeight.bold, fontSize: 18),
                      //         ),
                      //         SizedBox(width: 10),
                      //         Icon(Icons.search, color: Colors.indigo),
                      //         Spacer(),
                      //         Text(
                      //           "ReachingTheGoal".tr,
                      //           style: TextStyle(
                      //               fontWeight: FontWeight.bold, fontSize: 18),
                      //         ),
                      //         SizedBox(width: 10),
                      //         Icon(Icons.location_on, color: Colors.indigo)
                      //       ],
                      //     ),
                      //   ),
                      // ),
                      // SizedBox(height: 30.h),
                      // ...allfeature.map((items) {
                      //   // ignore: unused_element
                      //   int mainId() {
                      //     for (var i = 0; i < allCategories.length; i++) {
                      //       if (allCategories[i].allDepartment.length > 0) {
                      //         mainIDN = 0;
                      //       } else {
                      //         mainIDN = 1;
                      //       }
                      //     }
                      //     return mainIDN;
                      //   }
                      //
                      //   return Container(
                      //     child: Column(
                      //       children: [
                      //         Row(
                      //           children: [
                      //             Padding(
                      //               padding: const EdgeInsetsDirectional.only(
                      //                   start: 10),
                      //               child: Text(
                      //                 items.categoryName,
                      //                 style: TextStyle(
                      //                     fontWeight: FontWeight.bold,
                      //                     fontSize: 25),
                      //               ),
                      //             ),
                      //             Spacer(),
                      //             Container(
                      //                 decoration: BoxDecoration(
                      //                   borderRadius: BorderRadius.circular(15),
                      //                   color: Colors.blue.withAlpha(40),
                      //                   image: DecorationImage(
                      //                       image: CachedNetworkImageProvider(
                      //                           items.categoryImage),
                      //                       fit: BoxFit.fill),
                      //                 ),
                      //                 height: 90,
                      //                 width: 90),
                      //           ],
                      //         ),
                      //         SizedBox(height: 20.h),
                      //         // SingleChildScrollView(
                      //         //   scrollDirection: Axis.horizontal,
                      //         //   child: Row(
                      //         //     mainAxisAlignment:
                      //         //         MainAxisAlignment.spaceAround,
                      //         //     children: items.allProducts.map((e) {
                      //         //       // print("${e.productImage} image");
                      //         //       return Column(children: [
                      //         //         GestureDetector(
                      //         //           onTap: () {
                      //         //             Get.to(
                      //         //               ServicesDetails(
                      //         //                 id: e.prodId,
                      //         //               ),
                      //         //             );
                      //         //           },
                      //         //           child: Container(
                      //         //             margin: EdgeInsets.symmetric(
                      //         //                 horizontal: width * 0.015),
                      //         //             decoration: BoxDecoration(
                      //         //               borderRadius:
                      //         //                   BorderRadius.circular(15),
                      //         //             ),
                      //         //             height: 100,
                      //         //             width: 100,
                      //         //             child: ClipRRect(
                      //         //               borderRadius:
                      //         //                   BorderRadius.circular(15),
                      //         //               child: CachedNetworkImage(
                      //         //                 imageUrl: e.productImage,
                      //         //                 fit: BoxFit.fill,
                      //         //               ),
                      //         //             ),
                      //         //           ),
                      //         //         ),
                      //         //         Row(
                      //         //           mainAxisAlignment:
                      //         //               MainAxisAlignment.center,
                      //         //           children: [
                      //         //             IconButton(
                      //         //                 onPressed: () =>
                      //         //                     _sentFav(e.favExit, e.prodId),
                      //         //                 icon: e.favExit == 0
                      //         //                     ? Icon(
                      //         //                         CupertinoIcons.heart,
                      //         //                         color: Colors.red,
                      //         //                       )
                      //         //                     : Icon(
                      //         //                         CupertinoIcons.heart_fill,
                      //         //                         color: Colors.red,
                      //         //                       )),
                      //         //             SizedBox(
                      //         //               width: 8,
                      //         //             ),
                      //         //             Icon(
                      //         //               Icons.star,
                      //         //               color: Colors.yellow,
                      //         //             ),
                      //         //             e.totalRate == '' ||
                      //         //                     e.totalRate == null
                      //         //                 ? Text('0')
                      //         //                 : Text(e.totalRate),
                      //         //           ],
                      //         //         ),
                      //         //         Text(e.productName),
                      //         //         SizedBox(
                      //         //           width: 15,
                      //         //         )
                      //         //       ]);
                      //         //     }).toList(),
                      //         //   ),
                      //         // ),
                      //       ],
                      //     ),
                      //   );
                      // }).toList(),
                    ],
                  ),
                ),
              ],
            ),
    );
  }
}
