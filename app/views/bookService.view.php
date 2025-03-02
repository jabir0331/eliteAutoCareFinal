<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= CSS ?>/navbar.css">
    <link rel="stylesheet" href="<?= CSS ?>/bookService.css">
    <link rel="icon" href="<?= IMAGES ?>/logo.webp">
    <title>Elite Auto Care | My Vehicles</title>
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
                <a href="<?= ROOT ?>/RegisteredUserHome">Home</a>
                <a href="<?= ROOT ?>/MyVehicles">My Vehicles</a>
                <a href="<?= ROOT ?>/BookService" class="activeNav">Book Service</a>
                <a href="<?= ROOT ?>/ServiceHistory">Service History</a>
                <a href="<?= ROOT ?>/Home">Logout</a>
            </nav>
        </div>
    </header>

    <!-- Mobile Navigation -->
    <div class="mobile-nav">
        <a href="<?= ROOT ?>/RegisteredUserHome">Home</a>
        <a href="<?= ROOT ?>/MyVehicles">My Vehicles</a>
        <a href="<?= ROOT ?>/BookService" class="activeNav">Book Service</a>
        <a href="<?= ROOT ?>/ServiceHistory">Service History</a>
        <a href="<?= ROOT ?>/Home">Logout</a>
    </div>
    <div class="overlay"></div>


    <section class="service-section">
        <div class="service-container">
            <div class="section-header">
                <div class="section-title">
                    <h1>Book a Service</h1>
                    <p>Get AI-powered service recommendations for your vehicle</p>
                </div>
            </div>

            <!-- Vehicle Information -->
            <?php foreach ($data['vehicles'] as $vehicle): ?>
                <div class="vehicle-info-card">
                    <div class="vehicle-header">
                        <i class="fas fa-car"></i>
                        <h3><?= $vehicle->make . " " . $vehicle->model ?></h3>
                    </div>
                    <div class="vehicle-details">
                        <div class="detail-item">
                            <i class="fas fa-clock"></i>
                            <span>Last Service: <?= $data['hasServiceBookings'] ? $vehicle->lastServiceDate : $data['message'] ?></span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-tools"></i>
                            <span>Last Mileage: 42,000 km</span>
                        </div>
                    </div>
                </div>

                <!-- Mileage Input Section -->
                <div class="mileage-input-section" id="mileageSection">
                    <h3>Current Mileage</h3>
                    <p>Enter your vehicle's current mileage to get personalized service recommendations</p>
                    <div class="input-group">
                        <input type="number" id="mileageInput" placeholder="Enter current mileage (km)" min="42000">
                        <button class="button-primary" onclick="getRecommendations()">
                            <i class="fas fa-magic"></i>
                            Get AI Recommendations
                        </button>
                    </div>
                </div>
            <?php endforeach ?>

            <!-- Loading State -->
            <div class="loader" id="loader">
                <i class="fas fa-spinner fa-spin fa-2x"></i>
                <p>Analyzing your vehicle data...</p>
            </div>

            <!-- Recommendations Section -->
            <div class="recommendations-section" id="recommendationsSection">
                <h3>Recommended Services</h3>
                <div id="recommendationsList">
                    <!-- Service cards will be inserted here -->
                </div>

                <div class="navigation-buttons">
                    <button class="button-primary" onclick="goBack()">
                        <i class="fas fa-arrow-left"></i>
                        Back
                    </button>
                    <button class="button-primary" onclick="proceedToBooking()">
                        Continue to Booking
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <script src="assets/js/mobileNav.js"></script>
    <script src="assets/js/activeNav.js"></script>

    <script>
        // Vehicle data initialization
        const vehicleData = {
            lastMileage: 42000, // From your UI display
            lastService: "Dec 15, 2023"
        };

        function getRecommendations() {
            const mileageInput = document.getElementById('mileageInput');
            const loader = document.getElementById('loader');
            const mileageSection = document.getElementById('mileageSection');
            const recommendationsSection = document.getElementById('recommendationsSection');

            const currentMileage = parseInt(mileageInput.value);

            // Input validation
            if (!currentMileage) {
                alert('Please enter a valid mileage number.');
                return;
            }

            if (currentMileage <= vehicleData.lastMileage) {
                alert(`Please enter a mileage greater than ${vehicleData.lastMileage}km (last recorded mileage).`);
                return;
            }

            // Show loading state
            loader.classList.add('active');
            mileageSection.style.display = 'none';

            // Make AJAX call to PHP backend - UPDATED URL to match MVC route
            fetch('<?= ROOT ?>/BookService/getRecommendations', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `mileage=${currentMileage}&lastMileage=${vehicleData.lastMileage}`
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(result => {
                    if (!result.success) {
                        throw new Error(result.error || 'Failed to get recommendations');
                    }
                    displayRecommendations(result.data);
                    loader.classList.remove('active');
                    recommendationsSection.classList.add('active');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error getting recommendations. Please try again later.');
                    loader.classList.remove('active');
                    mileageSection.style.display = 'block';
                });
        }

        // Rest of your JavaScript functions remain the same
        function displayRecommendations(recommendations) {
            const container = document.getElementById('recommendationsList');

            if (!recommendations || recommendations.length === 0) {
                container.innerHTML = `
                    <div class="service-card">
                        <p>No recommendations available at this time. Please try again later.</p>
                    </div>
                `;
                return;
            }

            container.innerHTML = recommendations.map(service => `
                <div class="service-card">
                    <div class="service-header">
                        <h4>${escapeHtml(service.name)}</h4>
                        <span class="priority-badge priority-${service.priority.toLowerCase()}">
                            ${escapeHtml(service.priority)} Priority
                        </span>
                    </div>
                    <p class="service-reason">${escapeHtml(service.reason)}</p>
                    <div class="service-footer">
                        <span class="service-price">${parseFloat(service.price).toFixed(2)} LKR</span>
                        <button class="button-primary" onclick="addToService('${escapeHtml(service.name)}')">
                            <i class="fas fa-plus"></i>
                            Add to Service
                        </button>
                    </div>
                </div>
            `).join('');
        }

        // Helper function to prevent XSS
        function escapeHtml(unsafe) {
            return unsafe
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        function goBack() {
            document.getElementById('recommendationsSection').classList.remove('active');
            document.getElementById('mileageSection').style.display = 'block';
        }

        function proceedToBooking() {
            // Implement booking logic here
            alert('Proceeding to booking... (Implementation pending)');
        }

        function addToService(serviceName) {
            // Implement add to service logic here
            alert(`Service "${serviceName}" added to booking`);
        }
    </script>
</body>

</html>