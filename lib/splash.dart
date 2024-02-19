import 'dart:async';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:provider/provider.dart';
import 'package:shared_preferences/shared_preferences.dart';

import 'package:dio/dio.dart' as Dio;
import 'package:wassalny/Components/constants.dart';
import 'package:wassalny/Screens/intro/select_intro_screen.dart';
import 'package:wassalny/Screens/intro/view.dart';
import 'package:wassalny/Screens/register/register.dart';

import 'Screens/BattomBar/view.dart';
import 'Screens/login/view.dart';
import 'network/auth/auth.dart';
import 'network/auth/dio.dart';

class SplashScreen extends StatefulWidget {
  final GlobalKey<NavigatorState>? navigatorKey;
  SplashScreen({this.navigatorKey});
  @override
  State<StatefulWidget> createState() {
    return SplashScreenState();
  }
}

class SplashScreenState extends State<SplashScreen> {
  GlobalKey<ScaffoldState> _scafold = new GlobalKey<ScaffoldState>();

  Future<void> log(String tokenn) async {
    try {
      Dio.Response response = await dio().post(
        'pages/preparation_profile',
        data: Dio.FormData.fromMap(
          {'key': 1234567890, 'token_id': tokenn, 'lang': 'ar'},
        ),
      );
      print(response);
    } catch (error) {
      throw (error);
    }
  }

  String lang = Get.locale?.languageCode??'ar';

  checkUsers() async {
    if(storeToken!=null){
      Provider.of<Auth>(context, listen: false)
          .getUserInfoForSpalsh(storeToken!, lang);
    }
    Future.delayed(Duration(seconds: 1), () {

        Future.delayed(Duration(seconds: 1), () {
          if(storeToken==null){
          Get.offAll(Login());}
          else{
            Get.offAll(IntroScreen());
          }

        });

    });
  }

  @override
  void initState() {
    // GlobalNotification.instance.notificationSetup();
    // SharedPreferences.getInstance().then((prefs) {
    //   print(
    //       ">>>>>>>>>>>>>>>>>>>>>>>  splash >>>>>        ${prefs.getString('msgToken')}     <<<<<<<<<<<");
    // });

    super.initState();
    checkUsers();
    // SystemChrome.setEnabledSystemUIOverlays([]);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      key: _scafold,
      body: Stack(
        children: [
          Container(
            decoration: BoxDecoration(
                image: DecorationImage(
                    fit: BoxFit.fill,
                    image: AssetImage('assets/images/splash.png'))),
          ),
          Center(
              child: Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 60),
                  child: Image.asset(appLogo)))
        ],
      ),
    );
  }
}

//   Future<void> getToken() async {

//     if (tokenn==null) {
//       return null;
//     }else{
//       log( tokenn);
//     }

//   }

//   @override
//   void initState() {
//     getToken();

//     super.initState();
//   }
