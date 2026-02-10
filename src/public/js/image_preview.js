const input =
  document.getElementById('imageInput') ||
  document.getElementById('image-input');
const preview = document.getElementById('imagePreview');
const box = document.querySelector('.sell-image__box');

if (input && preview) {
  input.addEventListener('change', () => {
    const file = input.files[0];
    if (!file) {
      preview.innerHTML = '';
      if (box) box.classList.remove('has-image');
      return;
    }

    const img = document.createElement('img');
    img.src = URL.createObjectURL(file);
    img.onload = () => URL.revokeObjectURL(img.src);
    preview.innerHTML = '';
    preview.appendChild(img);
    if (box) box.classList.add('has-image');
  });
}
