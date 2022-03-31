import 'package:flutter/foundation.dart';
import 'package:flutter_local_notifications/flutter_local_notifications.dart';

class CustomNotification {
  FlutterLocalNotificationsPlugin _flutterLocalNotificationsPlugin;

  Future notificationConfig() async {
    _flutterLocalNotificationsPlugin = FlutterLocalNotificationsPlugin();
    var androidSettings = AndroidInitializationSettings('@mipmap/ic_launcher');
    var iosSettings = IOSInitializationSettings();
    var initSettings =
        InitializationSettings(android: androidSettings, iOS: iosSettings);
    await _flutterLocalNotificationsPlugin.initialize(initSettings,
        onSelectNotification: _onSelectNotification);
  }

  Future _onSelectNotification(String payload) async {
    if (payload != null) {
      debugPrint('notification payload: ' + payload);
    }
  }

  Future showNotification([String title, String body = '']) async {
    var android = AndroidNotificationDetails(
      "channelId",
      "channelName",
      channelDescription: "channelDescription",
      priority: Priority.high,
      importance: Importance.max,
      playSound: true,
    );
    var ios = IOSNotificationDetails(presentSound: true);
    var platform = NotificationDetails(android: android, iOS: ios);
    await _flutterLocalNotificationsPlugin.show(
      0,
      title,
      body,
      platform,
      payload: body,
    );
  }
}
