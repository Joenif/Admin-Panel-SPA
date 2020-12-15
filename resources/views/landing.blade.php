
<!DOCTYPE html>
 
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Admin Dashboard</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  @auth
    @dd("user loggedin")
  @endauth  
  <link rel="icon" type="image/png" href="/favicon.ico"/>

  {{-- Style --}}
  <link rel="stylesheet" href="/css/login.css">
  <link rel="stylesheet" href="/css/util.css">
  <link rel="stylesheet" href="/css/app.css">

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id='app'>

</div>
<!-- ./wrapper -->

    @auth
        {{-- <script>
            window.user = @json(auth()->user());
        </script> --}}
    @endauth

<!-- REQUIRED SCRIPTS -->
<script src="/js/app.js"></script>

</body>
</html>
