<section class="lokasi-interactive py-5 header-area header-eight " id="lokasi">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 mb-4 mb-lg-0">
                <div class="content-wrapper">
                    <h6 class="text-primary mb-2">TEMUKAN KAMI</h6>
                    <h2 class="fw-bold mb-4">Lokasi Praktek Kerja Lapangan</h2>
                    
                    <div class="feature-list">
                        <div class="feature-item d-flex align-items-center mb-4">
                            <div class="feature-icon bg-primary text-white rounded-circle p-3 me-4">
                                <i class="fas fa-map-marked-alt"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Lokasi Strategis</h5>
                                <p class="text-muted mb-0">Berada di pusat teknologi Yogyakarta</p>
                            </div>
                        </div>
                        
                        <div class="feature-item d-flex align-items-center mb-4">
                            <div class="feature-icon bg-success text-white rounded-circle p-3 me-4">
                                <i class="fas fa-bus"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Akses Mudah</h5>
                                <p class="text-muted mb-0">Dilalui berbagai angkutan umum</p>
                            </div>
                        </div>
                        
                        <div class="feature-item d-flex align-items-center">
                            <div class="feature-icon bg-warning text-white rounded-circle p-3 me-4">
                                <i class="fas fa-wifi"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Fasilitas Lengkap</h5>
                                <p class="text-muted mb-0">Internet, ruang meeting, dan fasilitas pendukung</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="action-buttons mt-5">
                        <a href="https://maps.google.com/?q=PT+Lauwba+Techno+Indonesia" 
                           target="_blank" 
                           class="btn btn-primary btn-lg me-3">
                            <i class="fas fa-map-marked me-2"></i>Buka Maps
                        </a>
                        <a href="https://wa.me/6282221777206" 
                           target="_blank" 
                           class="btn btn-outline-primary btn-lg">
                            <i class="fab fa-whatsapp me-2"></i>Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-7">
                <div class="map-container-interactive rounded-4 shadow-lg overflow-hidden">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.9574756982042!2d110.31926073099586!3d-7.794327320861191!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a5765d4d95351%3A0x5175f045ca1816c!2sPT%20Lauwba%20Techno%20Indonesia!5e0!3m2!1sid!2sid!4v1761547542396!5m2!1sid!2sid" 
                        width="100%" 
                        height="500" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<style>


.lokasi-interactive h2,
.lokasi-interactive h6,
.lokasi-interactive .text-muted {
    color: white !important;
}

.lokasi-interactive .text-muted {
    opacity: 0.9;
}

.feature-icon {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.map-container-interactive {
    position: relative;
    border: 3px solid white;
}

.map-container-interactive iframe {
    filter: saturate(1.2) contrast(1.1);
}

.rounded-4 {
    border-radius: 20px !important;
}

.btn-primary {
    background: rgba(255, 255, 255, 0.2);
    border: 2px solid white;
    backdrop-filter: blur(10px);
}

.btn-outline-primary {
    border: 2px solid white;
    color: white;
}

.btn-outline-primary:hover {
    background: white;
    color: #667eea;
}

@media (max-width: 991px) {
    .action-buttons .btn {
        margin-bottom: 10px;
        width: 100%;
    }
}
</style>