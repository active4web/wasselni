part of 'home_cubit.dart';

@immutable
abstract class HomeState {}

class HomeInitial extends HomeState {}
class FetchHomeDataSuccess extends HomeState {}
class FetchHomeDataError extends HomeState {}
class FetchHomeDataLoading extends HomeState {}
