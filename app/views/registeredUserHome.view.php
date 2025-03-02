<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="<?= CSS ?>/navbar.css">
    <link rel="stylesheet" href="<?= CSS ?>/loggedInUserHome.css">
    <link rel="icon" href="<?= IMAGES ?>/logo.webp">
    <title>Elite Auto Care - Dashboard</title>

    <style>
        /* Base Button Styles */
        .btn, .btn-small, .btn-tiny {
            display: inline-block;
            background-color: #f1f5f9;
            color: #3b82f6;
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            border-radius: 5px;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            text-align: center;
        }

        .btn:hover, .btn-small:hover, .btn-tiny:hover {
            background-color: #e2e8f0;
            color: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Main Button */
        .btn {
            padding: 12px 24px;
            font-size: 16px;
            margin: 10px 0;
        }

        /* Small Button */
        .btn-small {
            padding: 8px 16px;
            font-size: 14px;
            margin: 5px 0;
        }

        /* Tiny Button */
        .btn-tiny {
            padding: 4px 12px;
            font-size: 12px;
            margin: 0 0 0 10px;
            white-space: nowrap;
        }

        /* Empty State Styling */
        .empty-state-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 30px 20px;
            text-align: center;
        }

        .empty-icon {
            font-size: 48px;
            color: #ccc;
            margin-bottom: 15px;
        }

        .empty-state-content p {
            color: #666;
            margin-bottom: 20px;
            font-size: 16px;
        }

        .empty-state {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        /* Chart Card Empty State */
        .chart-card.empty-state {
            min-height: 300px;
        }

        /* Onboarding Card */
        .onboarding-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            margin: 20px 0;
            padding: 20px;
        }

        .onboarding-steps {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
        }   

        .onboarding-step {
            display: flex;
            align-items: flex-start;
            flex: 1;
            min-width: 250px;
        }

        .step-number {
            background-color: #3498db;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .step-content {
            flex: 1;
        }

        .step-content h3 {
            margin: 0 0 8px 0;
            font-size: 18px;
        }

        .step-content p {
            margin: 0 0 15px 0;
            color: #666;
        }

        /* Links in footer */
        .footer-links a {
            color: #ddd;
            text-decoration: none;
            margin-left: 15px;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: white;
        }

        /* Stat Card CTA */
        .stat-cta {
            margin-top: 15px;
            text-align: center;
        }

        /* Vehicle alert statuses */
        .vehicle-alert {
            display: flex;
            align-items: center;
            padding: 8px 12px;
            border-radius: 4px;
            margin-top: 8px;
            font-size: 14px;
        }

        .vehicle-alert i {
            margin-right: 8px;
        }

        /* Status colors */
        .overdue {
            background-color: rgba(255, 77, 77, 0.1);
            color: #ff4d4d;
        }

        .due-soon {
            background-color: rgba(255, 152, 0, 0.1);
            color: #ff9800;
        }

        .upcoming {
            background-color: rgba(0, 150, 136, 0.1);
            color: #009688;
        }

        .no-service {
            background-color: rgba(158, 158, 158, 0.1);
            color: #9e9e9e;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .btn {
                padding: 10px 20px;
                font-size: 15px;
            }
    
            .btn-small {
                padding: 6px 14px;
                font-size: 13px;
            }
    
            .btn-tiny {
                padding: 3px 10px;
                font-size: 11px;
            }
    
            .onboarding-steps {
                flex-direction: column;
            }
    
            .empty-state-content {
                padding: 20px 15px;
            }
    
            .empty-icon {
                font-size: 36px;
            }
        }
    </style>
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
                <a href="<?= ROOT ?>/RegisteredUserHome" class="activeNav">Home</a>
                <a href="<?= ROOT ?>/MyVehicles">My Vehicles</a>
                <a href="<?= ROOT ?>/BookService">Book Service</a>
                <a href="<?= ROOT ?>/ServiceHistory">Service History</a>
                <a href="<?= ROOT ?>/Home/logout">Logout</a>
            </nav>
        </div>
    </header>

    <div class="mobile-nav">
        <a href="<?= ROOT ?>/RegisteredUserHome" class="activeNav">Home</a>
        <a href="<?= ROOT ?>/MyVehicles">My Vehicles</a>
        <a href="<?= ROOT ?>/BookService">Book Service</a>
        <a href="<?= ROOT ?>/ServiceHistory">Service History</a>
        <a href="<?= ROOT ?>/Home/logout">Logout</a>
    </div>
    <div class="overlay"></div>

    <div class="dashboard">
        <?php if(isset($data['user'])): ?>
        <div class="welcome-section">
            <h1>Welcome back, <?= htmlspecialchars($data['user']->first_name) ?></h1>
            <p>
                <?php if(empty($data['vehicles'])): ?>
                    Get started by adding your first vehicle
                <?php else: ?>
                    Here's an overview of your vehicle maintenance
                <?php endif; ?>
            </p>
        </div>
        <?php endif; ?>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-card-header">
                    <div class="stat-icon blue">
                        <i class="fas fa-car"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?= isset($data['vehicles']) ? count($data['vehicles']) : 0 ?></h3>
                        <p>Active Vehicles</p>
                    </div>
                </div>
                <?php if(empty($data['vehicles'])): ?>
                    <div class="stat-cta">
                        <a href="<?= ROOT ?>/MyVehicles" class="btn-small">Add Vehicle</a>
                    </div>
                <?php endif; ?>
            </div>

            <div class="stat-card">
                <div class="stat-card-header">
                    <div class="stat-icon green">
                        <i class="fas fa-tools"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?= isset($data['serviceCount']) ? $data['serviceCount'] : 0 ?></h3>
                        <p>Services Done</p>
                    </div>
                </div>
                <?php if(empty($data['serviceCount']) && !empty($data['vehicles'])): ?>
                    <div class="stat-cta">
                        <a href="<?= ROOT ?>/BookService" class="btn-small">Book First Service</a>
                    </div>
                <?php endif; ?>
            </div>

            <div class="stat-card">
                <div class="stat-card-header">
                    <div class="stat-icon yellow">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-info">
                        <?php if(isset($data['nextServiceDays']) && $data['nextServiceDays'] > 0): ?>
                            <h3><?= $data['nextServiceDays'] ?></h3>
                            <p>Days to Next Service</p>
                        <?php else: ?>
                            <h3>--</h3>
                            <p>No upcoming service</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-card-header">
                    <div class="stat-icon purple">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <div class="stat-info">
                        <?php if(isset($data['nextBookingDate']) && !empty($data['nextBookingDate'])): ?>
                            <h3><?= date('M d', strtotime($data['nextBookingDate'])) ?></h3>
                            <p>Next Booking</p>
                        <?php else: ?>
                            <h3>--</h3>
                            <p>No bookings</p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if(empty($data['nextBookingDate']) && !empty($data['vehicles'])): ?>
                    <div class="stat-cta">
                        <a href="<?= ROOT ?>/BookService" class="btn-small">Schedule Now</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="main-content">
            <?php if(isset($data['serviceHistory']) && !empty($data['serviceHistory'])): ?>
            <div class="chart-card">
                <h2>Service History</h2>
                <div class="chart-container">
                    <!-- Actual chart to be implemented with JS charting library -->
                    <div id="service-history-chart" class="chart"></div>
                </div>
            </div>
            <?php else: ?>
            <div class="chart-card empty-state">
                <h2>Service History</h2>
                <div class="empty-state-content">
                    <i class="fas fa-history empty-icon"></i>
                    <p>No service history available yet</p>
                    <?php if(!empty($data['vehicles'])): ?>
                        <a href="<?= ROOT ?>/BookService" class="btn">Book Your First Service</a>
                    <?php else: ?>
                        <a href="<?= ROOT ?>/MyVehicles" class="btn">Add Your First Vehicle</a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <div class="vehicles-card">
                <div class="vehicle-card-header">
                    <h2>Vehicle Status</h2>
                </div>
                
                <?php if(isset($data['vehicles']) && !empty($data['vehicles'])): ?>
                    <?php foreach($data['vehicles'] as $vehicle): ?>
                    <div class="vehicle-item">
                        <div class="vehicle-header">
                            <span class="vehicle-name"><?= htmlspecialchars($vehicle->make . ' ' . $vehicle->model) ?></span>
                            <span class="vehicle-status <?= $vehicle->vehicle_status === 'Active' ? 'active' : 'inactive' ?>"><?= htmlspecialchars($vehicle->vehicle_status) ?></span>
                        </div>
                        <div class="vehicle-plate"><?= htmlspecialchars($vehicle->plate_number) ?></div>
                        <?php 
                            $serviceAlert = '';
                            $alertClass = '';
                            
                            if(isset($vehicle->days_to_service)) {
                                if($vehicle->days_to_service < 0) {
                                    $serviceAlert = 'Service overdue by ' . abs($vehicle->days_to_service) . ' days';
                                    $alertClass = 'overdue';
                                } elseif($vehicle->days_to_service <= 7) {
                                    $serviceAlert = 'Service due in ' . $vehicle->days_to_service . ' days';
                                    $alertClass = 'due-soon';
                                } else {
                                    $serviceAlert = 'Next service in ' . $vehicle->days_to_service . ' days';
                                    $alertClass = 'upcoming';
                                }
                            } else {
                                $serviceAlert = 'No upcoming services';
                                $alertClass = 'no-service';
                            }
                        ?>
                        <div class="vehicle-alert <?= $alertClass ?>">
                            <?php if($alertClass === 'overdue' || $alertClass === 'due-soon'): ?>
                                <i class="fas fa-exclamation-circle"></i>
                            <?php else: ?>
                                <i class="fas fa-check-circle"></i>
                            <?php endif; ?>
                            <?= $serviceAlert ?>
                            <?php if($alertClass === 'overdue' || $alertClass === 'due-soon'): ?>
                                <a href="<?= ROOT ?>/BookService?vehicle=<?= $vehicle->vehicle_id ?>" class="btn-tiny">Book Now</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <a href="<?= ROOT ?>/MyVehicles" class="btn-small" style = "width: 100%;"><i class="fas fa-plus"></i> Add Vehicle</a>
                <?php else: ?>
                    <div class="empty-state-content">
                        <i class="fas fa-car empty-icon"></i>
                        <p>You haven't added any vehicles yet</p>
                        <a href="<?= ROOT ?>/MyVehicles" class="btn">Add Your First Vehicle</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <?php if(isset($data['user']) && empty($data['vehicles'])): ?>
        <div class="onboarding-card">
            <h2>Get Started with Elite Auto Care</h2>
            <div class="onboarding-steps">
                <div class="onboarding-step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h3>Add Your Vehicle</h3>
                        <p>Register your vehicle details to get started</p>
                        <a href="<?= ROOT ?>/MyVehicles/add" class="btn-small">Add Vehicle</a>
                    </div>
                </div>
                <div class="onboarding-step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h3>Book a Service</h3>
                        <p>Schedule your first maintenance appointment</p>
                    </div>
                </div>
                <div class="onboarding-step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h3>Track Your Service</h3>
                        <p>Get updates and maintain service history</p>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div>

    <footer>
        <div class="footer-container">
            <p>© 2024 Elite Auto Care. All rights reserved.</p>
            <div class="footer-links">
                <a href="#"><i class="fas fa-map-marker-alt"></i> Find Us</a>
                <a href="#"><i class="fab fa-instagram"></i> Instagram</a>
                <a href="#"><i class="fab fa-facebook"></i> Facebook</a>
                <a href="#"><i class="fab fa-whatsapp"></i> WhatsApp</a>
            </div>
        </div>
    </footer>

    <script src="<?= JS ?>/mobileNav.js"></script>
    <script src="<?= JS ?>/activeNav.js"></script>
    <?php if(isset($data['serviceHistory']) && !empty($data['serviceHistory'])): ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>
        // Simple Chart.js implementation for service history
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('service-history-chart').getContext('2d');
            
            // Sample data structure - in production this would come from PHP
            const serviceData = <?= json_encode($data['serviceHistory']) ?>;
            
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: serviceData.map(item => item.service_date),
                    datasets: [{
                        label: 'Service Count',
                        data: serviceData.map(item => item.count),
                        borderColor: '#4CAF50',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Your Service History'
                        }
                    }
                }
            });
        });
    </script>
    <?php endif; ?>
</body>
</html>