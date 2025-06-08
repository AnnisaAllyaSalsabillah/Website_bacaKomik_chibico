import './bootstrap';
const images = document.querySelectorAll('.carousel-image');
const radios = document.querySelectorAll('input[name="carousel-radio"]');
const prevBtn = document.getElementById('prev');
const nextBtn = document.getElementById('next');

let currentIndex = 0;

function showImage(index) {
  images.forEach((img, i) => {
    img.classList.toggle('active', i === index);
    radios[i].checked = (i === index);
  });
  currentIndex = index;
}

// Event: klik radio akan ganti gambar
radios.forEach((radio, i) => {
  radio.addEventListener('change', () => {
    if (radio.checked) {
      showImage(i);
    }
  });
});

// Event tombol prev
prevBtn.addEventListener('click', () => {
  let newIndex = (currentIndex - 1 + images.length) % images.length;
  showImage(newIndex);
});

// Event tombol next
nextBtn.addEventListener('click', () => {
  let newIndex = (currentIndex + 1) % images.length;
  showImage(newIndex);
});

// Tampilkan gambar pertama saat mulai
showImage(0);
