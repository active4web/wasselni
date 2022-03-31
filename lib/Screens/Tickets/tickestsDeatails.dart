import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:provider/provider.dart';
import 'package:wassalny/Components/CustomWidgets/customTextField.dart';
import 'package:wassalny/Components/CustomWidgets/showdialog.dart';
import 'package:wassalny/model/ticketsDetailsModel.dart';

class TickestDetails extends StatefulWidget {
  final int id;
  TickestDetails(this.id);
  @override
  _TickestDetailsState createState() => _TickestDetailsState();
}

class _TickestDetailsState extends State<TickestDetails> {
  TextEditingController _replayController = TextEditingController();

  bool loader = false;
  Future<void> getx() async {
    String lang = Get.locale.languageCode;
    loader = true;
    try {
      await Provider.of<TicketsDetailsProvider>(context, listen: false)
          .fetchDetails(lang, widget.id);

      setState(() {
        loader = false;
      });
    } catch (e) {
      showErrorDaialog("NoInternet".tr, context);
    }
  }

  Future<void> replay() async {
    if (_replayController.text.isEmpty) {
      return;
    }
    String lang = Get.locale.languageCode;

    loader = true;
    try {
      await Provider.of<TicketsDetailsProvider>(context, listen: false)
          .sentReplay(lang, _replayController.text.toString(), widget.id);

      setState(() {
        loader = false;
      });
    } catch (e) {}
  }

  void _refresh() {
    setState(() {
      replay()
          .then((value) => getx().then((value) => _replayController.clear()));
    });
  }

  @override
  void initState() {
    getx();
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    List<TicketReply> replay =
        Provider.of<TicketsDetailsProvider>(context, listen: false).replay;
    final width = (MediaQuery.of(context).size.width);

    return Scaffold(
      appBar: AppBar(
        backgroundColor: Colors.blue,
        title: Text(
          "TicketsDetails".tr,
          style: TextStyle(
            color: Colors.white,
          ),
        ),
        centerTitle: true,
        iconTheme: IconThemeData(
          color: Colors.white,
        ),
        actionsIconTheme: IconThemeData(
          color: Colors.white,
        ),
      ),
      body: loader
          ? Center(child: CircularProgressIndicator())
          : Column(children: [
              Expanded(
                child: ListView.builder(
                  shrinkWrap: true,
                  itemCount: replay.length,
                  itemBuilder: (context, index) {
                    return Column(
                      crossAxisAlignment: replay[index].senderType == 0
                          ? CrossAxisAlignment.start
                          : replay[index].senderType == 1
                              ? CrossAxisAlignment.end
                              : SizedBox(),
                      children: [
                        Container(
                          margin: EdgeInsets.all(width * 0.02),
                          padding: EdgeInsets.all(width * 0.02),
                          decoration: BoxDecoration(
                              color: replay[index].senderType == 0
                                  ? Colors.grey[400]
                                  : replay[index].senderType == 1
                                      ? Colors.blue
                                      : SizedBox(),
                              borderRadius:
                                  BorderRadius.circular(width * 0.04)),
                          child: Text(
                            replay[index].content,
                            style: TextStyle(
                                color: replay[index].senderType == 0
                                    ? Colors.black
                                    : replay[index].senderType == 1
                                        ? Colors.white
                                        : SizedBox(),
                                fontSize: 18),
                          ),
                        ),
                        // Text(replay[index].createdAt.toString())
                      ],
                    );
                  },
                ),
              ),
              Padding(
                padding: EdgeInsets.all(width * 0.02),
                child: Container(
                  decoration: BoxDecoration(),
                  child: Row(
                    // crossAxisAlignment: CrossAxisAlignment.center,
                    children: [
                      Expanded(
                          child: CustomTextField(
                        controller: _replayController,
                      )),
                      ElevatedButton(
                        style: ElevatedButton.styleFrom(
                            shape: CircleBorder(), primary: Colors.blue),
                        child: Container(
                          width: width * 0.12,
                          height: width * 0.12,
                          alignment: Alignment.center,
                          decoration: BoxDecoration(shape: BoxShape.circle),
                          child: Text(
                            "send".tr,
                            style: TextStyle(fontSize: width * 0.055),
                          ),
                        ),
                        onPressed: _refresh,
                      )
                    ],
                  ),
                ),
              ),
            ]),
    );
  }
}
