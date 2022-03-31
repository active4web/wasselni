import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';


Widget authLoader(){
  return Center(
    child: CupertinoActivityIndicator(
      radius: 15,animating: true,
    ),
  );
}

Widget loader(){
  return Center(
    child: CupertinoActivityIndicator(
      radius: 15,animating: true,
    ),
  );
}


Widget dialogLoader(){
  return Center(
    child: CupertinoActivityIndicator(
      radius: 15,animating: true,
    ),
  );
}

