
<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="{{url('2025_aru');}}/images/favicon-32x32.png" type="image/png" />
	<!-- loader-->
	<link href="{{url('rocker');}}/css/pace.min.css" rel="stylesheet" />
	<script src="{{url('rocker');}}/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="{{url('rocker');}}/css/bootstrap.min.css" rel="stylesheet">
	<link href="{{url('rocker');}}/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anuphan:wght@100..700&family=Chakra+Petch:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Niramit:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&family=Sarabun:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link href="{{url('rocker');}}/css/aru_sign_app.css" rel="stylesheet">
	<link href="{{url('rocker');}}/css/icons.css" rel="stylesheet">
	<title>ARU - Phranakhon Si Ayutthaya Rajabhat University</title>
</head>
<body>
	<!-- wrapper -->
	<div class="wrapper">
		<div class="authentication-reset-password d-flex align-items-center justify-content-center">
		 <div class="container">
			<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
				<div class="col mx-auto">
					<div class="card">
						<div class="card-body" style="font-family:'Chakra Petch', sans-serif;">
                            <form action="{{ url('reset-password') }}" method="POST">
                            @csrf
							<div class="p-4">
								<div class="mb-4 text-center">
									<img src="{{url('2025_aru');}}/images/logo-icon.png" width="100" />
								</div>
								<div class="text-start mb-4">
									<h5 class="">Genrate New Password</h5>
									<p class="mb-0">We received your reset password request. Please enter your new password!</p>
								</div>
                                <div class="mb-3 mt-4">
                                    @error('password')<label class="text-danger">{{ $message }}</label>@enderror
                                    @error('email')<label class="text-danger">{{ $message }}</label>@enderror
                                </div>
								<div class="mb-3 mt-4">
									<label class="form-label">New Password</label>
                                    <input type="hidden" name="email" value="{{ request('email') }}" class="form-control"/>
                                    <input type="hidden" name="token" value="{{ $token }}">
									<input type="password" name="password" class="form-control" placeholder="Enter new password" />
								</div>
								<div class="mb-4">
									<label class="form-label">Confirm Password</label>
									<input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password" />
								</div>
								<div class="d-grid gap-2">
									<button type="submit" class="btn btn-primary">Change Password</button> <a href="{{ url('signin') }}" class="btn btn-light"><i class='bx bx-arrow-back mr-1'></i>Back to Login</a>
								</div>
							</div>
                            </form>
						</div>
					</div>
				</div>
			</div>
		  </div>
		</div>
	</div>
	<!-- end wrapper -->
</body>

</html>
