import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:pull_to_refresh/pull_to_refresh.dart';

import 'package:get/get.dart';
import 'package:wassalny/Components/CustomWidgets/CustomButton.dart';
import 'package:wassalny/Components/CustomWidgets/appBar.dart';
import 'package:wassalny/Screens/Tickets/tickestsDeatails.dart';
import 'package:wassalny/model/ticketsList.dart';

import 'createtickets.dart';

class Tickets extends StatefulWidget {
  @override
  _TicketsState createState() => _TicketsState();
}

class _TicketsState extends State<Tickets> {
  bool loader = false;
  String lang = Get.locale.languageCode;
  RefreshController _refreshController =
      RefreshController(initialRefresh: false);
  // ignore: override_on_non_overriding_member
  Future<void> future() async {
    loader = true;
    var provider = Provider.of<TicketsLisstProvider>(context, listen: false);
    provider.myTickets.clear();
    var nextLength = provider.myTickets.length + 20;
    try {
      await provider.fetchAllTickets(lang, 20, 0);
      if (provider.myTickets.length >= nextLength)
        _refreshController.loadComplete();
      else
        _refreshController.loadNoData();

      setState(() {
        loader = false;
      });
      _refreshController.refreshCompleted();
      // _refreshController.loadComplete();
    } catch (error) {
      _refreshController.refreshCompleted();
      // _refreshController.loadComplete();
      print(error);
      setState(() {
        loader = false;
      });
      throw (error);
    }
  }

  Future<void> fetchMore(int number) async {
    try {
      var provider = Provider.of<TicketsLisstProvider>(context, listen: false);
      var nextLength = provider.myTickets.length + 20;
      await provider.fetchAllTickets(lang, 20, number);

      // _refreshController.refreshCompleted();
      if (provider.myTickets.length >= nextLength)
        _refreshController.loadComplete();
      else
        _refreshController.loadNoData();
    } catch (error) {
      print(error);
      setState(() {
        loader = false;
      });
      // _refreshController.refreshCompleted();
      _refreshController.loadComplete();
      throw (error);
    }
  }

  int pageNumber = 0;

  @override
  void initState() {
    future();
    super.initState();
  }

  int count;
  @override
  Widget build(BuildContext context) {
    List<MyTicket> myTickets =
        Provider.of<TicketsLisstProvider>(context, listen: false).myTickets;
    return Scaffold(
      appBar: newAppBar(context, "tickets".tr),
      body: loader
          ? Center(child: CircularProgressIndicator())
          : SmartRefresher(
              onRefresh: () => future(),
              onLoading: () {
                setState(() {
                  pageNumber++;
                });
                fetchMore(pageNumber);
              },
              enablePullUp: true,
              controller: _refreshController,
              footer: CustomFooter(
                builder: (BuildContext context, LoadStatus mode) {
                  Widget body;
                  if (mode == LoadStatus.idle) {
                    body = Text("pull up load");
                  } else if (mode == LoadStatus.loading) {
                    body = CircularProgressIndicator();
                  } else if (mode == LoadStatus.failed) {
                    body = Text("Load Failed!Click retry!");
                  } else if (mode == LoadStatus.canLoading) {
                    body = Text("release to load more");
                  } else {
                    body = Text("");
                  }
                  return Container(
                    child: Center(child: body),
                  );
                },
              ),
              header: WaterDropHeader(),
              child: ListView(
                padding: EdgeInsets.all(15),
                shrinkWrap: true,
                children: [
                  CustomButton(
                      backgroundColor: Colors.blue,
                      borderColor: Colors.blue,
                      isShadow: 1,
                      onTap: () {
                        Get.to(CreateTikets()).then((value) => future());
                      },
                      textColor: Colors.white,
                      label: "CreateTickets".tr),
                  SizedBox(
                    height: 25,
                  ),
                  myTickets.isEmpty
                      ? Center(
                          child: Text(
                            "NoTickits".tr,
                            style: TextStyle(fontSize: 30, color: Colors.blue),
                          ),
                        )
                      : ListView.builder(
                          physics: NeverScrollableScrollPhysics(),
                          shrinkWrap: true,
                          itemCount: myTickets.length,
                          itemBuilder: (context, index) {
                            count = index;
                            return GestureDetector(
                              onTap: () {
                                Get.to(TickestDetails(myTickets[index].id));
                              },
                              child: Container(
                                padding: EdgeInsets.all(15),
                                margin: EdgeInsets.only(bottom: 10),
                                // height: 200,
                                decoration: BoxDecoration(
                                  borderRadius: BorderRadius.circular(20),
                                  color: Colors.grey.shade300,
                                ),
                                child: Column(
                                  children: [
                                    Row(
                                      children: [
                                        Text(
                                          myTickets[index].createdAt.toString(),
                                          style: TextStyle(color: Colors.grey),
                                        ),
                                        Spacer(),
                                        Text(myTickets[index].title)
                                      ],
                                    ),
                                    Row(
                                      children: [
                                        Expanded(
                                          child: Padding(
                                            padding: EdgeInsets.only(top: 25),
                                            child: Text(
                                              myTickets[index].content,
                                              style: TextStyle(
                                                  fontSize: 18,
                                                  fontWeight: FontWeight.bold),
                                              textAlign: TextAlign.center,
                                            ),
                                          ),
                                        ),
                                      ],
                                    ),
                                  ],
                                ),
                              ),
                            );
                          },
                        ),
                ],
              ),
            ),
    );
  }
}
