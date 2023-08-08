<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'ORFI CMS') }}</title>
  @include('components.head')
</head>
<body class="hold-transition sidebar-mini">

<div class="wrapper">
@include('components.navBar')
@include('components.sidebar')

