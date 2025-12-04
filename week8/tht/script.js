document.addEventListener('DOMContentLoaded', function() {
  // Ambil elemen form
  const form = document.getElementById('contactForm');
  const successMessage = document.getElementById('successMessage');
  
  // Fungsi untuk cek email valid
  function cekEmailValid(email) {
    const pola = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return pola.test(email);
  }
  
  // Fungsi untuk tampilkan error
  function tampilkanError(inputId, pesan) {
    const input = document.getElementById(inputId);
    const errorSpan = document.getElementById(inputId + 'Error');
    
    // Tambah border merah
    input.classList.add('border-red-500');
    // Tampilkan pesan error
    errorSpan.textContent = pesan;
  }
  
  // Fungsi untuk hapus semua error
  function hapusError() {
    // Hapus semua pesan error
    document.querySelectorAll('[id$="Error"]').forEach(el => {
      el.textContent = '';
    });
    
    // Hapus border merah
    document.querySelectorAll('.border-red-500').forEach(el => {
      el.classList.remove('border-red-500');
    });
    
    // Sembunyikan pesan sukses
    successMessage.classList.add('hidden');
  }
  
  // Fungsi untuk validasi form
  function validasiForm() {
    let valid = true;
    
    // Ambil nilai input
    const nama = document.getElementById('nama').value.trim();
    const email = document.getElementById('email').value.trim();
    const pesan = document.getElementById('pesan').value.trim();
    
    // Validasi Nama
    if (!nama) {
      tampilkanError('nama', 'Nama harus diisi');
      valid = false;
    }
    
    // Validasi Email
    if (!email) {
      tampilkanError('email', 'Email harus diisi');
      valid = false;
    } else if (!cekEmailValid(email)) {
      tampilkanError('email', 'Email tidak valid');
      valid = false;
    }
    
    // Validasi Pesan
    if (!pesan) {
      tampilkanError('pesan', 'Pesan harus diisi');
      valid = false;
    }
    
    return valid;
  }
  
  // Event saat form disubmit
  form.addEventListener('submit', function(event) {
    // Cegah halaman reload
    event.preventDefault();
    
    // Hapus error sebelumnya
    hapusError();
    
    // Validasi form
    if (validasiForm()) {
      // Tampilkan pesan sukses
      successMessage.textContent = 'Pesan berhasil dikirim!';
      successMessage.classList.remove('hidden');
      
      // Reset form
      form.reset();
      
      // Sembunyikan pesan sukses setelah 5 detik
      setTimeout(() => {
        successMessage.classList.add('hidden');
      }, 5000);
    }
  });
  
  // Hapus error saat user mengetik
  ['nama', 'email', 'pesan'].forEach(inputId => {
    document.getElementById(inputId).addEventListener('input', function() {
      this.classList.remove('border-red-500');
      document.getElementById(inputId + 'Error').textContent = '';
    });
  });
});