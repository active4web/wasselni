import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:provider/provider.dart';
import 'package:auto_size_text/auto_size_text.dart';
import 'package:wassalny/model/addToCart.dart';
import 'package:wassalny/model/min_sirv.dart';

class Min extends StatefulWidget {
  final int id;
  final String title;
  const Min({Key key, this.id, this.title}) : super(key: key);
  @override
  _MinState createState() => _MinState();
}

class _MinState extends State<Min> {
  bool loader = false;
  // ignore: override_on_non_overriding_member
  String lang = Get.locale.languageCode;

  Future<void> future() async {
    print(widget.id);
    loader = true;
    try {
      await Provider.of<AllMinProvider>(context, listen: false)
          .fetchAllMin(lang, widget.id);
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

  Future<void> add(int id) async {
    try {
      await Provider.of<AddProductProvider>(context, listen: false)
          .addToCart(id);
      Get.snackbar(
        'تم الاضافه',
        'تم الاضافه الي السلة بنجاح',
        isDismissible: true,
        titleText: Text(
          'تم الاضافه ',
          textDirection: lang == 'ar' ? TextDirection.rtl : TextDirection.ltr,
          style: TextStyle(
            color: Colors.black,
            fontWeight: FontWeight.bold,
            fontSize: 20,
          ),
        ),
        messageText: Text(
          'تم الاضافه الي السلة بنجاح',
          textDirection: lang == 'ar' ? TextDirection.rtl : TextDirection.ltr,
          style: TextStyle(
            color: Colors.black,
            fontWeight: FontWeight.bold,
            fontSize: 18,
          ),
        ),
      );
    } catch (error) {
      print(error);

      Get.snackbar(
        'لم تتم الاضافه',
        'تحقق من الاتصال بالانترت',
        isDismissible: true,
        titleText: Text(
          'لم تتم الاضافه',
          textDirection: lang == 'ar' ? TextDirection.rtl : TextDirection.ltr,
          style: TextStyle(
            color: Colors.black,
            fontWeight: FontWeight.bold,
            fontSize: 20,
          ),
        ),
        messageText: Text(
          'تحقق من الاتصال بالانترت',
          textDirection: lang == 'ar' ? TextDirection.rtl : TextDirection.ltr,
          style: TextStyle(
            color: Colors.black,
            fontWeight: FontWeight.bold,
            fontSize: 18,
          ),
        ),
      );
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
    final width = (MediaQuery.of(context).size.width);
    final higt = (MediaQuery.of(context).size.height -
        MediaQuery.of(context).padding.top);
    final List<AllProductService> info =
        Provider.of<AllMinProvider>(context, listen: false).allminu;

    return Scaffold(
      appBar: AppBar(
        backgroundColor: Colors.blue,
        iconTheme: IconThemeData(
          color: Colors.white,
        ),
        actionsIconTheme: IconThemeData(
          color: Colors.white,
        ),
        centerTitle: true,
        title: Text(
          "Products".tr,
          style: TextStyle(
            color: Colors.white,
            fontSize: 20,
          ),
        ),
      ),
      body: loader
          ? Center(child: CircularProgressIndicator())
          : info.isEmpty
              ? Center(
                  child: Text(
                    "NoProducts".tr,
                    style: TextStyle(
                        fontWeight: FontWeight.bold,
                        fontSize: 25,
                        color: Colors.blue),
                  ),
                )
              : Padding(
                  padding: EdgeInsets.symmetric(
                      vertical: higt * 0.02, horizontal: width * 0.06),
                  child: ListView.builder(
                    itemCount: info.length,
                    itemBuilder: (contex, index) {
                      return Column(
                        children: [
                          Container(
                            child: Row(
                              mainAxisAlignment: MainAxisAlignment.start,
                              children: [
                                Column(
                                  crossAxisAlignment: CrossAxisAlignment.center,
                                  children: [
                                    Container(
                                      alignment: Alignment.center,
                                      width: width * 0.3,
                                      padding: EdgeInsets.all(3),
                                      decoration: BoxDecoration(
                                          color: Colors.blue,
                                          borderRadius:
                                              BorderRadius.circular(10)),
                                      child: AutoSizeText(
                                        info[index].name,
                                        style: TextStyle(
                                          color: Colors.white,
                                          fontSize: 16,
                                          fontWeight: FontWeight.bold,
                                        ),
                                        maxLines: 1,
                                      ),
                                    ),
                                    SizedBox(
                                      height: higt * 0.01,
                                    ),
                                    Container(
                                      width: width * 0.3,
                                      height: width * 0.26,
                                      padding: EdgeInsets.all(5),
                                      decoration: BoxDecoration(
                                          color: Colors.blue,
                                          borderRadius:
                                              BorderRadius.circular(10)),
                                      child: ListView(
                                        children: [
                                          AutoSizeText(
                                            info[index].description,
                                            style: TextStyle(
                                              color: Colors.white,
                                              fontSize: 13,
                                              fontWeight: FontWeight.bold,
                                            ),
                                          ),
                                        ],
                                      ),
                                    ),
                                    SizedBox(
                                      height: higt * 0.01,
                                    ),
                                    if(info[index].newPrice.isNotEmpty)
                                    Container(
                                      width: width * 0.3,
                                      decoration: BoxDecoration(
                                          color: info[index].oldPrice.isEmpty &&
                                                  info[index].newPrice.isEmpty
                                              ? Colors.white10
                                              : Colors.red,
                                          borderRadius:
                                              BorderRadius.circular(10)),
                                      padding:
                                          EdgeInsets.symmetric(horizontal: 3),
                                      child: Row(
                                        mainAxisAlignment:
                                            MainAxisAlignment.center,
                                        children: [
                                          info[index].oldPrice.isEmpty
                                              ? SizedBox(
                                                  width: 0,
                                                  height: 0,
                                                )
                                              : AutoSizeText(
                                                  info[index].oldPrice,
                                                  textAlign: TextAlign.center,
                                                  style: TextStyle(
                                                      fontWeight:
                                                          FontWeight.bold,
                                                      color: Colors.white,
                                                      fontSize: 23,
                                                      decoration: TextDecoration
                                                          .lineThrough),
                                                ),
                                          info[index].oldPrice.isEmpty
                                              ? SizedBox(
                                                  width: 0,
                                                  height: 0,
                                                )
                                              : SizedBox(
                                                  width: width * 0.05,
                                                ),
                                          AutoSizeText(
                                            info[index].newPrice,
                                            textAlign: TextAlign.center,
                                            style: TextStyle(
                                                fontWeight: FontWeight.bold,
                                                color: Colors.white,
                                                fontSize: 23),
                                          ),
                                        ],
                                      ),
                                    ),
                                    if(info[index].newPrice.isNotEmpty)
                                    SizedBox(
                                      width: width * 0.3,
                                      child: RaisedButton(
                                        shape: RoundedRectangleBorder(
                                          borderRadius:
                                              BorderRadius.circular(10),
                                        ),
                                        color: Colors.blue,
                                        onPressed: () {
                                          add(info[index].id);
                                        },
                                        child: AutoSizeText(
                                          'اضافه الي السله',
                                          style: TextStyle(
                                              fontSize: 16,
                                              fontWeight: FontWeight.bold,
                                              color: Colors.white),
                                          maxLines: 1,
                                        ),
                                      ),
                                    ),
                                  ],
                                ),
                                Spacer(),
                                ClipRRect(
                                  borderRadius: BorderRadius.circular(15),
                                  child: Container(
                                    height: higt * 0.285,
                                    width: higt * 0.285,
                                    decoration: BoxDecoration(
                                      color: Colors.blue,
                                      borderRadius: BorderRadius.circular(15),
                                    ),
                                    child: Image.network(
                                      info[index].image,
                                      fit: BoxFit.fill,
                                    ),
                                  ),
                                ),
                              ],
                            ),
                          ),
                          Padding(
                            padding:
                                EdgeInsets.symmetric(horizontal: width * 0.065),
                            child: Divider(
                              thickness: 1,
                              height: 13,
                            ),
                          ),
                        ],
                      );
                    },
                  ),
                ),
    );
  }
}
