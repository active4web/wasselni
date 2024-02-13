// File generated by FlutterFire CLI.
// ignore_for_file: lines_longer_than_80_chars, avoid_classes_with_only_static_members
import 'package:firebase_core/firebase_core.dart' show FirebaseOptions;
import 'package:flutter/foundation.dart'
    show defaultTargetPlatform, kIsWeb, TargetPlatform;

/// Default [FirebaseOptions] for use with your Firebase apps.
///
/// Example:
/// ```dart
/// import 'firebase_options.dart';
/// // ...
/// await Firebase.initializeApp(
///   options: DefaultFirebaseOptions.currentPlatform,
/// );
/// ```
class DefaultFirebaseOptions {
  static FirebaseOptions get currentPlatform {
    if (kIsWeb) {
      return web;
    }
    switch (defaultTargetPlatform) {
      case TargetPlatform.android:
        return android;
      case TargetPlatform.iOS:
        return ios;
      case TargetPlatform.macOS:
        throw UnsupportedError(
          'DefaultFirebaseOptions have not been configured for macos - '
          'you can reconfigure this by running the FlutterFire CLI again.',
        );
      case TargetPlatform.windows:
        throw UnsupportedError(
          'DefaultFirebaseOptions have not been configured for windows - '
          'you can reconfigure this by running the FlutterFire CLI again.',
        );
      case TargetPlatform.linux:
        throw UnsupportedError(
          'DefaultFirebaseOptions have not been configured for linux - '
          'you can reconfigure this by running the FlutterFire CLI again.',
        );
      default:
        throw UnsupportedError(
          'DefaultFirebaseOptions are not supported for this platform.',
        );
    }
  }

  static const FirebaseOptions web = FirebaseOptions(
    apiKey: 'AIzaSyD60bnk1wqoCNIXNj3Qcy9VNpN0nkRoF4E',
    appId: '1:470409354831:web:2a12c69c2f5d01c007143a',
    messagingSenderId: '470409354831',
    projectId: 'wasselni-user-6a53e',
    authDomain: 'wasselni-user-6a53e.firebaseapp.com',
    storageBucket: 'wasselni-user-6a53e.appspot.com',
    measurementId: 'G-26WS34ZNCB',
  );

  static const FirebaseOptions android = FirebaseOptions(
    apiKey: 'AIzaSyCwpnkyjbMxQtIVwthGcqEDL5AiLDCZ7nU',
    appId: '1:470409354831:android:c294921e81ed65aa07143a',
    messagingSenderId: '470409354831',
    projectId: 'wasselni-user-6a53e',
    storageBucket: 'wasselni-user-6a53e.appspot.com',
  );

  static const FirebaseOptions ios = FirebaseOptions(
    apiKey: 'AIzaSyBbvQiVQ5OLrH1BG9fTy0UORU007lYijC0',
    appId: '1:470409354831:ios:b465a9a5ced6d6a307143a',
    messagingSenderId: '470409354831',
    projectId: 'wasselni-user-6a53e',
    storageBucket: 'wasselni-user-6a53e.appspot.com',
    iosBundleId: 'com.waselnni',
  );
}
