@extends('layouts.indexpage')
@section('title_page')
    {{ __('menu.clear_data') }}
@endsection
@section('index-title')
    {{ __('menu.clear_data_text') }}
@endsection
@section('table-section')
    <div class="mt-4 border-b border-gray-200">

        <!-- ปุ่มสำหรับกด Restore ข้อมูล -->
        @if (!session('successs'))
            <form id="clearForm" action="{{ route('clear_data') }}" method="POST" class="mb-4">
                @csrf
                <button type="button" class="submit_btn" onclick="confirmClear()">
                    {{ __('menu.clear_data') }}
                </button>
            </form>
        @endif
        <!-- แจ้งเตือนกรณี Error -->
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- แสดงผลเมื่อทำงานสำเร็จและมีข้อมูลสรุปส่งมา -->
        @if (session('successs'))

            <!-- ตารางแสดง List ว่า Table ไหนกู้คืนไปกี่ Record -->
            @if (session('summary_list'))
                <div class="card">
                    <div class="my-2">
                        <strong>{{ __('menu.clear_detail') }}</strong>
                    </div>
                    <div class="card-body p-0">
                        <table class="table-data">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('menu.clear_no') }}</th>
                                    <th scope="col">{{ __('menu.clear_table_name') }}</th>
                                    <th scope="col">{{ __('menu.clear_cleared_count') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (session('summary_list') as $index => $summary)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            {{ $summary['table_name'] }}
                                        </td>
                                        <td>
                                            @if ($summary['deleted_count'] > 0)
                                                <span class="badge bg-success">{{ $summary['deleted_count'] }}</span>
                                            @else
                                                <span class="badge bg-secondary">0</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="text-end">
                                        <strong>{{ __('menu.clear_total_cleared_record') }}</strong>
                                    </td>
                                    <td class="text-center">
                                        <strong>{{ session('total_cleared') }}</strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            @endif
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        function confirmClear() {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "alert_confirm_btn",
                    cancelButton: "alert_cancel_btn"
                },
                buttonsStyling: false
            });
            swalWithBootstrapButtons.fire({
                title: '{{ __('menu.confirm_clear_data') }}',
                text: '{{ __('menu.confirm_clear_data_text') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '{{ __('menu.yes_proceed') }}',
                cancelButtonText: '{{ __('menu.restore_cancel') }}',
                reverseButtons: true // สลับตำแหน่งปุ่มยกเลิกกับปุ่มยืนยัน (Option)
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('clearForm').submit();
                }
            })
        }
    </script>
@endpush
