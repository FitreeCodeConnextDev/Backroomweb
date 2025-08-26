document.addEventListener('DOMContentLoaded', function () {
    // เลือกทุกฟอร์มที่มีคลาส 'vendor_rabbit_form'
    const forms = document.querySelectorAll('.tabs_form');

    forms.forEach(function (form) {
        const saveButton = form.querySelector('.saveButton');

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            submitForm(form, saveButton);
        });
    });

    function submitForm(form, saveButton) {
        // Disable submit button to prevent double submission
        saveButton.disabled = true;

        // Get form data
        const formData = new FormData(form);

        // Get the form action URL
        const url = form.getAttribute('action');

        // Show loading state
        saveButton.innerHTML = 'กำลังบันทึก...';

        // Make Ajax request
        fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                credentials: 'same-origin'
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Show success message without confirmButtonText
                    Swal.fire({
                        icon: 'success',
                        title: data.message ||'บันทึกสำเร็จ',
                        showConfirmButton: false,
                        timer: 1000,
                    }).then(() => {
                        // Optionally reload page or update UI
                        window.location.reload();
                    });
                } else {
                    throw new Error(data.message || 'เกิดข้อผิดพลาดในการบันทึกข้อมูล');
                }
            })
            .catch(error => {
                // Show error message
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: error.message || 'กรุณาลองใหม่อีกครั้ง',
                });
            })
            .finally(() => {
                // Re-enable submit button and restore original text
                saveButton.disabled = false;
                saveButton.innerHTML = document.querySelector('button.submit_btn').textContent;
            });
    }
});
