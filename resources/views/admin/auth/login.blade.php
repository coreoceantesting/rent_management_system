<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SRA</title>
        <link rel="shortcut icon" href="{{ asset('admin/images/Group 1 copy 2.png') }}">
        <link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body{
                background-color: #f0f8ff;
                overflow-x: hidden;
            }

            .bg-img{
                background-image: url('{{ asset('admin/images/Slum Rehabilitation Authority renter.jpg') }}');
                background-repeat: no-repeat;
                background-position: 0%;
                background-size: cover;
                content: "";
                height: 100vh;
            }
            .right-content-div{
                background: #284db2;
                color: #fff;
                padding: 3% 2%;
                text-align: center;
                margin: 0% 10%;
                font-size: 18px;
                font-weight: 800;
                border-radius: 10px;
            }
            .custompadding{
                padding: 5% 10%;
            }

            .form-control{
                padding: 10px;
                border: 1px solid #2b5de4;
            }

            @media only screen and (min-width: 1200px) {
                .bg-img {
                    background-position: 1%;
                }
            }

            @media only screen and (max-width: 1999px) {
                .bg-img {
                    background-position: 1%;
                }
            }

            @media only screen and (max-width: 1115px) {
                .bg-img {
                    background-position: 16%;
                }
            }

            @media only screen and (max-width: 1060px) {
                .bg-img {
                    background-position: 24%;
                }
            }

            @media only screen and (max-width: 992px) {
                .bg-img {
                    background-position: 30%;
                }
            }

            @media only screen and (max-width: 767px) {
                .bg-img {
                    background-image: none;
                    background-color: #fff;
                    height: auto;
                    display: flex: 
                    justify-content: center;
                }

                .mobile-view-bgcolor{
                    background-color: #234cb3;
                }

                .mobile-view-bgcolor, body{
                    background-color: #234cb3;
                }

                .form-control{
                    padding: 10px;
                    background-color: #fff;
                    border: 1px solid #fff;
                }

                .form-label, .form-check-label{
                    color: #fff;
                }

                #loginForm_submit{
                    background-color: #fff;
                    color: #234cb3;
                    font-weight: 900;
                    font-size: 18px;
                    width : 50% !important;
                }

                .textSignup{
                    color: #fff!important;
                }
            }
        </style>
    </head>
    <body>
        <section class="">
            <div class="container-flud">
                <div class="row">
                    <div class="bg-img col-lg-6 col-md-6 col-12 d-flex justify-content-center">
                        <img class="d-md-none d-lg-none d-xl-none d-sm-block d-block mt-4" src="{{ asset('admin/images/Group 1 copy 2.png') }}" style="width: 300px;">
                    </div>
                    <div class="col-lg-6 col-md-6 col-12 d-md-none d-lg-none d-xl-none d-sm-block d-block mobile-view-bgcolor">
                        <img src="{{ asset('admin/images/banner.jpg') }}" style="width: 100%" alt="">
                    </div>
                    <div class="col-lg-6 col-md-6 col-12 mobile-view-bgcolor">
                        <div class="d-flex justify-content-center mt-3">
                            <img src="{{ asset('admin/images/Group 1 copy 2.png') }}" style="width: 50%;">
                        </div>
                        <div class="text-center mt-3">
                            <h2><b>Disbursement Management System</b></h2>
                        </div>
                        <div class="text-center mt-3">
                            <h4>लॉगिन मध्ये आपले स्वागत आहे </h4>
                        </div>
                        <div class="container custompadding">
                            <form id="loginForm">
                                @csrf
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username (वापरकर्तानाव)</label>
                                    <input type="text" class="form-control" name="username" id="username" placeholder="Enter username">
                                    <span class="text-danger is-invalid username_err"></span>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="password-input">Password (पासवर्ड)</label>
                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                        <input type="password" class="form-control pe-5 password-input" placeholder="Enter password" id="password" name="password" >
                                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                    </div>
                                    <span class="text-danger is-invalid password_err"></span>
                                </div>

                                <div class="mt-4 text-center">
                                    <button class="btn btn-primary w-40" type="submit" id="loginForm_submit">Sign In</button>
                                    <p class="mt-3">Don't Have An Account ? <a class="text-primary signUp" style="cursor: pointer;"> Signup </a> </small>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Signup Modal -->
                    <div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="signupModalLabel">Signup For Contractor</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="signupForm">
                                        @csrf
                                        <!-- Form Fields -->
                                        <div class="mb-1 row">

                                            <div class="col-md-6 mt-2">
                                                <label class="col-form-label" for="name">User Name <span class="text-danger">*</span></label>
                                                <input class="form-control" id="name" name="name" type="text" placeholder="Enter User Name">
                                                <span class="text-danger is-invalid name_err"></span>
                                            </div>
                
                                            <div class="col-md-6 mt-2">
                                                <label class="col-form-label" for="email">User Email <span class="text-danger">*</span></label>
                                                <input class="form-control" id="email" name="email" type="email" placeholder="Enter User Email">
                                                <span class="text-danger is-invalid email_err"></span>
                                            </div>
                
                                            <div class="col-md-6 mt-2">
                                                <label class="col-form-label" for="mobile">User Mobile <span class="text-danger">*</span></label>
                                                <input class="form-control" name="mobile" type="number" min="0" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"
                                                    placeholder="Enter User Mobile">
                                                <span class="text-danger is-invalid mobile_err"></span>
                                            </div>
                
                                            <div class="col-md-6 mt-2">
                                                <label class="col-form-label" for="ward">Ward <span class="text-danger">*</span></label>
                                                <input class="form-control" id="ward" name="ward" type="text" placeholder="Enter Ward">
                                                <span class="text-danger is-invalid ward_err"></span>
                                            </div>
                
                                            <div class="col-md-6 mt-2">
                                                <label class="col-form-label" for="area">Area<span class="text-danger">*</span></label>
                                                <input class="form-control" id="area" name="area" type="text" placeholder="Enter Area">
                                                <span class="text-danger is-invalid area_err"></span>
                                            </div>
                
                                            <div class="col-md-6 mt-2">
                                                <label class="col-form-label" for="password">Password <span class="text-danger">*</span></label>
                                                <input class="form-control" id="password" name="password" type="password" placeholder="********">
                                                <span class="text-danger is-invalid password_err"></span>
                                            </div>
                
                                            <div class="col-md-6 mt-2">
                                                <label class="col-form-label" for="confirm_password">Confirm Password <span class="text-danger">*</span></label>
                                                <input class="form-control" id="confirm_password" name="confirm_password" type="password" placeholder="********">
                                                <span class="text-danger is-invalid confirm_password_err"></span>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary mt-2" id="submitForm">SignUp</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </section>

        <script src="{{ asset('admin/js/jquery.min.js') }}" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="{{ asset('admin/js/sweetalert.min.js') }}" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            $("#loginForm").submit(function(e) {
                e.preventDefault();
                $("#loginForm_submit").prop('disabled', true);
                var formdata = new FormData(this);
                $.ajax({
                    url: '{{ route('signin') }}',
                    type: 'POST',
                    data: formdata,
                    contentType: false,
                    processData: false,
                    beforeSend: function()
                    {
                        $('#preloader').css('opacity', '0.5');
                        $('#preloader').css('visibility', 'visible');
                    },
                    success: function(data) {
                        if (!data.error && !data.error2) {
                                window.location.href = '{{ route('dashboard') }}';
                        } else {
                            if (data.error2) {
                                swal("Error!", data.error2, "error");
                                $("#loginForm_submit").prop('disabled', false);
                            } else {
                                $("#loginForm_submit").prop('disabled', false);
                                resetErrors();
                                printErrMsg(data.error);
                            }
                        }
                    },
                    error: function(error) {
                        $("#loginForm_submit").prop('disabled', false);
                    },
                    statusCode: {
                        422: function(responseObject, textStatus, jqXHR) {
                            $("#addSubmit").prop('disabled', false);
                            resetErrors();
                            printErrMsg(responseObject.responseJSON.errors);
                        },
                        500: function(responseObject, textStatus, errorThrown) {
                            $("#addSubmit").prop('disabled', false);
                            swal("Error occured!", "Something went wrong please try again", "error");
                        }
                    },
                    complete: function() {
                        $('#preloader').css('opacity', '0');
                        $('#preloader').css('visibility', 'hidden');
                    },
                });

                function resetErrors() {
                    var form = document.getElementById('loginForm');
                    var data = new FormData(form);
                    for (var [key, value] of data) {
                        console.log(key, value)
                        $('.' + key + '_err').text('');
                        $('#' + key).removeClass('is-invalid');
                        $('#' + key).addClass('is-valid');
                    }
                }

                function printErrMsg(msg) {
                    $.each(msg, function(key, value) {
                        console.log(key);
                        $('.' + key + '_err').text(value);
                        $('#' + key).addClass('is-invalid');
                    });
                }

            });
        </script>

        <script>
            $(document).ready(function() {
                $('.signUp').click(function() {
                    $('#signupModal').modal('show');
                    // alert('hii');
                });
            });
        </script>

        {{-- submit signup Form --}}
        <script>
            $("#signupForm").submit(function(e) {
                e.preventDefault();
                // $("#submitForm").prop('disabled', true);

                var formdata = new FormData(this);
                $.ajax({
                    url: '{{ route('storeRegistration') }}',
                    type: 'POST',
                    data: formdata,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $("#submitForm").prop('disabled', false);
                        if (!data.error2)
                            swal("Successful!", data.success, "success")
                            .then((action) => {
                                window.location.reload();
                            });
                        else
                            swal("Error!", data.error2, "error");
                    },
                    statusCode: {
                        422: function(responseObject, textStatus, jqXHR) {
                            $("#addSubmit").prop('disabled', false);
                            resetErrors();
                            printErrMsg(responseObject.responseJSON.errors);
                        },
                        500: function(responseObject, textStatus, errorThrown) {
                            $("#addSubmit").prop('disabled', false);
                            swal("Error occured!", "Something went wrong please try again", "error");
                        }
                    }
                });

                function resetErrors() {
                    var form = document.getElementById('loginForm');
                    var data = new FormData(form);
                    for (var [key, value] of data) {
                        console.log(key, value)
                        $('.' + key + '_err').text('');
                        $('#' + key).removeClass('is-invalid');
                        $('#' + key).addClass('is-valid');
                    }
                }

                function printErrMsg(msg) {
                    $.each(msg, function(key, value) {
                        console.log(key);
                        $('.' + key + '_err').text(value);
                        $('#' + key).addClass('is-invalid');
                    });
                }

            });
        </script>
    </body>
</html>