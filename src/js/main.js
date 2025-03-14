$(document).ready(function() {
    var theme = $('#theme');
    var isDark = localStorage.getItem('theme');
    if (isDark === "true") {
        theme.prop('checked', true);
    } else {
        theme.prop('checked', false);
    }

    theme.change(function() {
        console.log('----------------');
        if (localStorage.getItem('theme') === "false") {
            console.log('true');
            localStorage.setItem('theme', "true");
        } else {
            console.log('false');
            localStorage.setItem('theme', "false");
        }
    });
});

// Helper function to get DaisyUI alert class based on type
function getAlertClass(type) {
    switch (type) {
        case 'success': return 'alert-success';
        case 'error': return 'alert-error';
        case 'warning': return 'alert-warning';
        default: return 'alert-info';
    }
}

function showToast(message, type = 'info') {
    // Create toast element
    const toastId = 'toast-' + Date.now();
    
    const toastHTML = `
        <div id="${toastId}" class="toast toast-end">
            <div class="alert ${getAlertClass(type)}">
                <span>${message}</span>
            </div>
        </div>
    `;
    
    // Add to DOM
    $('body').append(toastHTML);
    
    // Show the toast
    setTimeout(() => {
        $(`#${toastId}`).addClass('opacity-100');
    }, 100);
    
    // Remove after 3 seconds
    setTimeout(() => {
        $(`#${toastId}`).addClass('opacity-0');
        setTimeout(() => {
            $(`#${toastId}`).remove();
        }, 500);
    }, 3000);
}