<script>
    function showToast(icon, title) {
        let backgroundColor, textColor;
        if (icon === 'success') {
            backgroundColor = '#28a745'; // Green for success
            textColor = '#ffffff'; // White text for better contrast
        } else if (icon === 'error') {
            backgroundColor = '#dc3545'; // Red for error
            textColor = '#ffffff'; // White text for better contrast
        }

        Swal.fire({
            toast: true,
            position: 'top-end', // You can change this position if desired
            icon: icon,
            title: title,
            showConfirmButton: false,
            timer: 3000, // Auto close after 3 seconds
            timerProgressBar: true,
            background: backgroundColor, // Set the background color
            color: textColor, // Set the text color
            confirmButtonColor: icon === 'success' ? '#3085d6' : '#d33'
        });
    }

    // SweetAlert for success and error messages as toasts
    document.addEventListener('DOMContentLoaded', function () {
        @if (session('toast'))
            showToast('success', "{{ session('toast') }}");
        @elseif (session('toast_error'))
            showToast('error', "{{ session('toast_error') }}");
        @endif
    });
</script>