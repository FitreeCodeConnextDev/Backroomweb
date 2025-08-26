<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anuphan:wght@100..700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('logo/CodeConnextLogo.png') }}">
    <title>LOGIN | Backroom</title>
</head>
<style>
    body {
        font-family: 'Anuphan', sans-serif;
    }
</style>

<body>
    <section class="login_bg">
        <div class="log_2">
            <div class="w-full bg-gray-50 rounded-lg shadow  md:mt-0 sm:max-w-md xl:p-0">
                <div class="log_3">

                    <h1 class="title">
                        {{-- Welcome, {{ $database->user_name }} --}}
                    </h1>
                    <form class="space-y-4 md:space-y-6" id="login-form" method="post">
                        @csrf
                        <div>
                            <label for="user_id" class="login-label">{{ __('menu.input.username') }}</label>
                            <input type="text" name="user_id" id="user_id" class="login-input "
                                value="{{ old('user_id') }}" required="">
                        </div>
                        <div>
                            <label for="user_pass" class="login-label">{{ __('menu.input.password') }}</label>
                            <input type="password" name="user_pass" id="user_pass" placeholder="••••••••"
                                class="login-input" required="">
                        </div>
                        <button type="submit" class="login-btn"> {{ __('menu.button.login') }} </button>

                    </form>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#login-form').on('submit', function(e) {
                e.preventDefault(); // Prevent the form from submitting the traditional way

                // Show the loading spinner
                // $('#loading-spinner').show();

                // Get the form data
                var formData = $(this).serialize();

                // Send AJAX request to login route
                $.ajax({
                    url: '{{ route('login') }}', // Use your login route here
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        // $('#loading-spinner').hide();
                        if (response.success) {
                            Swal.fire({
                                title: 'Loading...',
                                html: 'โปรดรอสักครู่...',
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading()
                                }
                            });
                            window.location.href = '{{ route('checkPermiss') }}';
                        } else {
                            // Handle errors or show a message to the user
                            Swal.fire({
                                title: 'การเข้าสู่ระบบล้มเหลว',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'ตกลง'
                            });
                        }
                    },
                    error: function(xhr, status, error) {

                        // If the error response is JSON, parse it and show the message
                        var response = xhr.responseJSON || {};
                        var errorMessage = response.message ||
                            'เกิดข้อผิดพลาดที่ไม่คาดคิด โปรดลองอีกครั้งในภายหลัง';

                        // Show error using SweetAlert2
                        Swal.fire({
                            title: 'Error',
                            text: errorMessage,
                            icon: 'error',
                            showConfirmButton: false,
                            timer: 3000,
                        });
                    }
                });
            });
        });
    </script>

</body>

</html>
