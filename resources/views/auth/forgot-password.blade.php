
<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="{{url('rocker');}}/images/favicon-32x32.png" type="image/png" />
	<!-- loader-->
	<link href="{{url('rocker');}}/css/pace.min.css" rel="stylesheet" />
	<script src="{{url('rocker');}}/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="{{url('rocker');}}/css/bootstrap.min.css" rel="stylesheet">
	<link href="{{url('rocker');}}/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="{{url('rocker');}}/css/app.css" rel="stylesheet">
	<link href="{{url('rocker');}}/css/icons.css" rel="stylesheet">
	<title>Rocker - Bootstrap 5 Admin Dashboard Template</title>
</head>

<body class="">
	<!-- wrapper -->
	<div class="wrapper">
		<div class="authentication-forgot d-flex align-items-center justify-content-center">
			<div class="card forgot-box">
				<div class="card-body">
                    <form method="POST" action="{{ url('forgot-password') }}">
                        @csrf
                        <div class="p-3">
                            <div class="text-center">
                                <img src="{{url('rocker');}}/images/icons/forgot-2.png" width="100" alt="" />
                            </div>
                            <h4 class="mt-5 font-weight-bold">Forgot Password?</h4>
                            <p class="text-muted">Enter your registered email ID to reset the password</p>
                            @if (session('status'))<div class="alert alert-success mt-2">{{ session('status') }}</div>@endif
                            @if ($errors->has('email'))<div class="alert alert-danger mt-2">{{ $errors->first('email') }}</div>@endif
                            <div class="my-4">
                                <label class="form-label">Email id</label>
                                <input type="email" value="{{ old('email')}}" name="email" class="form-control" placeholder="example@user.com" />
                                @error('email')<label class="text-danger">{{ $message }}</label>@enderror
                                @error('status')<label class="text-danger">{{ $message }}</label>@enderror
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Send</button>
                                <a href="{{url('signin');}}" class="btn btn-light"><i class='bx bx-arrow-back me-1'></i>Back to Login</a>
                            </div>
                        </div>
                    </form>
				</div>
			</div>
		</div>
	</div>
	<!-- end wrapper -->
</body>

</html>
