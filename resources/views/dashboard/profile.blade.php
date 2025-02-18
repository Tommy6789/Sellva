@extends('dashboard.partials.master')

@section('content')
    @if (session('success') || session('error'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: '{{ session('success') ? 'success' : 'error' }}',
                title: '{{ session('success') ? 'Success' : 'Error' }}',
                text: '{{ session('success') ?? session('error') }}',
            });
        </script>
        <style>
            body {
                background: #f8f9fa;
            }

            .form-control:focus {
                box-shadow: none;
                border-color: #6f42c1;
            }

            .profile-button {
                background-color: #6f42c1;
                border: none;
            }

            .profile-button:hover {
                background-color: #593091;
            }

            .labels {
                font-size: 14px;
                font-weight: 500;
            }
        </style>
    @endif

    <!-- Begin Main Content -->
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Profile</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Dashhboard</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Content -->
        <div class="app-content">
            <div class="container-fluid">
                <div class="card shadow-sm mt-4">
                    <div class="card-body">
                        <div class="row">
                            <!-- Profile Form -->
                            <div class="col-4 mx-auto">
                                <form action="{{ route('updateProfile', $user->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <!-- Profile Image Upload -->
                                    <div class="text-center mb-4">
                                        <div class="position-relative d-inline-block">
                                            <img id="profileImage" class="rounded-circle shadow border" width="150"
                                                height="150"
                                                src="{{ $profile && $profile->foto ? Storage::url($profile->foto) : url('https://dummyimage.com/640x640/') }}"
                                                alt="Profile Photo" style="object-fit: cover; cursor: pointer;">
                                            <input type="file" name="foto" id="profileInput" class="d-none"
                                                accept="image/*">
                                        </div>
                                        <br>
                                        <label for="profileInput" class="btn btn-outline-primary btn-sm mt-2">Change
                                            Photo</label>
                                        <p class="text-muted mt-2" style="font-size: 0.9rem;">Max file size: 3MB (JPEG, PNG,
                                            JPG, GIF)</p>
                                    </div>



                            </div> <!-- End Profile Form -->
                            <div class="col">
                                <!-- Profile Fields -->
                                <div class="p-3">
                                    <h4 class="text-center">Profile Settings</h4>

                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label class="form-label">NIK</label>
                                            <input type="text" name="nik" class="form-control"
                                                placeholder="Enter NIK" value="{{ old('nik', $profile->nik ?? '') }}"
                                                maxlength="16">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">NPWP</label>
                                            <input type="text" name="npwp" class="form-control"
                                                placeholder="Enter NPWP" value="{{ old('npwp', $profile->npwp ?? '') }}"
                                                maxlength="16">
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Gender</label>
                                            <select name="gender" class="form-control">
                                                <option value="">Select Gender</option>
                                                <option value="Male"
                                                    {{ old('gender', $profile->gender ?? '') == 'Male' ? 'selected' : '' }}>
                                                    Male</option>
                                                <option value="Female"
                                                    {{ old('gender', $profile->gender ?? '') == 'Female' ? 'selected' : '' }}>
                                                    Female</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Date of Birth</label>
                                            <input type="date" name="tanggal_lahir" class="form-control"
                                                value="{{ old('tanggal_lahir', $profile->tanggal_lahir ?? '') }}">
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Address</label>
                                            <input type="text" name="alamat" class="form-control"
                                                placeholder="Enter Address"
                                                value="{{ old('alamat', $user->alamat ?? '') }}">
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <label class="form-label">Phone Number</label>
                                            <input type="number" name="nomor_telepon" class="form-control" minlength="8"
                                                maxlength="12" placeholder="Enter Phone Number"
                                                value="{{ old('nomor_telepon', $user->nomor_telepon ?? '') }}">
                                        </div>
                                    </div>

                                    <div class="mt-4 text-center">
                                        <button class="btn btn-primary" type="submit">Save Profile</button>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection


@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const profileImage = document.getElementById('profileImage');
            const profileInput = document.getElementById('profileInput');

            if (profileImage && profileInput) {
                profileImage.addEventListener('click', function() {
                    profileInput.click();
                });

                profileInput.addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            profileImage.src = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    </script>
@endsection



{{-- @extends('dashboard.partials.master')

@section('content')

@if (session('success') || session('error'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
Swal.fire({
icon: '{{ session('success') ? 'success' : 'error' }}',
title: '{{ session('success') ? 'Berhasil' : 'Gagal' }}',
text: '{{ session('success') ?? session('error') }}',
});
</script>
@endif

<!--begin::App Main-->
<main class="app-main">
<div class="app-content-header">
<div class="container-fluid">
<div class="row">
<div class="col-sm-6">
<h3 class="mb-0">Profile</h3>
</div>
<div class="col-sm-6">
<ol class="breadcrumb float-sm-end">
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Profile</li>
</ol>
</div>
</div>
</div>
</div>

<div class="app-content">
<div class="container-fluid">
<div class="container rounded bg-white mt-5 mb-5">
<div class="row">
<div class="col-md-3 border-right">
<div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"><span class="font-weight-bold">Edogaru</span><span class="text-black-50">edogaru@mail.com.my</span><span> </span></div>
</div>
<div class="col-md-5 border-right">
<div class="p-3 py-5">
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="text-right">Profile Settings</h4>
</div>
<div class="row mt-2">
    <div class="col-md-6"><label class="labels">Name</label><input type="text" class="form-control" placeholder="first name" value=""></div>
    <div class="col-md-6"><label class="labels">Surname</label><input type="text" class="form-control" value="" placeholder="surname"></div>
</div>
<div class="row mt-3">
    <div class="col-md-12"><label class="labels">Mobile Number</label><input type="text" class="form-control" placeholder="enter phone number" value=""></div>
    <div class="col-md-12"><label class="labels">Address Line 1</label><input type="text" class="form-control" placeholder="enter address line 1" value=""></div>
    <div class="col-md-12"><label class="labels">Address Line 2</label><input type="text" class="form-control" placeholder="enter address line 2" value=""></div>
    <div class="col-md-12"><label class="labels">Postcode</label><input type="text" class="form-control" placeholder="enter address line 2" value=""></div>
    <div class="col-md-12"><label class="labels">State</label><input type="text" class="form-control" placeholder="enter address line 2" value=""></div>
    <div class="col-md-12"><label class="labels">Area</label><input type="text" class="form-control" placeholder="enter address line 2" value=""></div>
    <div class="col-md-12"><label class="labels">Email ID</label><input type="text" class="form-control" placeholder="enter email id" value=""></div>
    <div class="col-md-12"><label class="labels">Education</label><input type="text" class="form-control" placeholder="education" value=""></div>
</div>
<div class="row mt-3">
    <div class="col-md-6"><label class="labels">Country</label><input type="text" class="form-control" placeholder="country" value=""></div>
    <div class="col-md-6"><label class="labels">State/Region</label><input type="text" class="form-control" value="" placeholder="state"></div>
</div>
<div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="button">Save Profile</button></div>
</div>
</div>
<div class="col-md-4">
<div class="p-3 py-5">
<div class="d-flex justify-content-between align-items-center experience"><span>Edit Experience</span><span class="border px-3 p-1 add-experience"><i class="fa fa-plus"></i>&nbsp;Experience</span></div><br>
<div class="col-md-12"><label class="labels">Experience in Designing</label><input type="text" class="form-control" placeholder="experience" value=""></div> <br>
<div class="col-md-12"><label class="labels">Additional Details</label><input type="text" class="form-control" placeholder="additional details" value=""></div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</main>

<style>
body {
background: rgb(99, 39, 120)
}

.form-control:focus {
box-shadow: none;
border-color: #BA68C8
}

.profile-button {
background: rgb(99, 39, 120);
box-shadow: none;
border: none
}

.profile-button:hover {
background: #682773
}

.profile-button:focus {
background: #682773;
box-shadow: none
}

.profile-button:active {
background: #682773;
box-shadow: none
}

.back:hover {
color: #682773;
cursor: pointer
}

.labels {
font-size: 11px
}

.add-experience:hover {
background: #BA68C8;
color: #fff;
cursor: pointer;
border: solid 1px #BA68C8
}
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection --}}
