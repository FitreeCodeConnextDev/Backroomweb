function saveToLocalStorage() {
    const formData = {
        promo_code: document.getElementById('promo_code').value,
        promo_desc: document.getElementById('promo_desc').value,
        promo_seq: document.getElementById('promo_seq').value,
        start_date: document.getElementById('start_date').value,
        end_date: document.getElementById('end_date').value,
        start_time: document.getElementById('start_time').value,
        end_time: document.getElementById('end_time').value,
        expense_owner: document.getElementById('expense_owner').checked,
        req_refno: document.getElementById('req_refno').checked,
        buy_amt: document.getElementById('buy_amt').value,
        get_amt: document.getElementById('get_amt').value,
        get_point: document.getElementById('get_point').value,
        adj_amt: document.getElementById('adj_amt').value,
        adjget_amt: document.getElementById('adjget_amt').value,
        adjget_point: document.getElementById('adjget_point').value,
        promo_topup_verify: document.getElementById('promo_topup_verify').checked,
        days: {
            mon_day: document.getElementById('mon_day').checked,
            tue_day: document.getElementById('tue_day').checked,
            wed_day: document.getElementById('wed_day').checked,
            thu_day: document.getElementById('thu_day').checked,
            fri_day: document.getElementById('fri_day').checked,
            sat_day: document.getElementById('sat_day').checked,
            sun_day: document.getElementById('sun_day').checked
        },
        expire_day: document.getElementById('expire_day').value,
        pio_rity: document.getElementById('pio_rity').value,
        deposit: document.getElementById('deposit').value,
        expire_checkby: document.getElementById('expire_checkby').value
    };

    // Save the entire object to localStorage
    localStorage.setItem('formData', JSON.stringify(formData));
}


// Function to load form data from local storage
function loadFromLocalStorage() {
    const formData = JSON.parse(localStorage.getItem('formData'));

    if (formData) {
        document.getElementById('promo_code').value = formData.promo_code || '';
        document.getElementById('promo_desc').value = formData.promo_desc || '';
        document.getElementById('promo_seq').value = formData.promo_seq || '';
        document.getElementById('start_date').value = formData.start_date || '';
        document.getElementById('end_date').value = formData.end_date || '';
        document.getElementById('start_time').value = formData.start_time || '';
        document.getElementById('end_time').value = formData.end_time || '';
        document.getElementById('expense_owner').checked = formData.expense_owner || false;
        document.getElementById('req_refno').checked = formData.req_refno || false;
        document.getElementById('buy_amt').value = formData.buy_amt || '';
        document.getElementById('get_amt').value = formData.get_amt || '';
        document.getElementById('get_point').value = formData.get_point || '';
        document.getElementById('adj_amt').value = formData.adj_amt || '';
        document.getElementById('adjget_amt').value = formData.adjget_amt || '';
        document.getElementById('adjget_point').value = formData.adjget_point || '';
        document.getElementById('promo_topup_verify').checked = formData.promo_topup_verify || false;

        // Set days checkboxes
        document.getElementById('mon_day').checked = formData.days.mon_day || false;
        document.getElementById('tue_day').checked = formData.days.tue_day || false;
        document.getElementById('wed_day').checked = formData.days.wed_day || false;
        document.getElementById('thu_day').checked = formData.days.thu_day || false;
        document.getElementById('fri_day').checked = formData.days.fri_day || false;
        document.getElementById('sat_day').checked = formData.days.sat_day || false;
        document.getElementById('sun_day').checked = formData.days.sun_day || false;

        document.getElementById('expire_day').value = formData.expire_day || '';
        document.getElementById('pio_rity').value = formData.pio_rity || '';
        document.getElementById('deposit').value = formData.deposit || '';
        document.getElementById('expire_checkby').value = formData.expire_checkby || '';
        document.getElementById('print_start').value = formData.start_date || '';
        document.getElementById('print_end').value = formData.end_date || '';
        document.getElementById('print_promo_code').value = formData.promo_code || '';

    }
}


// Add event listeners
document.getElementById('promo_form').addEventListener('input', saveToLocalStorage);

// Load data from localStorage on page load
window.addEventListener('load', loadFromLocalStorage);



document.getElementById('submit_button').addEventListener('click', function () {
    // event.preventDefault(); // ป้องกันไม่ให้ฟอร์มถูกส่ง
    localStorage.clear();
    // ทำการ submit ฟอร์มที่นี่ถ้าต้องการ (เช่น เรียกใช้ฟังก์ชัน submit)
    // document.getElementById('promo_form').submit();
});
document.getElementById('cancel_button').addEventListener('click', function () {
    // ล้าง localStorage เมื่อกดปุ่ม cancel
    localStorage.clear();
});
document.getElementById('index_page').addEventListener('click', function () {
    // ล้าง localStorage เมื่อกดปุ่ม cancel
    localStorage.clear();
});


function handleSelectChange() {
    var selectedValue = document.getElementById("expire_checkby").value;
    var weekday = document.getElementById("weekday");
    var date_input = document.getElementById("date_input");

    // เปรียบเทียบค่าที่เลือกจาก <select>
    if (selectedValue === "4") {
        weekday.style.display = "block";
        date_input.style.display = "none";
    } else if (selectedValue === "5") {
        weekday.style.display = "none";
        date_input.style.display = "block";
    } else {
        weekday.style.display = "none";
        date_input.style.display = "none";
    }
}

