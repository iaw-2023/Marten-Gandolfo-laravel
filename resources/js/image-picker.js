const imageInput = document.getElementById('image-picker');
const previewImage = document.getElementById('preview-image');
const encodedImageInput = document.getElementById('image');

if (!encodedImageInput.value) {
    previewImage.style.display = 'none';
}

imageInput.addEventListener('change', function () {
    const file = imageInput.files[0];
    const reader = new FileReader();

    reader.onloadend = function () {
        const image = new Image();
        image.src = reader.result;

        image.onload = function () {
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');

            const targetWidth = 400;
            const targetHeight = 250;

            const imageWidth = image.width;
            const imageHeight = image.height;

            let width = targetWidth;
            let height = targetHeight;

            // Calculate the aspect ratio
            const aspectRatio = imageWidth / imageHeight;

            // Adjust the width or height to maintain the aspect ratio
            if (imageWidth > targetWidth || imageHeight > targetHeight) {
                if (aspectRatio > 1) {
                    width = targetWidth;
                    height = width / aspectRatio;
                } else {
                    height = targetHeight;
                    width = height * aspectRatio;
                }
            }

            // Calculate the position to center the image on the canvas
            const x = (targetWidth - width) / 2;
            const y = (targetHeight - height) / 2;

            // Set the canvas dimensions
            canvas.width = targetWidth;
            canvas.height = targetHeight;

            // Clear the canvas with transparent background
            context.clearRect(0, 0, targetWidth, targetHeight);

            // Draw the image on the canvas
            context.drawImage(image, x, y, width, height);

            const base64Data = canvas.toDataURL('image/webp').split(',')[1];
            if (base64Data) {
                previewImage.src = canvas.toDataURL('image/webp');
                previewImage.style.display = 'block';
                encodedImageInput.value = base64Data;
            } else {
                previewImage.style.display = 'none';
                encodedImageInput.value = '';
            }
        };
    };

    if (file) {
        reader.readAsDataURL(file);
    } else {
        previewImage.style.display = 'none';
        encodedImageInput.value = '';
    }
});