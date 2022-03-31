import 'dart:async';

import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import 'package:auto_size_text/auto_size_text.dart';
import 'package:url_launcher/url_launcher.dart';
import 'package:get/get.dart';
import 'package:wassalny/Components/CustomWidgets/appBar.dart';
import 'package:wassalny/model/branches.dart';

class Branches extends StatefulWidget {
  final int id;
  Branches(this.id);
  @override
  _BranchesState createState() => _BranchesState();
}

class _BranchesState extends State<Branches> {
  // Completer<GoogleMapController> _controller = Completer();

  bool loader = false;
  Future<void> future() async {
    loader = true;

    try {
      await Provider.of<BranchesProvider>(context, listen: false)
          .fetchAllBranches(widget.id);
      setState(() {
        loader = false;
      });
    } catch (error) {
      print(error);
      setState(() {
        loader = false;
      });
      throw (error);
    }
  }

  @override
  void initState() {
    future();
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    final higt = (MediaQuery.of(context).size.height -
        MediaQuery.of(context).padding.top);
    final double width = MediaQuery.of(context).size.width;
    List<AllProducts> branches =
        Provider.of<BranchesProvider>(context).branches;
    return Scaffold(
      appBar: newAppBar(context, "Branches".tr),
      body: loader
          ? Center(child: CircularProgressIndicator())
          : branches.isEmpty
              ? Center(
                  child: Text(
                    "NOBranches".tr,
                    style: TextStyle(
                        fontSize: 30,
                        fontWeight: FontWeight.bold,
                        color: Colors.blue),
                  ),
                )
              : ListView.builder(
                  itemCount: branches.length,
                  itemBuilder: (BuildContext context, int index) {
                    return Padding(
                      padding: EdgeInsets.symmetric(
                        horizontal: width * 0.02,
                      ),
                      child: Column(
                        children: [
                          Padding(
                            padding:
                                EdgeInsets.symmetric(vertical: higt * 0.01),
                            child: Row(
                              children: [
                                Column(
                                  crossAxisAlignment: CrossAxisAlignment.start,
                                  children: [
                                    AutoSizeText(branches[index].productName),
                                    InkWell(
                                      onTap: () async {
                                        await launch(
                                            'tel:${branches[index].phone}');
                                      },
                                      child: AutoSizeText(
                                        '${branches[index].phone}',
                                        style: TextStyle(
                                          fontSize: 16,
                                          fontWeight: FontWeight.w700,
                                        ),
                                        maxLines: 1,
                                      ),
                                    ),
                                    Container(
                                      width: width * 0.5,
                                      child: AutoSizeText(
                                        branches[index].address,
                                        maxLines: 2,
                                      ),
                                    ),
                                  ],
                                ),
                                Spacer(),
                                ClipRRect(
                                  borderRadius: BorderRadius.circular(10),
                                  child: Container(
                                    decoration: BoxDecoration(
                                      image: DecorationImage(
                                        fit: BoxFit.fill,
                                        image: NetworkImage(
                                          branches[index].productImage,
                                        ),
                                      ),
                                    ),
                                    height: higt * 0.14,
                                    width: higt * 0.14,
                                  ),
                                ),
                              ],
                            ),
                          ),
                          Padding(
                            padding: EdgeInsets.symmetric(
                              horizontal: 20,
                            ),
                            child: Divider(
                              color: Colors.blue,
                              thickness: 4,
                            ),
                          )
                        ],
                      ),
                    );
                  },
                ),
    );
  }
}
