import 'package:cached_network_image/cached_network_image.dart';
import 'package:flutter/material.dart';

import 'package:get/get.dart';
import 'package:wassalny/Screens/CategoryList/view.dart';
import 'package:wassalny/Screens/Subsections/view.dart';
import 'package:wassalny/model/home.dart';

Widget customGridView(BuildContext context, List<AllCategories> items) {
  return GridView.builder(
    shrinkWrap: true,
    physics: NeverScrollableScrollPhysics(),
    scrollDirection: Axis.vertical,
    itemCount: items.length,
    gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
      crossAxisSpacing: 3,
      childAspectRatio: 1 / 1.2,
      crossAxisCount: 3,
      mainAxisSpacing: .9,
    ),
    itemBuilder: (context, index) {
      return InkWell(
        onTap: () {
          if (items[index].totalDepartment > 0) {
            Get.to(
              Subsections(
                  items: items[index].allDepartment,
                  name: items[index].categoryName,
                  banner: items[index].categoryManbanner),
            );
          } else {
            print(items[index].catId);
            Get.to(CategoryList(items[index].catId, 1, 1));
          }
        },
        child: Column(
          children: [
            Container(
              decoration: BoxDecoration(
                borderRadius: BorderRadius.circular(15),
                color: Colors.blue.withAlpha(40),
              ),
              margin: EdgeInsets.only(right: 5),
              height: 100,
              width: 100,
              child: ClipRRect(
                borderRadius: BorderRadius.circular(15),
                child: CachedNetworkImage(
                  placeholder: (context, url) =>
                      Image.asset('assets/images/logo.png'),
                  imageUrl: items[index].categoryImage,
                  fit: BoxFit.fill,
                  fadeInDuration: Duration(seconds: 2),
                ),
              ),
            ),
            Container(
              child: Text(
                items[index].categoryName,
                overflow: TextOverflow.ellipsis,
                textAlign: TextAlign.center,
                style: TextStyle(
                  fontWeight: FontWeight.bold,
                  fontSize: 18,
                ),
              ),
            ),
          ],
        ),
      );
    },
  );
}
