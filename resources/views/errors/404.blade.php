@extends('errors::layout')

@section('title', __('Sayfa Bulunamadı'))
@section('code', '404')
@section('message', __('Eyvah! Böyle bir içeriğe ulaşamadık.'))
@section('extra', __('Aradığınız sayfa veya içerik silinmiş ya da hiç var olmamış olabilir.'))
