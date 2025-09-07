document.addEventListener('DOMContentLoaded', function() {
        var dropdowns = document.querySelectorAll('.dropdown');

        dropdowns.forEach(function(dropdown) {
            var dropdownBtn = dropdown.querySelector('.dropdown-btn');
            var dropdownContent = dropdown.querySelector('.dropdown-content');

            dropdownBtn.addEventListener('click', function(event) {
                event.preventDefault();
               
                if (dropdownContent.style.display === 'block') {
                    dropdownContent.style.display = 'none';
                } else {
                    dropdownContent.style.display = 'block';
                }
            });
        });
    });