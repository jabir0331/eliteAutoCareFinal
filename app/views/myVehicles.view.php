<?php 
    // var_dump($data['errors']); 
?> 

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= CSS ?>/navbar.css">
    <link rel="stylesheet" href="<?= CSS ?>/myVehicles.css">
    <link rel="icon" href="<?= IMAGES ?>/logo.webp">
    <title>Elite Auto Care | My Vehicles</title>
    <style>
        /* Styles for form validation and modal */
        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-error {
            color: var(--danger);
            font-size: 0.85rem;
            margin-top: 0.25rem;
            position: absolute;
            bottom: -1.2rem;
            left: 0;
        }

        input.error {
            border-color: var(--danger);
        }

        .loading {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            text-align: center;
        }

        .loading i {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 1rem;
            animation: spin 1s linear infinite;
        }

        .error-message {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            text-align: center;
        }

        .error-message i {
            font-size: 2rem;
            color: var(--danger);
            margin-bottom: 1rem;
        }

        .no-vehicles {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            text-align: center;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .preview-overlay {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .preview-overlay i {
            font-size: 1.5rem;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body id="body">
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
                <a href="<?= ROOT ?>/MyVehicles" class = "activeNav">My Vehicles</a>
                <a href="<?= ROOT ?>/BookService">Book Service</a>
                <a href="<?= ROOT ?>/ServiceHistory">Service History</a>
                <a href="<?= ROOT ?>/Home">Logout</a>
            </nav>
        </div>
    </header>

    <!-- Mobile Navigation -->
    <div class="mobile-nav">
        <a href="<?= ROOT ?>/RegisteredUserHome">Home</a>
        <a href="<?= ROOT ?>/MyVehicles" class = "activeNav">My Vehicles</a>
        <a href="<?= ROOT ?>/BookService">Book Service</a>
        <a href="<?= ROOT ?>/ServiceHistory">Service History</a>
        <a href="<?= ROOT ?>/Home">Logout</a>
    </div>
    <div class="overlay"></div>


    <!-- Modified Vehicles Section -->
    <section class="vehicles-section">
        <div class="vehicles-container">
            <div class="section-header">
                <div class="section-title">
                    <h1>My Vehicles</h1>
                    <p>Manage your registered vehicles and their service history</p>
                </div>
                <button class="button-primary" style="font-family: 'Poppins';" onclick="openAddVehicleModal()">
                    <i class="fas fa-plus"></i>
                    Add New Vehicle
                </button>
            </div>

            <div class="vehicles-list">
                <?php if (empty($vehicles)): ?>
                    <div class="no-vehicles">
                        <i class="fas fa-car" style="font-size: 4rem; color: #ccc; margin-bottom: 1rem;"></i>
                        <h3>No Vehicles Found</h3>
                        <p>You haven't added any vehicles yet. Click the 'Add New Vehicle' button to get started.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($vehicles as $vehicle): ?>
                        <div class="vehicle-card" data-id="<?= $vehicle->vehicle_id ?>">
                            <div class="vehicle-image-container">
                                <?php
                                
                                    $imagePath = !empty($vehicle->vehicle_img_path) ?  UPLOADS . '/vehicles/' . $vehicle->vehicle_img_path : "assets/images/default-car.png";
                               
                                ?>
                                <img src="<?= $imagePath ?>" alt="<?= $vehicle->make ?> <?= $vehicle->model ?>" class="vehicle-image">
                                <div class="edit-image-overlay">
                                    <i class="fas fa-camera"></i>
                                    Update Photo
                                </div>
                            </div>
                            <div class="vehicle-details">
                                <div class="vehicle-header">
                                    <h3 class="vehicle-title"><?= $vehicle->make ?> <?= $vehicle->model ?></h3>
                                    <div class="vehicle-actions">
                                        <button class="action-button edit-vehicle" data-id="<?= $vehicle->vehicle_id ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="action-button delete-vehicle" data-id="<?= $vehicle->vehicle_id ?>">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="vehicle-info">
                                    <div class="info-item">
                                        <i class="fas fa-hashtag"></i>
                                        <span><?= $vehicle->plate_number ?></span>
                                    </div>
                                    <div class="info-item">
                                        <i class="fas fa-calendar"></i>
                                        <span><?= $vehicle->vehicle_make_year ?></span>
                                    </div>
                                    <div class="info-item">
                                        <i class="fas fa-tachometer-alt"></i>
                                        <span><?= number_format($vehicle->last_serviced_mileage ?? 0) ?> km</span>
                                    </div>
                                </div>
                                <div class="vehicle-status">
                                    <span class="status-badge <?= strtolower($vehicle->vehicle_status) ?>">
                                        <i class="fas fa-<?= $vehicle->vehicle_status == 'active' ? 'check-circle' : 'exclamation-circle' ?>"></i>
                                        <?= ucfirst($vehicle->vehicle_status) ?>
                                    </span>
                                    <a href="<?= ROOT ?>/ServiceHistory/vehicle/<?= $vehicle->vehicle_id ?>" class="button-primary" style="font-family: 'Poppins'; text-decoration: none;">
                                        <i class="fas fa-history"></i>
                                        Service History
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Add/Edit Vehicle Modal -->
    <div class="modal" id="vehicleModal">
        <div class="modal-content">
            <button class="close-button" onclick="closeVehicleModal()">
                <i class="fas fa-times"></i>
            </button>

            <div class="modal-header">
                <h2>Add New Vehicle</h2>
                <p>Enter your vehicle details</p>
            </div>

            <form id="vehicleForm" method = "POST" action = "<?= ROOT ?>/MyVehicles/saveVehicle" enctype="multipart/form-data">
                
                <input type = "hidden" id = "mode" name = "mode" value = "insertMode">
                <input type = "hidden" id = "vehicleId" name = "vehicleId" value = "">

                <div class="upload-placeholder" onclick = "triggerImageUpload()">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <p>Click to upload vehicle image</p>
                    <span>or drag and drop</span>
                    <input type="file" id="vehicleImage" name = "vehicleImage" hidden accept="image/*" onchange="handleImageChange(event)">
                </div>

                <div class="form-group">
                    <label>Make:</label>
                    <input type="text" id="make" name = "make" placeholder="Eg: Toyota" required>
                </div>

                <div class="form-group">
                    <label>Model:</label>
                    <input type="text" id="model" name = "model" placeholder="Eg: Aqua" required>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Year:</label>
                        <input type="number" id="year" name = "year" placeholder = "Eg: 2020" min="1950" max="2024" required>
                    </div>
                    <div class="form-group">
                        <label>License Plate Number:</label>
                        <input type="text" id="licensePlate" name = "plate_number" placeholder="CAR-1234" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Last Serviced Mileage:</label>
                    <input type="number" id="mileage" name = "mileage" placeholder="Mileage in (km)" min="0" required>
                </div>

                <button type="submit" class="button-primary">
                    <i class="fas fa-save"></i>
                    Save Vehicle
                </button>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal" id="deleteModal">
        <div class="modal-content" style="max-width: 400px;">
            <div class="modal-header">
                <h2>Delete Vehicle</h2>
                <p>This action cannot be undone</p>
            </div>

            <div class="delete-confirmation">
                <i class="fas fa-exclamation-triangle"
                    style="font-size: 3rem; color: var(--danger); margin-bottom: 1rem;"></i>
                <p style="font-size: 1.1rem; margin-bottom: 2rem;">Are you sure you want to remove this vehicle from
                    your account?</p>

                <div class="button-group">
                    <button class="button-secondary" onclick="closeDeleteModal()">
                        <i class="fas fa-times"></i>
                        Cancel
                    </button>

                    <!-- <a href = "<?= ROOT ?>/MyVehicles/deleteVehicle/" id = "deleteConfirmationBtn" data-url = "<?= ROOT ?>/MyVehicles/deleteVehicle/" style = "text-decoration: none;">
                        <button class="button-danger">
                            <i class="fas fa-trash"></i>
                            Delete Vehicle
                        </button>

                    </a> -->
                    <!-- Replace your existing delete button with this -->
                    <form id="deleteForm" action="<?= ROOT ?>/MyVehicles/deleteVehicle" method="POST" style="display:inline;">
                        <input type="hidden" id="deleteVehicleId" name="vehicle_id_holder" value="">
                        <button type="submit" class="button-danger">
                            <i class="fas fa-trash"></i>
                            Delete Vehicle
                        </button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>

    <script src="<?= JS ?>/mobileNav.js"></script>
    <script src="<?= JS ?>/activeNav.js"></script>
    <script src="<?= JS ?>/newMyVehicles.js"></script>

    <script>
        // Initialize event listeners when the document is ready
        document.addEventListener('DOMContentLoaded', function() {
            // Attach edit button click handlers
            const editButtons = document.querySelectorAll('.edit-vehicle');
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const vehicleId = this.getAttribute('data-id');
                    openAddVehicleModal(vehicleId);
                });
            });

            // Attach delete button click handlers
            const deleteButtons = document.querySelectorAll('.delete-vehicle');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const vehicleId = this.getAttribute('data-id');
                    deleteVehicle(vehicleId);
                });
            });
        });
    </script>

</body>


</html>