// import 'dart:async';
// // import 'package:engazwaterclient/Screens/MyOrderDetails/view.dart';
// import 'package:firebase_messaging/firebase_messaging.dart';
// import 'package:flutter/material.dart';
// import 'package:get/get.dart';
// import 'package:shared_preferences/shared_preferences.dart';

// class GlobalNotification {
  
//   FirebaseMessaging _firebaseMessaging;
//   GlobalKey<NavigatorState> navigatorKey;

//   static StreamController<Map<String, dynamic>> _onMessageStreamController =
//       StreamController.broadcast();
//   static StreamController<Map<String, dynamic>> _streamController =
//       StreamController.broadcast();

//   static GlobalNotification instance = new GlobalNotification._();
//   GlobalNotification._();

//   static final Stream<Map<String, dynamic>> onFcmMessage =
//       _streamController.stream;

//   void notificationSetup({GlobalKey<NavigatorState> navigatorKey}) {
//     _firebaseMessaging = FirebaseMessaging();
//     // this.navigatorKey = navigatorKey;
//     requestPermissions();
//     getFcmToken();
//     notificationListeners();
//   }

//   StreamController<Map<String, dynamic>> get notificationSubject {
//     return _onMessageStreamController;
//   }

//   void requestPermissions() {
//     _firebaseMessaging.requestNotificationPermissions(
//         const IosNotificationSettings(sound: true, alert: true, badge: true));
//     _firebaseMessaging.onIosSettingsRegistered
//         .listen((IosNotificationSettings setting) {
//       print('IOS Setting Registed');
//     });
//   }

//   Future<String> getFcmToken() async {
//     SharedPreferences prefs = await SharedPreferences.getInstance();
//     prefs.setString('msgToken', await _firebaseMessaging.getToken());
//     print('firebase token => ${await _firebaseMessaging.getToken()}');
//     return await _firebaseMessaging.getToken();
//   }

//   void notificationListeners() {
//     _firebaseMessaging.configure(
//         onMessage: _onNotificationMessage,
//         onResume: _onNotificationResume,
//         onLaunch: _onNotificationLaunch);
//   }

//   Future<dynamic> _onNotificationMessage(Map<dynamic, dynamic> message) async {
//     print("------- ON message -----7777777=[--]=777777------- $message");
//     if (message['data']['order_id'] == "-1") {
//       // _logout();
//     } else {}
//     // _notificationSubject.add(message);
//     _onMessageStreamController.add(message);

//     // FlutterRingtonePlayer.play(
//     //   android: AndroidSounds.notification,
//     //   ios: IosSounds.glass,
//     //   looping: true, // Android only - API >= 28
//     //   volume: 0.1, // Android only - API >= 28
//     //   asAlarm: false, // Android only - all APIs
//     // );

//     Get.snackbar(
//       "${message['data']['title']}", // title
//       "${message['data']['body']}",
// //       "${message['data']["notification"]['title']}", // title
// //      "${message['data']["notification"]['body']}", // message
//       icon: Icon(Icons.notifications),
//       shouldIconPulse: true, dismissDirection: SnackDismissDirection.HORIZONTAL,
//       barBlur: 20,
//       isDismissible: true,
//       onTap: (_) {
//         if (message['data']['order_id'] != null) {
//           // Get.to(MyOrderDetailsView(
//           //   type: "finished",
//           //   orderNumber: int.parse(message['data']['order_id'].toString()),
//           // ));
//         } else {}
//       },
//       duration: Duration(seconds: 5),
//     );
//   }

//   Future<dynamic> _onNotificationResume(Map<dynamic, dynamic> message) async {
//     print("------- ON Resume ----- $message");

//     //  _notificationSubject.add(message);
//     _streamController.add(message);
//     if (message['data']['order_id'] == "-1") {
//       // _logout();
//     } else {}
//   }

//   Future<dynamic> _onNotificationLaunch(Map<dynamic, dynamic> message) async {
//     // if (message['data']['order_id'] == "-1") {
//     //   _logout();
//     // } else {}
//     //  _notificationSubject.add(message);
//     _streamController.add(message);
//   }

//   // navigatorKey.currentState.push(PageRouteBuilder(pageBuilder: (_, __, ___) {
//   //   return AlertsPage(model);
//   // }));

//   void killNotification() {
//     _onMessageStreamController.close();
//     _streamController.close();
//   }
// }
