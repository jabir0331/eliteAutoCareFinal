// Script for the signup and login popup functionality
const signupModal = document.getElementById('signupModal');
const loginModal = document.getElementById('loginModal');
const closeSignupModal = document.getElementById('closeModal');
const closeLoginModal = document.getElementById('closeLoginModal');
const getStartedBtn = document.querySelector('.button-primary');
const switchToLoginBtn = document.querySelector('.signin-link a');
const switchToSignupBtn = document.getElementById('switchToSignup');
const step1 = document.getElementById('step1');
const step2 = document.getElementById('step2');
const modalTitle = document.getElementById('modalTitle');
const modalSubtitle = document.getElementById('modalSubtitle');
const dots = document.querySelectorAll('.dot');
let currentStep = 1;

// Open signup modal
getStartedBtn.addEventListener('click', () => {
    signupModal.classList.add('active');
    document.body.style.overflow = 'hidden';
});

// Switch to login modal
switchToLoginBtn.addEventListener('click', (e) => {
    e.preventDefault();
    signupModal.classList.remove('active');
    loginModal.classList.add('active');
});

// Switch to signup modal
switchToSignupBtn.addEventListener('click', () => {
    loginModal.classList.remove('active');
    signupModal.classList.add('active');
    currentStep = 1;
    updateStepVisibility();
});


// Close signup modal
closeSignupModal.addEventListener('click', () => {
    signupModal.classList.remove('active');
    document.body.style.overflow = '';
    currentStep = 1;
    updateStepVisibility();
});

// Close login modal
closeLoginModal.addEventListener('click', () => {
    loginModal.classList.remove('active');
    document.body.style.overflow = '';
});


// Close modals when clicking outside
window.addEventListener('click', (e) => {
    if (e.target === signupModal) {
        signupModal.classList.remove('active');
        document.body.style.overflow = '';
        currentStep = 1;
        updateStepVisibility();
    }
    if (e.target === loginModal) {
        loginModal.classList.remove('active');
        document.body.style.overflow = '';
    }
});
function nextStep() {
    currentStep = 2;
    updateStepVisibility();
}

function backStep() {
    currentStep = 1;
    updateStepVisibility();
}

function updateStepVisibility() {
    if (currentStep === 1) {
        step1.style.display = 'block';
        step2.style.display = 'none';
        modalTitle.textContent = 'Create Account';
        modalSubtitle.textContent = 'Join Elite Auto Care for smart car maintenance';
    } else {
        step1.style.display = 'none';
        step2.style.display = 'block';
        modalTitle.textContent = 'Car Details';
        modalSubtitle.textContent = 'Help us provide personalized service recommendations';
    }

    // Update progress dots
    dots.forEach((dot, index) => {
        dot.classList.toggle('active', index + 1 <= currentStep);
    });
}

