
<style>
  /* Footer dengan efek kaca lembut */
  .shadow-footer {
    background: #ffffffcc; /* sedikit transparan */
    backdrop-filter: blur(6px); /* efek kaca lembut */
    box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.1); /* shadow halus di atas */
    border-top: 1px solid rgba(255, 255, 255, 0.4);
    position: relative;
    z-index: 10;
  }

  /* Warna teks footer */
  .shadow-footer a {
    color: #0077b6;
    text-decoration: none;
    transition: color 0.3s ease;
  }

  .shadow-footer a:hover {
    color: #023e8a;
    text-decoration: underline;
  }

  /* Responsif footer di layar kecil */
  @media (max-width: 768px) {
    .shadow-footer .container-fluid {
      flex-direction: column;
      gap: 8px;
      text-align: center;
    }
  }
</style>

<footer class="footer shadow-footer">
  <div class="container-fluid d-flex justify-content-center align-items-center py-3">
    <div class="copyright text-muted small text-center">
      © by
      <a href="http://www.themekita.com" class="fw-semibold">Lauwba Techno Indonesia</a>
    </div>
  </div>
</footer>



  <!-- ✅ Toast Notification Global -->
  <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
    <div id="toastNotif" class="toast align-items-center text-white border-0" role="alert">
      <div class="d-flex">
        <div class="toast-body fw-semibold" id="toastMessage"></div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
      </div>
    </div>
  </div>
  </div> <!-- end main wrapper -->