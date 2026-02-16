<!-- Main modal -->
<div id="ChangePassword" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
            <!-- Modal header -->
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    {{ __('users.change_password') }}
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-toggle="ChangePassword">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form action="{{ route('change_password') }}" method="POST">
                @csrf
                {{-- <div class="grid gap-4 mb-4 sm:grid-cols-1">
                    <div>
                        <label for="old_password" class="label_input">{{ __('users.old_password') }}</label>
                        <div class="relative">
                            <input type="password" name="old_password" id="old_password" class="input_text w-full"
                                placeholder="{{ __('users.old_password') }}" required>
                            <button type="button" onclick="togglePassword('old_password', this)"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400">
                                <svg class="h-5 w-5" fill="none" id="eye_icon_old_password" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label for="new_password" class="label_input">{{ __('users.new_password') }}</label>
                        <div class="relative">
                            <input type="password" name="new_password" id="new_password" class="input_text w-full"
                                placeholder="{{ __('users.new_password') }}" required>
                            <button type="button" onclick="togglePassword('new_password', this)"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400">
                                <svg class="h-5 w-5" fill="none" id="eye_icon_new_password" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label for="confirm_password" class="label_input">{{ __('users.confirm_password') }}</label>
                        <div class="relative">
                            <input type="password" name="confirm_password" id="confirm_password"
                                class="input_text w-full" placeholder="{{ __('users.confirm_password') }}" required>
                            <button type="button" onclick="togglePassword('confirm_password', this)"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400">
                                <svg class="h-5 w-5" fill="none" id="eye_icon_confirm_password" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div> --}}
                <div class="grid gap-4 mb-4 sm:grid-cols-1">
                    <div>
                        <label for="current_password" class="label_input">{{ __('users.old_password') }}</label>
                        <div class="relative">
                            <input type="password" name="current_password" id="current_password"
                                class="input_text w-full" required>
                            <button type="button" onclick="togglePassword('current_password', this)"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400">
                                <svg class="h-5 w-5" fill="none" id="eye_icon_old_password" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label for="new_password" class="label_input">{{ __('users.new_password') }}</label>
                        <div class="relative">
                            <input type="password" name="new_password" id="new_password" class="input_text w-full"
                                required>
                            <button type="button" onclick="togglePassword('new_password', this)"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400">
                                <svg class="h-5 w-5" fill="none" id="eye_icon_old_password" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label for="new_password_confirmation"
                            class="label_input">{{ __('users.confirm_password') }}</label>
                        <div class="relative">
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                class="input_text w-full" required>
                            <button type="button" onclick="togglePassword('new_password_confirmation', this)"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400">
                                <svg class="h-5 w-5" fill="none" id="eye_icon_old_password" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <button type="submit" class="submit_btn">
                    {{ __('menu.button.confirm') }}
                </button>
            </form>
        </div>
    </div>
</div>
<script>
    function togglePassword(inputId, button) {
        const input = document.getElementById(inputId);
        const svg = button.querySelector('svg');

        if (input.type === "password") {
            input.type = "text";
            // เปลี่ยนเป็นไอคอน "ปิดตา" (Eye-off)
            svg.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
</svg>
`;
        } else {
            input.type = "password";
            // เปลี่ยนกลับเป็นไอคอน "เปิดตา" (Eye)
            svg.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
</svg>
`;
        }
    }
</script>
<script type="module">
    document.addEventListener('DOMContentLoaded', function() {
        // ดักจับ Error จาก Validation ($request->validate)
        @if ($errors->any())
            Swal.fire({
                icon: 'warning',
                title: "{{ __('menu.is_warning') }}",
                html: '{!! implode('<br>', $errors->all()) !!}',
            });
        @endif

        // ดักจับ Success จากที่เรา with('swal_success', ...)
        @if (session('swal_success'))
            Swal.fire({
                icon: 'success',
                title: "{{ __('menu.is_success') }}",
                text: "{{ session('swal_success') }}",
                timer: 2500,
                showConfirmButton: false
            });
        @endif

        // ดักจับ Error จากที่เรา with('swal_error', ...)
        @if (session('swal_error'))
            Swal.fire({
                icon: 'error',
                title: "{{ __('menu.is_failed') }}",
                text: "{{ session('swal_error') }}",
            });
        @endif
    });
</script>
