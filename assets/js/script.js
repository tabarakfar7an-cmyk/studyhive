// تأكيد الحذف لأي نموذج يحمل data-confirm
document.addEventListener('submit', function (e) {
    var msg = e.target.getAttribute('data-confirm');
    if (msg && !window.confirm(msg)) { e.preventDefault(); }
});

// عدّاد أحرف لأي textarea يحمل data-counter
document.querySelectorAll('textarea[data-counter]').forEach(function (ta) {
    var out = document.getElementById(ta.getAttribute('data-counter'));
    if (!out) return;
    var max = ta.getAttribute('maxlength');
    function upd() { out.textContent = ta.value.length + ' / ' + max; }
    ta.addEventListener('input', upd); upd();
});

// تصفية فورية لجدول/قائمة العناصر (data-filter-input="#id" على الحقل و data-filter-item على العناصر)
document.querySelectorAll('[data-filter-input]').forEach(function (inp) {
    inp.addEventListener('input', function () {
        var v = inp.value.trim().toLowerCase();
        document.querySelectorAll(inp.getAttribute('data-filter-input')).forEach(function (el) {
            el.style.display = el.textContent.toLowerCase().indexOf(v) > -1 ? '' : 'none';
        });
    });
});
