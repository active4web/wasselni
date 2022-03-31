import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

showDaialogLoader(BuildContext context) {
  return showDialog(
    barrierDismissible: false,
    context: context,
    builder: (BuildContext context) {
      return AlertDialog(
        content: SizedBox(
          height: 32,
          child: Center(child: CircularProgressIndicator()),
        ),
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.all(
            Radius.circular(
              20,
            ),
          ),
        ),
      );
    },
  );
}

showErrorDaialog(
  String masseage,
  BuildContext context,
) {
  return showDialog(
    barrierDismissible: false,
    context: context,
    builder: (BuildContext context) {
      return AlertDialog(
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.all(
            Radius.circular(
              20,
            ),
          ),
        ),
        content: Text(
          masseage,
          style: TextStyle(
            color: Color.fromRGBO(4, 102, 200, 1),
            fontWeight: FontWeight.bold,
            fontSize: 18,
          ),
        ),
        actions: [
          Center(
            child: ElevatedButton(
                onPressed: () {
                  Navigator.of(context).pop();
                },
                child: Text('Okay')),
          )
        ],
      );
    },
  );
}

qrDaialog(String masseage, BuildContext context, String title) {
  return showDialog(
    barrierDismissible: false,
    context: context,
    builder: (BuildContext context) {
      return AlertDialog(
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.all(
            Radius.circular(
              20,
            ),
          ),
        ),
        title: Text(title,style: TextStyle(fontSize: 14,fontWeight: FontWeight.bold),),
        content: Text(
          masseage,
          style: TextStyle(
            color: Color.fromRGBO(4, 102, 200, 1),
            fontSize: 16,
          ),
        ),
        actions: [
          FlatButton(
              onPressed: () {
                Navigator.of(context).pop();
              },
              child: Text('ok'.tr))
        ],
      );
    },
  );
}
