import 'package:auto_size_text/auto_size_text.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:get/get.dart';
import 'package:wassalny/Components/CustomWidgets/appBar.dart';
import 'package:wassalny/model/notifDetails.dart';

class NotificationsDetails extends StatefulWidget {
  final int id;

  const NotificationsDetails({this.id});

  @override
  _NotificationsDetailsState createState() => _NotificationsDetailsState();
}

class _NotificationsDetailsState extends State<NotificationsDetails> {
  bool loader = false;
  Future<void> getDetails() async {
    loader = true;
    try {
      await Provider.of<NotificationDetailsProvider>(context, listen: false)
          .fetchDetails(widget.id);

      setState(() {
        loader = false;
      });
    } catch (e) {}
  }

  @override
  void initState() {
    getDetails();
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    var noti = Provider.of<NotificationDetailsProvider>(context);
    print(widget.id);
    final width = (MediaQuery.of(context).size.width);
    final higt = (MediaQuery.of(context).size.height -
        MediaQuery.of(context).padding.top);
    return Scaffold(
      appBar: newAppBar(context, "NotificationDetails".tr),
      body: loader
          ? Center(child: CircularProgressIndicator())
          : Container(
              width: width,
              child: Padding(
                padding: EdgeInsets.all(width * 0.05),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    AutoSizeText(
                      noti.tilte,
                      style: TextStyle(
                        fontSize: 24,
                        fontWeight: FontWeight.bold,
                      ),
                      maxLines: 1,
                    ),
                    SizedBox(
                      height: higt * 0.02,
                    ),
                    AutoSizeText(
                      noti.body,
                      style: TextStyle(
                        fontSize: 20,
                      ),
                      maxLines: 5,
                    ),
                  ],
                ),
              ),
            ),
    );
  }
}
