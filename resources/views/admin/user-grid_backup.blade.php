@extends('admin/roker_layout/dashboard_layout')

@section('title', 'มหาวิทยาลัยราชภัฏพระนครศรีอยุธยา')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Content</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Grid System</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddUserModal">AddUser</button>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if(session('success'))
        <div class="alert alert-success border-0 bg-success alert-dismissible fade show">
            <div class="text-white">{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if(session('fail'))
        <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
            <div class="text-white">{{ session('fail') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <div class="card border-primary border-top border-3 border-0">
            <div class="card-body">
                <div class="card-title" style="font-family:'Chakra Petch', sans-serif;">
                    <h5 class="text-primary rounded mb-0">ข้อมูลผู้ใช้งานระบบ</h5>
                </div>
                <hr/>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>FullName</th>
                                <th>email</th>
                                <th>Mobile</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td></td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->mobile }}</td>
                                <td>{{ $user->role }}</td>
                                <td>
                                    <button type="button" onclick="editUser({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}','{{ $user->mobile }}','{{ $user->role }}')"
                                        data-bs-target="#editUserModal" data-bs-toggle="modal" class="btn btn-outline-primary btn-sm"><i class='bx bx-edit me-0'></i></button>
                                    <button type="button" class="btn btn-outline-success btn-sm"><i class='bx bx-key me-0'></i></button>
                                    <button type="button" class="btn btn-outline-info btn-sm"><i class='bx bx-envelope-open me-0'></i></button>
                                    <button type="button" class="btn btn-outline-danger btn-sm"><i class='bx bx-trash me-0'></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>


<form class="row" method="POST" action="{{ url('admin/users/store') }}">
@csrf
<div class="modal fade" id="AddUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" style="font-family:'Chakra Petch', sans-serif;">เพิ่มผู้ใช้งานระบบ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="font-family:'Chakra Petch', sans-serif;">
                <div class="card-body p-2">
                    <label class="col-sm-12 col-form-label">Enter Your Name</label>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-user'></i></span>
                                <input type="text" name="name" class="form-control" placeholder="Your Name">
                            </div>
                        </div>
                    </div>
                    <label class="col-sm-12 col-form-label">Phone No</label>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-microphone'></i></span>
                                <input type="text" name="mobile" class="form-control" placeholder="Phone No">
                            </div>
                        </div>
                    </div>
                    <label class="col-sm-12 col-form-label">Email Address</label>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-envelope'></i></span>
                                <input type="email" name="email" class="form-control" placeholder="Email">
                            </div>
                        </div>
                    </div>
                    <label class="col-sm-12 col-form-label">Choose Password</label>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-lock-open'></i></span>
                                <input type="password" name="password" class="form-control" placeholder="Choose Password">
                            </div>
                        </div>
                    </div>
                    <label class="col-sm-12 col-form-label">Role</label>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-flag'></i></span>
                                <select class="form-select" name="role">
                                    <option selected>Open this select Role</option>
                                    <option {{ old('role')=='manager'? 'selected' : '' }} value="manager">Manager</option>
                                    <option {{ old('role')=='admin'? 'selected' : '' }} value="admin">Admin</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <label class="col-sm-12 col-form-label"></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">Check Active</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
</form>


<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ url('admin/users/store') }}" id="editUserForm">
            @csrf
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" style="font-family:'Chakra Petch', sans-serif;">เพิ่มผู้ใช้งานระบบ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="font-family:'Chakra Petch', sans-serif;">
                <div class="card-body p-2">
                    <label class="col-sm-12 col-form-label">Enter Your Name</label>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-user'></i></span>
                                <input type="text" name="name" id="user-name" class="form-control" placeholder="Your Name">
                            </div>
                        </div>
                    </div>
                    <label class="col-sm-12 col-form-label">Phone No</label>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-microphone'></i></span>
                                <input type="text" name="mobile" id="user-mobile" class="form-control" placeholder="Phone No">
                            </div>
                        </div>
                    </div>
                    <label class="col-sm-12 col-form-label">Email Address</label>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-envelope'></i></span>
                                <input type="email" name="email" id="user-email" class="form-control" placeholder="Email">
                            </div>
                        </div>
                    </div>
                    <label class="col-sm-12 col-form-label">Role</label>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-flag'></i></span>
                                <select class="form-select" id="user-role" name="role">
                                    <option selected>Open this select Role</option>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="manager" {{ $user->role == 'manager' ? 'selected' : '' }}>Manager</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <label class="col-sm-12 col-form-label"></label>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">Check Active</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id" id="user-id">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Edit user in the modal
    function editUser(id, name, email, mobile, role) {
        //$('#user-id').val(id); /*  New Version */
        document.getElementById('user-id').value = id; /*  Old Version */
        //$('#user-name').val(name);
        document.getElementById('user-name').value = name;
        //$('#user-email').val(email);
        document.getElementById('user-email').value = email;
        //$('#user-mobile').val(mobile);
        document.getElementById('user-mobile').value = mobile;
        //$('#user-role').val(role);
        document.getElementById('user-role').value = role;
    }

    document.getElementById('editUserForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const id = document.getElementById('user-id').value;
    const formData = new FormData(this);

    consone.log(id);

    // fetch(`/users/${id}/update`, {
    //     method: 'POST',
    //     headers: {
    //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    //     },
    //     body: formData
    // })
    // .then(response => response.json())
    // .then(result => {
    //     if (result.success) {
    //         alert(result.message);
    //         const modal = bootstrap.Modal.getInstance(document.getElementById('editUserModal'));
    //         modal.hide();
    //         location.reload(); // Reload the page or update the UI dynamically
    //     } else {
    //         alert('Failed to update user.');
    //     }
    // });
});
</script>
@endsection
