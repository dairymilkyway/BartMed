<!-- Login Modal -->
<div id="loginModal" class="fixed inset-0 z-50 hidden overflow-y-auto flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg mx-auto max-w-3xl w-full md:w-auto" style="width: 1080px; max-width: 90vw; max-height: 90vh; overflow: hidden;">
        <button id="closeLoginModal" class="absolute top-0 right-0 m-4 text-gray-600 hover:text-gray-800">&times;</button>
        <div style="max-height: 90vh; overflow: hidden;">
            <div style="width: 100%; height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                <div style="max-width: 90vw; max-height: calc(90vh - 100px); overflow-y: auto;">
                    <div style="width: 1080px;"> <!-- Adjust content width here -->
                        @include('login') <!-- Assuming login.blade.php exists -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Register Modal -->
<div id="registerModal" class="fixed inset-0 z-50 hidden overflow-y-auto flex items-center justify-center">
    <div class="bg-white p-2 rounded-lg shadow-lg mx-auto max-w-3xl w-full md:w-auto" style="width: 90vw; max-width: 1080px; max-height: 90vh;">
        <button id="closeRegisterModal" class="absolute top-0 right-0 m-2 text-gray-600 hover:text-gray-800">&times;</button>
        <div style="max-height: calc(90vh - 2rem); overflow-y: auto; width: 100%;">
            <div style="width: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                <div style="max-width: 100%; max-height: 100%; padding: 2px; box-sizing: border-box; font-size: 10px;">
                    @include('register') <!-- Assuming register.blade.php exists -->
                </div>
            </div>
        </div>
    </div>
</div>


<script>
function showModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.classList.remove('hidden');
    modal.classList.add('flex', 'animate-pop-in', 'shadow-lg');
    document.body.classList.add('overflow-hidden'); // Disable scrolling on body
}

function hideModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.classList.remove('flex', 'animate-pop-in', 'shadow-lg');
    modal.classList.add('hidden');
    document.body.classList.remove('overflow-hidden'); // Enable scrolling on body
}

// Attach event listeners to all buttons with the same class
document.querySelectorAll('.loginModalOpen').forEach(function(button) {
    button.addEventListener('click', function() {
        showModal('loginModal');
    });
});

document.querySelectorAll('.registerModalOpen').forEach(function(button) {
    button.addEventListener('click', function() {
        showModal('registerModal');
    });
});

document.getElementById('closeLoginModal').addEventListener('click', function() {
    hideModal('loginModal');
});

document.getElementById('closeRegisterModal').addEventListener('click', function() {
    hideModal('registerModal');
});

// Close modals by clicking outside
document.addEventListener('click', function(event) {
    if (event.target === document.getElementById('loginModal')) {
        hideModal('loginModal');
    }
    if (event.target === document.getElementById('registerModal')) {
        hideModal('registerModal');
    }
});

// Optional: Add animation classes to simulate modal pop-in
document.addEventListener('DOMContentLoaded', function() {
    var animatePopIn = document.createElement('style');
    animatePopIn.innerHTML = `
        @keyframes popIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-pop-in {
            animation: popIn 0.3s ease forwards;
        }
    `;
    document.head.appendChild(animatePopIn);
});

</script>