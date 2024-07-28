function showAlert(type, message) {
    var alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    var alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            <strong>${type === 'success' ? 'Success!' : 'Error!'}</strong> ${message}
            <button type="button" class="btn-close" aria-label="Close"></button>
        </div>
    `;
    
    var alertContainer = document.getElementById('alertContainer');
    alertContainer.innerHTML = alertHtml;

    // Automatically remove the alert after 2 seconds
    setTimeout(() => {
        var alertElement = alertContainer.querySelector('.alert');
        if (alertElement) {
            alertElement.classList.remove('show'); // Optionally handle fade-out animation
            alertElement.classList.add('fade'); // Handle fade-out animation if needed
            setTimeout(() => {
                alertElement.remove();
            }, 150); // Adjust timeout to match your CSS transition duration
        }
    }, 2000); // 2 seconds delay
}