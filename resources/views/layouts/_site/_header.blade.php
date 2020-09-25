<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="-1" />
      <meta name="csrf-token" content="{{ csrf_token() }}" />
      <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>TopUp - @yield('title')</title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
      <!--  -->
      <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link href="/your-path-to-fontawesome/css/solid.css" rel="stylesheet">
      <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
      <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
      <link rel="stylesheet" type="text/css" href="{{asset('css/app.css?v='.filemtime('css/app.css'))}}">
      <link rel="stylesheet" type="text/css" href="{{asset('css/default.css?v='.filemtime('css/default.css'))}}">
      <link rel="stylesheet" type="text/css" href="{{asset('css/site.css?v='.filemtime('css/site.css'))}}">
      <link rel="stylesheet" type="text/css" href="{{asset('css/adm/sidebar.css?v='.filemtime('css/adm/sidebar.css'))}}">
      <link rel="stylesheet" type="text/css" href="{{asset('css/adm/topup.css?v='.filemtime('css/adm/topup.css'))}}">
      <link rel="stylesheet" type="text/css" href="{{asset('css/adm/topup.css?v='.filemtime('css/adm/topup.css'))}}">
  </head>
  <img id="loader" src="/../../../img/loader.gif" alt="">


