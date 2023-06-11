const imageInput = document.getElementById('image-picker');
        const previewImage = document.getElementById('preview-image');
        const encodedImageInput = document.getElementById('image');

        if(!encodedImageInput.value){
                previewImage.style.display = 'none';
        }

        imageInput.addEventListener('change', function () {
            const file = imageInput.files[0];
            const reader = new FileReader();

            reader.onloadend = function () {
                const base64Data = reader.result;
                if (base64Data) {
                    previewImage.src = base64Data;
                    previewImage.style.display = 'block';
                    encodedImageInput.value = base64Data.split(',')[1];
                } else {
                    previewImage.style.display = 'none';
                    encodedImageInput.value = '';
                }
            };

            if (file) {
                reader.readAsDataURL(file);
            } else {
                previewImage.style.display = 'none';
                encodedImageInput.value = '';
            }
        });