import './bootstrap';
import 'flowbite';

// import './app-calendars.js';
// import './app-chart.js';
import './app-notification.js';
// import './app-pagination.js';
import './app-toggles.js';

const tabs = document.querySelectorAll('.tab-button');
const contents = document.querySelectorAll('.tab-content');

tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        const target = tab.id.replace('tab-', 'content-');

        // Reset all tabs and contents
        tabs.forEach(btn => btn.classList.remove('border-blue-500', 'text-blue-500', 'bg-gray-200'));
        contents.forEach(content => content.classList.add('hidden'));

        // Activate the clicked tab and corresponding content
        tab.classList.add('border-blue-500', 'text-blue-500', 'bg-gray-200');
        document.getElementById(target).classList.remove('hidden');
    });
});

const images = document.querySelectorAll('.image-fullscreen'); // Select all elements with the class

images.forEach(image => {
    image.addEventListener('click', () => {
        if (image.requestFullscreen) {
            image.requestFullscreen();
        } else if (image.webkitRequestFullscreen) { // Safari
            image.webkitRequestFullscreen();
        } else if (image.msRequestFullscreen) { // IE11
            image.msRequestFullscreen();
        }
    });
});

// Optionally, you can add a listener to exit fullscreen on "Escape" or click outside
document.addEventListener('fullscreenchange', () => {
    if (!document.fullscreenElement) {
        console.log('Exited fullscreen');
    }
});

// for security purposes

// document.addEventListener("contextmenu", function (e) {
//     e.preventDefault();
//     alert("Right-click is disabled on this page.");
// });

// document.onkeydown = function(e) {
//     if (e.key == "F12" || (e.ctrlKey && e.shiftKey && (e.key == "I" || e.key == "J")) || (e.ctrlKey && e.key == "U")) {
//       e.preventDefault();
//       alert("Inspecting elements is disabled.");
//     }
// };

// (function() {
//     console.log("%cThis is a browser feature intended for developers. If someone told you to copy-paste something here to enable a feature, it is a scam.", "font-size: 48px; color: red; font-weight: bold;");
// })();

