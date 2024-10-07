const loginForm = document.getElementById('login-form');
const signupForm = document.getElementById('signup-form');
const loginToggle = document.getElementById('login-toggle');
const signupToggle = document.getElementById('signup-toggle');

loginToggle.addEventListener('click', () => {
    loginForm.classList.add('active');
    signupForm.classList.remove('active');
    loginToggle.classList.add('active');
    signupToggle.classList.remove('active');
});

signupToggle.addEventListener('click', () => {
    signupForm.classList.add('active');
    loginForm.classList.remove('active');
    signupToggle.classList.add('active');
    loginToggle.classList.remove('active');
});

function onSignIn(googleUser) {
    var profile = googleUser.getBasicProfile();
    console.log('ID: ' + profile.getId());
    console.log('Name: ' + profile.getName());
    console.log('Email: ' + profile.getEmail());
    // You can send the profile information to your server for further processing
}


function toggleModuleDetails(moduleId) {
    const detailsElement = document.getElementById(`module-details-${moduleId}`);
    detailsElement.classList.toggle('show');
}


const viewLinks = document.querySelectorAll('.view-link');
viewLinks.forEach(link => {
    link.addEventListener('click', (event) => {
        event.preventDefault();
        const moduleId = link.getAttribute('data-module-id');
        toggleModuleDetails(moduleId);
    });
});


const deregisterLinks = document.querySelectorAll('.deregister-link');
deregisterLinks.forEach(link => {
    link.addEventListener('click', (event) => {
        event.preventDefault();
        const moduleId = link.getAttribute('data-module-id');
        if (confirm(`Are you sure you want to deregister from this module?`)) {
            console.log(`Deregistering from module ${moduleId}`);
        }
    });
});


const navLinks = document.querySelectorAll('nav ul li a');


navLinks.forEach(link => {
  link.addEventListener('click', (event) => {
    event.preventDefault(); 
   
    const sections = document.querySelectorAll('main section > div');
    sections.forEach(section => section.style.display = 'none');

    
    const targetId = link.getAttribute('href').substring(1);
    const targetSection = document.getElementById(targetId + '-section');
    if (targetSection) {
      targetSection.style.display = 'block';
    }
  });
});