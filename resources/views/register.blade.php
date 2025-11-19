<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - MyFurniture</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column justify-content-center align-items-center vh-100 bg-white">

  <div class="text-center" style="width: 90%; max-width: 320px;">
    <h2 class="fw-bold text-warning mb-3">MyFurniture</h2>
    <p class="text-muted mb-4 small">Welcome! Let's get started...</p>

    <form action="{{ route('register') }}" method="POST">
      @csrf
      <div class="mb-3">
        <input type="text" name="name" class="form-control rounded-pill bg-light border-0" placeholder="Name" required>
      </div>
      <div class="mb-3">
        <input type="email" name="email" class="form-control rounded-pill bg-light border-0" placeholder="Email" required>
      </div>
      <div class="mb-4">
        <input type="password" name="password" class="form-control rounded-pill bg-light border-0" placeholder="Password" required>
      </div>
      <div class="mb-3">
        <input type="password" name="password_confirmation" class="form-control rounded-pill bg-light border-0" placeholder="Confirm Password" required>
      </div>
      <button type="submit" class="btn btn-warning text-white rounded-pill w-100 fw-semibold py-2">Register</button>
    </form>
  </div>

</body>
</html>
