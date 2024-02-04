import 'package:flutter/material.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';

import 'myColors.dart';

Widget categoryAppBar(BuildContext context) {
  return AppBar(
      iconTheme: IconThemeData(color: Colors.blue),
      backgroundColor: Colors.transparent,
      elevation: 0,
      title: Image.asset('assets/images/logo.png', width: 50.w),
      centerTitle: true,
      automaticallyImplyLeading: true);
}

class CategoryAppBar extends StatelessWidget implements PreferredSizeWidget {
  const CategoryAppBar({super.key});

  @override
  Widget build(BuildContext context) {
    return AppBar(
        iconTheme: IconThemeData(color: Colors.blue),
        backgroundColor: Colors.transparent,
        elevation: 0,
        title: Image.asset('assets/images/logo.png', width: 50),
        centerTitle: true,
        automaticallyImplyLeading: true);
  }

  @override
  // TODO: implement preferredSize
  Size get preferredSize => Size.fromHeight(90);
}



class TitleAppBar extends StatelessWidget implements PreferredSizeWidget{
  const TitleAppBar({super.key, required this.title});
final String title;
  @override
  Widget build(BuildContext context) {
    return AppBar(
        iconTheme: IconThemeData(color: Colors.blue),
        backgroundColor: Colors.transparent,
        title: Text(
          title,
          style: TextStyle(color: MyColors.blue, fontWeight: FontWeight.bold),
        ),
        centerTitle: true,
        automaticallyImplyLeading: true);
  }

  @override
  // TODO: implement preferredSize
  Size get preferredSize => Size.fromHeight(90);
}


class NewAppBar extends StatelessWidget implements PreferredSizeWidget {
  const NewAppBar({super.key, required this.title});
final String title;
  @override
  Widget build(BuildContext context) {
    return AppBar(
        elevation: 0,
        iconTheme: IconThemeData(color: Colors.blue),
        backgroundColor: Colors.white,
        title: Text(
          title,
          style: TextStyle(color: MyColors.blue, fontWeight: FontWeight.bold),
        ),
        centerTitle: true,
        automaticallyImplyLeading: true);
  }

  @override
  // TODO: implement preferredSize
  Size get preferredSize => Size.fromHeight(90);
}
