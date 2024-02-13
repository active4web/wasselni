import 'package:fcm_config/fcm_config.dart';
import 'package:firebase_core/firebase_core.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:get_storage/get_storage.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:wassalny/waslnyApp.dart';

import 'Components/constants.dart';
import 'bloc_observer.dart';
import 'firebase_options.dart';
import 'network/auth/dio_helper.dart';

Future<void> _firebaseMessagingBackgroundHandler(RemoteMessage message) async {
  debugPrint("Handling a background message: ${message.messageType}");
}

GlobalKey navigatorKey = GlobalKey();
void main() async {
  await GetStorage.init();
  DioHelper.init();
  WidgetsFlutterBinding.ensureInitialized();
  await Firebase.initializeApp(
    options:DefaultFirebaseOptions.currentPlatform
  );
  Bloc.observer=MyBlocObserver();
  await ScreenUtil.ensureScreenSize();
  final preferences = await SharedPreferences.getInstance();
  storeToken = preferences.getString('bool');

  print('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');
  FCMConfig.instance.messaging.getToken().then((value) => {
    print('ttttttttttttttt'),
    print(value.toString())
  }).catchError((onError){
    print('errrrrrrrrrrrrr');
    print(onError);
  });
  print(FCMConfig.instance.messaging.getToken(),);
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
