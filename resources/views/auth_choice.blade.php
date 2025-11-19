<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MyFurniture - Welcome</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column justify-content-center align-items-center vh-100 bg-white">

  <div class="text-center">
    <h2 class="fw-bold text-warning mb-5">MyFurniture</h2>

    <a href="{{ route('login') }}" 
       class="btn btn-light rounded-pill px-5 py-2 mb-3 shadow-sm border border-1 text-secondary fw-semibold"
       style="width: 200px;">
       Login
    </a>

    <p class="text-muted small mb-2">Don't have an account?</p>

    <a href="{{ route('register') }}" 
       class="btn btn-warning rounded-pill px-5 py-2 text-white fw-semibold shadow"
       style="width: 200px;">
       Register
    </a>
  </div>

</body>
</html>
