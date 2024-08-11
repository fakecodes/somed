import Tagify from '@yaireo/tagify';

// Import the Tagify CSS
import '@yaireo/tagify/dist/tagify.css';

// Your existing imports
import './bootstrap';

// Initialize Tagify on the input field
document.addEventListener('DOMContentLoaded', function () {
    let input = document.querySelector('#interests');

    if (input) {
        new Tagify(input, {
            delimiters: ",| ",
            maxTags: 10,
            whitelist: [] // You can provide predefined tags here if needed
        });
    }
});

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();