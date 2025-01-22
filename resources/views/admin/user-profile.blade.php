@extends('admin/roker_layout/dashboard_layout')

@section('title', 'มหาวิทยาลัยราชภัฏพระนครศรีอยุธยา')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">User Profile</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">User Profilep</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="container">
            <div class="main-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body" style="font-family:'Chakra Petch', sans-serif;">
                                <div class="d-flex flex-column align-items-center text-center">
                                    @if(Auth::user()->avatar <> null)
                                    <img src="{{ asset('storage/avatars/'.Auth::user()->avatar) }}" alt="Admin" class="rounded-circle p-1 bg-primary" width="110">
                                    @else
                                    <img src="{{url('rocker');}}/images/avatars/avatar-0.png" alt="Admin" class="rounded-circle p-1 bg-primary" width="110">
                                    @endif
                                    <div class="mt-3">
                                        <h4>{{ Auth::user()->name; }}</h4>
                                        <p class="text-secondary mb-1">{{ Auth::user()->role; }}</p>
                                        <p class="text-muted font-size-sm">{{ Auth::user()->email; }}</p>
                                    </div>
                                    @error('avatars')
                                    <p class="text-danger rounded pt-2">{{$message}}</p>
                                    @enderror
                                    @if(session('success'))
                                    <p class="text-success rounded pt-2">{{session('success')}}</p>
                                    @endif
                                    <form action="{{ url('admin/profile_images') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div>
                                        <input class="form-control" name="avatars" type="file" id="formFile">
                                    </div>
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-primary">Change</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body" style="font-family:'Chakra Petch', sans-serif;">
                            <form action="{{url('admin/profile_update')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @if(session('data_success'))
                                <div class="row mb-3">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9">
                                    <p class="text-success rounded pt-2">{{session('data_success')}}</p>
                                    </div>
                                </div>
                                @endif
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Full Name</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">



                                        <input type="text" name="name" class="form-control" value="{{ Auth::user()->name; }}" />
                                        @error('name')
                                        <div class="text-danger rounded pt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Email</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="email" name="email" class="form-control" value="{{ Auth::user()->email; }}" />
                                        @error('email')
                                        <div class="text-danger rounded pt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Role</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <select class="form-select" name="role" id="inputSelectCountry" aria-label="Default select example">
                                            <option value="">Select Role</option>
                                            <option {{ Auth::user()->role=='manager'? 'selected' : '' }} value="manager">Manager</option>
                                            <option {{ Auth::user()->role=='admin'? 'selected' : '' }} value="admin">Admin</option>
                                        </select>
                                        @error('role')
                                        <div class="text-danger rounded pt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Mobile</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="mobile" class="form-control" value="{{Auth::user()->mobile}}" />
                                        @error('mobile')
                                        <div class="text-danger rounded pt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Agency</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" value="Phranakhon Si Ayutthaya Rajabhat University" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="submit" class="btn btn-primary px-4" value="Save Changes" />
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body" style="font-family:'Chakra Petch', sans-serif;">
                                <div>
									<h5 class="card-title">Delete your Account</h5>
								</div>
								<p class="card-text">{{ Auth::user()->name; }} </p>	<a href="{{ url('admin/destroy') }}" class="btn btn-danger">Delete your entier account</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
