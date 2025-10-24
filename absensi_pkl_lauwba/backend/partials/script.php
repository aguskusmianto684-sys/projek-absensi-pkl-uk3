<!-- Custom template | don't include it in your project! -->
<div class="custom-template">
    <div class="title">Settings</div>
    <div class="custom-content">
        <div class="switcher">
            <div class="switch-block">
                <h4>Logo Header</h4>
                <div class="btnSwitch">
                    <button
                        type="button"
                        class="selected changeLogoHeaderColor"
                        data-color="dark"></button>
                    <button
                        type="button"
                        class="changeLogoHeaderColor"
                        data-color="blue"></button>
                    <button
                        type="button"
                        class="changeLogoHeaderColor"
                        data-color="purple"></button>
                    <button
                        type="button"
                        class="changeLogoHeaderColor"
                        data-color="light-blue"></button>
                    <button
                        type="button"
                        class="changeLogoHeaderColor"
                        data-color="green"></button>
                    <button
                        type="button"
                        class="changeLogoHeaderColor"
                        data-color="orange"></button>
                    <button
                        type="button"
                        class="changeLogoHeaderColor"
                        data-color="red"></button>
                    <button
                        type="button"
                        class="changeLogoHeaderColor"
                        data-color="white"></button>
                    <br />
                    <button
                        type="button"
                        class="changeLogoHeaderColor"
                        data-color="dark2"></button>
                    <button
                        type="button"
                        class="changeLogoHeaderColor"
                        data-color="blue2"></button>
                    <button
                        type="button"
                        class="changeLogoHeaderColor"
                        data-color="purple2"></button>
                    <button
                        type="button"
                        class="changeLogoHeaderColor"
                        data-color="light-blue2"></button>
                    <button
                        type="button"
                        class="changeLogoHeaderColor"
                        data-color="green2"></button>
                    <button
                        type="button"
                        class="changeLogoHeaderColor"
                        data-color="orange2"></button>
                    <button
                        type="button"
                        class="changeLogoHeaderColor"
                        data-color="red2"></button>
                </div>
            </div>
            <div class="switch-block">
                <h4>Navbar Header</h4>
                <div class="btnSwitch">
                    <button
                        type="button"
                        class="changeTopBarColor"
                        data-color="dark"></button>
                    <button
                        type="button"
                        class="changeTopBarColor"
                        data-color="blue"></button>
                    <button
                        type="button"
                        class="changeTopBarColor"
                        data-color="purple"></button>
                    <button
                        type="button"
                        class="changeTopBarColor"
                        data-color="light-blue"></button>
                    <button
                        type="button"
                        class="changeTopBarColor"
                        data-color="green"></button>
                    <button
                        type="button"
                        class="changeTopBarColor"
                        data-color="orange"></button>
                    <button
                        type="button"
                        class="changeTopBarColor"
                        data-color="red"></button>
                    <button
                        type="button"
                        class="selected changeTopBarColor"
                        data-color="white"></button>
                    <br />
                    <button
                        type="button"
                        class="changeTopBarColor"
                        data-color="dark2"></button>
                    <button
                        type="button"
                        class="changeTopBarColor"
                        data-color="blue2"></button>
                    <button
                        type="button"
                        class="changeTopBarColor"
                        data-color="purple2"></button>
                    <button
                        type="button"
                        class="changeTopBarColor"
                        data-color="light-blue2"></button>
                    <button
                        type="button"
                        class="changeTopBarColor"
                        data-color="green2"></button>
                    <button
                        type="button"
                        class="changeTopBarColor"
                        data-color="orange2"></button>
                    <button
                        type="button"
                        class="changeTopBarColor"
                        data-color="red2"></button>
                </div>
            </div>
            <div class="switch-block">
                <h4>Sidebar</h4>
                <div class="btnSwitch">
                    <button
                        type="button"
                        class="changeSideBarColor"
                        data-color="white"></button>
                    <button
                        type="button"
                        class="selected changeSideBarColor"
                        data-color="dark"></button>
                    <button
                        type="button"
                        class="changeSideBarColor"
                        data-color="dark2"></button>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- End Custom template -->
</div>
<!--   Core JS Files   -->
<script src="../../template_admin/assets/js/core/jquery-3.7.1.min.js"></script>
<script src="../../template_admin/assets/js/core/popper.min.js"></script>
<script src="../../template_admin/assets/js/core/bootstrap.min.js"></script>

<!-- jQuery Scrollbar -->
<script src="../../template_admin/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

<!-- Chart JS -->
<script src="../../template_admin/assets/js/plugin/chart.js/chart.min.js"></script>

<!-- jQuery Sparkline -->
<script src="../../template_admin/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

<!-- Chart Circle -->
<script src="../../template_admin/assets/js/plugin/chart-circle/circles.min.js"></script>

<!-- Datatables -->
<script src="../../template_admin/assets/js/plugin/datatables/datatables.min.js"></script>

<!-- Bootstrap Notify -->
<script src="../../template_admin/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

<!-- jQuery Vector Maps -->
<script src="../../template_admin/assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
<script src="../../template_admin/assets/js/plugin/jsvectormap/world.js"></script>

<!-- Sweet Alert -->
<script src="../../template_admin/assets/js/plugin/sweetalert/sweetalert.min.js"></script>

<!-- Kaiadmin JS -->
<script src="../../template_admin/assets/js/kaiadmin.min.js"></script>



<!-- Kaiadmin DEMO methods, don't include it in your project! -->

<script>
    $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#177dff",
        fillColor: "rgba(23, 125, 255, 0.14)",
    });

    $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#f3545d",
        fillColor: "rgba(243, 84, 93, .14)",
    });

    $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#ffa534",
        fillColor: "rgba(255, 165, 52, .14)",
    });
</script>

<!-- ✅ Toast Notification (Kaiadmin Optimized) -->
<style>
    #toastNotif {
        background: linear-gradient(135deg, #0077b6, #023e8a);
        border: none;
        color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.2);
        padding: 0.8rem 1.2rem;
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.5s ease;
    }

    #toastNotif.showing,
    #toastNotif.show {
        opacity: 1 !important;
        transform: translateY(0) !important;
    }

    #toastNotif .toast-body {
        display: flex;
        align-items: center;
        font-weight: 500;
    }

    #toastNotif i {
        font-size: 1.2rem;
        margin-right: 10px;
    }
</style>

<!-- 📍 Posisi sedikit lebih tinggi supaya tidak menutupi navbar -->
<div class="position-fixed bottom-0 end-0 p-4" style="z-index: 1100; margin-bottom: 70px;">
    <div id="toastNotif" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body" id="toastMessage">
                <i class="fas fa-check-circle"></i> Data berhasil disimpan
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

<script>
    // Fungsi menampilkan toast profesional (Kaiadmin Style)
    function showToast(message, success = true) {
        const toastEl = document.getElementById('toastNotif');
        const toastMessage = document.getElementById('toastMessage');

        // Ganti ikon & warna dinamis
        toastMessage.innerHTML = success ?
            `<i class='fas fa-check-circle text-light'></i> ${message}` :
            `<i class='fas fa-times-circle text-light'></i> ${message}`;

        toastEl.style.background = success ?
            "linear-gradient(135deg, #0077b6, #023e8a)" :
            "linear-gradient(135deg, #b00020, #ff6b6b)";

        // Tampilkan toast dengan durasi 4.5 detik
        const toast = new bootstrap.Toast(toastEl, {
            delay: 4500
        });
        toast.show();
    }

    // AJAX toggle verifikasi
    document.querySelectorAll('.verify-toggle').forEach(toggle => {
        toggle.addEventListener('change', async function() {
            const id = this.dataset.id;
            const verified = this.checked ? 1 : 0;
            const formData = new FormData();
            formData.append('id', id);
            formData.append('verified', verified);

            try {
                const res = await fetch('../../actions/attendance/toggle_verify.php', {
                    method: 'POST',
                    body: formData
                });
                const text = await res.text();

                if (text.trim() === 'OK') {
                    showToast(verified ? '✔ Data berhasil diverifikasi' : '❌ Verifikasi dibatalkan', true);
                    const smallText = this.closest('td').querySelector('.small-text');
                    if (smallText) {
                        smallText.textContent = verified ? 'Terverifikasi' : 'Belum diverifikasi';
                        smallText.className = 'small-text ' + (verified ? 'text-success' : 'text-muted');
                    }
                } else {
                    showToast('Gagal memperbarui verifikasi!', false);
                }
            } catch (err) {
                showToast('Terjadi kesalahan koneksi!', false);
                console.error(err);
            }
        });
    });
</script>



</body>

</html>