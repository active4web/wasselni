// import 'package:flutter/material.dart';
// import 'package:flutter_spinkit/flutter_spinkit.dart';
// import 'package:wasalny/Components/CustomWidgets/MyText.dart';
// import 'package:wasalny/Components/CustomWidgets/myColors.dart';

// class LoadingDialog {
//   var _scafold;

//   LoadingDialog(this._scafold);

//   showDilaog() {
//     showDialog(
//         barrierDismissible: false,
//         context: _scafold.currentContext,
//         builder: (BuildContext context) {
//           return AlertDialog(
//               contentPadding: EdgeInsets.all(0),
//               elevation: 0,
//               shape: RoundedRectangleBorder(
//                   borderRadius: BorderRadius.all(Radius.circular(10))),
//               backgroundColor: Colors.transparent,
//               content: SpinKitDualRing(color: MyColors.primary, size: 30.0));
//         });
//   }

//   showLoadinView() {
//     return SpinKitDualRing(
//       color: MyColors.primary.withOpacity(.7),
//       size: 30.0,
//     );
//   }

//   showMapLoadinView() {
//     return SpinKitFadingFour(
//       color: MyColors.primary,
//       size: 60.0,
//     );
//   }

//   showNotification(msg) {
//     _scafold.currentState.showSnackBar(
//       SnackBar(
//         content: Container(
//           height: 30,
//           alignment: Alignment.center,
//           child: MyText(
//             title: msg,
//             color: Colors.white,
//             size: 16,
//           ),
//         ),
//         backgroundColor: MyColors.primary,
//         duration: Duration(seconds: 2),
//       ),
//     );
//   }

//   showBlackNotification(msg) {
//     _scafold.currentState.showSnackBar(SnackBar(
//         content: Container(
//           height: 30,
//           alignment: Alignment.center,
//           child: MyText(
//             title: msg,
//             color: Colors.white,
//             size: 16,
//           ),
//         ),
//         backgroundColor: MyColors.primary,
//         duration: Duration(seconds: 2)));
//   }
// }
