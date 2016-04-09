@extends('sms')

@section('header')
{!! $mobile !!}
@stop

@section('body')
{!! $body !!}
@stop

@section('footer')
{!! $created_at ?: "-HQ"!!}
@stop