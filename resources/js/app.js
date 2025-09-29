import './bootstrap';
import '../css/app.css'
 document.addEventListener('DOMContentLoaded', () => {
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        const mobileMenu = document.getElementById('mobileMenu');
        const menuIcon = document.getElementById('menuIcon');
        const closeIcon = document.getElementById('closeIcon');

        const profileButton = document.getElementById('profileButton');
        const profileDropdown = document.getElementById('profileDropdown');

        // 1. Mobile Menu Toggle
        mobileMenuButton.addEventListener('click', () => {
            // Toggle the visibility of the mobile menu
            mobileMenu.classList.toggle('hidden');

            // Toggle the menu icons (hamburger <-> close)
            menuIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');

            // Ensure profile dropdown is closed when opening mobile menu
            if (!profileDropdown.classList.contains('hidden')) {
                profileDropdown.classList.add('hidden');
            }
        });

        // 2. Profile Dropdown Toggle
        profileButton.addEventListener('click', (event) => {
            // Prevent the click from propagating to the document listener below
            event.stopPropagation();
            
            // Toggle the visibility of the profile dropdown
            profileDropdown.classList.toggle('hidden');
        });

        // 3. Close dropdown when clicking outside
        document.addEventListener('click', (event) => {
            // Check if the click is outside the profile button and dropdown
            if (!profileButton.contains(event.target) && !profileDropdown.contains(event.target)) {
                profileDropdown.classList.add('hidden');
            }
        });
    });