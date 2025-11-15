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






<!-- ✅ Plugin DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {

    // ✅ Tabel Users
    $('#usersTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],
        ordering: true,
        searching: true,
        language: { url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json" }
    });

    // ✅ Tabel Participants (Peserta)
    $('#participantsTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],
        ordering: true,
        searching: true,
        language: { url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json" }
    });

    // ✅ Tabel Supervisors (Pembimbing)
    $('#supervisorsTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],
        ordering: true,
        searching: true,
        language: { url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json" }
    });

        // ✅ Tabel Attendance (Absensi Peserta)
    $('#attendanceTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],
        ordering: true,
        searching: true,
        order: [[0, "asc"]],
        language: { 
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json",
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Tidak ada data tersedia",
            zeroRecords: "Tidak ditemukan data yang cocok",
            paginate: {
                first: "Awal",
                last: "Akhir",
                next: "›",
                previous: "‹"
            }
        }
    });

        // ✅ Tabel Rekap Absensi
    $('#rekapTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],
        ordering: true,
        searching: true,
        order: [[1, "asc"]],
        language: { 
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json",
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Tidak ada data tersedia",
            zeroRecords: "Tidak ditemukan data yang cocok",
            paginate: {
                first: "Awal",
                last: "Akhir",
                next: "›",
                previous: "‹"
            }
        }
    });



    // ✅ Tabel Schedules (Jadwal Absensi)
    $('#schedulesTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],
        ordering: true,
        searching: true,
        language: { url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json" }
    });

    // ✅ Tabel Settings (Konfigurasi Sistem)
    $('#settingsTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],
        ordering: true,
        searching: true,
        language: { url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json" }
    });




    // ⚠️ Tidak untuk tabel laporan (rekap), karena laporan biasanya sudah ada tombol ekspor sendiri
});
</script>




</body>

</html>