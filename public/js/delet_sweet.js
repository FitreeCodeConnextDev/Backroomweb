document.querySelectorAll('.del-button').forEach(button => {
    button.addEventListener('click', function (e) {
        e.preventDefault();
        const itemId = this.getAttribute('data-item-id');
        const itemName = this.getAttribute('data-name');
        const form = document.getElementById(`delete-form-${itemId}`);
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "alert_confirm_btn",
                cancelButton: "alert_cancel_btn"
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: "คุณแน่ใจเหรอ?",
            html: `ว่าจะลบ <b>` + itemName + `</b>`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "ใช่ ลบเลย",
            cancelButtonText: "ไม่ ยกเลิก!",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Swal.fire({
                //     title: "ลบแล้ว!",
                //     html: `ข้อมูลถูกลบแล้ว`,
                //     icon: "success"
                // });
                form.submit(); // Submit the form to delete the item
            }
        });
    });
});
