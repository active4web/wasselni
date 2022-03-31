import 'package:flutter/material.dart';
import 'package:flutter/services.dart';

class CustomTextField extends StatefulWidget {
  final TextEditingController controller;
  final TextInputType type;
  final FocusNode focusNode;
  final String hint;
  final TextDirection textDirection;
  final Function onTap;
  final Widget icon;
  List<TextInputFormatter> inputFormatters;
  final Function onChanged;
  final Function(String) onSaved;
  final String Function(String) valid;
  final IconData suffixIcon;
  final bool isPassword;
  final Function suffixPress;
  CustomTextField(
      {this.focusNode,
      this.valid,
      this.onSaved,
      this.controller,
      this.type,
      this.hint,
      this.textDirection,
      this.onTap,
      this.icon,
      this.onChanged,
      this.suffixIcon,
      this.isPassword = false,
      this.suffixPress,
      this.inputFormatters});

  @override
  _CustomTextFieldState createState() => _CustomTextFieldState();
}

class _CustomTextFieldState extends State<CustomTextField> {
  @override
  Widget build(BuildContext context) {
    var currentLanguage = Localizations.localeOf(context);
    return Container(
      padding: EdgeInsets.symmetric(horizontal: 20),
      decoration: BoxDecoration(
        borderRadius: BorderRadius.all(Radius.circular(30)),
        border: Border.all(color: Colors.blue, width: 2),
      ),
      child: TextFormField(
          onSaved: widget.onSaved,
          validator: widget.valid,
          onChanged: widget.onChanged,
          focusNode: widget.focusNode,
          controller: widget.controller,
          keyboardType: widget.type,
          inputFormatters: widget.inputFormatters,
          obscureText: widget.isPassword,
          textDirection: (widget.textDirection == null &&
                      currentLanguage.languageCode == "ar") ||
                  widget.textDirection == TextDirection.rtl
              ? TextDirection.rtl
              : TextDirection.ltr,
          autofocus: false,
          style: TextStyle(
              fontSize: 17, fontFamily: 'GE-Snd-Book', color: Colors.black),
          decoration: InputDecoration(
            filled: true,
            focusColor: Colors.transparent,
            fillColor: Colors.transparent,
            enabledBorder: InputBorder.none,
            focusedBorder: InputBorder.none,
            hintText: widget.hint,
            hintStyle: TextStyle(
                fontWeight: FontWeight.bold,
                fontSize: 17,
                color: Colors.red,
                fontFamily: 'GE-Snd-Book'),
            // icon: widget.icon == null ? null : widget.icon,
            suffixIcon: widget.suffixIcon != null
                ? InkWell(
                    onTap: widget.suffixPress, child: Icon(widget.suffixIcon))
                : null,
            // contentPadding:
            //     EdgeInsets.symmetric(horizontal: 0.0, vertical: 0.0)
          )),
    );
  }
}

// TextField But Not Rounded
class ProfileTextField extends StatefulWidget {
  final TextEditingController controller;
  final TextInputType type;
  final FocusNode focusNode;
  final String hint;
  final TextDirection textDirection;
  final Function onTap;
  final Widget icon;
  final String intialval;
  final Function(String) onChanged;
  final Function(String) onSaved;
  final String Function(String) validator;
  final int maxLi;
  ProfileTextField(
      {this.maxLi,
      this.focusNode,
      this.controller,
      this.type,
      this.hint,
      this.textDirection,
      this.onTap,
      this.icon,
      this.intialval,
      this.onChanged,
      this.onSaved,
      this.validator});

  @override
  _ProfileTextFieldState createState() => _ProfileTextFieldState();
}

class _ProfileTextFieldState extends State<ProfileTextField> {
  @override
  Widget build(BuildContext context) {
    var currentLanguage = Localizations.localeOf(context);
    return Container(
      height: 50,
      padding: EdgeInsets.symmetric(horizontal: 20),
      decoration: BoxDecoration(
        color: Colors.grey.withOpacity(.3),
        borderRadius: BorderRadius.all(Radius.circular(8)),
        // border: Border.all(color: Colors.blue, width: 2),
      ),
      child: TextFormField(
          maxLength: widget.maxLi,
          initialValue: widget.intialval,
          focusNode: widget.focusNode,
          controller: widget.controller,
          keyboardType: widget.type,
          onChanged: widget.onChanged,
          onSaved: widget.onSaved,
          validator: widget.validator,
          obscureText: false,
          textDirection: (widget.textDirection == null &&
                      currentLanguage.languageCode == "ar") ||
                  widget.textDirection == TextDirection.rtl
              ? TextDirection.rtl
              : TextDirection.ltr,
          autofocus: false,
          style: TextStyle(
              fontSize: 17, fontFamily: 'GE-Snd-Book', color: Colors.black),
          decoration: InputDecoration(
              filled: true,
              focusColor: Colors.transparent,
              fillColor: Colors.transparent,
              enabledBorder: InputBorder.none,
              focusedBorder: InputBorder.none,
              hintText: widget.hint,
              hintStyle: TextStyle(
                  fontWeight: FontWeight.bold,
                  fontSize: 17,
                  color: Colors.black,
                  fontFamily: 'GE-Snd-Book'),
              icon: widget.icon == null ? null : widget.icon,
              contentPadding:
                  EdgeInsets.symmetric(horizontal: 0.0, vertical: 0.0))),
    );
  }
}

class ProfileTextField1 extends StatefulWidget {
  final TextEditingController controller;
  final TextInputType type;
  final FocusNode focusNode;
  final String hint;
  final TextDirection textDirection;
  final Function onTap;
  final Widget icon;
  final String intialval;
  final Function(String) onChanged;
  final Function(String) onSaved;
  final String Function(String) validator;
  final int maxLi;
  ProfileTextField1(
      {this.maxLi,
      this.focusNode,
      this.controller,
      this.type,
      this.hint,
      this.textDirection,
      this.onTap,
      this.icon,
      this.intialval,
      this.onChanged,
      this.onSaved,
      this.validator});

  @override
  _ProfileTextField1State createState() => _ProfileTextField1State();
}

class _ProfileTextField1State extends State<ProfileTextField1> {
  @override
  Widget build(BuildContext context) {
    var currentLanguage = Localizations.localeOf(context);
    return Container(
      height: 200,
      padding: EdgeInsets.symmetric(horizontal: 20),
      decoration: BoxDecoration(
        color: Colors.grey.withOpacity(.3),
        borderRadius: BorderRadius.all(Radius.circular(8)),
        // border: Border.all(color: Colors.blue, width: 2),
      ),
      child: Padding(
        padding: const EdgeInsets.symmetric(vertical: 4),
        child: TextFormField(
            maxLines: 6,
            maxLength: widget.maxLi,
            initialValue: widget.intialval,
            focusNode: widget.focusNode,
            controller: widget.controller,
            keyboardType: widget.type,
            onChanged: widget.onChanged,
            onSaved: widget.onSaved,
            validator: widget.validator,
            obscureText: false,
            textDirection: (widget.textDirection == null &&
                        currentLanguage.languageCode == "ar") ||
                    widget.textDirection == TextDirection.rtl
                ? TextDirection.rtl
                : TextDirection.ltr,
            autofocus: false,
            style: TextStyle(
                fontSize: 17, fontFamily: 'GE-Snd-Book', color: Colors.black),
            decoration: InputDecoration(
                filled: true,
                focusColor: Colors.transparent,
                fillColor: Colors.transparent,
                enabledBorder: InputBorder.none,
                focusedBorder: InputBorder.none,
                hintText: widget.hint,
                hintStyle: TextStyle(
                    fontWeight: FontWeight.bold,
                    fontSize: 17,
                    color: Colors.black,
                    fontFamily: 'GE-Snd-Book'),
                icon: widget.icon == null ? null : widget.icon,
                contentPadding:
                    EdgeInsets.symmetric(horizontal: 0.0, vertical: 0.0))),
      ),
    );
  }
}

// Transparent TextField Without Container

class TransparentTextField extends StatefulWidget {
  final TextEditingController controller;
  final TextInputType type;
  final FocusNode focusNode;
  final String hint;
  final TextDirection textDirection;
  final Function onTap;
  final Widget icon;
  TransparentTextField({
    this.focusNode,
    this.controller,
    this.type,
    this.hint,
    this.textDirection,
    this.onTap,
    this.icon,
  });

  @override
  _TransparentTextFieldState createState() => _TransparentTextFieldState();
}

class _TransparentTextFieldState extends State<TransparentTextField> {
  @override
  Widget build(BuildContext context) {
    var currentLanguage = Localizations.localeOf(context);
    return TextFormField(
        focusNode: widget.focusNode,
        controller: widget.controller,
        keyboardType: widget.type,
        obscureText: false,
        textDirection: (widget.textDirection == null &&
                    currentLanguage.languageCode == "ar") ||
                widget.textDirection == TextDirection.rtl
            ? TextDirection.rtl
            : TextDirection.ltr,
        autofocus: false,
        style: TextStyle(
            fontSize: 17, fontFamily: 'GE-Snd-Book', color: Colors.white),
        decoration: InputDecoration(
            filled: true,
            focusColor: Colors.transparent,
            fillColor: Colors.transparent,
            enabledBorder: InputBorder.none,
            focusedBorder: InputBorder.none,
            hintText: widget.hint,
            hintStyle: TextStyle(
                fontWeight: FontWeight.bold,
                fontSize: 17,
                color: Colors.white,
                fontFamily: 'GE-Snd-Book'),
            icon: widget.icon == null ? null : widget.icon,
            contentPadding:
                EdgeInsets.symmetric(horizontal: 0.0, vertical: 0.0)));
  }
}

// Transparent TextField Without Container And With Color Text

class TransparentTextFieldColorText extends StatefulWidget {
  final TextEditingController controller;
  final TextInputType type;
  final FocusNode focusNode;
  final String hint;
  final TextDirection textDirection;
  final Function onTap;
  final Widget icon;
  final String Function(String) validator;
  TransparentTextFieldColorText({
    this.validator,
    this.focusNode,
    this.controller,
    this.type,
    this.hint,
    this.textDirection,
    this.onTap,
    this.icon,
  });

  @override
  _TransparentTextFieldColorTextState createState() =>
      _TransparentTextFieldColorTextState();
}

class _TransparentTextFieldColorTextState
    extends State<TransparentTextFieldColorText> {
  @override
  Widget build(BuildContext context) {
    var currentLanguage = Localizations.localeOf(context);
    return TextFormField(
        validator: widget.validator,
        focusNode: widget.focusNode,
        controller: widget.controller,
        keyboardType: widget.type,
        obscureText: false,
        textDirection: (widget.textDirection == null &&
                    currentLanguage.languageCode == "ar") ||
                widget.textDirection == TextDirection.rtl
            ? TextDirection.rtl
            : TextDirection.ltr,
        autofocus: false,
        style: TextStyle(
            fontSize: 17, fontFamily: 'GE-Snd-Book', color: Colors.black),
        decoration: InputDecoration(
            filled: true,
            focusColor: Colors.transparent,
            fillColor: Colors.transparent,
            enabledBorder: InputBorder.none,
            focusedBorder: InputBorder.none,
            hintText: widget.hint,
            hintStyle: TextStyle(
                fontWeight: FontWeight.w500,
                fontSize: 15,
                color: Colors.black,
                fontFamily: 'GE-Snd-Book'),
            icon: widget.icon == null ? null : widget.icon,
            contentPadding:
                EdgeInsets.symmetric(horizontal: 0.0, vertical: 9.0)));
  }
}
