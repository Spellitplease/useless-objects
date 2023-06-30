function handleAvatarChange(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const preview = document.getElementById('avatar-preview');
            preview.src = e.target.result;
            document.getElementById('avatar-url').value = e.target.result; // Update the hidden input value
        };
        reader.readAsDataURL(input.files[0]);
    }
}

document.getElementById('avatar-input').addEventListener('change', handleAvatarChange);