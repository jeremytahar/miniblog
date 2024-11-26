    // Prévisualisation dynamique de l'image sélectionnée
    const photoInput = document.getElementById('photo');
    const preview = document.getElementById('preview');

    photoInput.addEventListener('change', (event) => {
        const file = event.target.files[0];  

        if (file) {
            const reader = new FileReader();

            reader.onload = (e) => {
                preview.src = e.target.result;
                preview.style.display = 'block';  
            };

            reader.readAsDataURL(file);
        } else {
            preview.src = "";
            preview.style.display = 'none';
        }
    });