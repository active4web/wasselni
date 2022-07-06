import 'dart:io' show Platform;

import 'package:badges/badges.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:provider/provider.dart';
import 'package:share/share.dart';
import 'package:wassalny/Components/CustomWidgets/MyText.dart';
import 'package:wassalny/Components/CustomWidgets/showdialog.dart';
import 'package:wassalny/Screens/About/view.dart';
import 'package:wassalny/Screens/ContactUs/view.dart';
import 'package:wassalny/Screens/Language/view.dart';
import 'package:wassalny/Screens/Notif/view.dart';
import 'package:wassalny/Screens/Profile/view.dart';
import 'package:wassalny/Screens/Subscirbe/view.dart';
import 'package:wassalny/Screens/Tickets/view.dart';
import 'package:wassalny/Screens/cart/cart.dart';
import 'package:wassalny/Screens/login/view.dart';
import 'package:wassalny/Screens/myFavourite/myFavouriteScreen.dart';
import 'package:wassalny/Screens/myOrders/myOrders.dart';
import 'package:wassalny/model/home.dart';
import 'package:wassalny/network/auth/auth.dart';

import '../al_points_screen.dart';

class MyDrawer extends StatefulWidget {
  final String name;
  final userData;
  final products;

  MyDrawer({this.name, this.userData, this.products});

  @override
  State<StatefulWidget> createState() {
    return _MyDrawer();
  }
}

class _MyDrawer extends State<MyDrawer> {
  String name;
  bool isUser = false;
  String token;
  bool isAuth;
  var userData;

  String url;
  String chevk() {
    if (Platform.isAndroid) {
      url = 'https://play.google.com/store/apps/details?id=com.waselnni';
    } else if (Platform.isIOS) {
      url =
          'https://apps.apple.com/eg/app/%D9%88%D8%B5%D9%84%D9%86%D9%8A/id1578474355';
    }
    return url;
  }

  @override
  void initState() {
    chevk();
    super.initState();
  }

  Future<void> fechHome() async {
    try {
      await Provider.of<HomeLists>(context, listen: false)
          .fetchHome(lang)
          .then((_) {});
    } catch (error) {
      showErrorDaialog("NoInternet".tr, context);
    }
  }

  Widget menuTitle(String title, Function onTap, {bool cart = false}) {
    return Container(
      margin: EdgeInsets.only(right: 10.0, left: 10.0, bottom: 10.0, top: 0),
      padding: EdgeInsets.only(right: 0.0, left: 0.0, bottom: 10.0, top: 10),
      decoration: BoxDecoration(
          border: Border(bottom: BorderSide(color: Colors.white))),
      child: InkWell(
        onTap: onTap,
        child: Container(
          child: Row(
            children: <Widget>[
              SizedBox(width: 15),
              MyText(
                  title: title,
                  color: Colors.white,
                  weight: FontWeight.w600,
                  size: 15),
              if (cart)
                Badge(
                  badgeContent: Text(
                    widget.products.length.toString(),
                    style: TextStyle(
                      color: Colors.white,
                    ),
                  ),
                  child: Icon(Icons.shopping_cart_outlined, color: Colors.blue),
                )
            ],
          ),
        ),
      ),
    );
  }

  String lang = Get.locale.languageCode;

  Future<void> _submit() async {
    bool auth = Provider.of<Auth>(context, listen: false).doneLogOut;
    showDaialogLoader(context);
    try {
      auth = await Provider.of<Auth>(context, listen: false).logout(lang);
      // ignore: unused_catch_clause
    } catch (error) {
      print(error);

      Navigator.of(context).pop();
      showErrorDaialog('No internet connection', context);
    }
    if (auth) {
      // Navigator.pushAndRemoveUntil(context,
      //     MaterialPageRoute(builder: (context) => Login()), (route) => false);
      Get.offAll(Login());
    }
  }

  @override
  Widget build(BuildContext context) {
    return Container(
      width: 250,
      child: Drawer(
        child: Container(
          color: Colors.blue,
          child: ListView(
            children: <Widget>[
              SizedBox(height: 10),
              Container(
                padding: EdgeInsets.only(bottom: 10),
                decoration: BoxDecoration(
                  border: Border(
                    bottom: BorderSide(color: Colors.white),
                  ),
                ),
                child: Row(
                    mainAxisAlignment: MainAxisAlignment.start, children: []),
              ),
              // SizedBox(height: 30),
              menuTitle("Profile".tr, () {
                Get.to(Profile());
              }),
              menuTitle("notifications".tr, () {
                Get.to(Notififications());
              }),
              menuTitle("Favourite".tr, () {
                Get.to(MyFavouriteScreen());
              }),
              menuTitle(
                "cart".tr,
                () {
                  Get.to(CartScreen());
                },
              ),
              menuTitle("MyOrders".tr, () {
                Get.to(MyOrdersScreen());
              }),
              // menuTitle("offers".tr, () {
              //   Get.to(Offerss(
              //     searchType: 0,
              //   ));
              // }),
              menuTitle("lang".tr, () {
                Get.to(Language());
              }),
              menuTitle("TechnicalSupport".tr, () {
                Get.to(Tickets());
              }),
              menuTitle("SubscribeWithUs".tr, () {
                Get.to(Subscribe());
              }),
              menuTitle("ShareApp".tr, () async {
                await Share.share(url);
              }),
              menuTitle("aboutApp".tr, () {
                Get.to(About());
              }),
              menuTitle("points".tr, () {
                Get.to(AllPointsScreen());
              }),
              menuTitle(
                "ContactUs".tr,
                () {
                  Get.to(ContactUs());
                },
              ),
              menuTitle("SignOut".tr, _submit),
              SizedBox(
                height: MediaQuery.of(context).size.height * 0.15,
              ),
            ],
          ),
        ),
      ),
    );
  }
}
