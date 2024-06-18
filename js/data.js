const testimoniData = [
  {
    nama: "Icha",
    komentar:
      "Paket mendarat aman sampe bandung. Good packaging dan juga sudah ada sertifikasi halal dan pirt",
  },
  {
    nama: "Maulina",
    komentar:
      "Suka banget produknya segar, jarang-jarang nemu minuman yang ringan tapi fulfilling. Enak!",
  },
];

function updateTestimonial(index) {
  const testimonial = testimoniData[index];
  const testimonialQuote = document.querySelector(".testimoni-quote");
  const testimonialPerson = document.querySelector(".testimoni-person");

  testimonialQuote.textContent = `"${testimonial.komentar}"`;
  testimonialPerson.textContent = testimonial.nama;
}

let currentIndex = 0;
updateTestimonial(currentIndex);

document.querySelector(".left").addEventListener("click", function () {
  currentIndex = (currentIndex + 1) % testimoniData.length;
  updateTestimonial(currentIndex);
});

document.querySelector(".right").addEventListener("click", function () {
  currentIndex =
    (currentIndex - 1 + testimoniData.length) % testimoniData.length;
  updateTestimonial(currentIndex);
});
