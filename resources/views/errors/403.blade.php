@extends('errors::layout')

@section('title', 'Yetkisiz Erişim')
@section('code', '403')
@section('message', $exception->getMessage() ?: 'Bu sayfaya erişim izniniz yok.')
@section('extra', 'YOU SHALL NOT PASS! 🧙‍♂️')
