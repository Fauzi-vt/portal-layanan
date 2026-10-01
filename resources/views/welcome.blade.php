<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portal Resmi Dinas Komunikasi dan Informatika (Diskominfo) Kabupaten Tasikmalaya - Pelayanan Administrasi Publik Terpadu 39 Kecamatan">
    <title>Diskominfo Kabupaten Tasikmalaya — Portal Layanan Publik Terpadu</title>

    {{-- Google Fonts: Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>

    <style>
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        body { letter-spacing: -0.01em; }
        h1, h2, h3 { letter-spacing: -0.02em; }
        [data-lucide] { display: inline-block; vertical-align: middle; }

        .bg-yellow-ppid {
            background: linear-gradient(135deg, #fcd34d 0%, #facc15 60%, #eab308 100%);
        }

        /* ── Exact AICLASSASEAN Style Card System ── */
        .aiclass-section {
            background-color: #ffffff;
            padding: 55px 0 45px 0;
            text-align: center;
            position: relative;
        }
        .aiclass-filter-bar {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 26px;
            margin-bottom: 36px;
        }
        .aiclass-filter-btn {
            color: #666666;
            border: solid 1px #666666;
            background: #ffffff;
            font-weight: 700;
            font-size: 0.95rem;
            padding: 8px 24px;
            border-radius: 10px;
            transition: all 0.2s ease;
            cursor: pointer;
            outline: none;
            text-decoration: none;
        }
        .aiclass-filter-btn.active, .aiclass-filter-btn:hover {
            background: linear-gradient(-90deg, #ca6673 0%, #9177c7 50%, #4796e3 100%) !important;
            color: #ffffff !important;
            border-color: transparent !important;
            box-shadow: 0 4px 14px rgba(71, 150, 227, 0.25);
        }
        .aiclass-card {
            background: #ffffff;
            border: solid 1px #666666;
            border-radius: 20px;
            padding: 15px 15px 0 15px;
            text-align: left;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
            width: 320px;
            min-width: 320px;
            max-width: 320px;
            height: 485px;
            box-sizing: border-box;
            flex-shrink: 0;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .aiclass-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 22px rgba(0, 0, 0, 0.08);
        }
        .aiclass-card .card-img-wrap {
            border-radius: 15px;
            overflow: hidden;
            aspect-ratio: 16 / 9;
            width: 100%;
            background-color: #f1f5f9;
        }
        .aiclass-card .card-img-wrap img {
            border-radius: 15px;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
            display: block;
        }
        .aiclass-card:hover .card-img-wrap img {
            transform: scale(1.15);
        }
        .aiclass-card .tags {
            margin-top: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .aiclass-card .tags .competency {
            display: inline-block;
            border-radius: 5px;
            background-color: #355bdc;
            font-weight: 700;
            padding: 4px 8px;
            color: #ffffff;
            font-size: 0.65rem;
            line-height: 1.1;
        }
        .aiclass-card .tags .time {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            border-radius: 5px;
            background-color: #e84435;
            font-weight: 700;
            padding: 4px 8px;
            color: #ffffff;
            font-size: 0.65rem;
            line-height: 1.1;
        }
        .aiclass-card h5 {
            margin-top: 10px;
            margin-bottom: 0;
            font-weight: 700;
            font-size: 1.05rem;
            color: #000000;
            height: 56px;
            display: flex;
            align-items: center;
            line-height: 1.3;
            overflow: hidden;
        }
        .aiclass-card .meta-row {
            margin-top: 10px;
            border-top: solid 1px #000000;
            border-bottom: solid 1px #000000;
            font-size: 0.8rem;
            color: #333333;
            padding: 6px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0;
        }
        .aiclass-card .btn-detail {
            background-color: #ff9d00;
            font-weight: 700;
            color: #ffffff;
            border-radius: 15px 15px 0 0;
            font-size: 0.8rem;
            padding: 6px 20px;
            display: inline-block;
            margin-top: 10px;
            transition: background-color 0.2s ease;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }
        .aiclass-card .btn-detail:hover {
            background-color: #e68d00;
            color: #ffffff;
        }
        .aiclass-controls {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin-top: 24px;
        }
        .aiclass-nav-arrow {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: solid 1px #666666;
            background: #ffffff;
            color: #666666;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .aiclass-nav-arrow:hover {
            border-color: #000000;
            color: #000000;
            background-color: #f8fafc;
        }

        /* ── Exact AICLASSASEAN Style Header Login Button ── */
        .btn-join {
            background-color: #355bdc;
            color: #ffffff !important;
            font-weight: 700;
            padding: 5px 6px 5px 12px;
            display: inline-flex;
            align-items: center;
            border-radius: 6px;
            white-space: nowrap;
            text-decoration: none;
            font-size: 0.85rem;
            line-height: 1.2;
            transition: all 0.25s ease;
            box-shadow: 0 2px 6px rgba(53, 91, 220, 0.2);
            cursor: pointer;
        }
        .btn-join span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #ffffff;
            border-radius: 4px;
            color: #355bdc;
            width: 20px;
            height: 20px;
            margin-left: 8px;
            font-size: 0.65rem;
            transition: transform 0.2s ease;
        }
        .btn-join:hover {
            background: linear-gradient(-90deg, #ca6673 0%, #9177c7 50%, #4796e3 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 14px rgba(71, 150, 227, 0.35);
        }
        .btn-join:hover span {
            transform: translateX(2px);
            color: #ca6673;
        }

        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-800 antialiased selection:bg-[#0a2558] selection:text-white"
      x-data="{
          mobileNav: false,
          dropdownLayanan: false,
          dropdownPpid: false,
          mobileLayanan: false,
          mobilePpid: false,
          currentSlide: 0,
          timer: null,
          slides: [
              {
                  badge: 'Dinas Komunikasi dan Informatika Kabupaten Tasikmalaya',
                  title: 'Transformasi Digital Layanan Publik Terpadu',
                  desc: 'Pelayanan Administrasi Kependudukan, Perizinan, dan Keterbukaan Informasi Terintegrasi untuk Seluruh 39 Kecamatan se-Kabupaten Tasikmalaya.',
                  image: 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=1920&q=80',
                  ctaText: 'Jelajahi 8 Layanan Utama',
                  ctaLink: '#layanan',
                  btnSec: 'Masuk Akun Warga',
                  btnSecLink: '{{ route('login') }}'
              },
              {
                  badge: 'Pelayanan Terpadu Satu Pintu',
                  title: 'Pengurusan Izin & Berkas Cepat Tanpa Antre',
                  desc: 'Ajukan Kartu Identitas Anak (KIA), e-KTP Biometrik, Surat Pindah, dan dokumen kependudukan secara digital langsung dari genggaman Anda.',
                  image: 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=1920&q=80',
                  ctaText: 'Mulai Buat Permohonan',
                  ctaLink: '{{ route('login') }}',
                  btnSec: 'Lihat Syarat Berkas',
                  btnSecLink: '#layanan'
              },
              {
                  badge: 'Keterbukaan Informasi Publik (PPID)',
                  title: 'Transparan, Akuntabel, dan Mudah Diakses',
                  desc: 'Akses informasi publik resmi sesuai UU No. 14 Tahun 2008 dan sampaikan aspirasi masyarakat langsung melalui portal resmi Diskominfo.',
                  image: 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1920&q=80',
                  ctaText: 'Layanan PPID Kabupaten',
                  ctaLink: '#ppid',
                  btnSec: 'Layanan Pengaduan',
                  btnSecLink: '#pengaduan'
              },
              {
                  badge: 'Pemerintah Kabupaten Tasikmalaya',
                  title: 'Kolaborasi Menuju Pelayanan Prima 39 Kecamatan',
                  desc: 'Menghubungkan seluruh 39 Kecamatan dan 351 Desa dalam ekosistem digital yang terintegrasi, transparan, dan terenkripsi aman.',
                  image: 'https://images.unsplash.com/photo-1577495508048-b635879837f1?auto=format&fit=crop&w=1920&q=80',
                  ctaText: 'Masuk ke Portal',
                  ctaLink: '{{ route('login') }}',
                  btnSec: 'Daftar Akun Baru',
                  btnSecLink: '{{ route('register') }}'
              }
          ],
          nextSlide() {
              this.currentSlide = (this.currentSlide + 1) % this.slides.length;
          },
          prevSlide() {
              this.currentSlide = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
          },
          goToSlide(index) {
              this.currentSlide = index;
          },
          startAutoPlay() {
              this.timer = setInterval(() => {
                  this.nextSlide();
              }, 5000);
          },
          stopAutoPlay() {
              clearInterval(this.timer);
          },

          {{-- PPID & Interactivity State --}}
          showPpidModal: false,
          showPpidSuccessModal: false,
          showTrackingModal: false,
          showPengaduanModal: false,
          showDocPreviewModal: false,
          selectedDoc: null,
          activePpidTab: 'dokumen',
          ppidCategory: 'all',
          ppidSearch: '',
          toast: { show: false, message: '', type: 'success' },
          toastTimeout: null,

          triggerToast(msg, type = 'success') {
              if (this.toastTimeout) clearTimeout(this.toastTimeout);
              this.toast.message = msg;
              this.toast.type = type;
              this.toast.show = true;
              this.toastTimeout = setTimeout(() => {
                  this.toast.show = false;
              }, 3500);
          },

          openPpidModal() {
              this.showPpidModal = true;
              this.$nextTick(() => { window.lucide?.createIcons(); });
          },

          openPpidTracking(code = '') {
              if (code) {
                  this.trackingInput = code;
                  this.checkTracking(code);
              }
              this.showTrackingModal = true;
              this.$nextTick(() => { window.lucide?.createIcons(); });
          },

          openPengaduan() {
              this.showPengaduanModal = true;
              this.$nextTick(() => { window.lucide?.createIcons(); });
          },

          openDocPreview(doc) {
              this.selectedDoc = doc;
              this.showDocPreviewModal = true;
              this.$nextTick(() => { window.lucide?.createIcons(); });
          },

          downloadDoc(doc) {
              doc.downloads++;
              this.triggerToast('Mengunduh: ' + doc.title + ' (PDF)...');
              this.triggerSyntheticDownload(doc.title + '.pdf');
          },

          triggerSyntheticDownload(filename) {
              const element = document.createElement('a');
              const fileContent = 'PEMERINTAH KABUPATEN TASIKMALAYA\nDINAS KOMUNIKASI DAN INFORMATIKA\nPEJABAT PENGELOLA INFORMASI DAN DOKUMENTASI (PPID)\n\nDokumen Resmi: ' + filename + '\nUndang-Undang No. 14 Tahun 2008 tentang Keterbukaan Informasi Publik.\nDiunduh melalui Portal Resmi Pelayanan Publik Terpadu Kab. Tasikmalaya pada ' + new Date().toLocaleString('id-ID');
              element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(fileContent));
              element.setAttribute('download', filename);
              element.style.display = 'none';
              document.body.appendChild(element);
              element.click();
              document.body.removeChild(element);
          },

          {{-- PPID Form Data --}}
          ppidForm: {
              kategori: 'perorangan',
              nama: '',
              nik: '',
              no_hp: '',
              email: '',
              alamat: '',
              kecamatan: '',
              rincian: '',
              tujuan: '',
              cara_memperoleh: 'softcopy',
              cara_mendapatkan: 'elektronik',
              ktp_nama: '',
              setuju: false
          },
          generatedTicket: '',
          ticketDate: '',

          handleKtpUpload(e) {
              if (e.target.files && e.target.files[0]) {
                  this.ppidForm.ktp_nama = e.target.files[0].name;
              }
          },

          submitPpidForm() {
              if (!this.ppidForm.nama || !this.ppidForm.nik || !this.ppidForm.no_hp || !this.ppidForm.rincian) {
                  this.triggerToast('Harap lengkapi semua kolom wajib berbintang (*)', 'error');
                  return;
              }
              const randNum = Math.floor(1000 + Math.random() * 9000);
              const year = new Date().getFullYear();
              this.generatedTicket = 'PPID-TSK-' + year + '-' + randNum;
              this.ticketDate = new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
              
              {{-- Simpan juga ke tracking demo records --}}
              this.trackingRecords.unshift({
                  code: this.generatedTicket,
                  applicant: this.ppidForm.nama,
                  date: this.ticketDate,
                  category: this.ppidForm.kategori === 'perorangan' ? 'Perorangan' : 'Badan Hukum/Lembaga',
                  title: this.ppidForm.rincian.substring(0, 45) + '...',
                  step: 1,
                  statusText: 'Permohonan Diterima (Menunggu Verifikasi Administrasi)',
                  statusBadge: 'bg-amber-100 text-amber-800 border-amber-200',
                  slaDays: '10 Hari Kerja',
                  notes: 'Permohonan baru masuk sistem online PPID Diskominfo Kab. Tasikmalaya.'
              });

              this.showPpidModal = false;
              this.showPpidSuccessModal = true;
              this.triggerToast('Permohonan berhasil didaftarkan! No. Tiket: ' + this.generatedTicket);
              this.$nextTick(() => { window.lucide?.createIcons(); });
          },

          {{-- Tracking Data --}}
          trackingInput: '',
          trackingResult: null,
          trackingRecords: [
              {
                  code: 'PPID-TSK-2025-0142',
                  applicant: 'Hendra Gunawan, S.Kom',
                  date: '14 Januari 2025',
                  category: 'Perorangan (Peneliti)',
                  title: 'Data Statistik Penetrasi Fiber Optik SPBE 39 Kecamatan',
                  step: 4,
                  statusText: 'Selesai — Dokumen Siap Diunduh',
                  statusBadge: 'bg-slate-100 text-slate-800 border-slate-200/90 font-bold',
                  slaDays: 'Selesai tepat waktu (6 hari kerja)',
                  notes: 'Permohonan telah disetujui oleh PPID Utama Diskominfo Kab. Tasikmalaya. Salinan data statistik terlampir.',
                  hasDownload: true,
                  downloadTitle: 'Salinan_Statistik_SPBE_Tasikmalaya_2024.pdf'
              },
              {
                  code: 'PPID-TSK-2026-0891',
                  applicant: 'Lembaga Pemantau Pelayanan Publik Jabar',
                  date: '28 Februari 2025',
                  category: 'Badan Hukum / Ormas',
                  title: 'Salinan Dokumen Rencana Kerja Anggaran (RKA) Diskominfo 2025',
                  step: 3,
                  statusText: 'Sedang Disiapkan oleh Petugas PPID',
                  statusBadge: 'bg-slate-100 text-[#0a2558] border-slate-200/90 font-bold',
                  slaDays: 'Sisa batas waktu: 4 hari kerja',
                  notes: 'Verifikasi berkas legalitas pemohon selesai. Dokumen sedang dikoordinasikan dengan Subbag Perencanaan & Keuangan.',
                  hasDownload: false
              },
              {
                  code: 'PPID-TSK-2026-1024',
                  applicant: 'Siti Aminah, M.Pd',
                  date: '02 Maret 2025',
                  category: 'Perorangan',
                  title: 'Informasi Standar Operasional Pelayanan Publik Kecamatan Singaparna',
                  step: 2,
                  statusText: 'Tahap Verifikasi Administrasi',
                  statusBadge: 'bg-slate-100 text-slate-700 border-slate-200/90 font-bold',
                  slaDays: 'Sisa batas waktu: 8 hari kerja',
                  notes: 'Petugas sedang mencocokkan kelengkapan NIK dan identitas pemohon.',
                  hasDownload: false
              }
          ],

          checkTracking(code = null) {
              const query = (code || this.trackingInput).trim().toUpperCase();
              if (!query) {
                  this.trackingResult = null;
                  return;
              }
              const found = this.trackingRecords.find(item => item.code.toUpperCase() === query);
              if (found) {
                  this.trackingResult = found;
              } else {
                  this.trackingResult = {
                      code: query,
                      notFound: true
                  };
              }
              this.$nextTick(() => { window.lucide?.createIcons(); });
          },

          copyToClipboard(text) {
              navigator.clipboard?.writeText(text);
              this.triggerToast('Nomor tiket berhasil disalin ke clipboard!');
          },

          {{-- PPID Documents Dataset (17 Real Dokumen Diskominfo Kab. Tasikmalaya) --}}
          ppidDocs: [
              {{-- 1. INFORMASI BERKALA --}}
              {
                  id: 'DOC-PB-01',
                  category: 'berkala',
                  categoryLabel: 'Informasi Berkala',
                  categoryBadge: 'bg-slate-100 text-slate-700 border-slate-200/80',
                  title: 'Laporan Akuntabilitas Kinerja Instansi Pemerintah (LKjIP) Diskominfo TA 2024',
                  type: 'PDF',
                  size: '3.8 MB',
                  date: '15 Jan 2025',
                  downloads: 428,
                  summary: 'Laporan tahunan pertanggungjawaban akuntabilitas kinerja pelaksanaan program, kegiatan, dan sasaran strategis Diskominfo Kabupaten Tasikmalaya tahun anggaran 2024.',
                  pj: 'Sekretariat Diskominfo Kab. Tasikmalaya',
                  dasarHukum: 'PermenPAN-RB No. 53 Tahun 2014 & UU KIP No. 14 Tahun 2008 Pasal 9',
                  masaSimpan: '5 Tahun'
              },
              {
                  id: 'DOC-PB-02',
                  category: 'berkala',
                  categoryLabel: 'Informasi Berkala',
                  categoryBadge: 'bg-slate-100 text-slate-700 border-slate-200/80',
                  title: 'Rencana Strategis (Renstra) Diskominfo Kabupaten Tasikmalaya 2021-2026',
                  type: 'PDF',
                  size: '5.2 MB',
                  date: '10 Feb 2024',
                  downloads: 712,
                  summary: 'Dokumen perencanaan jangka menengah yang memuat visi, misi, arah kebijakan, dan target indikator transformasi digital di 39 kecamatan.',
                  pj: 'Subbag Perencanaan & Keuangan',
                  dasarHukum: 'UU No. 25 Tahun 2004 & Perda RPJMD Kab. Tasikmalaya',
                  masaSimpan: '10 Tahun'
              },
              {
                  id: 'DOC-PB-03',
                  category: 'berkala',
                  categoryLabel: 'Informasi Berkala',
                  categoryBadge: 'bg-slate-100 text-slate-700 border-slate-200/80',
                  title: 'Rencana Kerja (Renja) Tahunan Diskominfo Kabupaten Tasikmalaya 2025',
                  type: 'PDF',
                  size: '2.6 MB',
                  date: '05 Jan 2025',
                  downloads: 389,
                  summary: 'Penetapan rencana kerja operasional tahunan yang memuat rincian target program prioritas transformasi digital dan perluasan jaringan SPBE.',
                  pj: 'Subbag Perencanaan',
                  dasarHukum: 'Peraturan Bupati Tasikmalaya tentang RKPD 2025',
                  masaSimpan: '3 Tahun'
              },
              {
                  id: 'DOC-PB-04',
                  category: 'berkala',
                  categoryLabel: 'Informasi Berkala',
                  categoryBadge: 'bg-slate-100 text-slate-700 border-slate-200/80',
                  title: 'Laporan Realisasi Anggaran (LRA) Diskominfo Semester II TA 2024',
                  type: 'PDF',
                  size: '1.9 MB',
                  date: '20 Jan 2025',
                  downloads: 516,
                  summary: 'Laporan akuntabilitas keuangan daerah yang memuat perbandingan antara anggaran belanja modal, operasional, dan realisasi penerimaan secara transparan.',
                  pj: 'PPK & Bendahara Diskominfo',
                  dasarHukum: 'PP No. 71 Tahun 2010 tentang Standar Akuntansi Pemerintahan',
                  masaSimpan: '5 Tahun'
              },
              {
                  id: 'DOC-PB-05',
                  category: 'berkala',
                  categoryLabel: 'Informasi Berkala',
                  categoryBadge: 'bg-slate-100 text-slate-700 border-slate-200/80',
                  title: 'Profil Singkat, Struktur Organisasi, & Tupoksi PPID Kab. Tasikmalaya',
                  type: 'PDF',
                  size: '1.4 MB',
                  date: '02 Jan 2025',
                  downloads: 894,
                  summary: 'Uraian tugas pokok dan fungsi Pejabat Pengelola Informasi dan Dokumentasi (PPID) Utama serta pejabat penanggung jawab teknis di setiap bidang dinas.',
                  pj: 'PPID Utama Kab. Tasikmalaya',
                  dasarHukum: 'UU No. 14 Tahun 2008 & SK Bupati Tasikmalaya',
                  masaSimpan: 'Tetap / Selama Berlaku'
              },
              {
                  id: 'DOC-PB-06',
                  category: 'berkala',
                  categoryLabel: 'Informasi Berkala',
                  categoryBadge: 'bg-slate-100 text-slate-700 border-slate-200/80',
                  title: 'Standar Operasional Prosedur (SOP) Pengelolaan & Pelayanan Informasi Publik',
                  type: 'PDF',
                  size: '2.1 MB',
                  date: '12 Des 2024',
                  downloads: 634,
                  summary: 'Pedoman baku tata cara permohonan informasi, jangka waktu verifikasi, mekanisme keberatan, dan standar pelayanan informasi publik.',
                  pj: 'Bidang Informasi & Komunikasi Publik',
                  dasarHukum: 'Peraturan Komisi Informasi No. 1 Tahun 2021',
                  masaSimpan: 'Tetap / Selama Berlaku'
              },

              {{-- 2. INFORMASI SERTA MERTA --}}
              {
                  id: 'DOC-SM-01',
                  category: 'serta-merta',
                  categoryLabel: 'Informasi Serta Merta',
                  categoryBadge: 'bg-slate-100 text-slate-700 border-slate-200/80',
                  title: 'Peringatan Dini Cuaca Ekstrem BMKG & Kesiapsiagaan Bencana Daerah BPBD',
                  type: 'PDF',
                  size: '1.2 MB',
                  date: '28 Feb 2025',
                  downloads: 1240,
                  summary: 'Pemberitahuan darurat potensi cuaca ekstrem, tanah longsor, dan hidrometeorologi di wilayah Tasikmalaya Selatan serta panduan evakuasi warga.',
                  pj: 'Diskominfo & BPBD Kab. Tasikmalaya',
                  dasarHukum: 'UU KIP Pasal 10 & UU No. 24 Tahun 2007 tentang Penanggulangan Bencana',
                  masaSimpan: '1 Tahun'
              },
              {
                  id: 'DOC-SM-02',
                  category: 'serta-merta',
                  categoryLabel: 'Informasi Serta Merta',
                  categoryBadge: 'bg-slate-100 text-slate-700 border-slate-200/80',
                  title: 'Himbauan Keamanan Siber & Waspada Penipuan Digital Mengatasnamakan Pejabat Pemkab',
                  type: 'PDF',
                  size: '850 KB',
                  date: '14 Feb 2025',
                  downloads: 980,
                  summary: 'Peringatan resmi mengenai modus penipuan berbasis pesan singkat dan tautan aplikasi APK palsu yang mencatut nama pimpinan daerah.',
                  pj: 'Tim Tanggap Insiden Siber (CSIRT) Diskominfo',
                  dasarHukum: 'UU ITE No. 1 Tahun 2024 & UU KIP Pasal 10',
                  masaSimpan: '2 Tahun'
              },
              {
                  id: 'DOC-SM-03',
                  category: 'serta-merta',
                  categoryLabel: 'Informasi Serta Merta',
                  categoryBadge: 'bg-slate-100 text-slate-700 border-slate-200/80',
                  title: 'Pemberitahuan Darurat Pemeliharaan Server Cloud & Gateway SPBE Terpadu',
                  type: 'PDF',
                  size: '620 KB',
                  date: '03 Mar 2025',
                  downloads: 415,
                  summary: 'Informasi jadwal maintenance darurat server cloud data center daerah untuk penguatan sistem enkripsi data kependudukan.',
                  pj: 'Bidang Infrastruktur & Persandian',
                  dasarHukum: 'Perpres No. 95 Tahun 2018 tentang SPBE',
                  masaSimpan: '6 Bulan'
              },
              {
                  id: 'DOC-SM-04',
                  category: 'serta-merta',
                  categoryLabel: 'Informasi Serta Merta',
                  categoryBadge: 'bg-slate-100 text-slate-700 border-slate-200/80',
                  title: 'Protokol Tanggap Darurat & Kontak Bantuan Kebencanaan 39 Kecamatan',
                  type: 'PDF',
                  size: '1.5 MB',
                  date: '18 Jan 2025',
                  downloads: 820,
                  summary: 'Daftar nomor kontak darurat posko bencana, call center 112, pemadam kebakaran, dan koordinator satgas kecamatan se-Kabupaten Tasikmalaya.',
                  pj: 'Diskominfo Kab. Tasikmalaya',
                  dasarHukum: 'UU No. 14 Tahun 2008 Pasal 10',
                  masaSimpan: '1 Tahun'
              },

              {{-- 3. INFORMASI SETIAP SAAT --}}
              {
                  id: 'DOC-SS-01',
                  category: 'setiap-saat',
                  categoryLabel: 'Informasi Setiap Saat',
                  categoryBadge: 'bg-slate-100 text-slate-700 border-slate-200/80',
                  title: 'Peraturan Bupati Tasikmalaya No. 48 Tahun 2021 tentang Pedoman Pelayanan Informasi Publik',
                  type: 'PDF',
                  size: '4.1 MB',
                  date: '12 Nov 2023',
                  downloads: 1512,
                  summary: 'Regulasi resmi pemerintah daerah mengenai tata cara pelaksanaan keterbukaan informasi publik dan kewajiban badan publik di lingkungan Kabupaten Tasikmalaya.',
                  pj: 'Bagian Hukum Setda Kab. Tasikmalaya',
                  dasarHukum: 'Peraturan Bupati Tasikmalaya No. 48 Tahun 2021',
                  masaSimpan: 'Tetap / Selama Berlaku'
              },
              {
                  id: 'DOC-SS-02',
                  category: 'setiap-saat',
                  categoryLabel: 'Informasi Setiap Saat',
                  categoryBadge: 'bg-slate-100 text-slate-700 border-slate-200/80',
                  title: 'Daftar Rencana Umum Pengadaan (RUP) Barang dan Jasa Pemerintah Daerah TA 2025',
                  type: 'PDF',
                  size: '3.4 MB',
                  date: '22 Jan 2025',
                  downloads: 670,
                  summary: 'Daftar paket pengadaan barang, jasa konsultansi, dan pekerjaan konstruksi Diskominfo melalui sistem pengadaan secara elektronik (LPSE).',
                  pj: 'UKPBJ & PPK Diskominfo',
                  dasarHukum: 'Perpres No. 12 Tahun 2021 & UU KIP Pasal 11',
                  masaSimpan: '5 Tahun'
              },
              {
                  id: 'DOC-SS-03',
                  category: 'setiap-saat',
                  categoryLabel: 'Informasi Setiap Saat',
                  categoryBadge: 'bg-slate-100 text-slate-700 border-slate-200/80',
                  title: 'Buku Data Statistik Sektoral & Kompilasi Wilayah 39 Kecamatan Kab. Tasikmalaya',
                  type: 'PDF',
                  size: '7.8 MB',
                  date: '08 Jan 2025',
                  downloads: 1050,
                  summary: 'Publikasi data statistik sektoral resmi meliputi demografi kependudukan, penetrasi jaringan internet desa, fasilitas publik, dan sarana kesehatan.',
                  pj: 'Bidang Statistik Sektoral Diskominfo',
                  dasarHukum: 'Perpres No. 39 Tahun 2019 tentang Satu Data Indonesia',
                  masaSimpan: '10 Tahun'
              },
              {
                  id: 'DOC-SS-04',
                  category: 'setiap-saat',
                  categoryLabel: 'Informasi Setiap Saat',
                  categoryBadge: 'bg-slate-100 text-slate-700 border-slate-200/80',
                  title: 'Daftar Perjanjian Kerjasama (MoU) & Regulasi Keterbukaan Informasi Daerah',
                  type: 'PDF',
                  size: '2.3 MB',
                  date: '04 Des 2024',
                  downloads: 340,
                  summary: 'Daftar dokumen kesepahaman bersama dan perjanjian kerja sama Pemkab Tasikmalaya dengan instansi vertikal, perguruan tinggi, dan mitra telekomunikasi.',
                  pj: 'Bagian Kerjasama Setda',
                  dasarHukum: 'UU No. 23 Tahun 2014 & UU KIP Pasal 11',
                  masaSimpan: '5 Tahun'
              },
              {
                  id: 'DOC-SS-05',
                  category: 'setiap-saat',
                  categoryLabel: 'Informasi Setiap Saat',
                  categoryBadge: 'bg-slate-100 text-slate-700 border-slate-200/80',
                  title: 'Hasil Uji Konsekuensi Informasi Publik Diskominfo Kabupaten Tasikmalaya',
                  type: 'PDF',
                  size: '1.7 MB',
                  date: '15 Jan 2025',
                  downloads: 490,
                  summary: 'Matriks pertimbangan tertulis hasil rapat pengujian konsekuensi publik terhadap data dan informasi yang dapat dibuka atau dikecualikan.',
                  pj: 'Tim Pertimbangan PPID',
                  dasarHukum: 'Perki No. 1 Tahun 2021 Pasal 19',
                  masaSimpan: '3 Tahun'
              },

              {{-- 4. INFORMASI DIKECUALIKAN --}}
              {
                  id: 'DOC-DK-01',
                  category: 'dikecualikan',
                  categoryLabel: 'Informasi Dikecualikan',
                  categoryBadge: 'bg-slate-100 text-slate-700 border-slate-200/80',
                  title: 'Surat Keputusan Bupati tentang Penetapan Klasifikasi Informasi yang Dikecualikan',
                  type: 'PDF',
                  size: '2.2 MB',
                  date: '10 Jan 2025',
                  downloads: 780,
                  summary: 'Surat Keputusan resmi mengenai daftar informasi publik yang tidak dapat diberikan kepada pemohon umum berdasarkan pertimbangan pasal 17 UU No. 14 Tahun 2008.',
                  pj: 'Bupati Tasikmalaya / PPID Utama',
                  dasarHukum: 'UU No. 14 Tahun 2008 Pasal 17 & Perki No. 1 Tahun 2021',
                  masaSimpan: '5 Tahun'
              },
              {
                  id: 'DOC-DK-02',
                  category: 'dikecualikan',
                  categoryLabel: 'Informasi Dikecualikan',
                  categoryBadge: 'bg-slate-100 text-slate-700 border-slate-200/80',
                  title: 'Pedoman Pengujian Konsekuensi Pengecualian Informasi Rahasia Jabatan',
                  type: 'PDF',
                  size: '1.6 MB',
                  date: '14 Des 2024',
                  downloads: 310,
                  summary: 'Standar operasional penilaian dampak bahaya (harm test) dan kepentingan publik (public interest test) sebelum menetapkan dokumen sebagai rahasia.',
                  pj: 'Tim Advokasi Hukum PPID',
                  dasarHukum: 'UU No. 14 Tahun 2008 Pasal 17',
                  masaSimpan: 'Tetap'
              }
          ],

          get filteredPpidDocs() {
              let q = this.ppidSearch.toLowerCase().trim();
              return this.ppidDocs.filter(doc => {
                  let matchCat = (this.ppidCategory === 'all' || doc.category === this.ppidCategory);
                  let matchQuery = !q ||
                      doc.title.toLowerCase().includes(q) ||
                      doc.id.toLowerCase().includes(q) ||
                      doc.summary.toLowerCase().includes(q) ||
                      doc.categoryLabel.toLowerCase().includes(q);
                  return matchCat && matchQuery;
              });
          }
      }"
      x-init="startAutoPlay()">

    {{-- ═══════════════════════════════════════════════════════════════════════════
         1. FIXED HEADER NAVIGATION (CLEAN CORPORATE STYLE LIKE AICLASSASEAN)
    ═══════════════════════════════════════════════════════════════════════════ --}}
    {{-- ═══════════════════════════════════════════════════════════════════════════
         1. COMPACT FIXED HEADER NAVIGATION (SLIM CORPORATE STYLE ~56PX)
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <header class="fixed top-0 inset-x-0 z-50 bg-white/98 backdrop-blur-md border-b border-slate-200/80 shadow-2xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-14 sm:h-[58px] flex items-center justify-between">
            
            {{-- Left Side: Brand Logo + Slogan/Co-brand + "Katalog Layanan" Button --}}
            <div class="flex items-center gap-2.5 sm:gap-3">
                {{-- Logo Diskominfo Kab. Tasikmalaya --}}
                <a href="{{ url('/') }}" class="flex items-center gap-2 flex-shrink-0">
                    <img src="{{ asset('images/logo2.png') }}" alt="Diskominfo Kabupaten Tasikmalaya" class="h-7 sm:h-8 w-auto object-contain">
                </a>

                {{-- Co-brand / Partner separator similar to reference --}}
                <div class="hidden xl:flex items-center gap-1.5 pl-2.5 border-l border-slate-200 text-[10px] leading-tight text-slate-500">
                    <span class="text-slate-400 font-medium">oleh:</span>
                    <span class="font-bold text-slate-700">Diskominfo Kab. Tasikmalaya</span>
                </div>

                {{-- Compact Prominent Button: [ ≡ Katalog Layanan ] (like [ ≡ Kursus Kami ] in reference) --}}
                <div class="relative ml-1"
                     @mouseenter="dropdownLayanan = true; dropdownPpid = false; $nextTick(() => window.lucide?.createIcons())"
                     @mouseleave="dropdownLayanan = false">
                    
                    <button type="button"
                            @click="dropdownLayanan = !dropdownLayanan; dropdownPpid = false; $nextTick(() => window.lucide?.createIcons())"
                            class="px-2.5 py-1.5 sm:px-3 sm:py-1.5 rounded-lg bg-[#ea546c] hover:bg-[#d9445c] text-white text-xs font-bold flex items-center gap-1.5 shadow-2xs hover:shadow-xs transition-all cursor-pointer focus:outline-none">
                        <svg class="w-3.5 h-3.5 stroke-[2.5]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <span>Katalog Layanan</span>
                        <svg class="w-3 h-3 transition-transform duration-200 opacity-90"
                             :class="dropdownLayanan ? 'rotate-180' : ''"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    {{-- Dropdown Container for Layanan --}}
                    <div x-show="dropdownLayanan"
                         x-cloak
                         @click.outside="dropdownLayanan = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-1.5 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                         x-transition:leave-end="opacity-0 translate-y-1.5 scale-95"
                         class="absolute left-0 top-full mt-1.5 w-[390px] bg-white rounded-2xl p-3.5 shadow-2xl border border-slate-100 z-50">
                        
                        {{-- Top Header Pill --}}
                        <div class="flex items-center justify-between pb-2.5 px-2 border-b border-slate-100 mb-1.5">
                            <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">
                                4 Kategori Layanan Kependudukan
                            </span>
                            <a href="#layanan" @click="dropdownLayanan = false" class="text-[11px] font-bold text-[#0a2558] hover:underline flex items-center gap-1">
                                <span>Lihat Semua</span>
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>

                        {{-- 4 Categories Grid/List --}}
                        <div class="space-y-1">
                            {{-- Item 1: Identitas --}}
                            <a href="{{ route('layanan.show', ['serviceCode' => 'EKTP']) }}"
                               @click="dropdownLayanan = false"
                               class="group p-2 rounded-xl hover:bg-slate-50 transition-all flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-slate-100 text-[#0a2558] flex items-center justify-center flex-shrink-0 group-hover:bg-[#0a2558] group-hover:text-white transition-all shadow-2xs">
                                    <i data-lucide="contact" class="w-4 h-4"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h4 class="text-xs font-bold text-slate-800 group-hover:text-[#0a2558] transition-colors">
                                        Identitas Kependudukan
                                    </h4>
                                    <p class="text-[10px] text-slate-400 truncate">KTP Elektronik Biometrik & KIA Anak</p>
                                </div>
                                <span class="text-[9px] font-semibold px-1.5 py-0.5 rounded bg-slate-100 text-slate-600 border border-slate-200/60">
                                    2 Layanan
                                </span>
                            </a>

                            {{-- Item 2: Kartu Keluarga --}}
                            <a href="{{ route('layanan.show', ['serviceCode' => 'KK_BARU']) }}"
                               @click="dropdownLayanan = false"
                               class="group p-2 rounded-xl hover:bg-slate-50 transition-all flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-slate-100 text-[#0a2558] flex items-center justify-center flex-shrink-0 group-hover:bg-[#0a2558] group-hover:text-white transition-all shadow-2xs">
                                    <i data-lucide="users" class="w-4 h-4"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h4 class="text-xs font-bold text-slate-800 group-hover:text-[#0a2558] transition-colors">
                                        Kartu Keluarga (KK)
                                    </h4>
                                    <p class="text-[10px] text-slate-400 truncate">KK Baru, Penambahan & Pengurangan Anggota</p>
                                </div>
                                <span class="text-[9px] font-semibold px-1.5 py-0.5 rounded bg-slate-100 text-slate-600 border border-slate-200/60">
                                    3 Layanan
                                </span>
                            </a>

                            {{-- Item 3: Perpindahan Penduduk --}}
                            <a href="{{ route('layanan.show', ['serviceCode' => 'PINDAH_SATU_DESA']) }}"
                               @click="dropdownLayanan = false"
                               class="group p-2 rounded-xl hover:bg-slate-50 transition-all flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-slate-100 text-[#0a2558] flex items-center justify-center flex-shrink-0 group-hover:bg-[#0a2558] group-hover:text-white transition-all shadow-2xs">
                                    <i data-lucide="truck" class="w-4 h-4"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h4 class="text-xs font-bold text-slate-800 group-hover:text-[#0a2558] transition-colors">
                                        Perpindahan Domisili
                                    </h4>
                                    <p class="text-[10px] text-slate-400 truncate">Pindah Satu Desa s.d. Antar Kecamatan (F.1-23/29)</p>
                                </div>
                                <span class="text-[9px] font-semibold px-1.5 py-0.5 rounded bg-slate-100 text-slate-600 border border-slate-200/60">
                                    3 Layanan
                                </span>
                            </a>

                            {{-- Item 4: Dispensasi & Keterangan --}}
                            <a href="{{ route('layanan.show', ['serviceCode' => 'NIKAH']) }}"
                               @click="dropdownLayanan = false"
                               class="group p-2 rounded-xl hover:bg-slate-50 transition-all flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-slate-100 text-[#0a2558] flex items-center justify-center flex-shrink-0 group-hover:bg-[#0a2558] group-hover:text-white transition-all shadow-2xs">
                                    <i data-lucide="heart" class="w-4 h-4"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h4 class="text-xs font-bold text-slate-800 group-hover:text-[#0a2558] transition-colors">
                                        Dispensasi & Keterangan
                                    </h4>
                                    <p class="text-[10px] text-slate-400 truncate">Rekomendasi Nikah & Surat Keterangan Camat</p>
                                </div>
                                <span class="text-[9px] font-semibold px-1.5 py-0.5 rounded bg-slate-100 text-slate-600 border border-slate-200/60">
                                    2 Layanan
                                </span>
                            </a>
                        </div>

                        {{-- Bottom CTA Box --}}
                        <div class="mt-2 pt-2 border-t border-slate-100 bg-slate-50/80 -mx-3.5 -mb-3.5 p-3 rounded-b-2xl flex items-center justify-between text-xs">
                            <span class="text-[10px] text-slate-500 font-medium">Bebas antrean & bebas biaya (Rp 0)</span>
                            <a href="#layanan" @click="dropdownLayanan = false" class="text-[11px] font-bold text-[#0a2558] hover:underline flex items-center gap-1">
                                <span>Katalog Lengkap</span>
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Side: Navigation Links + Flag Indicator + Login Button --}}
            <div class="flex items-center gap-3 sm:gap-5">
                {{-- Desktop Menu Links --}}
                <nav class="hidden lg:flex items-center space-x-5 text-xs font-semibold text-slate-600">
                    {{-- 1. BERANDA (Rumah) --}}
                    <a href="#" class="text-[#2563eb] hover:text-[#1d4ed8] transition-colors py-1">
                        Beranda
                    </a>

                    {{-- 2. DATA KECAMATAN --}}
                    <a href="#kewilayahan" class="hover:text-[#2563eb] transition-colors py-1">
                        Data Kecamatan
                    </a>

                    {{-- 3. PPID & INFORMASI (DROPDOWN) --}}
                    <div class="relative"
                         @mouseenter="dropdownPpid = true; dropdownLayanan = false; $nextTick(() => window.lucide?.createIcons())"
                         @mouseleave="dropdownPpid = false">
                        
                        <button type="button"
                                @click="dropdownPpid = !dropdownPpid; dropdownLayanan = false; $nextTick(() => window.lucide?.createIcons())"
                                class="hover:text-[#2563eb] transition-colors flex items-center gap-1 focus:outline-none py-1 cursor-pointer"
                                :class="dropdownPpid ? 'text-[#2563eb]' : ''">
                            <span>PPID & Informasi</span>
                            <svg class="w-3 h-3 transition-transform duration-200"
                                 :class="dropdownPpid ? 'rotate-180 text-[#2563eb]' : 'text-slate-400'"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        {{-- Dropdown Container for PPID --}}
                        <div x-show="dropdownPpid"
                             x-cloak
                             @click.outside="dropdownPpid = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-1.5 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 translate-y-1.5 scale-95"
                             class="absolute right-0 top-full mt-1.5 w-[370px] bg-white rounded-2xl p-3.5 shadow-2xl border border-slate-100 z-50">
                            
                            {{-- Top Header Pill --}}
                            <div class="flex items-center justify-between pb-2.5 px-2 border-b border-slate-100 mb-1.5">
                                <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">
                                    Keterbukaan Informasi Publik (UU 14/2008)
                                </span>
                                <a href="#ppid" @click="dropdownPpid = false" class="text-[11px] font-bold text-[#0a2558] hover:underline flex items-center gap-1">
                                    <span>Portal PPID</span>
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>

                            {{-- 4 PPID Actions List --}}
                            <div class="space-y-1">
                                {{-- Item 1: Direktori Dokumen --}}
                                <a href="#ppid-daftar"
                                   @click="dropdownPpid = false; activePpidTab = 'dokumen'; $nextTick(() => window.lucide?.createIcons())"
                                   class="group p-2 rounded-xl hover:bg-slate-50 transition-all flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-slate-100 text-[#0a2558] flex items-center justify-center flex-shrink-0 group-hover:bg-[#0a2558] group-hover:text-white transition-all shadow-2xs">
                                        <i data-lucide="files" class="w-4 h-4"></i>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h4 class="text-xs font-bold text-slate-800 group-hover:text-[#0a2558] transition-colors">
                                            Daftar Informasi Publik (DIP)
                                        </h4>
                                        <p class="text-[10px] text-slate-400 truncate">17 Dokumen Resmi (Berkala, Serta Merta, dll.)</p>
                                    </div>
                                    <span class="text-[9px] font-semibold px-1.5 py-0.5 rounded bg-slate-100 text-slate-600 border border-slate-200/60">
                                        17 Berkas
                                    </span>
                                </a>

                                {{-- Item 2: Ajukan Permohonan Informasi --}}
                                <button type="button"
                                        @click="openPpidModal(); dropdownPpid = false"
                                        class="w-full text-left group p-2 rounded-xl hover:bg-slate-50 transition-all flex items-center gap-2.5 cursor-pointer">
                                    <div class="w-8 h-8 rounded-lg bg-slate-100 text-[#0a2558] flex items-center justify-center flex-shrink-0 group-hover:bg-[#0a2558] group-hover:text-white transition-all shadow-2xs">
                                        <i data-lucide="send" class="w-4 h-4"></i>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h4 class="text-xs font-bold text-slate-800 group-hover:text-[#0a2558] transition-colors">
                                            Ajukan Permohonan Informasi
                                        </h4>
                                        <p class="text-[10px] text-slate-400 truncate">Formulir Online Pemohon Warga & Lembaga</p>
                                    </div>
                                    <span class="text-[9px] font-semibold px-1.5 py-0.5 rounded bg-slate-100 text-slate-600 border border-slate-200/60">
                                        Online
                                    </span>
                                </button>

                                {{-- Item 3: Lacak Status Permohonan --}}
                                <button type="button"
                                        @click="openPpidTracking(); dropdownPpid = false"
                                        class="w-full text-left group p-2 rounded-xl hover:bg-slate-50 transition-all flex items-center gap-2.5 cursor-pointer">
                                    <div class="w-8 h-8 rounded-lg bg-slate-100 text-[#0a2558] flex items-center justify-center flex-shrink-0 group-hover:bg-[#0a2558] group-hover:text-white transition-all shadow-2xs">
                                        <i data-lucide="search" class="w-4 h-4"></i>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h4 class="text-xs font-bold text-slate-800 group-hover:text-[#0a2558] transition-colors">
                                            Lacak Status Permohonan
                                        </h4>
                                        <p class="text-[10px] text-slate-400 truncate">Cek progres tiket nomor registrasi PPID</p>
                                    </div>
                                    <span class="text-[9px] font-semibold px-1.5 py-0.5 rounded bg-slate-100 text-slate-600 border border-slate-200/60">
                                        Tracking
                                    </span>
                                </button>

                                {{-- Item 4: SOP & Prosedur --}}
                                <a href="#ppid"
                                   @click="dropdownPpid = false; activePpidTab = 'alur'; $nextTick(() => window.lucide?.createIcons())"
                                   class="group p-2 rounded-xl hover:bg-slate-50 transition-all flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-slate-100 text-[#0a2558] flex items-center justify-center flex-shrink-0 group-hover:bg-[#0a2558] group-hover:text-white transition-all shadow-2xs">
                                        <i data-lucide="workflow" class="w-4 h-4"></i>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h4 class="text-xs font-bold text-slate-800 group-hover:text-[#0a2558] transition-colors">
                                            Alur & Standar Prosedur (SOP)
                                        </h4>
                                        <p class="text-[10px] text-slate-400 truncate">SOP Waktu Layanan & Tata Cara Keberatan</p>
                                    </div>
                                    <span class="text-[9px] font-semibold px-1.5 py-0.5 rounded bg-slate-100 text-slate-600 border border-slate-200/60">
                                        SOP
                                    </span>
                                </a>
                            </div>

                            {{-- Bottom CTA Box --}}
                            <div class="mt-2 pt-2 border-t border-slate-100 bg-slate-50/80 -mx-3.5 -mb-3.5 p-3 rounded-b-2xl flex items-center justify-between text-xs">
                                <span class="text-[10px] text-slate-500 font-medium">Layanan resmi bebas biaya (Rp 0)</span>
                                <a href="#ppid" @click="dropdownPpid = false" class="text-[11px] font-bold text-[#0a2558] hover:underline flex items-center gap-1">
                                    <span>Meja PPID Utama</span>
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- 4. PROFIL & CAPAIAN --}}
                    <a href="#capaian" class="hover:text-[#2563eb] transition-colors py-1">
                        Profil & Capaian
                    </a>

                    {{-- 5. PENGADUAN (Membantu / Bantuan) --}}
                    <button type="button"
                            @click="openPengaduan()"
                            class="hover:text-[#2563eb] transition-colors font-semibold py-1 flex items-center gap-1 focus:outline-none cursor-pointer">
                        <span>Pengaduan</span>
                    </button>
                </nav>

                {{-- Flag Indicator (RI / ID) as in reference screenshot --}}
                <div class="hidden sm:flex items-center gap-1 px-1.5 py-1 rounded bg-slate-50 border border-slate-200/80 select-none shadow-2xs" title="Indonesia">
                    <span class="w-3.5 h-2 rounded-[2px] overflow-hidden flex flex-col border border-slate-300/60 shadow-2xs">
                        <span class="w-full h-1/2 bg-[#d8222a]"></span>
                        <span class="w-full h-1/2 bg-white"></span>
                    </span>
                    <span class="text-[10px] font-bold text-slate-700">ID</span>
                </div>

                {{-- Exact AICLASSASEAN Style Login Button: [.btn-join] --}}
                @auth
                    <a href="{{ route('dashboard') }}" class="nav-link btn-join">
                        Dashboard <span><i class="fa-solid fa-chevron-right"></i></span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="nav-link btn-join">
                        Login <span><i class="fa-solid fa-chevron-right"></i></span>
                    </a>
                @endauth

                {{-- Mobile toggle button --}}
                <button type="button" @click="mobileNav = !mobileNav" class="lg:hidden p-1.5 rounded-lg hover:bg-slate-100 text-slate-700 transition-colors">
                    <i data-lucide="menu" class="w-5 h-5"></i>
                </button>
            </div>
        </div>

        {{-- Mobile Full-Width Dropdown Drawer --}}
        <div x-show="mobileNav"
             x-cloak
             @click.outside="mobileNav = false"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="lg:hidden bg-white border-b border-slate-200 px-4 py-3 shadow-xl text-xs sm:text-sm space-y-2 font-semibold text-slate-800 max-h-[calc(100vh-4rem)] overflow-y-auto">
            
            {{-- Mobile Layanan Accordion --}}
            <div>
                <button type="button"
                        @click="mobileLayanan = !mobileLayanan"
                        class="w-full py-2 px-3 rounded-lg bg-slate-50 hover:bg-slate-100 text-slate-800 flex items-center justify-between text-xs">
                    <span class="flex items-center gap-1.5 text-[#ea546c] font-bold">
                        <svg class="w-3.5 h-3.5 stroke-[2.5]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <span>Katalog Layanan</span>
                    </span>
                    <svg class="w-3.5 h-3.5 transition-transform duration-200 text-slate-400"
                         :class="mobileLayanan ? 'rotate-180 text-[#ea546c]' : ''"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="mobileLayanan" x-collapse class="pl-3 pr-2 py-1.5 space-y-1 text-xs text-slate-600">
                    <a href="{{ route('layanan.show', ['serviceCode' => 'EKTP']) }}" @click="mobileNav = false" class="block py-1.5 px-2.5 rounded-lg hover:bg-slate-100 text-slate-700 hover:text-[#0a2558]">🪪 Identitas (e-KTP & KIA)</a>
                    <a href="{{ route('layanan.show', ['serviceCode' => 'KK_BARU']) }}" @click="mobileNav = false" class="block py-1.5 px-2.5 rounded-lg hover:bg-slate-100 text-slate-700 hover:text-[#0a2558]">👨‍👩‍👧‍👦 Kartu Keluarga (KK)</a>
                    <a href="{{ route('layanan.show', ['serviceCode' => 'PINDAH_SATU_DESA']) }}" @click="mobileNav = false" class="block py-1.5 px-2.5 rounded-lg hover:bg-slate-100 text-slate-700 hover:text-[#0a2558]">🚚 Perpindahan Domisili</a>
                    <a href="{{ route('layanan.show', ['serviceCode' => 'NIKAH']) }}" @click="mobileNav = false" class="block py-1.5 px-2.5 rounded-lg hover:bg-slate-100 text-slate-700 hover:text-[#0a2558]">📜 Dispensasi & Keterangan</a>
                    <a href="#layanan" @click="mobileNav = false" class="block py-1.5 px-2.5 rounded-lg text-[#ea546c] font-bold hover:underline">Lihat Semua 8 Layanan &rarr;</a>
                </div>
            </div>

            {{-- Mobile Beranda --}}
            <a href="#" @click="mobileNav = false" class="block py-1.5 px-3 rounded-lg hover:bg-slate-50 text-[#2563eb]">Beranda</a>

            {{-- Mobile Data Kecamatan --}}
            <a href="#kewilayahan" @click="mobileNav = false" class="block py-1.5 px-3 rounded-lg hover:bg-slate-50 text-slate-800">Data Kecamatan</a>

            {{-- Mobile PPID Accordion --}}
            <div>
                <button type="button"
                        @click="mobilePpid = !mobilePpid"
                        class="w-full py-1.5 px-3 rounded-lg hover:bg-slate-50 text-slate-800 flex items-center justify-between text-xs">
                    <span>PPID & Informasi</span>
                    <svg class="w-3.5 h-3.5 transition-transform duration-200 text-slate-400"
                         :class="mobilePpid ? 'rotate-180 text-[#2563eb]' : ''"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="mobilePpid" x-collapse class="pl-3 pr-2 py-1.5 space-y-1 text-xs text-slate-600">
                    <a href="#ppid-daftar" @click="mobileNav = false; activePpidTab = 'dokumen'" class="block py-1.5 px-2.5 rounded-lg hover:bg-slate-100 text-slate-700 hover:text-[#0a2558]">📁 Daftar Informasi Publik (DIP)</a>
                    <button type="button" @click="mobileNav = false; openPpidModal()" class="w-full text-left py-1.5 px-2.5 rounded-lg hover:bg-slate-100 text-slate-700 hover:text-[#0a2558] font-semibold">✍️ Ajukan Permohonan Informasi</button>
                    <button type="button" @click="mobileNav = false; openPpidTracking()" class="w-full text-left py-1.5 px-2.5 rounded-lg hover:bg-slate-100 text-slate-700 hover:text-[#0a2558] font-semibold">🔍 Lacak Status Permohonan</button>
                    <a href="#ppid" @click="mobileNav = false; activePpidTab = 'alur'" class="block py-1.5 px-2.5 rounded-lg hover:bg-slate-100 text-slate-700 hover:text-[#0a2558]">📋 Alur & Prosedur (SOP)</a>
                </div>
            </div>

            {{-- Mobile Profil & Capaian --}}
            <a href="#capaian" @click="mobileNav = false" class="block py-1.5 px-3 rounded-lg hover:bg-slate-50 text-slate-800">Profil & Capaian</a>

            {{-- Mobile Pengaduan --}}
            <button type="button" @click="mobileNav = false; openPengaduan()" class="w-full text-left py-1.5 px-3 rounded-lg hover:bg-slate-50 text-slate-800 font-semibold flex items-center justify-between text-xs">
                <span>Layanan Pengaduan</span>
            </button>

            <div class="pt-2 border-t border-slate-100 flex justify-center">
                <a href="{{ route('login') }}" class="nav-link btn-join w-full justify-center text-center">
                    Login<span><i class="fa-solid fa-chevron-right"></i></span>
                </a>
            </div>
        </div>
    </header>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         2. HERO SECTION WITH INTERACTIVE SLIDER / CAROUSEL
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <section class="relative text-white pt-20 sm:pt-24 pb-32 sm:pb-36 px-4 sm:px-6 lg:px-8 overflow-hidden min-h-[580px] sm:min-h-[640px] flex items-center justify-center"
             @mouseenter="stopAutoPlay()"
             @mouseleave="startAutoPlay()">

        {{-- Background Slider Images with Gradient Overlays --}}
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="currentSlide === index"
                 x-transition:enter="transition ease-out duration-700"
                 x-transition:enter-start="opacity-0 scale-105"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-500"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute inset-0 bg-cover bg-center transition-all"
                 :style="`background-image: linear-gradient(180deg, rgba(10, 37, 88, 0.88) 0%, rgba(15, 23, 42, 0.94) 100%), url('${slide.image}')`">
            </div>
        </template>

        {{-- Ambient Light Deco --}}
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-96 h-96 bg-blue-500/15 rounded-full blur-3xl pointer-events-none"></div>


        {{-- Slide Content --}}
        <div class="max-w-4xl mx-auto text-center space-y-5 relative z-10 py-6">
            <template x-for="(slide, index) in slides" :key="index">
                <div x-show="currentSlide === index"
                     x-transition:enter="transition ease-out duration-500 delay-100"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-4"
                     class="space-y-5">
                    
                    {{-- Badge --}}
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-500/20 text-blue-200 text-xs sm:text-sm font-semibold border border-blue-400/30 backdrop-blur-md">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span x-text="slide.badge"></span>
                    </div>

                    {{-- Title --}}
                    <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-tight text-white drop-shadow-md max-w-3xl mx-auto"
                        x-text="slide.title">
                    </h1>
                    
                    {{-- Description --}}
                    <p class="text-sm sm:text-lg text-blue-100 font-normal tracking-wide max-w-2xl mx-auto leading-relaxed pt-1"
                       x-text="slide.desc">
                    </p>

                    {{-- CTA Buttons --}}
                    <div class="pt-6 flex flex-wrap justify-center gap-4">
                        <a :href="slide.ctaLink"
                           class="px-7 py-3.5 rounded-full text-xs sm:text-sm font-bold bg-amber-400 hover:bg-amber-300 text-slate-950 transition-all shadow-xl hover:shadow-2xl hover:-translate-y-0.5 flex items-center gap-2">
                            <span x-text="slide.ctaText"></span>
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                        <a :href="slide.btnSecLink"
                           class="px-7 py-3.5 rounded-full text-xs sm:text-sm font-semibold bg-white/10 hover:bg-white/20 text-white border border-white/20 backdrop-blur-md transition-all flex items-center gap-2">
                            <span x-text="slide.btnSec"></span>
                        </a>
                    </div>

                </div>
            </template>
        </div>

        {{-- ── SLIDER NAVIGATION CONTROLS ── --}}
        {{-- Prev Button --}}
        <button type="button"
                @click="prevSlide()"
                class="absolute left-3 sm:left-6 top-1/2 -translate-y-1/2 z-20 w-11 h-11 sm:w-12 sm:h-12 rounded-full bg-white/10 hover:bg-white/25 text-white border border-white/20 backdrop-blur-md flex items-center justify-center transition-all hover:scale-110 shadow-lg"
                title="Slide Sebelumnya"
                aria-label="Slide Sebelumnya">
            <i data-lucide="chevron-left" class="w-6 h-6"></i>
        </button>

        {{-- Next Button --}}
        <button type="button"
                @click="nextSlide()"
                class="absolute right-3 sm:right-6 top-1/2 -translate-y-1/2 z-20 w-11 h-11 sm:w-12 sm:h-12 rounded-full bg-white/10 hover:bg-white/25 text-white border border-white/20 backdrop-blur-md flex items-center justify-center transition-all hover:scale-110 shadow-lg"
                title="Slide Selanjutnya"
                aria-label="Slide Selanjutnya">
            <i data-lucide="chevron-right" class="w-6 h-6"></i>
        </button>

        {{-- Dot Indicators --}}
        <div class="absolute bottom-24 inset-x-0 z-20 flex items-center justify-center gap-2.5">
            <template x-for="(slide, index) in slides" :key="index">
                <button type="button"
                        @click="goToSlide(index)"
                        class="h-2.5 rounded-full transition-all duration-300 cursor-pointer"
                        :class="currentSlide === index ? 'w-8 bg-amber-400 shadow-md' : 'w-2.5 bg-white/40 hover:bg-white/70'"
                        :title="`Buka Slide ${index + 1}`"
                        :aria-label="`Slide ${index + 1}`">
                </button>
            </template>
        </div>

    </section>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         3. HERO 3 FLOATING FEATURE CARDS
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <div id="capaian" class="-mt-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-30 scroll-mt-28">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-stretch">

            {{-- Card 1: Profil & Capaian Diskominfo (Left Card) --}}
            <div class="md:col-span-3 bg-white rounded-3xl p-6 shadow-xl border border-slate-100 flex flex-col justify-between">
                <div>
                    <span class="text-[10px] font-bold text-blue-700 uppercase tracking-widest block mb-1">Standar Layanan</span>
                    <h3 class="text-base font-extrabold text-slate-900 leading-snug">
                        Diskominfo Kab. Tasikmalaya
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">Komitmen Pelayanan Prima, Keamanan Informasi & SPBE Kabupaten.</p>

                    <div class="grid grid-cols-2 gap-3 pt-4">
                        <div class="p-3 bg-slate-50 rounded-2xl text-center border border-slate-100">
                            <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center mx-auto mb-1">
                                <i data-lucide="building-2" class="w-4 h-4"></i>
                            </div>
                            <span class="text-[11px] font-bold text-slate-800 block">39 Kecamatan</span>
                            <span class="text-[9px] text-slate-400">Terintegrasi</span>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-2xl text-center border border-slate-100">
                            <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center mx-auto mb-1">
                                <i data-lucide="shield-check" class="w-4 h-4"></i>
                            </div>
                            <span class="text-[11px] font-bold text-slate-800 block">Keamanan Data</span>
                            <span class="text-[9px] text-slate-400">Terenkripsi</span>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 text-right">
                    <a href="#layanan" class="text-xs font-bold text-[#0a2558] hover:text-blue-700 flex items-center justify-end gap-1">
                        <span>Lihat Layanan</span>
                        <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </div>

            {{-- Card 2: PROMINENT YELLOW PPID CARD (Center Card) --}}
            <div id="ppid-highlight" class="md:col-span-6 bg-yellow-ppid rounded-3xl p-6 sm:p-8 shadow-2xl flex flex-col sm:flex-row items-center justify-between gap-6 relative overflow-hidden scroll-mt-28">
                <div class="space-y-4 max-w-md relative z-10">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-950/10 text-slate-950 text-[11px] font-bold">
                        <i data-lucide="info" class="w-3.5 h-3.5"></i>
                        <span>PPID Diskominfo Kabupaten Tasikmalaya</span>
                    </div>

                    <h3 class="text-xl sm:text-2xl font-black text-slate-950 leading-tight">
                        <span class="italic font-extrabold">Yuk</span>, minta informasi melalui PPID Diskominfo Kabupaten Tasikmalaya
                    </h3>

                    <ul class="space-y-2 text-xs font-medium text-slate-900">
                        <li class="flex items-start gap-2">
                            <span class="w-4 h-4 rounded-full bg-white text-emerald-700 flex items-center justify-center font-bold text-[10px] flex-shrink-0 mt-0.5 shadow-xs">
                                <i data-lucide="check" class="w-3 h-3 text-emerald-700"></i>
                            </span>
                            <span>Diatur dalam <strong>Undang-Undang No. 14 Tahun 2008</strong> tentang Keterbukaan Informasi Publik.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="w-4 h-4 rounded-full bg-white text-emerald-700 flex items-center justify-center font-bold text-[10px] flex-shrink-0 mt-0.5 shadow-xs">
                                <i data-lucide="check" class="w-3 h-3 text-emerald-700"></i>
                            </span>
                            <span>PPID Diskominfo menyediakan informasi berkala, serta merta, dan setiap saat secara transparan.</span>
                        </li>
                    </ul>

                    <div class="pt-2 flex flex-wrap items-center gap-2.5">
                        <button type="button"
                                @click="openPpidModal()"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full font-bold text-xs bg-slate-950 hover:bg-slate-800 text-white shadow-md hover:shadow-lg transition-all active:scale-95 cursor-pointer">
                            <i data-lucide="send" class="w-3.5 h-3.5"></i>
                            <span>Ajukan Permohonan Informasi</span>
                        </button>
                        <a href="#ppid"
                           class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-full font-bold text-xs bg-white/70 hover:bg-white text-slate-950 border border-slate-950/15 backdrop-blur-xs transition-all hover:shadow-sm">
                            <span>Direktori Informasi PPID</span>
                            <i data-lucide="arrow-down" class="w-3.5 h-3.5"></i>
                        </a>
                    </div>
                </div>

                {{-- Officer Photo / Avatar Representation --}}
                <div class="flex-shrink-0 relative z-10 w-36 h-44 rounded-2xl bg-white/40 border border-white/60 flex flex-col items-center justify-center text-center p-3 shadow-sm backdrop-blur-xs">
                    <div class="w-12 h-12 rounded-2xl bg-slate-950 text-amber-400 flex items-center justify-center mb-2 shadow-sm">
                        <i data-lucide="headset" class="w-6 h-6"></i>
                    </div>
                    <span class="text-[11px] font-black text-slate-950">Petugas PPID</span>
                    <span class="text-[10px] text-slate-800 font-medium">Kab. Tasikmalaya</span>
                    <button type="button"
                            @click="openPpidTracking()"
                            class="mt-2 text-[10px] font-bold text-slate-950 bg-white/80 hover:bg-white px-2.5 py-1 rounded-full border border-slate-300 shadow-2xs transition-colors cursor-pointer">
                        Lacak Status →
                    </button>
                </div>
            </div>

            {{-- Card 3: SP4N-LAPOR! / Pengaduan (Right Card) --}}
            <div id="pengaduan" class="md:col-span-3 bg-white rounded-3xl p-6 shadow-xl border border-slate-100 flex flex-col justify-between scroll-mt-28">
                <div>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-14 rounded-2xl bg-rose-50 border border-rose-200 flex items-center justify-center text-rose-600 flex-shrink-0">
                            <i data-lucide="megaphone" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-rose-950 leading-snug">
                                Aspirasi & Pengaduan
                            </h3>
                            <p class="text-xs text-slate-500 mt-1">Sampaikan laporan layanan publik ke Diskominfo & SP4N-LAPOR!.</p>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100">
                    <button type="button"
                            @click="openPengaduan()"
                            class="w-full inline-flex items-center justify-center gap-1.5 py-2.5 rounded-xl font-bold text-xs text-white bg-rose-600 hover:bg-rose-700 transition-colors shadow-xs cursor-pointer">
                        <span>Buat Pengaduan</span>
                        <i data-lucide="arrow-up-right" class="w-3.5 h-3.5"></i>
                    </button>
                </div>
            </div>

        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         4. 8 MASTER LAYANAN PUBLIK TERPADU
    ═══════════════════════════════════════════════════════════════════════════ --}}
    {{-- ═══════════════════════════════════════════════════════════════════════════
         4. KATALOG LAYANAN PUBLIK TERPADU (AICLASSASEAN STYLE CARDS)
    ═══════════════════════════════════════════════════════════════════════════ --}}
    @php
        $publicServicesData = [
            [
                'kode' => 'EKTP',
                'category_id' => 'identitas',
                'category' => 'Identitas Kependudukan',
                'title' => 'Perekaman E-KTP Biometrik',
                'time' => '1 Hari Kerja',
                'modules' => '2 Dokumen Syarat',
                'learners' => '84.778 Pemohon',
                'image' => asset('images/layanan-ektp.png'),
                'url' => route('layanan.show', ['serviceCode' => 'EKTP']),
            ],
            [
                'kode' => 'KIA',
                'category_id' => 'identitas',
                'category' => 'Identitas Kependudukan',
                'title' => 'Pembuatan Kartu Identitas Anak (KIA)',
                'time' => '1 Hari Kerja',
                'modules' => '4 Dokumen Syarat',
                'learners' => '52.410 Pemohon',
                'image' => asset('images/layanan-kia.png'),
                'url' => route('layanan.show', ['serviceCode' => 'KIA']),
            ],
            [
                'kode' => 'KK_BARU',
                'category_id' => 'kk',
                'category' => 'Kartu Keluarga',
                'title' => 'Penerbitan Kartu Keluarga (KK) Baru',
                'time' => '2 Hari Kerja',
                'modules' => '4 Dokumen Syarat',
                'learners' => '71.372 Pemohon',
                'image' => asset('images/layanan-kk-baru.png'),
                'url' => route('layanan.show', ['serviceCode' => 'KK_BARU']),
            ],
            [
                'kode' => 'KK_ADD',
                'category_id' => 'kk',
                'category' => 'Kartu Keluarga',
                'title' => 'Penambahan Anggota Kartu Keluarga',
                'time' => '1 Hari Kerja',
                'modules' => '3 Dokumen Syarat',
                'learners' => '48.290 Pemohon',
                'image' => asset('images/layanan-kk-add.png'),
                'url' => route('layanan.show', ['serviceCode' => 'KK_ADD']),
            ],
            [
                'kode' => 'PINDAH_SATU_DESA',
                'category_id' => 'pindah',
                'category' => 'Perpindahan Domisili',
                'title' => 'Pindah Datang WNI (Satu Desa / F.1-23)',
                'time' => '1 Hari Kerja',
                'modules' => '3 Dokumen Syarat',
                'learners' => '66.859 Pemohon',
                'image' => asset('images/layanan-pindah.jpg'),
                'url' => route('layanan.show', ['serviceCode' => 'PINDAH_SATU_DESA']),
            ],
            [
                'kode' => 'PINDAH_ANTAR_KEC',
                'category_id' => 'pindah',
                'category' => 'Perpindahan Domisili',
                'title' => 'Pindah Antar Kecamatan (SKPWNI / F.1-29)',
                'time' => '2 Hari Kerja',
                'modules' => '3 Dokumen Syarat',
                'learners' => '39.120 Pemohon',
                'image' => asset('images/layanan-pindah-antar-kecamatan.jpg'),
                'url' => route('layanan.show', ['serviceCode' => 'PINDAH_ANTAR_KEC']),
            ],
            [
                'kode' => 'NIKAH',
                'category_id' => 'surat',
                'category' => 'Dispensasi & Keterangan',
                'title' => 'Surat Rekomendasi / Dispensasi Nikah',
                'time' => '1 Hari Kerja',
                'modules' => '5 Dokumen Syarat',
                'learners' => '28.640 Pemohon',
                'image' => asset('images/layanan-nikah.png'),
                'url' => route('layanan.show', ['serviceCode' => 'NIKAH']),
            ],
            [
                'kode' => 'LAINNYA',
                'category_id' => 'surat',
                'category' => 'Dispensasi & Keterangan',
                'title' => 'Surat Keterangan Camat Terpadu',
                'time' => '1 Hari Kerja',
                'modules' => '4 Dokumen Syarat',
                'learners' => '61.930 Pemohon',
                'image' => asset('images/layanan-surat-keterangan.png'),
                'url' => route('layanan.show', ['serviceCode' => 'LAINNYA']),
            ],
        ];
    @endphp

    <section id="layanan" class="aiclass-section bg-white" x-data="{
        activeCategory: 'all',
        services: {{ json_encode($publicServicesData) }},
        get filteredServices() {
            if (this.activeCategory === 'all') return this.services;
            return this.services.filter(s => s.category_id === this.activeCategory);
        },
        scrollTrack(offset) {
            this.$refs.cardTrack.scrollBy({ left: offset, behavior: 'smooth' });
        }
    }">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6">
            
            {{-- Header (Meniru Persis Tata Letak & Tipografi Referensi) --}}
            <div class="text-center mb-4">
                <h3 style="color: #355bdc; font-weight: 800; font-size: 1rem; letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 6px;">
                    LAYANAN KAMI
                </h3>
                <h4 style="font-weight: 700; font-size: 2.5rem; letter-spacing: -0.02em; margin-bottom: 24px; line-height: 1.2;">
                    <span style="color: #e84435;">Layanan</span> <span style="color: #000000;">Terpopuler Kami</span>
                </h4>

                {{-- Filter Pills Bar (Meniru Persis Bentuk, Border, & Gradien Tombol Aktif) --}}
                <div class="aiclass-filter-bar">
                    <button type="button"
                            @click="activeCategory = 'all'; $refs.cardTrack.scrollLeft = 0"
                            :class="activeCategory === 'all' ? 'active' : ''"
                            class="aiclass-filter-btn">
                        Semua Layanan
                    </button>
                    <button type="button"
                            @click="activeCategory = 'identitas'; $refs.cardTrack.scrollLeft = 0"
                            :class="activeCategory === 'identitas' ? 'active' : ''"
                            class="aiclass-filter-btn">
                        Identitas Kependudukan
                    </button>
                    <button type="button"
                            @click="activeCategory = 'kk'; $refs.cardTrack.scrollLeft = 0"
                            :class="activeCategory === 'kk' ? 'active' : ''"
                            class="aiclass-filter-btn">
                        Kartu Keluarga
                    </button>
                    <button type="button"
                            @click="activeCategory = 'pindah'; $refs.cardTrack.scrollLeft = 0"
                            :class="activeCategory === 'pindah' ? 'active' : ''"
                            class="aiclass-filter-btn">
                        Perpindahan Domisili
                    </button>
                    <button type="button"
                            @click="activeCategory = 'surat'; $refs.cardTrack.scrollLeft = 0"
                            :class="activeCategory === 'surat' ? 'active' : ''"
                            class="aiclass-filter-btn">
                        Dispensasi & Keterangan
                    </button>
                </div>
            </div>

            {{-- Horizontal Cards Carousel (Meniru Bentuk Kartu & 3.5 Kartu Horizontal Berjajar) --}}
            <div class="relative overflow-hidden w-full">
                <div x-ref="cardTrack"
                     class="flex gap-6 overflow-x-auto scroll-smooth pb-4 px-2 select-none"
                     style="scrollbar-width: none; -ms-overflow-style: none;">
                    
                    <template x-for="(item, index) in filteredServices" :key="item.kode">
                        <div class="aiclass-card">
                            <div>
                                {{-- Card Image --}}
                                <div class="card-img-wrap">
                                    <img :src="item.image" :alt="item.title" loading="lazy">
                                </div>

                                {{-- Tags Row: Blue Category Badge + Red Time Badge --}}
                                <div class="tags">
                                    <span class="competency" x-text="item.category"></span>
                                    <span class="time">
                                        <span style="display: inline-block; width: 6px; height: 6px; border-radius: 50%; background: #ffffff;"></span>
                                        <span x-text="item.time"></span>
                                    </span>
                                </div>

                                {{-- Service Title --}}
                                <h5 x-text="item.title"></h5>
                            </div>

                            <div>
                                {{-- Metadata Row with Black Borders --}}
                                <div class="meta-row">
                                    <span style="display: flex; align-items: center; gap: 6px;">
                                        <svg class="w-3.5 h-3.5 inline-block text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                        <span x-text="item.modules"></span>
                                    </span>
                                    <span style="display: flex; align-items: center; gap: 6px;">
                                        <svg class="w-3.5 h-3.5 inline-block text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <span x-text="item.learners"></span>
                                    </span>
                                </div>

                                {{-- Action Button: Aligned Left with Rounded Top Corners Only --}}
                                <a :href="item.url" class="btn-detail">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Slider Controls (Arrow Buttons & Progress Line) --}}
            <div class="aiclass-controls">
                <button type="button" @click="scrollTrack(-344)" class="aiclass-nav-arrow" aria-label="Sebelumnya">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <div class="w-32 h-1 bg-slate-200 rounded-full overflow-hidden">
                    <div class="h-full bg-[#ff9d00] rounded-full w-1/3 transition-all duration-300"></div>
                </div>
                <button type="button" @click="scrollTrack(344)" class="aiclass-nav-arrow" aria-label="Selanjutnya">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>

        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         5. TABEL DATA KEWILAYAHAN KECAMATAN KABUPATEN TASIKMALAYA
         (Model Presisi Sesuai Referensi Laci RW Kewilayahan)
    ═══════════════════════════════════════════════════════════════════════════ --}}
    @php
        $kecamatanTableData = $kecamatans->map(function ($kec) {
            $actualDesas = $kec->desas ?? collect();
            $desaCount = $kec->total_desa;
            $rwCount = $kec->total_rw;
            $rtCount = $kec->total_rt;

            return [
                'id' => $kec->id,
                'kode' => $kec->kode_kecamatan ?: ('KEC-' . str_pad($kec->id, 3, '0', STR_PAD_LEFT)),
                'nama' => $kec->nama_kecamatan,
                'desa_count' => $desaCount,
                'rw_count' => $rwCount,
                'rt_count' => $rtCount,
                'alamat' => $kec->alamat_kantor ?: ('Jl. Raya ' . $kec->nama_kecamatan . ' No. 01, Kab. Tasikmalaya, Jawa Barat 46182'),
                'telepon' => $kec->telepon ?: ('(0265) 54' . str_pad($kec->id, 4, '0', STR_PAD_LEFT)),
                'email' => $kec->email ?: ('kecamatan.' . \Illuminate\Support\Str::slug($kec->nama_kecamatan) . '@tasikmalayakab.go.id'),
                'jam' => $kec->jam_operasional ?: 'Senin - Jumat (08.00 - 15.30 WIB)',
                'desas' => $actualDesas->map(fn($d) => [
                    'kode' => $d->kode_desa,
                    'nama' => $d->nama_desa,
                    'rw' => $d->jumlah_rw ?? 0,
                    'rt' => $d->jumlah_rt ?? 0,
                ])->values()->all(),
            ];
        })->values()->all();
    @endphp

    <section id="kewilayahan"
             class="pt-12 pb-20 bg-[#8cb7ee] relative overflow-hidden"
             x-data="{
                 searchQuery: '',
                 perPage: 10,
                 currentPage: 1,
                 sortCol: 'nama',
                 sortAsc: true,
                 showModal: false,
                 selectedKec: null,
                 rawData: {{ Js::from($kecamatanTableData) }},

                 sortBy(col) {
                     if (this.sortCol === col) {
                         this.sortAsc = !this.sortAsc;
                     } else {
                         this.sortCol = col;
                         this.sortAsc = true;
                     }
                     this.currentPage = 1;
                 },

                 get filteredData() {
                     let q = this.searchQuery.toLowerCase().trim();
                     let data = this.rawData.filter(item => {
                         return !q ||
                             item.nama.toLowerCase().includes(q) ||
                             item.kode.toLowerCase().includes(q) ||
                             item.desa_count.toString().includes(q) ||
                             item.rw_count.toString().includes(q) ||
                             item.rt_count.toString().includes(q);
                     });

                     data.sort((a, b) => {
                         let valA = a[this.sortCol];
                         let valB = b[this.sortCol];
                         if (typeof valA === 'string') {
                             return this.sortAsc
                                 ? valA.localeCompare(valB)
                                 : valB.localeCompare(valA);
                         }
                         return this.sortAsc ? (valA - valB) : (valB - valA);
                     });

                     return data;
                 },

                 get paginatedData() {
                     if (this.perPage >= 999) return this.filteredData;
                     let start = (this.currentPage - 1) * this.perPage;
                     return this.filteredData.slice(start, start + parseInt(this.perPage));
                 },

                 get totalPages() {
                     if (this.perPage >= 999) return 1;
                     return Math.ceil(this.filteredData.length / this.perPage) || 1;
                 },

                 openDetail(item) {
                     this.selectedKec = item;
                     this.showModal = true;
                     this.$nextTick(() => {
                         if (window.lucide) window.lucide.createIcons();
                     });
                 }
             }">

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- 1. Dark Navy Title Banner Pill (Identik dengan Screenshot) --}}
            <div class="flex justify-center mb-6">
                <div class="bg-[#0e3a6c] text-white font-bold text-lg sm:text-2xl px-8 sm:px-14 py-3 rounded-lg shadow-md border border-white/10 tracking-wide text-center">
                    Tabel Data Kecamatan Kabupaten Tasikmalaya
                </div>
            </div>

            {{-- 2. White Card Container --}}
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200/80 p-5 sm:p-8">

                {{-- Controls Row: Filter (Left) & Show (Right) --}}
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4 mb-6">
                    {{-- Filter Input --}}
                    <div class="flex items-center gap-2">
                        <label for="kecamatanFilter" class="text-sm font-semibold text-slate-700">Filter:</label>
                        <div class="relative w-full sm:w-64">
                            <input id="kecamatanFilter"
                                   type="text"
                                   x-model="searchQuery"
                                   @input="currentPage = 1"
                                   placeholder="Type to filter..."
                                   class="w-full pl-3 pr-9 py-1.5 text-sm bg-white border border-slate-300 rounded focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 text-slate-800 placeholder-slate-400">
                            <div class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Show Per Page Select --}}
                    <div class="flex items-center justify-end gap-2">
                        <label for="showPerPage" class="text-sm font-semibold text-slate-700">Show:</label>
                        <div class="relative">
                            <select id="showPerPage"
                                    x-model="perPage"
                                    @change="currentPage = 1"
                                    class="appearance-none bg-white border border-slate-300 rounded px-3 py-1.5 pr-8 text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 cursor-pointer">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="999">Semua</option>
                            </select>
                            <svg class="w-4 h-4 text-slate-500 absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Table Responsive Wrapper --}}
                <div class="overflow-x-auto rounded border border-slate-200">
                    <table class="w-full text-sm text-left border-collapse">
                        {{-- Blue Header Sesuai Screenshot --}}
                        <thead>
                            <tr class="bg-[#0088e8] text-white font-bold select-none text-xs sm:text-sm">
                                <th scope="col" @click="sortBy('nama')" class="py-3 px-4 sm:px-6 cursor-pointer hover:bg-[#007cd3] transition-colors">
                                    <div class="flex items-center gap-1.5">
                                        <span>Kecamatan</span>
                                        <span class="text-sky-200 text-xs" :class="{ 'text-white font-extrabold': sortCol === 'nama' }">↕</span>
                                    </div>
                                </th>
                                <th scope="col" @click="sortBy('desa_count')" class="py-3 px-4 sm:px-6 cursor-pointer hover:bg-[#007cd3] transition-colors">
                                    <div class="flex items-center gap-1.5">
                                        <span>Kelurahan</span>
                                        <span class="text-sky-200 text-xs" :class="{ 'text-white font-extrabold': sortCol === 'desa_count' }">↕</span>
                                    </div>
                                </th>
                                <th scope="col" @click="sortBy('rw_count')" class="py-3 px-4 sm:px-6 cursor-pointer hover:bg-[#007cd3] transition-colors">
                                    <div class="flex items-center gap-1.5">
                                        <span>RW</span>
                                        <span class="text-sky-200 text-xs" :class="{ 'text-white font-extrabold': sortCol === 'rw_count' }">↕</span>
                                    </div>
                                </th>
                                <th scope="col" @click="sortBy('rt_count')" class="py-3 px-4 sm:px-6 cursor-pointer hover:bg-[#007cd3] transition-colors">
                                    <div class="flex items-center gap-1.5">
                                        <span>RT</span>
                                        <span class="text-sky-200 text-xs" :class="{ 'text-white font-extrabold': sortCol === 'rt_count' }">↕</span>
                                    </div>
                                </th>
                                <th scope="col" class="py-3 px-4 sm:px-6 text-center">
                                    Detail
                                </th>
                            </tr>
                        </thead>

                        {{-- Body Rows --}}
                        <tbody class="divide-y divide-slate-200 bg-white">
                            <template x-for="(item, idx) in paginatedData" :key="item.id">
                                <tr class="hover:bg-sky-50/40 transition-colors text-slate-700">
                                    <td class="py-3.5 px-4 sm:px-6 font-medium text-slate-900">
                                        <span x-text="item.nama"></span>
                                    </td>
                                    <td class="py-3.5 px-4 sm:px-6 text-slate-600" x-text="item.desa_count"></td>
                                    <td class="py-3.5 px-4 sm:px-6 text-slate-600" x-text="item.rw_count"></td>
                                    <td class="py-3.5 px-4 sm:px-6 text-slate-600" x-text="item.rt_count"></td>
                                    <td class="py-3.5 px-4 sm:px-6 text-center">
                                        <button type="button"
                                                @click="openDetail(item)"
                                                class="inline-block bg-[#102a43] hover:bg-[#0a2558] text-white text-xs font-semibold px-4 py-1.5 rounded shadow-2xs transition-all active:scale-95 focus:outline-none focus:ring-2 focus:ring-blue-600/30">
                                            Detail
                                        </button>
                                    </td>
                                </tr>
                            </template>

                            {{-- Empty State --}}
                            <tr x-show="filteredData.length === 0">
                                <td colspan="5" class="py-10 text-center text-slate-400">
                                    <p class="font-medium text-sm">Tidak ada data kecamatan yang sesuai dengan filter pencarian.</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Pagination & Summary Footer --}}
                <div class="mt-5 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs sm:text-sm text-slate-600">
                    <div>
                        Menampilkan
                        <span class="font-bold text-slate-900" x-text="filteredData.length === 0 ? 0 : ((currentPage - 1) * perPage + 1)"></span>
                        sampai
                        <span class="font-bold text-slate-900" x-text="Math.min(currentPage * perPage, filteredData.length)"></span>
                        dari
                        <span class="font-bold text-slate-900" x-text="filteredData.length"></span>
                        data kecamatan
                    </div>

                    <div class="flex items-center gap-1" x-show="totalPages > 1">
                        <button type="button"
                                @click="currentPage = Math.max(1, currentPage - 1)"
                                :disabled="currentPage === 1"
                                class="px-3 py-1.5 rounded border border-slate-200 text-slate-600 hover:bg-slate-100 disabled:opacity-40 disabled:cursor-not-allowed font-medium transition-colors">
                            Sebelumnya
                        </button>

                        <template x-for="p in totalPages" :key="p">
                            <button type="button"
                                    @click="currentPage = p"
                                    x-text="p"
                                    class="px-3 py-1.5 rounded border font-medium transition-colors"
                                    :class="currentPage === p ? 'bg-[#0088e8] border-[#0088e8] text-white font-bold' : 'border-slate-200 text-slate-700 hover:bg-slate-100'">
                            </button>
                        </template>

                        <button type="button"
                                @click="currentPage = Math.min(totalPages, currentPage + 1)"
                                :disabled="currentPage === totalPages"
                                class="px-3 py-1.5 rounded border border-slate-200 text-slate-600 hover:bg-slate-100 disabled:opacity-40 disabled:cursor-not-allowed font-medium transition-colors">
                            Selanjutnya
                        </button>
                    </div>
                </div>

            </div>

        </div>

        {{-- 3. Detail Modal Window --}}
        <div x-show="showModal"
             x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 overflow-y-auto"
             role="dialog"
             aria-modal="true">

            {{-- Backdrop --}}
            <div x-show="showModal"
                 x-transition:enter="ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="showModal = false"
                 class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs">
            </div>

            {{-- Modal Content Card --}}
            <div x-show="showModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative bg-white rounded-3xl shadow-2xl border border-slate-100 max-w-2xl w-full overflow-hidden z-10 my-8">

                {{-- Modal Header --}}
                <div class="px-6 py-5 bg-gradient-to-r from-[#0a2558] to-[#164e87] text-white flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-white font-bold">
                            <i data-lucide="map-pin" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <span class="text-[11px] uppercase tracking-wider font-semibold text-blue-200" x-text="'Kode Wilayah: ' + (selectedKec?.kode || '-')"></span>
                            <h3 class="text-xl font-bold" x-text="'Kecamatan ' + (selectedKec?.nama || '')"></h3>
                        </div>
                    </div>
                    <button type="button" @click="showModal = false" class="text-white/70 hover:text-white p-2 rounded-xl hover:bg-white/10 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                {{-- Modal Body --}}
                <div class="p-6 space-y-5 text-sm text-slate-600">

                    {{-- 3 Quick Stats Pill --}}
                    <div class="grid grid-cols-3 gap-3">
                        <div class="bg-blue-50/80 border border-blue-100 rounded-2xl p-3.5 text-center">
                            <span class="block text-2xl font-black text-[#0a2558]" x-text="selectedKec?.desa_count"></span>
                            <span class="text-xs font-semibold text-blue-700">Desa / Kelurahan</span>
                        </div>
                        <div class="bg-amber-50/80 border border-amber-100 rounded-2xl p-3.5 text-center">
                            <span class="block text-2xl font-black text-amber-900" x-text="selectedKec?.rw_count"></span>
                            <span class="text-xs font-semibold text-amber-700">Rukun Warga (RW)</span>
                        </div>
                        <div class="bg-emerald-50/80 border border-emerald-100 rounded-2xl p-3.5 text-center">
                            <span class="block text-2xl font-black text-emerald-900" x-text="selectedKec?.rt_count"></span>
                            <span class="text-xs font-semibold text-emerald-700">Rukun Tetangga (RT)</span>
                        </div>
                    </div>

                    {{-- Info Kantor --}}
                    <div class="bg-slate-50 rounded-2xl p-4 border border-slate-200/80 space-y-2.5">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-800 flex items-center gap-1.5">
                            <i data-lucide="building-2" class="w-4 h-4 text-blue-600"></i>
                            <span>Informasi Kantor Kecamatan</span>
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                            <div>
                                <span class="text-slate-400 block">Alamat Kantor:</span>
                                <span class="text-slate-800 font-medium" x-text="selectedKec?.alamat"></span>
                            </div>
                            <div>
                                <span class="text-slate-400 block">Jam Operasional:</span>
                                <span class="text-emerald-700 font-medium" x-text="selectedKec?.jam"></span>
                            </div>
                            <div>
                                <span class="text-slate-400 block">Nomor Telepon:</span>
                                <span class="text-slate-800 font-medium" x-text="selectedKec?.telepon"></span>
                            </div>
                            <div>
                                <span class="text-slate-400 block">Email Resmi:</span>
                                <span class="text-blue-600 font-medium" x-text="selectedKec?.email"></span>
                            </div>
                        </div>
                    </div>

                    {{-- Daftar Desa/Kelurahan --}}
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-800">
                                Wilayah Kerja Desa / Kelurahan
                            </h4>
                            <span class="text-xs font-medium text-slate-500" x-text="selectedKec?.desas?.length ? (selectedKec.desas.length + ' Desa Terdata') : (selectedKec?.desa_count + ' Wilayah Desa')"></span>
                        </div>

                        <div class="max-h-48 overflow-y-auto pr-1">
                            <template x-if="selectedKec?.desas && selectedKec.desas.length > 0">
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                    <template x-for="desa in selectedKec.desas" :key="desa.kode">
                                        <div class="px-3 py-2 bg-white border border-slate-200 rounded-xl flex items-center gap-2 shadow-2xs">
                                            <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                                            <div class="truncate">
                                                <p class="text-xs font-semibold text-slate-800 truncate" x-text="desa.nama"></p>
                                                <p class="text-[10px] text-slate-400 truncate" x-text="desa.kode"></p>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </template>

                            <template x-if="!selectedKec?.desas || selectedKec.desas.length === 0">
                                <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-600 flex items-center gap-2.5">
                                    <i data-lucide="info" class="w-4 h-4 text-blue-500 flex-shrink-0"></i>
                                    <span>Kecamatan ini mengoordinasikan <strong class="text-slate-800" x-text="selectedKec?.desa_count"></strong> desa/kelurahan aktif yang terhubung dalam sistem pelayanan administrasi terpadu Diskominfo Kab. Tasikmalaya.</span>
                                </div>
                            </template>
                        </div>
                    </div>

                </div>

                {{-- Modal Footer --}}
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button type="button"
                            @click="showModal = false"
                            class="px-4 py-2 text-xs font-bold text-slate-600 hover:text-slate-800 bg-white hover:bg-slate-100 border border-slate-200 rounded-xl transition-colors">
                        Tutup
                    </button>
                    @auth
                        <a href="{{ route('warga.submissions.index') }}"
                           class="px-5 py-2 text-xs font-bold text-white bg-[#0a2558] hover:bg-[#0d3070] rounded-xl shadow-md transition-all">
                            Ajukan Permohonan di Kecamatan Ini
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="px-5 py-2 text-xs font-bold text-white bg-[#0a2558] hover:bg-[#0d3070] rounded-xl shadow-md transition-all">
                            Masuk & Ajukan Layanan
                        </a>
                    @endauth
                </div>

            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         6. PORTAL PPID & KETERBUKAAN INFORMASI PUBLIK
         Dinas Komunikasi dan Informatika Kabupaten Tasikmalaya
         Berdasarkan UU RI No. 14 Tahun 2008 tentang Keterbukaan Informasi Publik
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <section id="ppid" class="py-20 bg-slate-50 border-t border-slate-200/90 relative scroll-mt-24 sm:scroll-mt-28 overflow-hidden">
        
        {{-- Ambient decorative background circles --}}
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-slate-200/50 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-slate-200/50 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

            {{-- 1. HEADER SECTION --}}
            <div class="text-center max-w-3xl mx-auto mb-12">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-slate-100 text-[#0a2558] border border-slate-200 text-xs font-semibold shadow-2xs">
                    <span class="w-2 h-2 rounded-full bg-[#0a2558]"></span>
                    <span>Pejabat Pengelola Informasi & Dokumentasi (PPID)</span>
                </div>
                <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight mt-3">
                    Portal Keterbukaan Informasi Publik
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 mt-2.5 leading-relaxed">
                    Sesuai amanat <strong>Undang-Undang No. 14 Tahun 2008</strong>, Pemerintah Kabupaten Tasikmalaya melalui Diskominfo menjamin hak masyarakat untuk memperoleh informasi publik secara transparan, akurat, dan bebas biaya.
                </p>

                {{-- Action Quick Buttons --}}
                <div class="flex flex-wrap items-center justify-center gap-3 mt-6">
                    <button type="button"
                            @click="openPpidModal()"
                            class="px-5 py-2.5 rounded-full text-xs font-bold text-white bg-[#0a2558] hover:bg-[#0d3070] shadow-md hover:shadow-lg transition-all active:scale-95 flex items-center gap-2 cursor-pointer">
                        <i data-lucide="send" class="w-4 h-4 text-white"></i>
                        <span>Ajukan Permohonan Informasi</span>
                    </button>
                    <button type="button"
                            @click="openPpidTracking()"
                            class="px-5 py-2.5 rounded-full text-xs font-bold text-slate-800 bg-white hover:bg-slate-50 border border-slate-300 shadow-2xs transition-all active:scale-95 flex items-center gap-2 cursor-pointer">
                        <i data-lucide="search" class="w-4 h-4 text-slate-600"></i>
                        <span>Lacak Status Permohonan</span>
                    </button>
                    <button type="button"
                            @click="activePpidTab = 'alur'; $nextTick(() => lucide.createIcons())"
                            class="px-5 py-2.5 rounded-full text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 transition-all flex items-center gap-1.5 cursor-pointer">
                        <i data-lucide="git-branch" class="w-4 h-4 text-slate-600"></i>
                        <span>Alur & SOP Pelayanan</span>
                    </button>
                </div>
            </div>

            {{-- 2. 4 HIGHLIGHT STATS CARDS --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
                <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-xs flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-slate-100 text-[#0a2558] flex items-center justify-center flex-shrink-0">
                        <i data-lucide="folder-check" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <span class="text-lg font-black text-slate-900 block leading-tight">4 Kategori</span>
                        <span class="text-[11px] text-slate-500 font-medium">Informasi Publik Resmi</span>
                    </div>
                </div>

                <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-xs flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-slate-100 text-[#0a2558] flex items-center justify-center flex-shrink-0">
                        <i data-lucide="clock" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <span class="text-lg font-black text-slate-900 block leading-tight">10 + 7 Hari</span>
                        <span class="text-[11px] text-slate-500 font-medium">Maks. Pelayanan UU KIP</span>
                    </div>
                </div>

                <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-xs flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-slate-100 text-[#0a2558] flex items-center justify-center flex-shrink-0">
                        <i data-lucide="badge-percent" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <span class="text-lg font-black text-slate-900 block leading-tight">Rp 0 (Gratis)</span>
                        <span class="text-[11px] text-slate-500 font-medium">Bebas Pungutan Biaya</span>
                    </div>
                </div>

                <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-xs flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-slate-100 text-[#0a2558] flex items-center justify-center flex-shrink-0">
                        <i data-lucide="network" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <span class="text-lg font-black text-slate-900 block leading-tight">39 Kecamatan</span>
                        <span class="text-[11px] text-slate-500 font-medium">PPID Pembantu Terhubung</span>
                    </div>
                </div>
            </div>

            {{-- 3. MAIN PPID CARD CONTAINER WITH TABS --}}
            <div id="ppid-daftar" class="bg-white rounded-3xl border border-slate-200/90 shadow-xl overflow-hidden scroll-mt-28">

                {{-- Tabs Bar --}}
                <div class="px-5 sm:px-8 pt-4 pb-4 sm:pb-0 bg-slate-900 text-white flex flex-wrap items-center justify-between gap-4 border-b border-slate-800">
                    <div class="flex items-center gap-2 overflow-x-auto pb-3 sm:pb-0 scrollbar-none w-full sm:w-auto">
                        <button type="button"
                                @click="activePpidTab = 'dokumen'; $nextTick(() => lucide.createIcons())"
                                class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2 whitespace-nowrap cursor-pointer"
                                :class="activePpidTab === 'dokumen' ? 'bg-white text-[#0a2558] shadow-md' : 'text-slate-300 hover:text-white hover:bg-white/10'">
                            <i data-lucide="files" class="w-4 h-4"></i>
                            <span>Daftar Informasi Publik (DIP)</span>
                            <span class="px-1.5 py-0.5 rounded-full text-[10px] font-extrabold"
                                  :class="activePpidTab === 'dokumen' ? 'bg-[#0a2558] text-white' : 'bg-white/20 text-white'">
                                17
                            </span>
                        </button>

                        <button type="button"
                                @click="activePpidTab = 'alur'; $nextTick(() => lucide.createIcons())"
                                class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2 whitespace-nowrap cursor-pointer"
                                :class="activePpidTab === 'alur' ? 'bg-white text-[#0a2558] shadow-md' : 'text-slate-300 hover:text-white hover:bg-white/10'">
                            <i data-lucide="workflow" class="w-4 h-4"></i>
                            <span>Alur & SOP Permohonan</span>
                        </button>

                        <button type="button"
                                @click="activePpidTab = 'regulasi'; $nextTick(() => lucide.createIcons())"
                                class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2 whitespace-nowrap cursor-pointer"
                                :class="activePpidTab === 'regulasi' ? 'bg-white text-[#0a2558] shadow-md' : 'text-slate-300 hover:text-white hover:bg-white/10'">
                            <i data-lucide="scale" class="w-4 h-4"></i>
                            <span>Dasar Hukum & Regulasi</span>
                        </button>

                        <button type="button"
                                @click="activePpidTab = 'kontak'; $nextTick(() => lucide.createIcons())"
                                class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2 whitespace-nowrap cursor-pointer"
                                :class="activePpidTab === 'kontak' ? 'bg-white text-[#0a2558] shadow-md' : 'text-slate-300 hover:text-white hover:bg-white/10'">
                            <i data-lucide="phone-call" class="w-4 h-4"></i>
                            <span>Meja Layanan PPID</span>
                        </button>
                    </div>

                    <div class="hidden sm:flex items-center gap-2 pb-3 sm:pb-0 text-[11px] text-slate-300">
                        <i data-lucide="shield-check" class="w-4 h-4 text-slate-300"></i>
                        <span>Diskominfo Terverifikasi KIP</span>
                    </div>
                </div>

                {{-- TAB CONTENT 1: DAFTAR INFORMASI PUBLIK (DIP) --}}
                <div x-show="activePpidTab === 'dokumen'" class="p-5 sm:p-8 space-y-6">

                    {{-- Filters & Search Controls --}}
                    <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4 pb-6 border-b border-slate-100">
                        
                        {{-- Category Pills --}}
                        <div class="flex flex-wrap items-center gap-2">
                            <button type="button"
                                    @click="ppidCategory = 'all'; $nextTick(() => lucide.createIcons())"
                                    class="px-3.5 py-1.5 rounded-full text-xs font-bold transition-all cursor-pointer"
                                    :class="ppidCategory === 'all' ? 'bg-[#0a2558] text-white border border-[#0a2558] shadow-xs' : 'bg-white hover:bg-slate-50 text-slate-600 border border-slate-200'">
                                Semua Kategori (17)
                            </button>
                            <button type="button"
                                    @click="ppidCategory = 'berkala'; $nextTick(() => lucide.createIcons())"
                                    class="px-3.5 py-1.5 rounded-full text-xs font-bold transition-all cursor-pointer"
                                    :class="ppidCategory === 'berkala' ? 'bg-[#0a2558] text-white border border-[#0a2558] shadow-xs' : 'bg-white hover:bg-slate-50 text-slate-600 border border-slate-200'">
                                Berkala (6)
                            </button>
                            <button type="button"
                                    @click="ppidCategory = 'serta-merta'; $nextTick(() => lucide.createIcons())"
                                    class="px-3.5 py-1.5 rounded-full text-xs font-bold transition-all cursor-pointer"
                                    :class="ppidCategory === 'serta-merta' ? 'bg-[#0a2558] text-white border border-[#0a2558] shadow-xs' : 'bg-white hover:bg-slate-50 text-slate-600 border border-slate-200'">
                                Serta Merta (4)
                            </button>
                            <button type="button"
                                    @click="ppidCategory = 'setiap-saat'; $nextTick(() => lucide.createIcons())"
                                    class="px-3.5 py-1.5 rounded-full text-xs font-bold transition-all cursor-pointer"
                                    :class="ppidCategory === 'setiap-saat' ? 'bg-[#0a2558] text-white border border-[#0a2558] shadow-xs' : 'bg-white hover:bg-slate-50 text-slate-600 border border-slate-200'">
                                Setiap Saat (5)
                            </button>
                            <button type="button"
                                    @click="ppidCategory = 'dikecualikan'; $nextTick(() => lucide.createIcons())"
                                    class="px-3.5 py-1.5 rounded-full text-xs font-bold transition-all cursor-pointer"
                                    :class="ppidCategory === 'dikecualikan' ? 'bg-[#0a2558] text-white border border-[#0a2558] shadow-xs' : 'bg-white hover:bg-slate-50 text-slate-600 border border-slate-200'">
                                Dikecualikan (2)
                            </button>
                        </div>

                        {{-- Search Input --}}
                        <div class="relative w-full lg:w-80">
                            <input type="text"
                                   x-model="ppidSearch"
                                   placeholder="Cari dokumen, kode, topik..."
                                   class="w-full pl-9 pr-8 py-2 text-xs sm:text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-[#0a2558] text-slate-800 placeholder-slate-400">
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                                <i data-lucide="search" class="w-4 h-4"></i>
                            </div>
                            <button type="button"
                                    x-show="ppidSearch"
                                    @click="ppidSearch = ''"
                                    class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-0.5">
                                <i data-lucide="x" class="w-3.5 h-3.5"></i>
                            </button>
                        </div>

                    </div>

                    {{-- Dynamic Summary Text --}}
                    <div class="flex items-center justify-between text-xs text-slate-500">
                        <div>
                            Menampilkan <strong class="text-slate-900" x-text="filteredPpidDocs.length"></strong> dari <strong class="text-slate-900" x-text="ppidDocs.length"></strong> dokumen informasi publik resmi
                        </div>
                        <span class="text-[11px] text-slate-600 bg-slate-100 px-2.5 py-0.5 rounded-md font-semibold border border-slate-200/80">
                            Terakhir Diperbarui: Maret 2025
                        </span>
                    </div>

                    {{-- Documents Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <template x-for="doc in filteredPpidDocs" :key="doc.id">
                            <div class="p-5 rounded-2xl border border-slate-200/90 bg-white hover:border-slate-300 hover:shadow-md transition-all flex flex-col justify-between group">
                                <div class="space-y-2.5">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex items-center gap-2">
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider" :class="doc.categoryBadge" x-text="doc.categoryLabel"></span>
                                            <span class="text-[10px] font-mono text-slate-400 font-semibold" x-text="doc.id"></span>
                                        </div>
                                        <div class="flex items-center gap-1 text-[11px] font-semibold text-slate-400">
                                            <i data-lucide="download" class="w-3 h-3"></i>
                                            <span x-text="doc.downloads"></span>
                                        </div>
                                    </div>

                                    <h4 class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-[#0a2558] transition-colors leading-snug line-clamp-2"
                                        x-text="doc.title">
                                    </h4>

                                    <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed"
                                       x-text="doc.summary">
                                    </p>
                                </div>

                                <div class="pt-4 mt-3 border-t border-slate-100 flex items-center justify-between gap-2 text-[11px]">
                                    <div class="flex items-center gap-2 text-slate-500">
                                        <span class="px-1.5 py-0.5 rounded bg-slate-100 font-bold text-slate-700 text-[10px]" x-text="doc.type"></span>
                                        <span x-text="doc.size"></span>
                                        <span>&bull;</span>
                                        <span x-text="doc.date"></span>
                                    </div>

                                    <div class="flex items-center gap-1.5">
                                        <button type="button"
                                                @click="openDocPreview(doc)"
                                                class="px-2.5 py-1.5 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100 font-semibold transition-colors cursor-pointer"
                                                title="Lihat Ringkasan">
                                            Detail
                                        </button>
                                        <button type="button"
                                                @click="downloadDoc(doc)"
                                                class="px-3 py-1.5 rounded-lg bg-[#0a2558] hover:bg-[#0d3070] text-white font-bold transition-all shadow-2xs flex items-center gap-1 cursor-pointer">
                                            <i data-lucide="download" class="w-3 h-3"></i>
                                            <span>Unduh</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- Empty State --}}
                    <div x-show="filteredPpidDocs.length === 0" class="py-12 text-center text-slate-400 space-y-2">
                        <i data-lucide="file-question" class="w-10 h-10 mx-auto text-slate-300"></i>
                        <p class="font-bold text-slate-700 text-sm">Dokumen Informasi Tidak Ditemukan</p>
                        <p class="text-xs text-slate-500">Tidak ada dokumen yang cocok dengan kata kunci pencarian atau kategori yang dipilih.</p>
                        <button type="button" @click="ppidCategory = 'all'; ppidSearch = ''" class="mt-2 text-xs font-bold text-[#0a2558] hover:underline">
                            Reset Filter Pencarian
                        </button>
                    </div>

                </div>

                {{-- TAB CONTENT 2: ALUR & PROSEDUR PERMOHONAN (SOP) --}}
                <div x-show="activePpidTab === 'alur'" class="p-5 sm:p-8 space-y-8">
                    <div>
                        <h3 class="text-base sm:text-lg font-black text-slate-900">
                            Standar Operasional Prosedur (SOP) Permohonan Informasi Publik
                        </h3>
                        <p class="text-xs text-slate-500 mt-1">
                            Berdasarkan Peraturan Komisi Informasi (PERKI) No. 1 Tahun 2021 dan UU RI No. 14 Tahun 2008.
                        </p>
                    </div>

                    {{-- 4 Flow Steps --}}
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 relative">
                        {{-- Step 1 --}}
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/90 relative flex flex-col justify-between">
                            <div class="space-y-3">
                                <div class="w-8 h-8 rounded-xl bg-[#0a2558] text-white font-extrabold flex items-center justify-center text-sm shadow-xs">
                                    1
                                </div>
                                <h4 class="text-sm font-bold text-slate-900">Pengajuan Permohonan</h4>
                                <p class="text-xs text-slate-500 leading-relaxed">
                                    Pemohon mengisi formulir permohonan informasi secara online melalui portal ini atau datang langsung ke Meja PPID Diskominfo dengan melampirkan fotokopi KTP / Identitas.
                                </p>
                            </div>
                            <span class="text-[10px] font-semibold text-slate-600 bg-slate-100 px-2 py-0.5 rounded border border-slate-200/80 mt-4 block text-center">
                                Online / Langsung
                            </span>
                        </div>

                        {{-- Step 2 --}}
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/90 relative flex flex-col justify-between">
                            <div class="space-y-3">
                                <div class="w-8 h-8 rounded-xl bg-[#0a2558] text-white font-extrabold flex items-center justify-center text-sm shadow-xs">
                                    2
                                </div>
                                <h4 class="text-sm font-bold text-slate-900">Verifikasi & Tanda Terima</h4>
                                <p class="text-xs text-slate-500 leading-relaxed">
                                    Petugas PPID memeriksa kelengkapan identitas dan kejelasan permohonan. Petugas menerbitkan Bukti Tanda Terima Permohonan ber-Nomor Registrasi resmi.
                                </p>
                            </div>
                            <span class="text-[10px] font-semibold text-slate-600 bg-slate-100 px-2 py-0.5 rounded border border-slate-200/80 mt-4 block text-center">
                                Waktu: 1 - 3 Hari Kerja
                            </span>
                        </div>

                        {{-- Step 3 --}}
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/90 relative flex flex-col justify-between">
                            <div class="space-y-3">
                                <div class="w-8 h-8 rounded-xl bg-[#0a2558] text-white font-extrabold flex items-center justify-center text-sm shadow-xs">
                                    3
                                </div>
                                <h4 class="text-sm font-bold text-slate-900">Penyiapan & Uji Dokumen</h4>
                                <p class="text-xs text-slate-500 leading-relaxed">
                                    PPID mengoordinasikan penyiapan data kepada perangkat daerah terkait. Batas waktu penyiapan maksimal 10 hari kerja (+ perpanjangan 7 hari kerja jika informasi kompleks).
                                </p>
                            </div>
                            <span class="text-[10px] font-semibold text-slate-600 bg-slate-100 px-2 py-0.5 rounded border border-slate-200/80 mt-4 block text-center">
                                Maks. 10 + 7 Hari Kerja
                            </span>
                        </div>

                        {{-- Step 4 --}}
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/90 relative flex flex-col justify-between">
                            <div class="space-y-3">
                                <div class="w-8 h-8 rounded-xl bg-[#0a2558] text-white font-extrabold flex items-center justify-center text-sm shadow-xs">
                                    4
                                </div>
                                <h4 class="text-sm font-bold text-slate-900">Penyerahan Dokumen</h4>
                                <p class="text-xs text-slate-500 leading-relaxed">
                                    Pemohon menerima salinan dokumen informasi yang diminta dalam bentuk softcopy via email / download portal atau salinan fisik di loket pelayanan.
                                </p>
                            </div>
                            <span class="text-[10px] font-semibold text-slate-600 bg-slate-100 px-2 py-0.5 rounded border border-slate-200/80 mt-4 block text-center">
                                Selesai & Bebas Biaya
                            </span>
                        </div>
                    </div>

                    {{-- Mekanisme Pengajuan Keberatan --}}
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 text-xs text-slate-700 space-y-2.5">
                        <div class="flex items-center gap-2 font-bold text-slate-900 text-sm">
                            <i data-lucide="alert-triangle" class="w-4 h-4 text-[#0a2558]"></i>
                            <span>Mekanisme Pengajuan Keberatan Informasi Publik</span>
                        </div>
                        <p class="leading-relaxed">
                            Apabila permohonan informasi tidak ditanggapi, ditolak sebagian/seluruhnya, atau biaya/alasan tidak memuaskan, pemohon berhak mengajukan <strong>Surat Keberatan kepada Atasan PPID (Sekretaris Daerah / Kepala Dinas Kominfo)</strong> dalam jangka waktu paling lambat <strong>30 (tiga puluh) hari kerja</strong> setelah diterimanya surat pemberitahuan tertulis.
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center justify-end gap-3 pt-2">
                        <button type="button"
                                @click="triggerSyntheticDownload('Formulir_Permohonan_Informasi_Publik_Kosong.pdf'); triggerToast('Mengunduh Formulir Permohonan Manual (PDF)...')"
                                class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-100 text-xs font-bold transition-all flex items-center gap-2 cursor-pointer">
                            <i data-lucide="download" class="w-3.5 h-3.5"></i>
                            <span>Unduh Formulir Kosong (PDF)</span>
                        </button>
                        <button type="button"
                                @click="openPpidModal()"
                                class="px-5 py-2.5 rounded-xl bg-[#0a2558] hover:bg-[#0d3070] text-white text-xs font-bold shadow-md transition-all flex items-center gap-2 cursor-pointer">
                            <i data-lucide="send" class="w-3.5 h-3.5 text-white"></i>
                            <span>Mulai Isi Permohonan Online</span>
                        </button>
                    </div>
                </div>

                {{-- TAB CONTENT 3: DASAR HUKUM & HAK PEMOHON --}}
                <div x-show="activePpidTab === 'regulasi'" class="p-5 sm:p-8 space-y-6">
                    <div>
                        <h3 class="text-base sm:text-lg font-black text-slate-900">
                            Landasan Hukum & Hak Pemohon Informasi Publik
                        </h3>
                        <p class="text-xs text-slate-500 mt-1">
                            Payung hukum keterbukaan informasi di lingkungan Pemerintah Kabupaten Tasikmalaya.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                            <span class="px-2 py-0.5 rounded bg-slate-200/80 text-slate-700 font-semibold text-[10px] uppercase">Undang-Undang Nasional</span>
                            <h4 class="font-bold text-slate-900 text-sm">UU RI No. 14 Tahun 2008</h4>
                            <p class="text-slate-600 leading-relaxed">
                                Tentang Keterbukaan Informasi Publik yang menjamin hak setiap warga negara untuk mengetahui rencana pembuatan kebijakan publik, program keputusan publik, dan proses pengambilan keputusan publik.
                            </p>
                        </div>

                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                            <span class="px-2 py-0.5 rounded bg-slate-200/80 text-slate-700 font-semibold text-[10px] uppercase">Standar Layanan</span>
                            <h4 class="font-bold text-slate-900 text-sm">PERKI No. 1 Tahun 2021</h4>
                            <p class="text-slate-600 leading-relaxed">
                                Peraturan Komisi Informasi tentang Standar Layanan Informasi Publik yang memuat tata kelola PPID, format dokumen, jangka waktu layanan, dan prosedur uji konsekuensi informasi dikecualikan.
                            </p>
                        </div>

                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                            <span class="px-2 py-0.5 rounded bg-slate-200/80 text-slate-700 font-semibold text-[10px] uppercase">Regulasi Daerah</span>
                            <h4 class="font-bold text-slate-900 text-sm">Perbup Tasikmalaya No. 48 Tahun 2021</h4>
                            <p class="text-slate-600 leading-relaxed">
                                Pedoman Teknis Pengelolaan Pelayanan Informasi dan Dokumentasi di Lingkungan Pemerintah Daerah Kabupaten Tasikmalaya yang mengintegrasikan seluruh perangkat daerah dan 39 kecamatan.
                            </p>
                        </div>

                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                            <span class="px-2 py-0.5 rounded bg-slate-200/80 text-slate-700 font-semibold text-[10px] uppercase">Hak & Kewajiban</span>
                            <h4 class="font-bold text-slate-900 text-sm">Hak Pemohon Informasi</h4>
                            <p class="text-slate-600 leading-relaxed">
                                Setiap pemohon berhak melihat dan mengetahui informasi publik, menghadiri pertemuan publik yang terbuka, dan mendapatkan salinan informasi publik melalui permohonan resmi sesuai ketentuan perundang-undangan.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- TAB CONTENT 4: MEJA LAYANAN & KONTAK PPID --}}
                <div x-show="activePpidTab === 'kontak'" class="p-5 sm:p-8 space-y-6">
                    <div>
                        <h3 class="text-base sm:text-lg font-black text-slate-900">
                            Lokasi Meja Layanan Fisik & Kontak Petugas PPID
                        </h3>
                        <p class="text-xs text-slate-500 mt-1">
                            Kunjungi kantor PPID Diskominfo Kabupaten Tasikmalaya atau hubungi kanal layanan daring.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 text-[#0a2558] flex items-center justify-center font-bold">
                                <i data-lucide="map-pin" class="w-5 h-5"></i>
                            </div>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Alamat Meja Pelayanan</h4>
                            <p class="text-xs font-semibold text-slate-800 leading-relaxed">
                                Kantor Dinas Komunikasi dan Informatika (Diskominfo) Kab. Tasikmalaya<br>
                                Jl. Raya Cintaraja, Kec. Singaparna, Kabupaten Tasikmalaya, Jawa Barat 46182
                            </p>
                        </div>

                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 text-[#0a2558] flex items-center justify-center font-bold">
                                <i data-lucide="clock" class="w-5 h-5"></i>
                            </div>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Jam Operasional Layanan</h4>
                            <div class="text-xs space-y-1">
                                <p class="text-slate-800 font-bold">Senin - Kamis: 08.00 - 15.30 WIB</p>
                                <p class="text-slate-800 font-bold">Jumat: 08.00 - 15.00 WIB</p>
                                <p class="text-slate-400 text-[11px]">Sabtu, Minggu & Libur Nasional: Tutup</p>
                            </div>
                        </div>

                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 text-[#0a2558] flex items-center justify-center font-bold">
                                <i data-lucide="message-square" class="w-5 h-5"></i>
                            </div>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Kontak Resmi PPID</h4>
                            <div class="text-xs space-y-1">
                                <p class="text-slate-800">Email: <a href="mailto:ppid@tasikmalayakab.go.id" class="text-blue-600 font-semibold hover:underline">ppid@tasikmalayakab.go.id</a></p>
                                <p class="text-slate-800">Telepon / Fax: <span class="font-semibold">(0265) 545123</span></p>
                                <p class="text-slate-800">WhatsApp Desk: <span class="font-semibold text-emerald-700">0811-2345-6789</span></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         7. FOOTER — DISKOMINFO KABUPATEN TASIKMALAYA
    ═══════════════════════════════════════════════════════════════════════════ --}}
    <footer class="bg-slate-950 text-slate-400 text-xs py-10 sm:py-12 border-t border-slate-800 w-full overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8 text-center sm:text-left">
                
                {{-- Col 1: Identity --}}
                <div class="md:col-span-2 space-y-3">
                    <div class="inline-flex items-center bg-white px-4 py-2 rounded-2xl shadow-sm">
                        <img src="{{ asset('images/logo.png') }}" alt="Diskominfo Kabupaten Tasikmalaya" class="h-9 w-auto object-contain">
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed max-w-md mt-2">
                        Portal Pelayanan Publik Terpadu Pemerintah Kabupaten Tasikmalaya dikelola oleh Dinas Komunikasi dan Informatika (Diskominfo) untuk memberikan kemudahan akses layanan kependudukan dan surat keterangan masyarakat di 39 kecamatan.
                    </p>
                    <p class="text-[11px] text-slate-500 flex items-center justify-center sm:justify-start gap-1.5 pt-1">
                        <i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400"></i>
                        <span>Kantor Dishubkominfo Kab. Tasikmalaya, Cintaraja, Kec. Singaparna, Kabupaten Tasikmalaya, Jawa Barat 46182</span>
                    </p>
                </div>

                {{-- Col 2: Wilayah Layanan --}}
                <div class="space-y-2">
                    <h4 class="text-white font-bold text-xs uppercase tracking-wider mb-2">Wilayah Layanan</h4>
                    <ul class="space-y-1.5 text-xs text-slate-400">
                        <li>39 Kecamatan Aktif</li>
                        <li>351 Desa se-Kab. Tasikmalaya</li>
                        <li>Layanan Terpadu Satu Pintu</li>
                        <li>Pelayanan Ramah & Transparan</li>
                    </ul>
                </div>

                {{-- Col 3: Kontak Resmi --}}
                <div class="space-y-2">
                    <h4 class="text-white font-bold text-xs uppercase tracking-wider mb-2">Kontak Resmi</h4>
                    <p class="text-slate-400">Email: <a href="mailto:diskominfo@tasikmalayakab.go.id" class="text-blue-400 hover:underline">diskominfo@tasikmalayakab.go.id</a></p>
                    <p class="text-slate-400">Telepon: <span class="text-slate-200 font-semibold">(0265) 545123</span></p>
                    <p class="text-slate-400">Jam Layanan: <span class="text-emerald-400 font-medium">08.00 - 16.00 WIB</span></p>
                </div>

            </div>

            {{-- Copyright Bar --}}
            <div class="pt-8 border-t border-slate-800/80 flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left">
                <p class="text-xs text-slate-400">
                    &copy; {{ date('Y') }} Dinas Komunikasi dan Informatika (Diskominfo) Kabupaten Tasikmalaya. Seluruh Hak Cipta Dilindungi.
                </p>
                <div class="flex items-center gap-3 text-slate-500 text-xs">
                    <span>Portal Pelayanan Publik Terpadu</span>
                    <span>&bull;</span>
                    <span>Kabupaten Tasikmalaya</span>
                </div>
            </div>
        </div>
    </footer>

    {{-- ═══════════════════════════════════════════════════════════════════════════
         MODALS & INTERACTIVE OVERLAYS
    ═══════════════════════════════════════════════════════════════════════════ --}}

    {{-- 1. MODAL: FORMULIR PERMOHONAN INFORMASI PUBLIK (PPID ONLINE) --}}
    <div x-show="showPpidModal"
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 overflow-y-auto"
         role="dialog"
         aria-modal="true">
        
        {{-- Backdrop --}}
        <div x-show="showPpidModal"
             x-transition:enter="ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="showPpidModal = false"
             class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs"></div>

        {{-- Modal Content Card --}}
        <div x-show="showPpidModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:scale-95"
             class="relative bg-white rounded-3xl shadow-2xl border border-slate-100 max-w-2xl w-full overflow-hidden z-10 my-8">

            {{-- Header --}}
            <div class="px-6 py-5 bg-slate-900 text-white flex items-center justify-between border-b border-slate-800">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/10 text-white border border-white/20 flex items-center justify-center font-bold shadow-md">
                        <i data-lucide="send" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <span class="text-[10px] uppercase tracking-wider font-bold text-slate-400">PPID Online Diskominfo</span>
                        <h3 class="text-base sm:text-lg font-black text-white leading-tight">Formulir Permohonan Informasi Publik</h3>
                    </div>
                </div>
                <button type="button" @click="showPpidModal = false" class="text-slate-400 hover:text-white p-2 rounded-xl hover:bg-white/10 transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            {{-- Body Form --}}
            <form @submit.prevent="submitPpidForm()" class="p-6 space-y-4 text-xs max-h-[75vh] overflow-y-auto">
                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 text-[11px] leading-relaxed flex items-start gap-2">
                    <i data-lucide="info" class="w-4 h-4 text-[#0a2558] flex-shrink-0 mt-0.5"></i>
                    <span>Sesuai <strong>UU No. 14 Tahun 2008</strong>, permohonan informasi publik akan diverifikasi dalam 1-3 hari kerja dan diproses maksimal 10 hari kerja tanpa dipungut biaya (gratis).</span>
                </div>

                {{-- Kategori Pemohon --}}
                <div class="space-y-1.5">
                    <label class="font-bold text-slate-800 block">Kategori Pemohon <span class="text-rose-500">*</span></label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center gap-2 p-3 rounded-xl border cursor-pointer transition-all"
                                :class="ppidForm.kategori === 'perorangan' ? 'border-[#0a2558] bg-slate-100 text-[#0a2558] font-bold' : 'border-slate-200 text-slate-700'">
                            <input type="radio" value="perorangan" x-model="ppidForm.kategori" class="text-[#0a2558] focus:ring-0">
                            <span>Perorangan / Warga</span>
                        </label>
                        <label class="flex items-center gap-2 p-3 rounded-xl border cursor-pointer transition-all"
                                :class="ppidForm.kategori === 'lembaga' ? 'border-[#0a2558] bg-slate-100 text-[#0a2558] font-bold' : 'border-slate-200 text-slate-700'">
                            <input type="radio" value="lembaga" x-model="ppidForm.kategori" class="text-[#0a2558] focus:ring-0">
                            <span>Lembaga / Badan Hukum</span>
                        </label>
                    </div>
                </div>

                {{-- NIK & Nama --}}400">PPID Online Diskominfo</span>
                        <h3 class="text-base sm:text-lg font-black text-white leading-tight">Formulir Permohonan Informasi Publik</h3>
                    </div>
                </div>
                <button type="button" @click="showPpidModal = false" class="text-white/70 hover:text-white p-2 rounded-xl hover:bg-white/10 transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            {{-- Body Form --}}
            <form @submit.prevent="submitPpidForm()" class="p-6 space-y-4 text-xs max-h-[75vh] overflow-y-auto">
                <div class="p-3.5 rounded-xl bg-blue-50 border border-blue-200/80 text-blue-900 text-[11px] leading-relaxed flex items-start gap-2">
                    <i data-lucide="info" class="w-4 h-4 text-blue-600 flex-shrink-0 mt-0.5"></i>
                    <span>Sesuai <strong>UU No. 14 Tahun 2008</strong>, permohonan informasi publik akan diverifikasi dalam 1-3 hari kerja dan diproses maksimal 10 hari kerja tanpa dipungut biaya (gratis).</span>
                </div>

                {{-- Kategori Pemohon --}}
                <div class="space-y-1.5">
                    <label class="font-bold text-slate-800 block">Kategori Pemohon <span class="text-rose-500">*</span></label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center gap-2 p-3 rounded-xl border cursor-pointer transition-all"
                               :class="ppidForm.kategori === 'perorangan' ? 'border-[#0a2558] bg-blue-50/50 text-[#0a2558] font-bold' : 'border-slate-200 text-slate-700'">
                            <input type="radio" value="perorangan" x-model="ppidForm.kategori" class="text-blue-600 focus:ring-0">
                            <span>Perorangan / Warga</span>
                        </label>
                        <label class="flex items-center gap-2 p-3 rounded-xl border cursor-pointer transition-all"
                               :class="ppidForm.kategori === 'lembaga' ? 'border-[#0a2558] bg-blue-50/50 text-[#0a2558] font-bold' : 'border-slate-200 text-slate-700'">
                            <input type="radio" value="lembaga" x-model="ppidForm.kategori" class="text-blue-600 focus:ring-0">
                            <span>Lembaga / Badan Hukum</span>
                        </label>
                    </div>
                </div>

                {{-- NIK & Nama --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label class="font-bold text-slate-800 block">NIK (Nomor Induk Kependudukan) <span class="text-rose-500">*</span></label>
                        <input type="text"
                               x-model="ppidForm.nik"
                               required
                               maxlength="16"
                               placeholder="16 digit nomor KTP..."
                               class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-slate-900 font-mono">
                    </div>
                    <div class="space-y-1">
                        <label class="font-bold text-slate-800 block">Nama Lengkap Pemohon <span class="text-rose-500">*</span></label>
                        <input type="text"
                               x-model="ppidForm.nama"
                               required
                               placeholder="Sesuai kartu identitas resmi..."
                               class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-slate-900">
                    </div>
                </div>

                {{-- Kontak (No HP & Email) --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label class="font-bold text-slate-800 block">No. WhatsApp / HP Aktif <span class="text-rose-500">*</span></label>
                        <input type="tel"
                               x-model="ppidForm.no_hp"
                               required
                               placeholder="0812xxxxxxxx"
                               class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-slate-900">
                    </div>
                    <div class="space-y-1">
                        <label class="font-bold text-slate-800 block">Alamat Email Aktif <span class="text-rose-500">*</span></label>
                        <input type="email"
                               x-model="ppidForm.email"
                               required
                               placeholder="nama@email.com"
                               class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-slate-900">
                    </div>
                </div>

                {{-- Alamat Domisili --}}
                <div class="space-y-1">
                    <label class="font-bold text-slate-800 block">Alamat Domisili & Kecamatan <span class="text-rose-500">*</span></label>
                    <input type="text"
                           x-model="ppidForm.alamat"
                           required
                           placeholder="Contoh: Kp. Cintaraja RT 02/04, Kec. Singaparna..."
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-slate-900">
                </div>

                {{-- Rincian Informasi yang Dibutuhkan --}}
                <div class="space-y-1">
                    <label class="font-bold text-slate-800 block">Rincian Informasi Publik yang Dimohon <span class="text-rose-500">*</span></label>
                    <textarea x-model="ppidForm.rincian"
                              rows="3"
                              required
                              placeholder="Tuliskan secara jelas judul dokumen, data statistik, atau informasi yang Anda butuhkan..."
                              class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-slate-900 leading-relaxed"></textarea>
                </div>

                {{-- Tujuan Penggunaan Informasi --}}
                <div class="space-y-1">
                    <label class="font-bold text-slate-800 block">Tujuan Penggunaan Informasi <span class="text-rose-500">*</span></label>
                    <textarea x-model="ppidForm.tujuan"
                              rows="2"
                              required
                              placeholder="Contoh: Penelitian skripsi/tesis akademik, pemenuhan persyaratan izin usaha, atau kajian kebijakan publik..."
                              class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 text-slate-900 leading-relaxed"></textarea>
                </div>

                {{-- Cara Memperoleh Informasi & Salinan --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label class="font-bold text-slate-800 block">Bentuk Salinan Informasi</label>
                        <select x-model="ppidForm.cara_memperoleh" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl font-medium text-slate-800">
                            <option value="softcopy">Salinan Elektronik / Softcopy (PDF)</option>
                            <option value="hardcopy">Salinan Cetak / Hardcopy Dokumen</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="font-bold text-slate-800 block">Metode Pengiriman Salinan</label>
                        <select x-model="ppidForm.cara_mendapatkan" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl font-medium text-slate-800">
                            <option value="elektronik">Kirim via Email & Unduh di Portal</option>
                            <option value="ambil_langsung">Mengambil Langsung di Meja PPID</option>
                        </select>
                    </div>
                </div>

                {{-- Unggah KTP / Identitas --}}
                <div class="space-y-1">
                    <label class="font-bold text-slate-800 block">Unggah Foto / Scan KTP (Identitas Resmi) <span class="text-slate-400 font-normal">(Opsional)</span></label>
                    <div class="p-3 border-2 border-dashed border-slate-200 rounded-xl bg-slate-50/50 text-center hover:bg-slate-50 transition-colors">
                        <input type="file"
                               @change="handleKtpUpload($event)"
                               accept="image/*,application/pdf"
                               class="hidden"
                               id="ktpFileInput">
                        <label for="ktpFileInput" class="cursor-pointer block">
                            <i data-lucide="upload-cloud" class="w-6 h-6 text-slate-400 mx-auto mb-1"></i>
                            <span class="text-xs text-blue-600 font-semibold hover:underline block">Klik untuk memilih file identitas</span>
                            <span class="text-[10px] text-slate-400 block mt-0.5">Format JPG, PNG, atau PDF (Maks. 2 MB)</span>
                        </label>
                        <template x-if="ppidForm.ktp_nama">
                            <div class="mt-2 text-[11px] font-bold text-emerald-700 bg-emerald-50 py-1 px-3 rounded-md inline-flex items-center gap-1.5">
                                <i data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                                <span x-text="ppidForm.ktp_nama"></span>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Persetujuan Pernyataan --}}
                <label class="flex items-start gap-2.5 pt-2 text-slate-600 cursor-pointer">
                    <input type="checkbox" required class="rounded border-slate-300 text-blue-600 focus:ring-0 mt-0.5">
                    <span class="text-[11px] leading-tight">Saya menyatakan bahwa data yang diisikan adalah benar dan saya bersedia mematuhi ketentuan perundang-undangan terkait pemanfaatan informasi publik.</span>
                </label>

                {{-- Footer Actions --}}
                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2.5">
                    <button type="button"
                            @click="showPpidModal = false"
                            class="px-4 py-2 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 font-bold transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-6 py-2 rounded-xl bg-[#0a2558] hover:bg-[#0d3070] text-white font-bold shadow-md transition-all flex items-center gap-2">
                        <i data-lucide="send" class="w-3.5 h-3.5 text-amber-400"></i>
                        <span>Kirim Permohonan Informasi</span>
                    </button>
                </div>
            </form>

        </div>
    </div>

    {{-- 2. MODAL: BUKTI TANDA TERIMA / SUKSES REGISTRASI PERMOHONAN PPID --}}
    <div x-show="showPpidSuccessModal"
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 overflow-y-auto"
         role="dialog"
         aria-modal="true">
        
        <div x-show="showPpidSuccessModal"
             x-transition:enter="ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             @click="showPpidSuccessModal = false"
             class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs"></div>

        <div x-show="showPpidSuccessModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="relative bg-white rounded-3xl shadow-2xl border border-slate-100 max-w-lg w-full p-6 sm:p-8 text-center z-10 space-y-5 my-8">

            <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto shadow-md">
                <i data-lucide="check-check" class="w-8 h-8"></i>
            </div>

            <div>
                <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200 font-bold text-[11px] uppercase tracking-wider">
                    Registrasi Berhasil
                </span>
                <h3 class="text-xl font-black text-slate-900 mt-2">
                    Permohonan Informasi Telah Diterima!
                </h3>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                    Permohonan Anda telah resmi tercatat dalam sistem PPID Diskominfo Kabupaten Tasikmalaya.
                </p>
            </div>

            {{-- Ticket Box --}}
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2 text-left">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Nomor Tiket Registrasi:</span>
                    <button type="button"
                            @click="copyToClipboard(generatedTicket)"
                            class="text-[11px] font-bold text-blue-600 hover:underline flex items-center gap-1">
                        <i data-lucide="copy" class="w-3 h-3"></i>
                        <span>Salin No. Tiket</span>
                    </button>
                </div>
                <div class="p-2.5 bg-white rounded-xl border border-slate-200 flex items-center justify-between font-mono font-black text-base text-[#0a2558]">
                    <span x-text="generatedTicket"></span>
                    <i data-lucide="ticket" class="w-5 h-5 text-[#0a2558]"></i>
                </div>
                <div class="grid grid-cols-2 gap-2 pt-2 text-[11px] text-slate-600">
                    <div>
                        <span class="text-slate-400 block">Pemohon:</span>
                        <span class="font-bold text-slate-800" x-text="ppidForm.nama"></span>
                    </div>
                    <div>
                        <span class="text-slate-400 block">Tanggal Registrasi:</span>
                        <span class="font-bold text-slate-800" x-text="ticketDate"></span>
                    </div>
                </div>
            </div>

            {{-- SLA Note --}}
            <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 text-left text-[11px] text-slate-700 space-y-1">
                <span class="font-bold text-slate-900 block">Waktu Penanganan:</span>
                <p>Petugas PPID akan melakukan verifikasi dan penyiapan berkas dalam waktu maksimal <strong>10 hari kerja</strong> sesuai SOP UU No. 14 Tahun 2008.</p>
            </div>

            {{-- Actions --}}
            <div class="space-y-2 pt-2">
                <button type="button"
                        @click="triggerSyntheticDownload('Tanda_Terima_' + generatedTicket + '.pdf'); triggerToast('Mengunduh Bukti Tanda Terima (PDF)...')"
                        class="w-full py-2.5 rounded-xl bg-[#0a2558] hover:bg-[#0d3070] text-white text-xs font-bold shadow-md transition-all flex items-center justify-center gap-2">
                    <i data-lucide="download" class="w-4 h-4 text-white"></i>
                    <span>Unduh Bukti Tanda Terima (PDF)</span>
                </button>
                <div class="flex items-center gap-2">
                    <button type="button"
                            @click="showPpidSuccessModal = false; openPpidTracking(generatedTicket)"
                            class="flex-1 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold transition-colors">
                        Lacak Status Tiket Ini
                    </button>
                    <button type="button"
                            @click="showPpidSuccessModal = false"
                            class="flex-1 py-2 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold transition-colors">
                        Tutup
                    </button>
                </div>
            </div>

        </div>
    </div>

    {{-- 3. MODAL: LACAK STATUS PERMOHONAN PPID --}}
    <div x-show="showTrackingModal"
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 overflow-y-auto"
         role="dialog"
         aria-modal="true">
        
        <div x-show="showTrackingModal"
             x-transition:enter="ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             @click="showTrackingModal = false"
             class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs"></div>

        <div x-show="showTrackingModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             class="relative bg-white rounded-3xl shadow-2xl border border-slate-100 max-w-xl w-full p-6 sm:p-8 z-10 space-y-5 my-8">

            {{-- Header --}}
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-slate-100 text-[#0a2558] flex items-center justify-center font-bold">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-slate-900 leading-tight">Lacak Permohonan Informasi PPID</h3>
                        <p class="text-[11px] text-slate-400">Pantau progres penyiapan informasi publik Anda secara berkala</p>
                    </div>
                </div>
                <button type="button" @click="showTrackingModal = false" class="text-slate-400 hover:text-slate-700 p-1.5 rounded-lg">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            {{-- Search Box --}}
            <div class="space-y-2">
                <label class="font-bold text-xs text-slate-700 block">Masukkan Nomor Tiket Registrasi:</label>
                <div class="flex items-center gap-2">
                    <input type="text"
                           x-model="trackingInput"
                           @keyup.enter="checkTracking()"
                           placeholder="Contoh: PPID-TSK-2025-0142..."
                           class="flex-1 px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-[#0a2558] text-slate-900 font-mono uppercase">
                    <button type="button"
                            @click="checkTracking()"
                            class="px-5 py-2.5 rounded-xl bg-[#0a2558] hover:bg-[#0d3070] text-white font-bold text-xs transition-colors flex items-center gap-1.5 cursor-pointer">
                        <i data-lucide="search" class="w-3.5 h-3.5"></i>
                        <span>Cek</span>
                    </button>
                </div>

                {{-- Demo Chips --}}
                <div class="pt-1 flex flex-wrap items-center gap-1.5 text-[11px]">
                    <span class="text-slate-400">Coba nomor demo:</span>
                    <template x-for="item in trackingRecords.slice(0, 3)" :key="item.code">
                        <button type="button"
                                @click="trackingInput = item.code; checkTracking(item.code)"
                                class="px-2 py-0.5 rounded-md bg-slate-100 hover:bg-slate-200 text-slate-700 font-mono text-[10px] font-semibold border border-slate-200 transition-colors"
                                x-text="item.code">
                        </button>
                    </template>
                </div>
            </div>

            {{-- Tracking Result Box --}}
            <template x-if="trackingResult && !trackingResult.notFound">
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/90 space-y-4 text-xs">
                    
                    {{-- Status Banner --}}
                    <div class="flex items-start justify-between gap-3 pb-3 border-b border-slate-200">
                        <div>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border" :class="trackingResult.statusBadge" x-text="trackingResult.statusText"></span>
                            <h4 class="font-bold text-slate-900 text-sm mt-1.5" x-text="trackingResult.title"></h4>
                            <p class="text-[11px] text-slate-500 mt-0.5">Pemohon: <strong class="text-slate-700" x-text="trackingResult.applicant"></strong> &bull; <span x-text="trackingResult.date"></span></p>
                        </div>
                    </div>

                    {{-- 4 Step Progress Bar --}}
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between text-[10px] font-bold text-slate-500">
                            <span>1. Diterima</span>
                            <span>2. Verifikasi</span>
                            <span>3. Penyiapan</span>
                            <span>4. Selesai</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-slate-200 overflow-hidden">
                            <div class="h-full bg-[#0a2558] transition-all duration-500"
                                 :style="`width: ${trackingResult.step * 25}%`"></div>
                        </div>
                    </div>

                    {{-- Officer Notes --}}
                    <div class="p-3 bg-white rounded-xl border border-slate-200 space-y-1">
                        <span class="text-[10px] uppercase font-bold text-slate-400 block">Catatan Petugas PPID:</span>
                        <p class="text-slate-700 leading-relaxed text-[11px]" x-text="trackingResult.notes"></p>
                    </div>

                    {{-- Download Output (if ready) --}}
                    <template x-if="trackingResult.hasDownload">
                        <div class="pt-2">
                            <button type="button"
                                    @click="triggerSyntheticDownload(trackingResult.downloadTitle); triggerToast('Mengunduh Salinan Dokumen Hasil Permohonan...')"
                                    class="w-full py-2.5 rounded-xl bg-[#0a2558] hover:bg-[#0d3070] text-white font-bold text-xs shadow-md transition-all flex items-center justify-center gap-2">
                                <i data-lucide="file-check" class="w-4 h-4"></i>
                                <span>Unduh Salinan Dokumen Resmi (PDF)</span>
                            </button>
                        </div>
                    </template>

                </div>
            </template>

            {{-- Not Found Result --}}
            <template x-if="trackingResult && trackingResult.notFound">
                <div class="p-5 rounded-2xl bg-rose-50 border border-rose-200 text-center text-xs space-y-1">
                    <i data-lucide="alert-circle" class="w-7 h-7 text-rose-500 mx-auto"></i>
                    <p class="font-bold text-rose-900">Nomor Registrasi Tidak Ditemukan</p>
                    <p class="text-rose-700 text-[11px]">Pastikan format nomor tiket sesuai (Contoh: PPID-TSK-2025-0142). Silakan periksa kembali tanda terima Anda.</p>
                </div>
            </template>

            <div class="pt-2 flex justify-end">
                <button type="button" @click="showTrackingModal = false" class="px-5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors">
                    Tutup
                </button>
            </div>

        </div>
    </div>

    {{-- 4. MODAL: RINGKASAN / DETAIL DOKUMEN INFORMASI PUBLIK --}}
    <div x-show="showDocPreviewModal"
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 overflow-y-auto"
         role="dialog"
         aria-modal="true">
        
        <div x-show="showDocPreviewModal"
             x-transition:enter="ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             @click="showDocPreviewModal = false"
             class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs"></div>

        <div x-show="showDocPreviewModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             class="relative bg-white rounded-3xl shadow-2xl border border-slate-100 max-w-xl w-full p-6 sm:p-8 z-10 space-y-5 my-8">

            <div class="flex items-start justify-between gap-3 pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded text-[10px] font-black uppercase tracking-wider"
                          :class="selectedDoc?.categoryBadge"
                          x-text="selectedDoc?.categoryLabel"></span>
                    <span class="text-xs font-mono text-slate-400 font-semibold" x-text="selectedDoc?.id"></span>
                </div>
                <button type="button" @click="showDocPreviewModal = false" class="text-slate-400 hover:text-slate-700 p-1.5 rounded-lg">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <div class="space-y-3">
                <h3 class="text-base font-bold text-slate-900 leading-snug" x-text="selectedDoc?.title"></h3>
                <p class="text-xs text-slate-600 leading-relaxed bg-slate-50 p-3.5 rounded-2xl border border-slate-200" x-text="selectedDoc?.summary"></p>
            </div>

            <div class="grid grid-cols-2 gap-3 text-xs bg-slate-50/80 p-4 rounded-2xl border border-slate-200/80">
                <div>
                    <span class="text-slate-400 block text-[10px] uppercase font-bold">Pejabat Penanggung Jawab:</span>
                    <span class="font-bold text-slate-800" x-text="selectedDoc?.pj"></span>
                </div>
                <div>
                    <span class="text-slate-400 block text-[10px] uppercase font-bold">Masa Retensi / Simpan:</span>
                    <span class="font-bold text-slate-800" x-text="selectedDoc?.masaSimpan"></span>
                </div>
                <div class="col-span-2 pt-2 border-t border-slate-200/60">
                    <span class="text-slate-400 block text-[10px] uppercase font-bold">Dasar Hukum Keterbukaan:</span>
                    <span class="text-slate-700 font-medium" x-text="selectedDoc?.dasarHukum"></span>
                </div>
            </div>

            <div class="flex items-center justify-between gap-3 pt-2">
                <span class="text-xs text-slate-400">
                    Format: <strong class="text-slate-700" x-text="selectedDoc?.type"></strong> &bull; <span x-text="selectedDoc?.size"></span>
                </span>
                <div class="flex items-center gap-2">
                    <button type="button" @click="showDocPreviewModal = false" class="px-4 py-2 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold transition-colors">
                        Tutup
                    </button>
                    <button type="button"
                            @click="downloadDoc(selectedDoc); showDocPreviewModal = false"
                            class="px-5 py-2 rounded-xl bg-[#0a2558] hover:bg-[#0d3070] text-white text-xs font-bold shadow-md transition-all flex items-center gap-1.5 cursor-pointer">
                        <i data-lucide="download" class="w-3.5 h-3.5"></i>
                        <span>Unduh Dokumen</span>
                    </button>
                </div>
            </div>

        </div>
    </div>

    {{-- 5. MODAL: LAYANAN ASPIRASI & PENGADUAN (SP4N-LAPOR!) --}}
    <div x-show="showPengaduanModal"
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 overflow-y-auto"
         role="dialog"
         aria-modal="true">
        
        <div x-show="showPengaduanModal"
             x-transition:enter="ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             @click="showPengaduanModal = false"
             class="fixed inset-0 bg-slate-950/70 backdrop-blur-xs"></div>

        <div x-show="showPengaduanModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             class="relative bg-white rounded-3xl shadow-2xl border border-slate-100 max-w-lg w-full p-6 sm:p-8 z-10 space-y-5 my-8">

            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-10 h-10 rounded-xl bg-slate-100 text-[#0a2558] flex items-center justify-center font-bold">
                        <i data-lucide="megaphone" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-black text-slate-900 leading-tight">Layanan Aspirasi & Pengaduan Warga</h3>
                        <p class="text-[11px] text-slate-400">Pemerintah Kabupaten Tasikmalaya & SP4N-LAPOR!</p>
                    </div>
                </div>
                <button type="button" @click="showPengaduanModal = false" class="text-slate-400 hover:text-slate-700 p-1.5 rounded-lg">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <p class="text-xs text-slate-600 leading-relaxed">
                Masyarakat dapat menyampaikan kritik, saran, pengaduan pelayanan kependudukan, serta aspirasi secara langsung melalui kanal resmi terpadu berikut:
            </p>

            <div class="space-y-3">
                {{-- SP4N LAPOR Card --}}
                <a href="https://www.lapor.go.id" target="_blank" rel="noopener noreferrer"
                   class="p-4 rounded-2xl border border-slate-200 bg-white hover:bg-slate-50 transition-all flex items-center justify-between gap-3 block group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-slate-800 text-white flex items-center justify-center font-bold text-xs shadow-xs">
                            SP4N
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-900 group-hover:text-[#0a2558] transition-colors">Kanal Nasional SP4N-LAPOR!</h4>
                            <p class="text-[11px] text-slate-500">Layanan Aspirasi dan Pengaduan Online Rakyat RI</p>
                        </div>
                    </div>
                    <i data-lucide="external-link" class="w-4 h-4 text-slate-400 group-hover:text-[#0a2558] transition-colors"></i>
                </a>

                {{-- WhatsApp Desk --}}
                <a href="https://wa.me/6281123456789?text=Halo%20Admin%20Diskominfo%20Kabupaten%20Tasikmalaya,%20saya%20ingin%20menyampaikan%20aspirasi/pengaduan" target="_blank" rel="noopener noreferrer"
                   class="p-4 rounded-2xl border border-slate-200 bg-white hover:bg-slate-50 transition-all flex items-center justify-between gap-3 block group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-xs shadow-xs">
                            WA
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-900 group-hover:text-[#0a2558] transition-colors">WhatsApp Pengaduan Diskominfo</h4>
                            <p class="text-[11px] text-slate-500">Kirim pesan langsung ke petugas pelayanan publik</p>
                        </div>
                    </div>
                    <i data-lucide="arrow-up-right" class="w-4 h-4 text-slate-400 group-hover:text-[#0a2558] transition-colors"></i>
                </a>

                {{-- Call Center 112 --}}
                <div class="p-4 rounded-2xl border border-slate-200 bg-white flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-[#0a2558] text-white flex items-center justify-center font-bold text-xs shadow-xs">
                            112
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-900">Layanan Darurat Kedaruratan 112</h4>
                            <p class="text-[11px] text-slate-500">Bebas pulsa untuk ambulans, damkar, dan bencana daerah</p>
                        </div>
                    </div>
                    <span class="text-xs font-semibold text-slate-700 bg-slate-100 px-2.5 py-1 rounded-lg border border-slate-200/80">24 Jam</span>
                </div>
            </div>

            <div class="pt-2 flex justify-end">
                <button type="button" @click="showPengaduanModal = false" class="px-5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors">
                    Tutup
                </button>
            </div>

        </div>
    </div>

    {{-- 6. FLOATING TOAST NOTIFICATION --}}
    <div x-show="toast.show"
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-3 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-3 scale-95"
         class="fixed bottom-5 right-5 z-50 max-w-sm w-full bg-slate-900 text-white px-4 py-3.5 rounded-2xl shadow-2xl border border-white/10 flex items-center gap-3">
        <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0"
             :class="toast.type === 'error' ? 'bg-rose-500/20 text-rose-400' : 'bg-emerald-500/20 text-emerald-400'">
            <template x-if="toast.type !== 'error'">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
            </template>
            <template x-if="toast.type === 'error'">
                <i data-lucide="alert-circle" class="w-5 h-5"></i>
            </template>
        </div>
        <div class="flex-1 text-xs font-medium leading-snug" x-text="toast.message"></div>
        <button type="button" @click="toast.show = false" class="text-slate-400 hover:text-white p-1">
            <i data-lucide="x" class="w-4 h-4"></i>
        </button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
</body>
</html>
