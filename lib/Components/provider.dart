import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';

class Counter with ChangeNotifier {
  Counter({GlobalKey<NavigatorState> navigatorKey});
  int notifyCount = 0;
  void setNotificationsCount() {
    notifyCount++;
    notifyListeners();
  }

  // void setNotificationCount(val) {
  //   notifyCount = val;
  //   notifyListeners();
  // }

  void setNotificationZero() {
    notifyCount = 0;
    notifyListeners();
  }
}
