window.addEventListener('scroll', function() {
  const header = document.getElementById('header');
  const reNav = document.querySelector('.reNav');
  if (window.scrollY > 0) {
      header.classList.add('scrolled');
      reNav.style.height = `calc(100% - 69px)`;
    } else {
        header.classList.remove('scrolled');
        reNav.style.height = `calc(100% - 50px)`;
  }
  });

document.querySelectorAll('#submission2 .faq-question').forEach(button => {
    button.addEventListener('click', () => {
        const answer = button.nextElementSibling;

        button.classList.toggle('active');

        if (button.classList.contains('active')) {
            answer.style.display = 'block';
        } else {
            answer.style.display = 'none';
        }
    });
});

const buttons = document.querySelectorAll('.tab-button');
  const contents = document.querySelectorAll('.content');
  const image = document.getElementById('image-display');

  const imageMap = {
    summarization: 'demo.galeribukujakarta.com/img/a1.jpg',
    read: 'demo.galeribukujakarta.com/img/a1.jpg',
    toolbar: 'demo.galeribukujakarta.com/img/a1.jpg'
  };

  buttons.forEach(button => {
    button.addEventListener('click', () => {
      // aktifkan tombol
      buttons.forEach(btn => btn.classList.remove('active'));
      button.classList.add('active');

      // tampilkan konten
      const tab = button.getAttribute('data-tab');
      contents.forEach(c => c.style.display = 'none');
      document.getElementById(tab).style.display = 'block';

      // ubah gambar
      image.src = imageMap[tab];
    });
  });






