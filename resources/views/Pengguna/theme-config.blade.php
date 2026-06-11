<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

<script>
  tailwind.config = {
    darkMode: "class",
    theme: {
      extend: {
        colors: {
          // Palette Burgundy Estetik
          primary: "#800020",    /* Burgundy Utama (Tombol & Judul) */
          secondary: "#4A0404",  /* Burgundy Gelap (Hover) */
          tertiary: "#A52A2A",   /* Deep Brown/Red */
          background: "#ffffff", /* Tetap Putih agar bersih */
          surface: "#ffffff",
          "on-primary": "#ffffff",
          "on-background": "#2D0909",
          "on-surface": "#2D0909",
        },
        fontFamily: {
          headline: ["Manrope"],
          body: ["Inter"],
        },
      },
    },
  };
</script>

<style>
  /* Ganti warna teks judul jadi Burgundy */
  h1, h2, h3, .font-headline, .text-teal-900, .text-teal-700 {
    color: #800020 !important;
  }

  /* Ganti border bawah link aktif di navbar */
  .border-teal-700, .border-teal-300 {
    border-color: #800020 !important;
  }

  /* Hero gradient jadi gradasi merah anggur yang mewah */
  .hero-gradient {
    background: linear-gradient(135deg, #800020 0%, #4A0404 100%) !important;
  }

  /* Perbaiki warna tombol "Sign Up" atau tombol primer lainnya */
  .bg-primary {
    background-color: #800020 !important;
    color: #ffffff !important;
  }

  /* Hover effect pada tombol */
  .bg-primary:hover {
    background-color: #4A0404 !important;
  }

  /* Warna icon agar senada */
  .text-primary, .material-symbols-outlined {
    color: #800020 !important;
  }

  /* Tambahan untuk teks sekunder agar tetap estetik (tidak terlalu hitam) */
  .text-on-surface-variant {
    color: #5D4037 !important;
  }
</style>