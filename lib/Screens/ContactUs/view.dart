import 'package:flutter/material.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';
import 'package:get/get.dart';
import 'package:provider/provider.dart';
import 'package:url_launcher/url_launcher.dart';
import 'package:wassalny/Components/CustomWidgets/appBar.dart';
import 'package:wassalny/model/aboutandcontact.dart';

class ContactUs extends StatefulWidget {
  @override
  _ContactUsState createState() => _ContactUsState();
}

class _ContactUsState extends State<ContactUs> {
  bool loader = false;
  Future<void> getContacts() async {
    String lang = Get.locale.languageCode;
    loader = true;
    try {
      await Provider.of<ContactUsModel>(context, listen: false)
          .getContactUs(lang, context);
      setState(() {
        loader = false;
      });
    } catch (e) {}
  }

  @override
  void initState() {
    getContacts();
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    final hight = (MediaQuery.of(context).size.height -
        MediaQuery.of(context).padding.top);
    final width = (MediaQuery.of(context).size.width);
    var provider = Provider.of<ContactUsModel>(context, listen: false);
    ResultContact info = provider.contacts;
    String site = provider.site;
    return Scaffold(
      appBar: newAppBar(context, "ContactUs".tr),
      body: loader
          ? Center(
              child: CircularProgressIndicator(),
            )
          : ListView(
              children: [
                Padding(
                  padding: EdgeInsets.symmetric(
                      vertical: hight * 0.08, horizontal: width * 0.05),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        "ContactUs".tr,
                        style: TextStyle(color: Colors.blue, fontSize: 25),
                      ),
                      info.supportPhone == null
                          ? Text('')
                          : InkWell(
                              onTap: () async {
                                await launch('tel:${info.supportPhone}');
                              },
                              child: Text(
                                info.supportPhone,
                                style: TextStyle(
                                    fontWeight: FontWeight.bold, fontSize: 22),
                                textAlign: TextAlign.left,
                              ),
                            ),
                      info.hotline == null
                          ? Text('')
                          : InkWell(
                              onTap: () async {
                                await launch('tel:${info.hotline}');
                              },
                              child: Text(
                                '${info.hotline}',
                                style: TextStyle(
                                    fontWeight: FontWeight.bold, fontSize: 22),
                                textAlign: TextAlign.end,
                              ),
                            ),
                      SizedBox(
                        height: 50,
                      ),
                      Text(
                        "ADRESSES".tr,
                        style: TextStyle(color: Colors.blue, fontSize: 25),
                      ),
                      site == null
                          ? Text('')
                          : InkWell(
                              onTap: () async {
                                print(',,');
                                await launch('http:$site');
                              },
                              child: Text(site, style: TextStyle(fontSize: 22)),
                            ),
                      info.supportEmail == null
                          ? Text('')
                          : InkWell(
                              onTap: () async {
                                await launch('mailto:${info.supportEmail}');
                              },
                              child: Text(info.supportEmail,
                                  style: TextStyle(fontSize: 22)),
                            ),
                      info.address == null
                          ? Text('')
                          : Text(info.address, style: TextStyle(fontSize: 22)),
                      SizedBox(
                        height: 30,
                      ),
                      info.infoEmail == null
                          ? Text('')
                          : Text(info.infoEmail,
                              style: TextStyle(fontSize: 22)),
                      SizedBox(
                        height: 30,
                      ),
                      Center(
                        child: Text(
                          "ContactUsSocial".tr,
                          style: TextStyle(color: Colors.blue, fontSize: 22),
                        ),
                      ),
                      SizedBox(
                        height: 13,
                      ),
                      Row(
                        children: [
                          Padding(
                            padding:
                                EdgeInsets.symmetric(horizontal: width * 0.08),
                            child: Container(
                              width: width * 0.74,
                              child: Center(
                                child: Row(
                                  mainAxisAlignment:
                                      MainAxisAlignment.spaceBetween,
                                  children: [
                                    IconButton(
                                      icon: FaIcon(
                                        FontAwesomeIcons.facebook,
                                        size: width * 0.1,
                                        color: Colors.blue[900],
                                      ),
                                      onPressed: () async {
                                        await launch('http:${info.facebook}');
                                      },
                                    ),
                                    IconButton(
                                      icon: FaIcon(
                                        FontAwesomeIcons.instagram,
                                        size: width * 0.1,
                                        color: Colors.red,
                                      ),
                                      onPressed: () async {
                                        await launch('http:${info.instagram}');
                                      },
                                    ),
                                    IconButton(
                                      icon: FaIcon(
                                        FontAwesomeIcons.twitter,
                                        size: width * 0.1,
                                        color: Colors.blue,
                                      ),
                                      onPressed: () async {
                                        await launch('http:${info.twitter}');
                                      },
                                    ),
                                    IconButton(
                                      icon: FaIcon(
                                        FontAwesomeIcons.phone,
                                        size: width * 0.1,
                                        color: Colors.blue,
                                      ),
                                      onPressed: () async {
                                        await launch(
                                            'tel:${info.supportPhone}');
                                      },
                                    ),
                                    IconButton(
                                      icon: FaIcon(
                                        FontAwesomeIcons.whatsapp,
                                        size: width * 0.1,
                                        color: Colors.green,
                                      ),
                                      onPressed: () async {
                                        await launch('tel:${info.whatsapp}');
                                      },
                                    ),
                                  ],
                                ),
                              ),
                            ),
                          ),
                        ],
                      ),
                    ],
                  ),
                )
              ],
            ),
    );
  }
}
