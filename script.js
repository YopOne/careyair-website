// script.js
document.addEventListener('DOMContentLoaded', () => {
    
    // 1. Smooth Scroll for the Hero Button
    const consultBtn = document.getElementById('consult-btn');
    const contactSection = document.getElementById('contact');

    consultBtn.addEventListener('click', () => {
        contactSection.scrollIntoView({ behavior: 'smooth' });
    });

    // 2. Handle Contact Form Submission
    const contactForm = document.getElementById('contact-form');
    const formFeedback = document.getElementById('form-feedback');

    contactForm.addEventListener('submit', (e) => {
        // Prevent the page from actually refreshing
        e.preventDefault(); 
        
        // Grab the name of the user for a personalized message
        const name = document.getElementById('name').value;
        const projectType = document.getElementById('project-type').options[document.getElementById('project-type').selectedIndex].text;

        // Hide the form visually 
        contactForm.style.display = 'none';

        // Show a success message based on their inputs
        formFeedback.classList.remove('hidden');
        formFeedback.classList.add('success');
        formFeedback.innerHTML = `
            Thank you, ${name}! <br>
            Your inquiry regarding <strong>${projectType}</strong> has been received. 
            An engineering consultant will be in touch shortly.
        `;
    });
});