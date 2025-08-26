// ฟังก์ชันเก็บข้อมูลลง LocalStorage เมื่อผู้ใช้กรอกข้อมูล
function SaveToLocal() {
    const vendorForm = {
        branch_id: document.getElementById('branch_id').value,
        term_id: document.getElementById('term_id').value,
        term_seq: document.getElementById('term_seq').value,
        issuedate: document.getElementById('issuedate').value,
        validdate: document.getElementById('validdate').value,
        vendor_name: document.getElementById('vendor_name').value,
        vendor_food: document.getElementById('vendor_food').value,
        vendorno: document.getElementById('vendorno').value,
        productno: document.getElementById('productno').value,
        owner_shop: document.getElementById('owner_shop').value,
        txnno: document.getElementById('txnno').value,
        vendor_batchno: document.getElementById('vendor_batchno').value,
        billcount: document.getElementById('billcount').value
    };
    localStorage.setItem('vendorForm', JSON.stringify(vendorForm));
}

// ฟังก์ชันโหลดข้อมูลจาก LocalStorage
function LoadFromLocal() {
    const vendorForm = JSON.parse(localStorage.getItem('vendorForm'));
    if (vendorForm) {
        document.getElementById('branch_id').value = vendorForm.branch_id;
        document.getElementById('term_id').value = vendorForm.term_id;
        document.getElementById('term_seq').value = vendorForm.term_seq;
        document.getElementById('issuedate').value = vendorForm.issuedate;
        document.getElementById('validdate').value = vendorForm.validdate;
        document.getElementById('vendor_name').value = vendorForm.vendor_name;
        document.getElementById('vendor_food').value = vendorForm.vendor_food;
        document.getElementById('vendorno').value = vendorForm.vendorno;
        document.getElementById('productno').value = vendorForm.productno;
        document.getElementById('owner_shop').value = vendorForm.owner_shop;
        document.getElementById('txnno').value = vendorForm.txnno;
        document.getElementById('vendor_batchno').value = vendorForm.vendor_batchno;
        document.getElementById('billcount').value = vendorForm.billcount;
    }
}


// เรียกฟังก์ชันเมื่อหน้าเว็บโหลด
window.onload = LoadFromLocal;


function back() {
    localStorage.clear();
}
