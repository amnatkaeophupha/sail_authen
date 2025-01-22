@extends('admin/roker_layout/users_layout')

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
        @if(session('status'))
        <div class="alert alert-info border-0 bg-info alert-dismissible fade show">
            <div class="text-white">{{ session('status') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if(session('email'))
        <div class="alert alert-info border-0 bg-info alert-dismissible fade show">
            <div class="text-white">{{ session('email') }}</div>
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
                    <table class="table" style="font-family:'Chakra Petch', sans-serif;">
                        <thead>
                            <tr>
                                <th><i class='bx bx-key me-0'></i></th>
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
                                @if(Auth::user()->id <> $user->id)
                                <td><input type="checkbox" onchange="editUserActive({{ $user->id }}, this.checked)"  {{ $user->active ? 'checked' : '' }}></td>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->mobile }}</td>
                                <td>{{ $user->role }}</td>
                                <td>
                                    <button type="button" class="btn {{ $user->active ? 'btn-outline-success' : 'btn-outline-secondary' }}  btn-sm"><i class='bx bx-key me-0'></i></button>
                                    <button type="button" onclick="editUser({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}','{{ $user->mobile }}','{{ $user->role }}')"
                                        data-bs-target="#editUserModal" data-bs-toggle="modal" class="btn btn-outline-primary btn-sm"><i class='bx bx-edit me-0'></i></button>
                                    <button type="button" onclick="VerifyEmail({{ $user->id }},'{{ $user->email }}')" data-bs-target="#VerifyEmailModal" data-bs-toggle="modal" class="btn btn-outline-info btn-sm"><i class='bx bx-envelope-open me-0'></i></button>
                                    <form id="delete-form-{{ $user->id }}" method="POST" action="{{ route('users.destroy', $user->id) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmDelete({{ $user->id }})"><i class='bx bx-trash me-0'></i></button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>



<div class="modal fade" id="AddUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">

        <div class="modal-content">
        <form method="POST" action="{{ url('admin/users/store') }}">
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
                                <input class="form-check-input" type="checkbox" name="active_users">
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
        </form>
        </div>

    </div>
</div>


<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ url('admin/users/update') }}">
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

<div class="modal fade" id="VerifyEmailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ url('admin/users/sendmail') }}">
            @csrf
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" style="font-family:'Chakra Petch', sans-serif;">เปลี่ยนรหัสผ่าน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="font-family:'Chakra Petch', sans-serif;">
                <div class="card-body p-2">
                    <label class="col-sm-12 col-form-label">Email</label>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-envelope'></i></span>
                                <input type="email" name="email" id="VerifyEmail" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id" id="VerifyId">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">VerifyEmail</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
function editUserActive(id, isActive) {
        const csrfToken = "{{ csrf_token() }}"; // For CSRF protection in Laravel

        fetch(`users/${id}/update-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken // Include CSRF token in the request headers
            },
            body: JSON.stringify({ active: isActive ? 1 : 0 }) // Send the active status as 1 or 0
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message); // Notify the user
                location.reload();
            } else {
                alert('Failed to update status.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Something went wrong.');
        });
    }
</script>

<script>
    function editUser(id, name, email, mobile, role) {
        $('#user-id').val(id);
        $('#user-name').val(name);
        $('#user-email').val(email);
        $('#user-mobile').val(mobile);
        $('#user-role').val(role);
    }
    function VerifyEmail(id, email) {
        $('#VerifyId').val(id);
        $('#VerifyEmail').val(email);
    }
    function confirmDelete(userId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the hidden form
                document.getElementById(`delete-form-${userId}`).submit();

            }
        });
    }
</script>
@endsection
