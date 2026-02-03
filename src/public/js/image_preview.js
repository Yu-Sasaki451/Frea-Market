const input = document.getElementById('imageInput');
const preview = document.getElementById('imagePreview');
const box = document.querySelector('.sell-image__box');

input.addEventListener('change', () => {
  const file = input.files[0];
  preview.innerHTML = file ? `<img src="${URL.createObjectURL(file)}">` : '';
  box.classList.toggle('has-image', !!file);
});
