// // Global variables
// let currentVehicleId = null;
// let isEditMode = false;

// // Function to open the vehicle modal
// function openAddVehicleModal(vehicleId = null) {
//     const modal = document.getElementById('vehicleModal');
//     const modalTitle = modal.querySelector('.modal-header h2');
//     const modalSubtitle = modal.querySelector('.modal-header p');
//     const mode = document.getElementById('mode');
//     const vehicleIdInput = document.getElementById('vehicleId');
//     const submitButton = modal.querySelector('button[type="submit"]');
    
//     // Reset form when opening
//     document.getElementById('vehicleForm').reset();
    
//     if (vehicleId) {
//         // Edit mode
//         isEditMode = true;
//         currentVehicleId = vehicleId;
//         modalTitle.textContent = 'Edit Vehicle';
//         modalSubtitle.textContent = 'Update your vehicle details';
//         mode.value = 'updateMode';
//         vehicleIdInput.value = vehicleId;
//         vehicleIdInput.type = "hidden";
//         submitButton.innerHTML = '<i class="fas fa-save"></i> Update Vehicle';
        
//         // Fetch and populate vehicle data
//         fetchVehicleDetails(vehicleId);
//     } else {
//         // Add mode
//         isEditMode = false;
//         currentVehicleId = null;
//         modalTitle.textContent = 'Add New Vehicle';
//         modalSubtitle.textContent = 'Enter your vehicle details';
//         submitButton.innerHTML = '<i class="fas fa-save"></i> Save Vehicle';
        
//         // Clear image preview if any
//         const uploadPlaceholder = document.querySelector('.upload-placeholder');
//         if (uploadPlaceholder.querySelector('img')) {
//             uploadPlaceholder.innerHTML = `
//                 <i class="fas fa-cloud-upload-alt"></i>
//                 <p>Click to upload vehicle image</p>
//                 <span>or drag and drop</span>
//                 <input type="file" id="vehicleImage" hidden accept="image/*" onchange="handleImageChange(event)">
//             `;
//         }
//     }
    
//     modal.style.display = 'flex';
//     document.body.classList.add('modal-open');
// }

// // Function to fetch vehicle details by ID
// function fetchVehicleDetails(vehicleId) {
//     // In a real application, this would be an AJAX call to your server
//     // For demonstration, we'll simulate this with the data from the visible card
    
//     // Get values from the current vehicle card
//     const vehicleCard = document.querySelector(`.vehicle-card[data-id="${vehicleId}"]`);
//     if (!vehicleCard) {
//         console.error("Vehicle card not found");
//         return;
//     }
    
//     const make = vehicleCard.querySelector('.vehicle-title').textContent.split(' ')[0];
//     const model = vehicleCard.querySelector('.vehicle-title').textContent.split(' ')[1];
//     const plateNumber = vehicleCard.querySelector('.info-item:nth-child(1) span').textContent;
//     const year = vehicleCard.querySelector('.info-item:nth-child(2) span').textContent;
//     const mileage = parseInt(vehicleCard.querySelector('.info-item:nth-child(3) span').textContent.replace(',', '').replace(' km', ''));
//     const imageUrl = vehicleCard.querySelector('.vehicle-image').src;
    
//     // Populate form fields
//     document.getElementById('make').value = make;
//     document.getElementById('model').value = model;
//     document.getElementById('licensePlate').value = plateNumber;
//     document.getElementById('year').value = year;
//     document.getElementById('mileage').value = mileage;
    
//     // Update image preview
//     updateImagePreview(imageUrl);
// }

// // Function to update image preview
// function updateImagePreview(imageUrl) {
//     const uploadPlaceholder = document.querySelector('.upload-placeholder');
    
//     // Clear existing content
//     uploadPlaceholder.innerHTML = '';
    
//     // Create image element
//     const img = document.createElement('img');
//     img.src = imageUrl;
//     img.alt = 'Vehicle Preview';
//     img.style.width = '100%';
//     img.style.height = '100%';
//     img.style.objectFit = 'cover';
//     img.style.borderRadius = '8px';
    
//     // Create overlay
//     const overlay = document.createElement('div');
//     overlay.className = 'preview-overlay';
//     overlay.innerHTML = '<i class="fas fa-camera"></i><span>Change Image</span>';
//     overlay.style.position = 'absolute';
//     overlay.style.top = '0';
//     overlay.style.left = '0';
//     overlay.style.width = '100%';
//     overlay.style.height = '100%';
//     overlay.style.display = 'flex';
//     overlay.style.flexDirection = 'column';
//     overlay.style.alignItems = 'center';
//     overlay.style.justifyContent = 'center';
//     overlay.style.background = 'rgba(0, 0, 0, 0.5)';
//     overlay.style.color = 'white';
//     overlay.style.borderRadius = '8px';
//     overlay.style.opacity = '0';
//     overlay.style.transition = 'opacity 0.3s';
    
//     // Add hover effect
//     uploadPlaceholder.onmouseover = () => overlay.style.opacity = '1';
//     uploadPlaceholder.onmouseout = () => overlay.style.opacity = '0';
    
//     // Add file input
//     const input = document.createElement('input');
//     input.type = 'file';
//     input.id = 'vehicleImage';
//     input.accept = 'image/*';
//     input.onchange = handleImageChange;
//     input.style.display = 'none';
    
//     // Add click handler
//     uploadPlaceholder.onclick = () => input.click();
    
//     // Append elements
//     uploadPlaceholder.appendChild(img);
//     uploadPlaceholder.appendChild(overlay);
//     uploadPlaceholder.appendChild(input);
    
//     // Update styling for the container
//     uploadPlaceholder.style.position = 'relative';
//     uploadPlaceholder.style.cursor = 'pointer';
// }

// // Function to close the vehicle modal
// function closeVehicleModal() {
//     const modal = document.getElementById('vehicleModal');
//     modal.style.display = 'none';
//     document.body.classList.remove('modal-open');
    
//     // Reset form
//     document.getElementById('vehicleForm').reset();
// }

// // Function to handle image selection for upload
// function handleImageChange(event) {
//     const file = event.target.files[0];
//     if (file) {
//         const reader = new FileReader();
//         reader.onload = function(e) {
//             updateImagePreview(e.target.result);
//         };
//         reader.readAsDataURL(file);
//     }
// }

// // Function to trigger the file upload dialog
// function triggerImageUpload() {
//     document.getElementById('vehicleImage').click();
// }

// // Function to handle form submission
// function handleVehicleSubmit(event) {
//     event.preventDefault();
    
//     // Get form values
//     const make = document.getElementById('make').value;
//     const model = document.getElementById('model').value;
//     const year = document.getElementById('year').value;
//     const licensePlate = document.getElementById('licensePlate').value;
//     const mileage = document.getElementById('mileage').value;
//     const imageFile = document.getElementById('vehicleImage').files[0];
    
//     // Create form data for submission
//     const formData = new FormData();
//     formData.append('make', make);
//     formData.append('model', model);
//     formData.append('year', year);
//     formData.append('plate_number', licensePlate);
//     formData.append('mileage', mileage);
    
//     if (imageFile) {
//         formData.append('vehicle_image', imageFile);
//     }
    
//     if (isEditMode && currentVehicleId) {
//         formData.append('vehicle_id', currentVehicleId);
//         formData.append('_method', 'PUT'); // For method spoofing if needed
//     }
    
//     // In a real application, you would send this data to the server via AJAX
//     // For demonstration, log the data and close the modal
//     console.log('Form Data:', Object.fromEntries(formData.entries()));
//     console.log('Mode:', isEditMode ? 'Edit' : 'Add');
    
//     // For demonstration purposes, simulate a successful submission
//     alert(`Vehicle ${isEditMode ? 'updated' : 'added'} successfully!`);
//     closeVehicleModal();
    
//     // In a real application, you would reload the vehicles or update the UI
//     // location.reload();
// }

// // Function to open delete confirmation modal
// function deleteVehicle(vehicleId) {
//     currentVehicleId = vehicleId;
//     const modal = document.getElementById('deleteModal');
//     modal.style.display = 'flex';
//     document.body.classList.add('modal-open');
// }

// // Function to close delete confirmation modal
// function closeDeleteModal() {
//     const modal = document.getElementById('deleteModal');
//     modal.style.display = 'none';
//     document.body.classList.remove('modal-open');
// }

// // Function to confirm vehicle deletion
// function confirmDelete() {
//     if (currentVehicleId) {
//         // In a real application, you would send an AJAX request to delete the vehicle
//         console.log('Deleting vehicle ID:', currentVehicleId);
        
//         // For demonstration purposes, simulate a successful deletion
//         alert('Vehicle deleted successfully!');
//         closeDeleteModal();
        
//         // In a real application, you would reload the vehicles or update the UI
//         // location.reload();
//     }
// }

// // Initialize event listeners when the document is ready
// document.addEventListener('DOMContentLoaded', function() {
//     // Add data-id attributes to vehicle cards for easier targeting
//     const vehicleCards = document.querySelectorAll('.vehicle-card');
//     vehicleCards.forEach((card, index) => {
//         card.setAttribute('data-id', index + 1);
        
//         // Update the edit button click handler
//         const editButton = card.querySelector('.action-button:nth-child(1)');
//         editButton.onclick = function() {
//             openAddVehicleModal(index + 1);
//         };
//     });
// });

// Global variables
let currentVehicleId = null;
let isEditMode = false;

// Function to open the vehicle modal
function openAddVehicleModal(vehicleId = null) {
    const modal = document.getElementById('vehicleModal');
    const modalTitle = modal.querySelector('.modal-header h2');
    const modalSubtitle = modal.querySelector('.modal-header p');
    const mode = document.getElementById('mode');
    const vehicleIdInput = document.getElementById('vehicleId');
    const submitButton = modal.querySelector('button[type="submit"]');
    
    // Reset form when opening
    document.getElementById('vehicleForm').reset();
    
    // Make sure the file input is properly reset and maintained
    let uploadPlaceholder = document.querySelector('.upload-placeholder');
    if (!uploadPlaceholder.querySelector('#vehicleImage')) {
        uploadPlaceholder.innerHTML = `
            <i class="fas fa-cloud-upload-alt"></i>
            <p>Click to upload vehicle image</p>
            <span>or drag and drop</span>
            <input type="file" id="vehicleImage" name="vehicleImage" hidden accept="image/*" onchange="handleImageChange(event)">
        `;
    }
    
    if (vehicleId) {
        // Edit mode
        isEditMode = true;
        currentVehicleId = vehicleId;
        modalTitle.textContent = 'Edit Vehicle';
        modalSubtitle.textContent = 'Update your vehicle details';
        mode.value = 'updateMode';
        vehicleIdInput.value = vehicleId;
        vehicleIdInput.type = "hidden";
        submitButton.innerHTML = '<i class="fas fa-save"></i> Update Vehicle';
        
        // Fetch and populate vehicle data
        fetchVehicleDetails(vehicleId);
    } else {
        // Add mode
        isEditMode = false;
        currentVehicleId = null;
        modalTitle.textContent = 'Add New Vehicle';
        modalSubtitle.textContent = 'Enter your vehicle details';
        mode.value = 'insertMode';
        vehicleIdInput.value = '';
        submitButton.innerHTML = '<i class="fas fa-save"></i> Save Vehicle';
        
        // Clear image preview
        uploadPlaceholder.innerHTML = `
            <i class="fas fa-cloud-upload-alt"></i>
            <p>Click to upload vehicle image</p>
            <span>or drag and drop</span>
            <input type="file" id="vehicleImage" name="vehicleImage" hidden accept="image/*" onchange="handleImageChange(event)">
        `;
    }
    
    modal.style.display = 'flex';
    document.body.classList.add('modal-open');
}

// Function to fetch vehicle details by ID
function fetchVehicleDetails(vehicleId) {
    // In a real application, this would be an AJAX call to your server
    // For demonstration, we'll simulate this with the data from the visible card
    
    // Get values from the current vehicle card
    const vehicleCard = document.querySelector(`.vehicle-card[data-id="${vehicleId}"]`);
    if (!vehicleCard) {
        console.error("Vehicle card not found");
        return;
    }
    
    const make = vehicleCard.querySelector('.vehicle-title').textContent.split(' ')[0];
    const model = vehicleCard.querySelector('.vehicle-title').textContent.split(' ')[1];
    const plateNumber = vehicleCard.querySelector('.info-item:nth-child(1) span').textContent;
    const year = vehicleCard.querySelector('.info-item:nth-child(2) span').textContent;
    const mileage = parseInt(vehicleCard.querySelector('.info-item:nth-child(3) span').textContent.replace(',', '').replace(' km', ''));
    const imageUrl = vehicleCard.querySelector('.vehicle-image').src;
    
    // Populate form fields
    document.getElementById('make').value = make;
    document.getElementById('model').value = model;
    document.getElementById('licensePlate').value = plateNumber;
    document.getElementById('year').value = year;
    document.getElementById('mileage').value = mileage;
    
    // Update image preview
    updateImagePreview(imageUrl);
}

// Function to update image preview
function updateImagePreview(imageUrl) {
    const uploadPlaceholder = document.querySelector('.upload-placeholder');
    
    // Save the original file input before clearing content
    const originalInput = document.getElementById('vehicleImage');
    
    // Clear existing content but maintain original input
    uploadPlaceholder.innerHTML = '';
    
    // Create image element
    const img = document.createElement('img');
    img.src = imageUrl;
    img.alt = 'Vehicle Preview';
    img.style.width = '100%';
    img.style.height = '100%';
    img.style.objectFit = 'cover';
    img.style.borderRadius = '8px';
    
    // Create overlay
    const overlay = document.createElement('div');
    overlay.className = 'preview-overlay';
    overlay.innerHTML = '<i class="fas fa-camera"></i><span>Change Image</span>';
    overlay.style.position = 'absolute';
    overlay.style.top = '0';
    overlay.style.left = '0';
    overlay.style.width = '100%';
    overlay.style.height = '100%';
    overlay.style.display = 'flex';
    overlay.style.flexDirection = 'column';
    overlay.style.alignItems = 'center';
    overlay.style.justifyContent = 'center';
    overlay.style.background = 'rgba(0, 0, 0, 0.5)';
    overlay.style.color = 'white';
    overlay.style.borderRadius = '8px';
    overlay.style.opacity = '0';
    overlay.style.transition = 'opacity 0.3s';
    
    // Add hover effect
    uploadPlaceholder.onmouseover = () => overlay.style.opacity = '1';
    uploadPlaceholder.onmouseout = () => overlay.style.opacity = '0';
    
    // Add click handler to trigger the existing file input
    uploadPlaceholder.onclick = triggerImageUpload;
    
    // Append elements
    uploadPlaceholder.appendChild(img);
    uploadPlaceholder.appendChild(overlay);
    uploadPlaceholder.appendChild(originalInput);
    
    // Update styling for the container
    uploadPlaceholder.style.position = 'relative';
    uploadPlaceholder.style.cursor = 'pointer';
}

// Function to close the vehicle modal
function closeVehicleModal() {
    const modal = document.getElementById('vehicleModal');
    modal.style.display = 'none';
    document.body.classList.remove('modal-open');
    
    // Reset form
    document.getElementById('vehicleForm').reset();
}

// Function to handle image selection for upload
function handleImageChange(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            updateImagePreview(e.target.result);
        };
        reader.readAsDataURL(file);
    }
}

// Function to trigger the file upload dialog
function triggerImageUpload() {
    document.getElementById('vehicleImage').click();
}

// Function to handle form submission
function handleVehicleSubmit(event) {
    event.preventDefault();
    
    // Get form values
    const make = document.getElementById('make').value;
    const model = document.getElementById('model').value;
    const year = document.getElementById('year').value;
    const licensePlate = document.getElementById('licensePlate').value;
    const mileage = document.getElementById('mileage').value;
    const imageFile = document.getElementById('vehicleImage').files[0];
    
    // Create form data for submission
    const formData = new FormData();
    formData.append('make', make);
    formData.append('model', model);
    formData.append('year', year);
    formData.append('plate_number', licensePlate);
    formData.append('mileage', mileage);
    
    if (imageFile) {
        formData.append('vehicleImage', imageFile); // Use 'vehicleImage' to match PHP
    }
    
    if (isEditMode && currentVehicleId) {
        formData.append('vehicleId', currentVehicleId);
        formData.append('mode', 'updateMode');
    } else {
        formData.append('mode', 'insertMode');
    }
    
    // Submit the form
    document.getElementById('vehicleForm').submit();
}

// Function to open delete confirmation modal
function deleteVehicle(vehicleId) {

    let vehicle_id_holder =  document.getElementById('deleteVehicleId');
    vehicle_id_holder.value = vehicleId;

    const modal = document.getElementById('deleteModal');
    modal.style.display = 'flex';
    document.body.classList.add('modal-open');
}

// Function to close delete confirmation modal
function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.style.display = 'none';
    document.body.classList.remove('modal-open');
}

// // Function to confirm vehicle deletion
// function confirmDelete() {
//     if (currentVehicleId) {
//         // In a real application, you would send an AJAX request to delete the vehicle
//         console.log('Deleting vehicle ID:', currentVehicleId);
        
//         // For demonstration purposes, simulate a successful deletion
//         alert('Vehicle deleted successfully!');
//         closeDeleteModal();
        
//         // In a real application, you would reload the vehicles or update the UI
//         // location.reload();
//     }
// }

// Initialize event listeners when the document is ready
document.addEventListener('DOMContentLoaded', function() {
    // Add data-id attributes to vehicle cards for easier targeting
    const vehicleCards = document.querySelectorAll('.vehicle-card');
    vehicleCards.forEach((card, index) => {
        const vehicleId = card.getAttribute('data-id');
        
        // Update the edit button click handler
        const editButton = card.querySelector('.edit-vehicle');
        if (editButton) {
            editButton.onclick = function() {
                openAddVehicleModal(vehicleId);
            };
        }
        
        // Update the delete button click handler
        const deleteButton = card.querySelector('.delete-vehicle');
        if (deleteButton) {
            deleteButton.onclick = function() {
                deleteVehicle(vehicleId);
            };
        }
    });
    
    // Attach form submit handler
    const vehicleForm = document.getElementById('vehicleForm');
    if (vehicleForm) {
        vehicleForm.addEventListener('submit', function(e) {
            // Let the form submit naturally
        });
    }
});