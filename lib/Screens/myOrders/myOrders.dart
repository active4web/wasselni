import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:wassalny/model/myOrdersProvider.dart';
import 'package:get/get.dart';

class MyOrdersScreen extends StatefulWidget {
  @override
  _MyOrdersScreenState createState() => _MyOrdersScreenState();
}

class _MyOrdersScreenState extends State<MyOrdersScreen> {
  bool loader = false;
  List<OrderDetail> allProducts = [];
  Future<void> future() async {
    loader = true;
    try {
      allProducts = await Provider.of<MyOrdersProvider>(context, listen: false)
          .fetchMyOrders();

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
    return Scaffold(
      appBar: AppBar(
        title: Text(
          "MyOrders".tr,
          style: TextStyle(
            color: Colors.white,
          ),
        ),
        centerTitle: true,
      ),
      body: loader
          ? Center(child: CircularProgressIndicator())
          : allProducts.isEmpty
              ? Center(
                  child: Text(
                    "onOrders".tr,
                    style: TextStyle(
                      color: Colors.blue,
                      fontSize: 24,
                    ),
                  ),
                )
              : ListView.builder(
                  itemCount: allProducts.length,
                  itemBuilder: (context, index) {
                    return Column(
                      children: [
                        Card(
                          child: Container(
                            height: MediaQuery.of(context).size.height * 0.15,
                            width: MediaQuery.of(context).size.width,
                            child: Padding(
                              padding:
                                  const EdgeInsets.symmetric(horizontal: 8),
                              child: Row(
                                crossAxisAlignment: CrossAxisAlignment.center,
                                children: [
                                  Container(
                                    width: MediaQuery.of(context).size.width *
                                        0.18,
                                    child: Text(
                                      "${allProducts[index].totalPrice} ${allProducts[index].currencyName}",
                                      style: TextStyle(
                                          fontSize: 20,
                                          fontWeight: FontWeight.bold),
                                    ),
                                  ),
                                  Container(
                                    height: MediaQuery.of(context).size.height *
                                        0.15,
                                    width: 1,
                                    color: Colors.black,
                                  ),
                                  Padding(
                                    padding: const EdgeInsets.symmetric(
                                        horizontal: 5),
                                    child: Column(
                                      mainAxisAlignment:
                                          MainAxisAlignment.center,
                                      crossAxisAlignment:
                                          CrossAxisAlignment.start,
                                      children: [
                                        Text(
                                            '${'productsCount'.tr} : ${allProducts[index].totalProduct}'),
                                        Container(
                                          height: 1,
                                          width: MediaQuery.of(context)
                                                  .size
                                                  .width *
                                              0.5,
                                          color: Colors.black,
                                        ),
                                        Text(
                                            '${'orderID'.tr} : ${allProducts[index].idOrder} '),
                                        Container(
                                          height: 1,
                                          width: MediaQuery.of(context)
                                                  .size
                                                  .width *
                                              0.5,
                                          color: Colors.black,
                                        ),
                                        Text(
                                            '${'shippingCharges'.tr} : ${allProducts[index].shippingCharges} '),
                                        Container(
                                          height: 1,
                                          width: MediaQuery.of(context)
                                                  .size
                                                  .width *
                                              0.5,
                                          color: Colors.black,
                                        ),
                                        Text(
                                            '${'orderDate'.tr} : ${allProducts[index].date} '),
                                      ],
                                    ),
                                  ),
                                  // Spacer(),
                                  // Text('تم التسليم')
                                ],
                              ),
                            ),
                          ),
                        ),
                        Divider(
                          thickness: 1,
                        )
                      ],
                    );
                  },
                ),
    );
  }
}
