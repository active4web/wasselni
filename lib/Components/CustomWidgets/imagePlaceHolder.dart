// import 'dart:io';
// import 'package:cached_network_image/cached_network_image.dart';
// import 'package:flutter/material.dart';
// import 'package:wasalny/Components/CustomWidgets/myColors.dart';
// import 'loaders.dart';

// Widget imagePlaceHolder(BuildContext context, String image, double radius) {
//   return CachedNetworkImage(
//       imageUrl: image,
//       imageBuilder: (context, imageProvider) => Container(
//           decoration: BoxDecoration(
//               image: DecorationImage(image: imageProvider, fit: BoxFit.cover),
//               borderRadius: BorderRadius.all(Radius.circular(radius)))),
//       placeholder: (context, url) => Container(
//           child: Center(
//               child: Platform.isAndroid
//                   ? CircularProgressIndicator(backgroundColor: MyColors.blue)
//                   : loader())),
//       errorWidget: (context, url, error) => Container(
//           decoration: BoxDecoration(
//               color: Colors.black.withOpacity(.2),
//               borderRadius: BorderRadius.all(Radius.circular(radius))),
//           child: Icon(Icons.error, color: Colors.red)));
// }

// Widget customImageHolder(
//     BuildContext context, double iconSize, String imageUrl, Widget widget) {
//   return CachedNetworkImage(
//       imageUrl: imageUrl,
//       imageBuilder: (context, imageProvider) => widget,
//       placeholder: (context, url) => Container(
//           child: Center(
//               child: Platform.isAndroid
//                   ? CircularProgressIndicator(backgroundColor: MyColors.blue)
//                   : loader())),
//       errorWidget: (context, url, error) => Icon(Icons.error,
//           color: Colors.red, size: iconSize == null ? 50 : iconSize));
// }
