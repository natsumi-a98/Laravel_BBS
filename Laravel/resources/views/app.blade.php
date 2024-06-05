<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel='stylesheet' href="{{ asset('/css/app.css') }}">
  <title>Laravel_test</title>
</head>
<body>
  <header>
    <h1 class="page-header">Laravel個人課題</h1>
  </header>

  <div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
      <div class="container">

      </div>
    </nav>
    <main class="py-4">
      @yield('content')
    </main>
  </div>


  <footer>
    <small>Laravel_test@crud.curriculum</small>
  </footer>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
</body>
</html>
