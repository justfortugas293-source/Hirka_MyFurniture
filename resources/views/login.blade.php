<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - MyFurniture</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column justify-content-center align-items-center vh-100 bg-white">

  <div class="text-center" style="width: 90%; max-width: 320px;">
    <h2 class="fw-bold text-warning mb-3">MyFurniture</h2>
    <p class="text-muted mb-4 small">Glad to see you again! Welcome Back...</p>

    <form action="{{ route('login') }}" method="POST">
      @csrf
      @if($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
      <div class="mb-3">
        <input type="email" name="email" class="form-control rounded-pill bg-light border-0" placeholder="Email" value="{{ old('email') }}" required>
      </div>
      <div class="mb-4">
        <input type="password" name="password" class="form-control rounded-pill bg-light border-0" placeholder="Password" required>
      </div>
      <div class="form-check mb-3 text-start">
        <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember">
        <label class="form-check-label small text-muted" for="remember">
          Remember me
        </label>
      </div>
      <button type="submit" class="btn btn-warning text-white rounded-pill w-100 fw-semibold py-2">Login</button>
    </form>
  </div>

</body>
</html>
