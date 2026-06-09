// app.js - Custom JavaScript untuk Aplikasi Laundry Online

// Konfirmasi sebelum hapus
document.addEventListener('DOMContentLoaded', function () {
    // Auto-hide alert setelah 3 detik (jika ada)
    const alerts = document.querySelectorAll('.alert-dismissible');
    alerts.forEach(function (alert) {
        setTimeout(function () {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            if (bsAlert) bsAlert.close();
        }, 3000);
    });
});
