import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:provider/provider.dart';
import 'package:wassalny/Components/CustomWidgets/CustomButton.dart';
import 'package:wassalny/Components/CustomWidgets/customTextField.dart';
import 'package:wassalny/Components/CustomWidgets/showdialog.dart';
import 'package:wassalny/model/tickets.dart';
import 'package:wassalny/model/user.dart';
import 'package:wassalny/network/auth/auth.dart';

class CreateTikets extends StatefulWidget {
  @override
  _CreateTiketsState createState() => _CreateTiketsState();
}

class _CreateTiketsState extends State<CreateTikets> {
  num catigoryId;

  bool loader = false;
  Future<void> gettype() async {
    String lang = Get.locale.languageCode;
    loader = true;
    try {
      await Provider.of<TicketsTypeProvider>(context, listen: false)
          .fetchtype(lang);
      setState(() {
        loader = false;
      });
    } catch (e) {}
  }

  String lang = Get.locale.languageCode;
  User user = User();
  final GlobalKey<FormState> key = GlobalKey<FormState>();

  Future<void> sentTickets() async {
    bool done = Provider.of<Auth>(context, listen: false).doneSent;
    if (!key.currentState.validate()) {
      return;
    }
    key.currentState.save();
    showDaialogLoader(context);
    try {
      done = await Provider.of<Auth>(context, listen: false)
          .sentTickets(user, lang);
    } catch (error) {
      showErrorDaialog("NoInternet".tr, context);
    } finally {
      Navigator.of(context).pop();
      if (done) {
        Get.back();
      }
    }
  }

  @override
  void initState() {
    gettype();
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    List<TicketsTypeElement> caategories =
        Provider.of<TicketsTypeProvider>(context, listen: false).type;
    final width = (MediaQuery.of(context).size.width);
    final higt = (MediaQuery.of(context).size.height -
        MediaQuery.of(context).padding.top);
    String _currentSelectedValue;

    return Scaffold(
      appBar: AppBar(
        iconTheme: IconThemeData(color: Colors.blue),
        title: Text(
          "CreateTicket".tr,
          style: TextStyle(color: Colors.blue),
        ),
        centerTitle: true,
        backgroundColor: Colors.white,
        elevation: 0,
      ),
      body: loader
          ? Center(
              child: CircularProgressIndicator(),
            )
          : SingleChildScrollView(
              child: Padding(
                padding: EdgeInsets.all(width * 0.06),
                child: Form(
                  key: key,
                  child: Column(
                    children: [
                      Container(
                        height: 50,
                        width: width,
                        padding: EdgeInsets.symmetric(horizontal: 20),
                        decoration: BoxDecoration(
                          color: Colors.grey.withOpacity(.3),
                          borderRadius: BorderRadius.all(Radius.circular(8)),
                          // border: Border.all(color: Colors.blue, width: 2),
                        ),
                        child: DropdownButtonFormField(
                          decoration: InputDecoration(
                            filled: true,
                            focusColor: Colors.transparent,
                            fillColor: Colors.transparent,
                            enabledBorder: InputBorder.none,
                            focusedBorder: InputBorder.none,
                            hintText: "TicketType".tr,
                            hintStyle: TextStyle(
                                fontWeight: FontWeight.bold,
                                fontSize: 17,
                                color: Colors.black,
                                fontFamily: 'GE-Snd-Book'),
                          ),
                          isExpanded: true,
                          iconSize: 24,
                          validator: (val) {
                            if (val == null) {
                              return "Thisfieldisrequired".tr;
                            } else {
                              return null;
                            }
                          },
                          icon: Icon(
                            Icons.arrow_drop_down,
                            size: 24,
                            color: Color.fromRGBO(2, 62, 125, 1),
                          ),
                          value: _currentSelectedValue,
                          isDense: true,
                          onSaved: (val) {
                            user.ticId = int.parse(val);
                          },
                          onChanged: (String newValue) {
                            setState(() {
                              _currentSelectedValue = newValue;
                              print(newValue);
                            });
                          },
                          items: caategories.map((value) {
                            return DropdownMenuItem<String>(
                                value: value.id.toString(),
                                child: Text(value.name));
                          }).toList(),
                        ),
                      ),
                      SizedBox(
                        height: higt * 0.06,
                      ),
                      ProfileTextField(
                        hint: "Topic".tr,
                        validator: (val) {
                          if (val.isEmpty) {
                            return "Thisfieldisrequired".tr;
                          } else if (val.length <= 4) {
                            return "NameMust4Cracters".tr;
                          } else {
                            return null;
                          }
                        },
                        onSaved: (val) {
                          user.title = val;
                        },
                      ),
                      SizedBox(
                        height: higt * 0.06,
                      ),
                      ProfileTextField1(
                        hint: "TicketContent".tr,
                        validator: (val) {
                          if (val.isEmpty) {
                            return "Thisfieldisrequired".tr;
                          } else if (val.length <= 4) {
                            return "TicketContentValidation".tr;
                          } else {
                            return null;
                          }
                        },
                        onSaved: (val) {
                          user.content = val;
                        },
                        maxLi: 250,
                      ),
                      SizedBox(
                        height: higt * 0.12,
                      ),
                      CustomButton(
                          backgroundColor: Colors.blue,
                          borderColor: Colors.blue,
                          isShadow: 1,
                          onTap: sentTickets,
                          textColor: Colors.white,
                          label: "send".tr)
                    ],
                  ),
                ),
              ),
            ),
    );
  }
}
