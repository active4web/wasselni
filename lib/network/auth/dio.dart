import 'package:dio/dio.dart';
import 'package:wassalny/Components/constants.dart';

 Dio dio() {
  Dio dio = Dio();
  dio.options.baseUrl = fakeBaseUrl;
  dio.interceptors.add(LogInterceptor(
   responseBody: true,
   error: true,
   requestHeader: false,
   responseHeader: false,
   requestBody: true,
   request: true,
  ));
  // dio.options.connectTimeout = 10000;
  return dio;

}


