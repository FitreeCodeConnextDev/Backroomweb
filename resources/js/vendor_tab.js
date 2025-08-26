document.addEventListener("DOMContentLoaded", function () {
    // เมื่อหน้าโหลดเสร็จแล้ว
    const tabs = document.querySelectorAll('.tab_button');
    
    // เช็คว่าใน localStorage มีการบันทึก tab ไว้หรือไม่
    const activeTabId = localStorage.getItem('activeTab');
    if (activeTabId) {
        // ถ้ามีการบันทึก tab ไว้ ให้เปิด tab นั้น
        const activeTab = document.getElementById(activeTabId);
        if (activeTab) {
            activeTab.setAttribute('aria-selected', 'true');
            const targetTab = document.querySelector(activeTab.getAttribute('data-tabs-target'));
            targetTab.classList.remove('hidden');
        }
    }

    tabs.forEach(tab => {
        tab.addEventListener('click', function () {
            // เมื่อผู้ใช้คลิก tab จะบันทึก tab ที่เลือก
            localStorage.setItem('activeTab', tab.id);
            
            // ปิด tab ทั้งหมด
            document.querySelectorAll('.tab_button').forEach(button => {
                button.setAttribute('aria-selected', 'false');
                const targetTab = document.querySelector(button.getAttribute('data-tabs-target'));
                targetTab.classList.add('hidden');
            });

            // เปิด tab ที่เลือก
            tab.setAttribute('aria-selected', 'true');
            const target = document.querySelector(tab.getAttribute('data-tabs-target'));
            target.classList.remove('hidden');
        });
    });
});
