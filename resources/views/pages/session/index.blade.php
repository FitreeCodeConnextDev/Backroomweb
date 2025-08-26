@extends('layouts.indexpage')
@section('title_page')
    Session index
@endsection
@section('index-title')
    Session index
@endsection
@section('table-section')
    <table class="table-data" id="session-table">
        <thead>
            <tr>
                <th scope="col"> User ID </th>
                <th scope="col"> User Name </th>
                <th scope="col"> IP ADDRESS </th>
                <th scope="col"> Session Status </th>
                <th scope="col"> Action </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($session_data as $session)
                @php
                    $lastLogin = $session->last_activity;
                    $timeDifference = \Carbon\Carbon::parse($lastLogin)->diffInMinutes(\Carbon\Carbon::now());
                    $time_config = env('SESSION_TIMEOUT', 30); // Default to 30 minutes if not set
                @endphp
                <tr>
                    <td>{{ $session->user_id }}</td>
                    <td>{{ $session->user_name }}</td>
                    <td>{{ $session->ip_address }}</td>
                    <td>
                        @if ($session->session_active != null)
                            @if ($timeDifference > $time_config)
                                {{-- <span class="font-semibold text-red-500">Session Time Out</span> --}}
                                <span
                                    class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full ">
                                    <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                    Session Time Out
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full ">
                                    <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                    Online
                                </span>
                            @endif
                        @else
                            <span
                                class="inline-flex items-center bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full ">
                                <span class="w-2 h-2 me-1 bg-gray-500 rounded-full"></span>
                                Offline
                            </span>
                        @endif
                    </td>
                    <td>
                        <button type="button" data-modal-target="session-detail-{{ $session->user_id }}"
                            data-modal-toggle="session-detail-{{ $session->user_id }}" class="show_button">
                            <svg class="w-[16px] h-[16px]" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </button>
                    </td>

                </tr>
                <div id="session-detail-{{ $session->user_id }}" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow-sm">
                            <!-- Modal header -->
                            <div
                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t  border-gray-200">
                                <h3 class="text-xl font-semibold text-gray-900 ">
                                    Detail Session of User ID: {{ $session->user_id }}
                                </h3>
                                <button type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                    data-modal-hide="session-detail-{{ $session->user_id }}">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="p-4 md:p-5 space-y-4">
                                <div class="flex flex-col space-x-2 space-y-1">
                                    <div>
                                        <span class="font-semibold">User ID:</span>
                                        <span>{{ $session->user_id }}</span>
                                    </div>
                                    <div>
                                        <span class="font-semibold">User Name:</span>
                                        <span>{{ $session->user_name }}</span>
                                    </div>
                                    <div>
                                        <span class="font-semibold">IP Address:</span>
                                        <span>{{ $session->ip_address }}</span>
                                    </div>
                                    <div>
                                        <span class="font-semibold">User Agent:</span>
                                        <span>{{ $session->user_agent }}</span>
                                    </div>
                                    <div class="flex space-x-2">
                                        <span class="font-semibold">Session Active:</span>
                                        <div>
                                            {{-- Check if session_active is not null --}}
                                            @if ($session->session_active != null)
                                                <span
                                                    class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full ">
                                                    <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                                    Active
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full ">
                                                    <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                                    Inactive
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        <span class="font-semibold">Login At:</span>
                                        <span>{{ $session->login_at }}</span>
                                    </div>

                                    <div>
                                        <span class="font-semibold">Session Status:</span>
                                        @if ($session->session_active != null)
                                            @if ($timeDifference > $time_config)
                                                <span
                                                    class="inline-flex items-center bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full ">
                                                    <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                                                    Session Time Out
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full ">
                                                    <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                                    Online
                                                </span>
                                            @endif
                                        @else
                                            <span
                                                class="inline-flex items-center bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full ">
                                                <span class="w-2 h-2 me-1 bg-gray-500 rounded-full"></span>
                                                Offline
                                            </span>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
            @endforeach
        </tbody>
    </table>
@endsection
