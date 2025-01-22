
<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="{{url('2025_aru');}}/images/favicon-32x32.png" type="image/png" />
	<!--plugins-->
	<link href="{{url('rocker');}}/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
	<link href="{{url('rocker');}}/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
	<link href="{{url('rocker');}}/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
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

<body class="">
	<!--wrapper-->
	<div class="wrapper">
		<div class="d-flex align-items-center justify-content-center my-5">
			<div class="container-fluid">
				<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
					<div class="col mx-auto">
						<div class="card mb-0">
							<div class="card-body" style="font-family:'Chakra Petch', sans-serif;">
								<div class="p-4">
									<div class="mb-3 text-center">
										<img src="{{url('2025_aru');}}/images/logo-icon.png" width="100"/>
									</div>
									<div class="text-center mb-4">
										<h5 class="">Web Admin</h5>
										<p class="mb-0">Please fill the below details to create your account</p>
									</div>
									<div class="form-body">
                                        @if(session('fail'))
                                        <div class="alert alert-success border-0 bg-success alert-dismissible fade show">
                                            <div class="text-white">{{ session('success') }}</div>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                        @endif
										<form class="row g-3" method="POST" action="{{ url('store') }}">
                                            @csrf
											<div class="col-12">
												<label for="inputUsername" class="form-label">Username</label>
												<input type="text" name="name" class="form-control" id="inputUsername" placeholder="Full Name">
                                                @error('name')
                                                <div class="text-danger rounded pt-2">{{ $message }}</div>
                                                @enderror
											</div>
											<div class="col-12">
												<label for="inputEmailAddress" class="form-label">Email Address</label>
												<input type="email" name="email" class="form-control" id="inputEmailAddress" placeholder="example@aru.ac.th">
                                                @error('email')
                                                <div class="text-danger rounded pt-2">{{ $message }}</div>
                                                @enderror
											</div>
											<div class="col-12">
												<label for="inputEmailAddress" class="form-label">Moblie</label>
												<input type="text" name="mobile" class="form-control" placeholder="Mobile Number">
                                                @error('mobile')
                                                <div class="text-danger rounded pt-2">{{ $message }}</div>
                                                @enderror
											</div>
											<div class="col-12">
												<label for="inputChoosePassword" class="form-label">Password</label>
												<div class="input-group" id="show_hide_password">
													<input type="password" name="password" class="form-control border-end-0" placeholder="Enter Password Min 6 Characters"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
												</div>
                                                @error('password')
                                                <div class="col-12 text-danger rounded pt-2">{{ $message }}</div>
                                                @enderror
											</div>
											<div class="col-12">
												<label for="inputSelectCountry" class="form-label">Country</label>
												<select class="form-select" name="role" id="inputSelectCountry" aria-label="Default select example">
													<option value="">Select Role</option>
													<option {{ old('role')=='manager'? 'selected' : '' }} value="manager">Manager</option>
													<option {{ old('role')=='admin'? 'selected' : '' }} value="admin">Admin</option>
												</select>
                                                @error('role')
                                                    <div class="text-danger rounded pt-2">{{ $message }}</div>
                                                @enderror
											</div>
											{{-- <div class="col-12">
												<div class="form-check form-switch">
													<input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked">
													<label class="form-check-label" for="flexSwitchCheckChecked">I read and agree to Terms & Conditions</label>
												</div>
											</div> --}}
											<div class="col-12">
												<div class="d-grid">
													<button type="submit" class="btn btn-primary">Sign up</button>
												</div>
											</div>
											<div class="col-12">
												<div class="text-center ">
													<p class="mb-0">Already have an account? <a href="{{url('signin');}}">Sign in here</a></p>
												</div>
											</div>
										</form>
									</div>
									{{-- <div class="login-separater text-center mb-5"> <span>OR SIGN UP WITH EMAIL</span>
										<hr/>
									</div>
									<div class="list-inline contacts-social text-center">
										<a href="javascript:;" class="list-inline-item bg-facebook text-white border-0 rounded-3"><i class="bx bxl-facebook"></i></a>
										<a href="javascript:;" class="list-inline-item bg-twitter text-white border-0 rounded-3"><i class="bx bxl-twitter"></i></a>
										<a href="javascript:;" class="list-inline-item bg-google text-white border-0 rounded-3"><i class="bx bxl-google"></i></a>
										<a href="javascript:;" class="list-inline-item bg-linkedin text-white border-0 rounded-3"><i class="bx bxl-linkedin"></i></a>
									</div> --}}

								</div>
							</div>
						</div>
					</div>
				 </div>
				<!--end row-->
			</div>
		</div>
	</div>
	<!--end wrapper-->
	<!-- Bootstrap JS -->
	<script src="{{url('rocker');}}/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="{{url('rocker');}}/js/jquery.min.js"></script>
	<script src="{{url('rocker');}}/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="{{url('rocker');}}/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="{{url('rocker');}}/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<!--Password show & hide js -->
	<script>
		$(document).ready(function () {
			$("#show_hide_password a").on('click', function (event) {
				event.preventDefault();
				if ($('#show_hide_password input').attr("type") == "text") {
					$('#show_hide_password input').attr('type', 'password');
					$('#show_hide_password i').addClass("bx-hide");
					$('#show_hide_password i').removeClass("bx-show");
				} else if ($('#show_hide_password input').attr("type") == "password") {
					$('#show_hide_password input').attr('type', 'text');
					$('#show_hide_password i').removeClass("bx-hide");
					$('#show_hide_password i').addClass("bx-show");
				}
			});
		});
	</script>
	<!--app JS-->
	<script src="{{url('rocker');}}/assets/js/app.js"></script>
</body>
</html>
