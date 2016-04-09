@extends('sms')

@section('header')
txtcmdr
@stop

@section('body')
{!! $mobile !!}
@stop

@section('footer')
{!! $created_at ?: "-HQ"!!}
@stop