<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel = "stylesheet"  href = "<?= CSS ?>/navbar.css">
    <link rel = "stylesheet"  href = "<?= CSS ?>/serviceHistory.css">
    <link rel="icon" href="<?= IMAGES ?>/logo.webp">
    <title>Elite Auto Care | Service History</title>
    
   
</head>

<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <img src="<?= IMAGES ?>/logo.webp" alt="Logo">
                <span>Elite Auto Care</span>
            </div>
            <button class="mobile-menu-btn" aria-label="Toggle menu">
                <i class="fas fa-bars"></i>
            </button>
            <nav>
                <a href = "<?= ROOT ?>/RegisteredUserHome">Home</a>
                <a href = "<?= ROOT ?>/MyVehicles">My Vehicles</a>
                <a href = "<?= ROOT ?>/BookService">Book Service</a>
                <a href = "<?= ROOT ?>/ServiceHistory" class="activeNav">Service History</a>
                <a href = "<?= ROOT ?>/Home">Logout</a>
            </nav>
        </div>
    </header>

    <!-- Mobile Navigation -->
    <div class="mobile-nav">
        <a href = "<?= ROOT ?>/RegisteredUserHome">Home</a>
        <a href = "<?= ROOT ?>/MyVehicles">My Vehicles</a>
        <a href = "<?= ROOT ?>/BookService">Book Service</a>
        <a href = "<?= ROOT ?>/ServiceHistory" class="activeNav">Service History</a>
        <a href = "<?= ROOT ?>/Home">Logout</a>
    </div>
    <div class="overlay"></div>

    <section class="history-section">
        <div class="history-container">
            <div class="section-header">
                <div class="section-title">
                    <h1>Service History</h1>
                    <p>Track all your vehicle service records</p>
                </div>
            </div>

            <div class="tabs">
                <div class="tab active" onclick="showTab('all')">
                    <i class="fas fa-list"></i>
                    All Services
                </div>
                <div class="tab" onclick="showTab('pending')">
                    <i class="fas fa-clock"></i>
                    Pending
                </div>
                <div class="tab" onclick="showTab('approved')">
                    <i class="fas fa-check"></i>
                    Approved
                </div>
                <div class="tab" onclick="showTab('completed')">
                    <i class="fas fa-check-double"></i>
                    Completed
                </div>
                <div class="tab" onclick="showTab('cancelled')">
                    <i class="fas fa-times"></i>
                    Cancelled
                </div>
            </div>

            <!-- Previous HTML remains the same until the service-list div -->
            <div class="service-list">
                <!-- Pending Service -->
                <div class="service-card" data-status="pending">
                    <div class="service-header">
                        <div class="vehicle-info">
                            <img src="assets/images/alto.jpeg" alt="Vehicle" class="vehicle-image">
                            <div class="vehicle-details">
                                <h3>Suzuki Alto</h3>
                                <p>CAR-1234</p>
                            </div>
                        </div>
                        <div class="service-status status-pending">
                            <i class="fas fa-clock"></i>
                            Pending Approval
                        </div>
                    </div>
                    <div class="service-details">
                        <div class="detail-item">
                            <i class="fas fa-calendar"></i>
                            <span>June 5, 2025</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-tools"></i>
                            <span>Full Service</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-dollar-sign"></i>
                            <span>Estimated: $150</span>
                        </div>
                    </div>
                    <div class="service-actions">
                        <button class="action-button button-secondary">
                            <i class="fas fa-times"></i>
                            Cancel Request
                        </button>
                        <button class="action-button button-primary">
                            <i class="fas fa-eye"></i>
                            View Details
                        </button>
                    </div>
                </div>

                <!-- Approved Service -->
                <div class="service-card" data-status="approved">
                    <div class="service-header">
                        <div class="vehicle-info">
                            <img src="assets/images/alto.jpeg" alt="Vehicle" class="vehicle-image">
                            <div class="vehicle-details">
                                <h3>Suzuki Alto</h3>
                                <p>CAR-1234</p>
                            </div>
                        </div>
                        <div class="service-status status-approved">
                            <i class="fas fa-check"></i>
                            Approved
                        </div>
                    </div>
                    <div class="service-details">
                        <div class="detail-item">
                            <i class="fas fa-calendar"></i>
                            <span>March 05, 2025</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-tools"></i>
                            <span>Oil Change + Brake Service</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-dollar-sign"></i>
                            <span>Quoted: $280</span>
                        </div>
                    </div>
                    <div class="service-actions">
                        <button class="action-button button-primary">
                            <i class="fas fa-eye"></i>
                            View Details
                        </button>
                    </div>
                </div>

                <!-- Completed Service -->
                <div class="service-card" data-status="completed">
                    <div class="service-header">
                        <div class="vehicle-info">
                            <img src="assets/images/alto.jpeg" alt="Vehicle" class="vehicle-image">
                            <div class="vehicle-details">
                                <h3>Suzuki Alto</h3>
                                <p>CAR-1234</p>
                            </div>
                        </div>
                        <div class="service-status status-completed">
                            <i class="fas fa-check-double"></i>
                            Completed
                        </div>
                    </div>
                    <div class="service-details">
                        <div class="detail-item">
                            <i class="fas fa-calendar"></i>
                            <span>January 5, 2025</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-tools"></i>
                            <span>Annual Inspection</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-dollar-sign"></i>
                            <span>Final: $200</span>
                        </div>
                    </div>
                    <div class="service-actions">
                        <button class="action-button button-secondary">
                            <i class="fas fa-star"></i>
                            Leave Review
                        </button>
                        <button class="action-button button-primary">
                            <i class="fas fa-eye"></i>
                            View Details
                        </button>
                    </div>
                </div>

                <!-- Cancelled Service -->
                <div class="service-card" data-status="cancelled">
                    <div class="service-header">
                        <div class="vehicle-info">
                            <img src="assets/images/alto.jpeg" alt="Vehicle" class="vehicle-image">
                            <div class="vehicle-details">
                                <h3>Suzuki Alto</h3>
                                <p>CAR-1234</p>
                            </div>
                        </div>
                        <div class="service-status status-cancelled">
                            <i class="fas fa-times"></i>
                            Cancelled
                        </div>
                    </div>
                    <div class="service-details">
                        <div class="detail-item">
                            <i class="fas fa-calendar"></i>
                            <span>December 20, 2024</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-tools"></i>
                            <span>Tire Replacement</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-dollar-sign"></i>
                            <span>Estimated: $400</span>
                        </div>
                    </div>
                    <div class="service-actions">
                        <button class="action-button button-primary">
                            <i class="fas fa-redo"></i>
                            Rebook Service
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="<?= JS ?>/activeNav.js"></script>

    <script>
        // Mobile menu functionality
        const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
        const mobileNav = document.querySelector('.mobile-nav');
        const overlay = document.querySelector('.overlay');

        mobileMenuBtn.addEventListener('click', () => {
            mobileNav.classList.toggle('active');
            overlay.classList.toggle('active');
        });

        overlay.addEventListener('click', () => {
            mobileNav.classList.remove('active');
            overlay.classList.remove('active');
        });

        // Tab functionality
        function showTab(status, clickedTab = null) {
            // Update active tab
            const tabs = document.querySelectorAll('.tab');
            tabs.forEach(tab => tab.classList.remove('active'));

            if (clickedTab) {
                // If clicked, use the clicked tab
                clickedTab.classList.add('active');
            } else {
                // If initial load, find and activate the "All Services" tab
                tabs.forEach(tab => {
                    if (tab.textContent.trim().includes('All Services')) {
                        tab.classList.add('active');
                    }
                });
            }

            // Show/hide service cards based on status
            const cards = document.querySelectorAll('.service-card');
            cards.forEach(card => {
                if (status === 'all' || card.dataset.status === status) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Add click handlers to tabs
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', (e) => {
                const status = e.currentTarget.textContent.trim().toLowerCase().includes('all') ? 'all'
                    : e.currentTarget.textContent.trim().toLowerCase().split(' ')[0];
                showTab(status, e.currentTarget);
            });
        });

        // Initialize with 'all' tab active
        document.addEventListener('DOMContentLoaded', () => {
            showTab('all');
        });
    </script>
    
</body>    
</html>