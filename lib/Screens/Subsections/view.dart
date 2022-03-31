import 'package:auto_size_text/auto_size_text.dart';
import 'package:cached_network_image/cached_network_image.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:wassalny/Screens/CategoryList/view.dart';
import 'package:wassalny/model/home.dart';

class Subsections extends StatefulWidget {
  final String banner;
  final List<AllDepartment> items;
  final String name;
  const Subsections({Key key, this.items, this.name, this.banner})
      : super(key: key);
  @override
  _SubsectionsState createState() => _SubsectionsState();
}

class _SubsectionsState extends State<Subsections> {
  @override
  Widget build(BuildContext context) {
    for (var i = 0; i < widget.items.length; i++) {
      print(widget.items[i].departmentName);
    }
    return Scaffold(
      appBar: AppBar(
        title: Text(
          widget.name,
          style: TextStyle(color: Colors.blue),
        ),
        centerTitle: true,
        iconTheme: IconThemeData(
          color: Colors.blue,
        ),
        backgroundColor: Colors.white,
      ),
      body: Padding(
        padding: const EdgeInsets.all(15.0),
        child: Column(
          children: [
            ClipRRect(
              borderRadius: BorderRadius.circular(30),
              child: Container(
                width: MediaQuery.of(context).size.width,
                height: MediaQuery.of(context).size.height * 0.2,
                decoration: BoxDecoration(
                  borderRadius: BorderRadius.circular(30),
                ),
                child: CachedNetworkImage(
                  imageUrl: widget.banner,
                  fit: BoxFit.fill,
                  placeholder: (context, url) =>
                      Image.asset('assets/images/logo.png'),
                ),
              ),
            ),
            SizedBox(
              height: 15,
            ),
            Expanded(
              child: GridView.builder(
                shrinkWrap: true,
                scrollDirection: Axis.vertical,
                itemCount: widget.items.length,
                gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
                  crossAxisSpacing: 3,
                  childAspectRatio: MediaQuery.of(context).size.width * .002,
                  crossAxisCount: 3,
                  mainAxisSpacing: .9,
                ),
                itemBuilder: (context, index) {
                  return InkWell(
                    onTap: () {
                      print(widget.items[index].departmentId);
                      Get.to(
                        CategoryList(
                            int.parse(widget.items[index].departmentId), 0, 2),
                      );
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
                              imageUrl: widget.items[index].departmentImage,
                              fit: BoxFit.fill,
                              fadeInDuration: Duration(seconds: 2),
                            ),
                          ),
                        ),
                        AutoSizeText(
                          widget.items[index].departmentName,
                          textAlign: TextAlign.center,
                          style: TextStyle(
                            fontWeight: FontWeight.bold,
                            fontSize: 15,
                          ),
                          maxLines: 1,
                          minFontSize: 12,
                        ),
                      ],
                    ),
                  );
                },
              ),
            )
          ],
        ),
      ),
    );
  }
}
