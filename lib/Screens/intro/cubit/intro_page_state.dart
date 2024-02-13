part of 'intro_page_cubit.dart';

@immutable
abstract class IntroPageState {}

class IntroPageInitial extends IntroPageState {}
class GetCategoriesSuccessState extends IntroPageState {}
class GetCategoriesErrorState extends IntroPageState {}
class GetCategoriesLoadingState extends IntroPageState {}
