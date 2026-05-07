@extends('layouts.indexpage')
@section('title_page')
    {{ __('menu.restore') }}
@endsection
@section('index-title')
    {{ __('menu.restore_data') }}
@endsection
@section('table-section')
    <div class="mt-4 border-b border-gray-200">

        <!-- ปุ่มสำหรับกด Restore ข้อมูล -->
        @if (!session('successs'))
            <form id="restoreForm" action="{{ route('restore_data') }}" method="POST" class="mb-4">
                @csrf
                <button type="button" class="submit_btn" onclick="confirmRestore()">
                    {{ __('menu.restore') }}
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
                        <strong>{{ __('menu.restore_detail') }}</strong>
                    </div>
                    <div class="card-body p-0">
                        <table class="table-data">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('menu.restore_no') }}</th>
                                    <th scope="col">{{ __('menu.restore_table_name') }}</th>
                                    <th scope="col">{{ __('menu.restore_restored_count') }}</th>
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
                                            @if ($summary['restored_count'] > 0)
                                                <span class="badge bg-success">{{ $summary['restored_count'] }}</span>
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
                                        <strong>{{ __('menu.restore_total_restored_record') }}</strong>
                                    </td>
                                    <td class="text-center">
                                        <strong>{{ session('total_restored') }}</strong>
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
        function confirmRestore() {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "alert_confirm_btn",
                    cancelButton: "alert_cancel_btn"
                },
                buttonsStyling: false
            });
            swalWithBootstrapButtons.fire({
                title: '{{ __('menu.confirm_restore') }}',
                text: "{{ __('menu.confirm_restore_text') }}",
                icon: 'warning',

                showCancelButton: true,
                confirmButtonText: '{{ __('menu.yes_proceed') }}',
                cancelButtonText: '{{ __('menu.restore_cancel') }}',
                reverseButtons: true // สลับตำแหน่งปุ่มยกเลิกกับปุ่มยืนยัน (Option)
            }).then((result) => {
                if (result.isConfirmed) {
                    // ถ้ากดยืนยัน ให้แสดง Loading ก่อน Submit ป้องกันการกดเบิ้ล
                    Swal.fire({
                        title: '{{ __('menu.is_processing') }}',
                        text: '{{ __('menu.is_loading') }}',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // สั่ง Submit Form
                    document.getElementById('restoreForm').submit();
                }
            });
        }
    </script>
@endpush
