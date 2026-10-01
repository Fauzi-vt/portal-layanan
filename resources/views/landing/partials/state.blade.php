<script>
    function landingApp() {
        return {
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
                  statusText: 'Selesai â€” Dokumen Siap Diunduh',
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
        };
    }

    document.addEventListener('alpine:init', () => {
        if (typeof Alpine !== 'undefined' && Alpine.data) {
            Alpine.data('landingApp', landingApp);
        }
    });
</script>
