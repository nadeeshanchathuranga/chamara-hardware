<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title inertia>{{ config('app.name', 'jaan-network') }}</title>
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.5.0/remixicon.css" />

  <link rel="stylesheet" href="/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="/css/buttons.dataTables.min.css">
  {{-- <link rel="stylesheet" href="/css/app.css"> --}}



  <script src="/js/jquery-3.6.0.min.js"></script>
  <script src="/js/jquery.dataTables.min.js"></script>
  <script src="/js/dataTables.buttons.min.js"></script>
  <script src="/js/buttons.html5.min.js"></script>
  <script src="/js/buttons.print.min.js"></script>
  <script src="/js/buttons.colVis.min.js"></script>
  <script src="/js/jszip.min.js"></script>
  <script src="/js/pdfmake.min.js"></script>
  <script src="/js/vfs_fonts.js"></script>



  <script src="/js/JsBarcode.all.min.js"></script>
  <style>
      /* Optional styles for the table */
      .dt-buttons .btn {
          margin-right: 5px;
      }
  </style>





    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body class="font-sans antialiased">
    @inertia
</body>
<script>

document.addEventListener("click", () => {
  const audio = new Audio("/sounds/click-sound.mp3");
  audio.play();
});


</script>

</html>
