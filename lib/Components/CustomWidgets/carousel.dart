// import 'package:carousel_slider/carousel_slider.dart';
// import 'package:flutter/material.dart';

// import 'imagePlaceHolder.dart';

// Widget banner(BuildContext context, Function onTap, List sliderImages) {
//   return Container(
//       decoration: BoxDecoration(
//           borderRadius: BorderRadius.all(Radius.circular(10)),
//           boxShadow: [
//             BoxShadow(
//                 color: Color(0xff0000001F),
//                 spreadRadius: 5,
//                 blurRadius: 7,
//                 offset: Offset(0, 3))
//           ]),
//       // margin: EdgeInsets.only(bottom: 10),
//       child: CarouselSlider.builder(
//           itemCount: sliderImages.length == 0 ? 1 : sliderImages.length,
//           itemBuilder: (context, index) {
//             return sliderImages.length == 0
//                 ? InkWell(
//                     onTap: onTap,
//                     child: Image.asset("assets/images/slider.png",
//                         fit: BoxFit.cover))
//                 : InkWell(
//                     onTap: onTap,
//                     child: Container(
//                         decoration: BoxDecoration(
//                             borderRadius:
//                                 BorderRadius.all(Radius.circular(10))),
//                         child: customImageHolder(
//                             context,
//                             50,
//                             sliderImages[index]['image'] == null
//                                 ? 'assets/images/slider.png'
//                                 : sliderImages[index]['image'],
//                             Container(
//                                 width: MediaQuery.of(context).size.width,
//                                 decoration: BoxDecoration(
//                                     borderRadius:
//                                         BorderRadius.all(Radius.circular(10)),
//                                     image: DecorationImage(
//                                         image: sliderImages.length == 0 ||
//                                                 sliderImages[index]['image'] ==
//                                                     null
//                                             ? AssetImage(
//                                                 "assets/images/slider.png")
//                                             : NetworkImage(
//                                                 sliderImages[index]['image']),
//                                         fit: BoxFit.fill))))));
//           },
//           viewportFraction: 1.2,
//           initialPage: 0,
//           enableInfiniteScroll: true,
//           reverse: false,
//           autoPlay: true,
//           autoPlayInterval: Duration(seconds: 3),
//           autoPlayAnimationDuration: Duration(milliseconds: 800),
//           autoPlayCurve: Curves.easeOutSine,
//           // pauseAutoPlayOnTouch: Duration(seconds: 10),
//           enlargeCenterPage: false));
// }
