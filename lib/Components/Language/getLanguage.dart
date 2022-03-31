import 'package:get/get.dart';

import 'ar.dart';
import 'en.dart';
import 'tr.dart';

class Messages extends Translations {
  @override
  Map<String, Map<String, String>> get keys => {
        'ar': getArabicLanguage(),
        'en': getEnglishLanguage(),
        'tr': getTurkishLanguage()
      };
}
