import 'package:fcm_config/fcm_config.dart';
import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/foundation.dart';
import 'package:flutter_local_notifications/flutter_local_notifications.dart';
import 'package:flutter_localizations/flutter_localizations.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:get_storage/get_storage.dart';
import 'package:shared_preferences/shared_preferences.dart';

import 'package:provider/provider.dart';
import 'package:wassalny/Screens/Offerss/view.dart';
import 'package:wassalny/customNoti.dart';
import 'package:wassalny/main.dart';
import 'package:wassalny/model/addRatingModel.dart';
import 'package:wassalny/model/addToCart.dart';
import 'package:wassalny/model/addToFavourite.dart';
import 'package:wassalny/model/endOrderProvider.dart';
import 'package:wassalny/model/getMyFav.dart';
import 'package:wassalny/model/myOrdersProvider.dart';
import 'package:wassalny/model/sentLocation.dart';
import 'package:wassalny/splash.dart';
import 'Components/CustomWidgets/myColors.dart';
import 'Components/Language/getLanguage.dart';
import 'Screens/Notif/view.dart';
import 'Screens/Tickets/view.dart';
import 'Screens/cart/cart.dart';
import 'Screens/myOrders/myOrders.dart';
import 'Screens/register/county/list.dart';
import 'model/aboutandcontact.dart';
import 'model/branches.dart';
import 'model/cartProvider.dart';
import 'model/categoriseDetails.dart';
import 'model/deleteItem.dart';
import 'model/home.dart';
import 'model/homeSearch.dart';
import 'model/itemServicesDetail.dart';
import 'model/min_sirv.dart';
import 'model/notifications.dart';
import 'model/offerDetails.dart';
import 'model/offers.dart';
import 'model/searchByCity.dart';
import 'model/searchByCityOffers.dart';
import 'model/searchoffersLAndLat.dart';
import 'model/tickets.dart';
import 'model/ticketsDetailsModel.dart';
import 'model/ticketsList.dart' as x;
import 'model/searchStates.dart' as y;
import 'model/notifDetails.dart';
import 'model/searchLAndLat.dart';
import 'model/sirv_offers.dart';
import 'model/updateCartProvider.dart';
import 'network/auth/auth.dart';
import 'notification_helper.dart';

class WaslnyApp extends StatefulWidget {
  @override
  _WaslnyAppState createState() => _WaslnyAppState();
}

class _WaslnyAppState extends State<WaslnyApp> with WidgetsBindingObserver {
  final savedLang = GetStorage();
  final saveToken = GetStorage();
  void getMessage() async {
    // if (initialMessage?.data != null) {
    //   if (initialMessage?.data['type'] == '1') {
    //     Get.to(() => MyOrdersScreen());
    //   }
    //   if (initialMessage?.data['type'] == '2') {
    //     Get.to(() => Offerss());
    //   }
    //   if (initialMessage?.data['type'] == '3') {
    //     Get.to(() => Tickets());
    //   }
    //   if (initialMessage?.data['type'] == '4') {
    //     Get.to(() => Notififications());
    //   }
    // }
    FirebaseMessaging.onMessageOpenedApp.listen((RemoteMessage message) {
      print(message.data['type']);
      if (message.data['type'] == '1') {
        Get.to(() => MyOrdersScreen());
      }
      if (message.data['type'] == '2') {
        Get.to(() => Offerss());
      }
      if (message.data['type'] == '3') {
        Get.to(() => Tickets());
      }
      if (message.data['type'] == '4') {
        Get.to(() => Notififications());
      }
    });
    // FirebaseMessaging.onMessage.listen((RemoteMessage message) {
    //   print('Message data: ${message.data}');
    //   if (message.notification != null) {
    //     // NotificationHelper().displayNotification(title: message.notification.title, body: message.notification.body);
    //   }
    // });
  }

  @override
  void initState() {
    super.initState();
    getMessage();
  }

  @override
  Widget build(BuildContext context) {
    // FirebaseMessaging().getToken().then((value) {
    //   saveToken.write('fire', value);
    // });
    return MultiProvider(
      providers: [
        ChangeNotifierProvider(
          create: (context) => Auth(),
        ),
        ChangeNotifierProvider(
          create: (context) => CityDropDownProvider(),
        ),
        ChangeNotifierProxyProvider<Auth, AllOffersProvider>(
          create: null,
          update: (context, auth, alOffersProvider) => AllOffersProvider(
            id: auth.id,
            lang: auth.lang,
            token: auth.token,
          ),
        ),

        ChangeNotifierProxyProvider<Auth, HomeLists>(
          create: null,
          update: (context, auth, homelist) => HomeLists(
            id: auth.id,
            lang: auth.lang,
            token: auth.token,
          ),
        ),
        ChangeNotifierProxyProvider<Auth, AboutAndContactUS>(
          create: null,
          update: (context, auth, aboutAndContactUS) => AboutAndContactUS(
            token: auth.token,
          ),
        ),
        ChangeNotifierProxyProvider<Auth, ContactUsModel>(
          create: null,
          update: (context, auth, contactUs) => ContactUsModel(
            token: auth.token,
          ),
        ),
        ChangeNotifierProxyProvider<Auth, TicketsTypeProvider>(
          create: null,
          update: (context, auth, contactUs) => TicketsTypeProvider(
            token: auth.token,
          ),
        ),
        ChangeNotifierProxyProvider<Auth, OfferDetailsProvider>(
          create: null,
          update: (context, auth, offerDetailsProvider) => OfferDetailsProvider(
            token: auth.token,
          ),
        ),
        ChangeNotifierProxyProvider<Auth, DetailsOfServicesProvider>(
          create: null,
          update: (context, auth, offerDetailsProvider) =>
              DetailsOfServicesProvider(
            token: auth.token,
          ),
        ),
        ChangeNotifierProxyProvider<Auth, ItemServicesDetail>(
          create: null,
          update: (context, auth, offerDetailsProvider) => ItemServicesDetail(
            auth.token,
          ),
        ),
        ChangeNotifierProxyProvider<Auth, x.TicketsLisstProvider>(
          create: null,
          update: (context, auth, offerDetailsProvider) =>
              x.TicketsLisstProvider(
            token: auth.token,
          ),
        ),
        ChangeNotifierProxyProvider<Auth, NotificationsProvider>(
          create: null,
          update: (context, auth, offerDetailsProvider) =>
              NotificationsProvider(
            token: auth.token,
          ),
        ),
        ChangeNotifierProxyProvider<Auth, BranchesProvider>(
          create: null,
          update: (context, auth, branchesProvider) => BranchesProvider(
            token: auth.token,
          ),
        ),
        ChangeNotifierProxyProvider<Auth, SearchName>(
          create: null,
          update: (context, auth, searchName) => SearchName(
            token: auth.token,
          ),
        ),
        ChangeNotifierProxyProvider<Auth, TicketsDetailsProvider>(
          create: null,
          update: (context, auth, ticketsDetailsProvider) =>
              TicketsDetailsProvider(token: auth.token),
        ),
        ChangeNotifierProxyProvider<Auth, SearchCity>(
          create: null,
          update: (context, auth, searchCity) => SearchCity(token: auth.token),
        ),
        ChangeNotifierProxyProvider<Auth, SearchOffersByCity>(
          create: null,
          update: (context, auth, searchOfferCity) =>
              SearchOffersByCity(token: auth.token),
        ),
        ChangeNotifierProxyProvider<Auth, y.SearchStatesProvider>(
          create: null,
          update: (context, auth, searchCity) =>
              y.SearchStatesProvider(token: auth.token),
        ),
        ChangeNotifierProxyProvider<Auth, NotificationDetailsProvider>(
          create: null,
          update: (context, auth, searchCity) =>
              NotificationDetailsProvider(token: auth.token),
        ),
        ChangeNotifierProxyProvider<Auth, AddRatingProvider>(
          create: null,
          update: (context, auth, searchCity) =>
              AddRatingProvider(token: auth.token),
        ),
        ChangeNotifierProxyProvider<Auth, SearchLatAndLagProvider>(
          create: null,
          update: (context, auth, searchCity) =>
              SearchLatAndLagProvider(token: auth.token),
        ),
        ChangeNotifierProxyProvider<Auth, SearchLatAndLagOffersProvider>(
          create: null,
          update: (context, auth, searchCity) =>
              SearchLatAndLagOffersProvider(token: auth.token),
        ),
        ChangeNotifierProxyProvider<Auth, AllMinProvider>(
          create: null,
          update: (context, auth, searchCity) =>
              AllMinProvider(token: auth.token),
        ),
        ChangeNotifierProxyProvider<Auth, SirvOfferProvider>(
          create: null,
          update: (context, auth, searchCity) =>
              SirvOfferProvider(token: auth.token),
        ),
        //         ChangeNotifierProxyProvider<Auth, AddProductProvider>(
        //   create: null,
        //   update: (context, auth, offerDetailsProvider) => AddProductProvider(
        //     token: auth.token,
        //   ),
        // ),
        ChangeNotifierProxyProvider<Auth, RemoveFromCartProvider>(
          create: null,
          update: (context, auth, offerDetailsProvider) =>
              RemoveFromCartProvider(
            token: auth.token,
          ),
        ),
        ChangeNotifierProxyProvider<Auth, CartListProvider>(
          create: null,
          update: (context, auth, searchCity) =>
              CartListProvider(token: auth.token),
        ),
        ChangeNotifierProxyProvider<Auth, UpdateIndexOfCartProvider>(
          create: null,
          update: (context, auth, searchCity) =>
              UpdateIndexOfCartProvider(token: auth.token),
        ),
        ChangeNotifierProxyProvider<Auth, UpdateFavProvider>(
          create: null,
          update: (context, auth, searchCity) =>
              UpdateFavProvider(token: auth.token),
        ),
        ChangeNotifierProxyProvider<Auth, FavouriteListProvider>(
          create: null,
          update: (context, auth, searchCity) =>
              FavouriteListProvider(token: auth.token),
        ),
        ChangeNotifierProxyProvider<Auth, AddProductProvider>(
          create: null,
          update: (context, auth, searchCity) =>
              AddProductProvider(token: auth.token),
        ),
        ChangeNotifierProxyProvider<Auth, SentLocationgProvider>(
          create: null,
          update: (context, auth, searchCity) =>
              SentLocationgProvider(token: auth.token),
        ),
        ChangeNotifierProxyProvider<Auth, MyOrdersProvider>(
          create: null,
          update: (context, auth, searchCity) =>
              MyOrdersProvider(token: auth.token),
        ),
        ChangeNotifierProxyProvider<Auth, EndOrderProvider>(
          create: null,
          update: (context, auth, searchCity) =>
              EndOrderProvider(token: auth.token),
        ),
      ],
      child: GetMaterialApp(
        translations: Messages(),
        // your translations
        locale: Locale(savedLang.read('lang') == null
            ? 'ar'
            : savedLang
                .read('lang')), // translations will be displayed in that locale
        fallbackLocale: Locale(
            savedLang.read('lang') == null ? 'ar' : savedLang.read('lang')),
        debugShowCheckedModeBanner: false,
        localizationsDelegates: [
          GlobalMaterialLocalizations.delegate,
          GlobalWidgetsLocalizations.delegate,
          GlobalCupertinoLocalizations.delegate,
          DefaultCupertinoLocalizations.delegate,
        ],
        supportedLocales: [Locale('ar'), Locale('en'), Locale('tr')],
        theme: ThemeData(
          cupertinoOverrideTheme: CupertinoThemeData(
              textTheme: CupertinoTextThemeData(
            dateTimePickerTextStyle:
                TextStyle(fontSize: 15, fontWeight: FontWeight.bold),
          )),
          brightness: Brightness.light,
          primaryColor: MyColors.primary,
          accentColor: MyColors.primary,
          fontFamily: "GE-Snd-Book",
          backgroundColor: Color.fromRGBO(250, 250, 250, 1),
          canvasColor: Color.fromRGBO(250, 250, 250, 1),
          textTheme: TextTheme(
            headline1: TextStyle(fontFamily: 'GE-Snd-Book'),
          ),
        ),
        home: SplashScreen(),
      ),
    );
  }

  // Future _notificationConfig() async {
  //   _firebaseMessaging.configure(
  //       onMessage: (Map<String, dynamic> message) async {
  //     print('message: ' + message.toString());
  //     _notification.showNotification(
  //         message['notification']['title'], message['notification']['body']);
  //   }, onLaunch: (Map<String, dynamic> message) async {
  //     print('OnLaunch: $message');
  //   }, onResume: (Map<String, dynamic> message) async {
  //     print('OnResume: $message');
  //   });
  //   await _firebaseMessaging.requestNotificationPermissions(
  //     IosNotificationSettings(
  //         sound: true, badge: true, alert: true, provisional: false),
  //   );
  // }
}
