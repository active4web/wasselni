import 'package:fcm_config/fcm_config.dart';
import 'package:firebase_core/firebase_core.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:get_storage/get_storage.dart';
import 'package:wassalny/waslnyApp.dart';

Future<void> _firebaseMessagingBackgroundHandler(RemoteMessage message) async {
  debugPrint("Handling a background message: ${message.messageType}");
}

GlobalKey navigatorKey = GlobalKey();
void main() async {
  await GetStorage.init();
  WidgetsFlutterBinding.ensureInitialized();
  await Firebase.initializeApp();
  FirebaseMessaging.onMessage.listen((RemoteMessage message) {
    print('Message data: ${message.data}');
    if (message.notification != null) {
      // NotificationHelper().displayNotification(title: message.notification.title, body: message.notification.body);
    }
  });
  // RemoteMessage initialMessage =
  //     await FirebaseMessaging.instance.getInitialMessage();
  // print(initialMessage.data);
  // if (initialMessage?.data['type'] == '1') {
  //   Get.to(MyOrdersScreen());
  // }
  // if (initialMessage?.data['type'] == '2') {
  //   Get.to(Offerss());
  // }
  // if (initialMessage?.data['type'] == '3') {
  //   Get.to(Tickets());
  // }
  // if (initialMessage?.data['type'] == '4') {
  //   Get.to(Notififications());
  // }

  SystemChrome.setPreferredOrientations(
      [DeviceOrientation.portraitUp, DeviceOrientation.portraitDown]);
  await FCMConfig.instance.init(
      onBackgroundMessage: _firebaseMessagingBackgroundHandler,
      defaultAndroidChannel: AndroidNotificationChannel(
          'high_importance_channel', // same as value from android setup
          'Fcm config'));
  runApp(
    WaslnyApp(),
  );
}
