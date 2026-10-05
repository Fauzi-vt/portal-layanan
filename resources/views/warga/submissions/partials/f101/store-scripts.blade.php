
<script>
    (function() {
        const configKkBaru = {
            userName: @js($user->name),
            userNik: @js($user->nik ?? ''),
            userPhone: @js($user->phone ?? ''),
            userEmail: @js($user->email ?? ''),
            userAlamat: @js($user->alamat_detail ?? ''),
            kecamatanName: @js($userKecName),
            desaName: @js($defaultDesa),
            kecamatanMap: @js($kecamatanMap),
            existingData: @js($existingF101)
        };

        function registerKkBaruStore() {
            if (!window.Alpine) return;
            if (Alpine.store('kkBaru')) return;

            Alpine.store('kkBaru', {
                kecamatanMap: configKkBaru.kecamatanMap || {},
                availableDesas: [],
                showMemberModal: false,
                editingIndex: null,
                validationError: '',

                meta: {
                    nama_pemohon: configKkBaru.userName || '',
                    nik_pemohon: configKkBaru.userNik || '',
                    telepon: configKkBaru.userPhone || '',
                    email: configKkBaru.userEmail || '',
                    nama_kepala_keluarga: configKkBaru.existingData?.nama_kepala_keluarga || configKkBaru.userName || '',
                    alamat: configKkBaru.existingData?.alamat || configKkBaru.userAlamat || '',
                    rt: configKkBaru.existingData?.rt || '001',
                    rw: configKkBaru.existingData?.rw || '001',
                    kode_pos: configKkBaru.existingData?.kode_pos || '46182',
                    kecamatan: configKkBaru.existingData?.nama_kecamatan || configKkBaru.kecamatanName || 'SINGAPARNA',
                    desa: configKkBaru.existingData?.nama_desa || configKkBaru.desaName || '',
                    kabupaten: configKkBaru.existingData?.nama_kabupaten || 'KABUPATEN TASIKMALAYA',
                    provinsi: configKkBaru.existingData?.nama_provinsi || 'JAWA BARAT',
                    negara: configKkBaru.existingData?.negara || 'INDONESIA',
                },

                formMember: {
                    nama: '',
                    nik: '',
                    jenis_kelamin: 'LAKI-LAKI',
                    tempat_lahir: 'TASIKMALAYA',
                    tanggal_lahir: '',
                    agama: 'ISLAM',
                    pendidikan: 'SLTA / SEDERAJAT',
                    pekerjaan: 'KARYAWAN SWASTA',
                    gol_darah: '-',
                    status_kawin: 'BELUM KAWIN',
                    tgl_kawin: '',
                    shdk: 'KEPALA KELUARGA',
                    kewarganegaraan: 'WNI',
                    no_paspor: '',
                    no_kitap: '',
                    nama_ayah: '',
                    nama_ibu: '',
                },

                anggota: configKkBaru.existingData?.anggota ? configKkBaru.existingData.anggota : [
                    {
                        nama: configKkBaru.userName || '',
                        nik: configKkBaru.userNik || '',
                        jenis_kelamin: 'LAKI-LAKI',
                        tempat_lahir: 'TASIKMALAYA',
                        tanggal_lahir: '1995-01-01',
                        agama: 'ISLAM',
                        pendidikan: 'SLTA / SEDERAJAT',
                        pekerjaan: 'KARYAWAN SWASTA',
                        gol_darah: 'O',
                        status_kawin: 'KAWIN TERCATAT',
                        tgl_kawin: '',
                        shdk: 'KEPALA KELUARGA',
                        kewarganegaraan: 'WNI',
                        no_paspor: '',
                        no_kitap: '',
                        nama_ayah: '',
                        nama_ibu: '',
                    }
                ],

                init() {
                    this.onKecamatanInput(false);
                },

                onKecamatanInput(resetDesa = true) {
                    const kec = (this.meta.kecamatan || '').toUpperCase().trim();
                    if (kec.length > 0) {
                        if (!this.meta.kabupaten || this.meta.kabupaten === 'TASIKMALAYA') {
                            this.meta.kabupaten = 'KABUPATEN TASIKMALAYA';
                        }
                        if (!this.meta.provinsi) {
                            this.meta.provinsi = 'JAWA BARAT';
                        }
                        if (!this.meta.negara) {
                            this.meta.negara = 'INDONESIA';
                        }
                    }
                    if (this.kecamatanMap[kec]) {
                        this.availableDesas = this.kecamatanMap[kec];
                        if (resetDesa && this.availableDesas.length > 0 && !this.meta.desa) {
                            this.meta.desa = this.availableDesas[0];
                        }
                    } else {
                        this.availableDesas = [];
                    }
                },

                openAddMember() {
                    this.editingIndex = null;
                    this.validationError = '';
                    this.formMember = {
                        nama: '',
                        nik: '',
                        jenis_kelamin: this.anggota.length === 0 ? 'LAKI-LAKI' : 'PEREMPUAN',
                        tempat_lahir: 'TASIKMALAYA',
                        tanggal_lahir: '',
                        agama: 'ISLAM',
                        pendidikan: 'SLTA / SEDERAJAT',
                        pekerjaan: this.anggota.length === 1 ? 'MENGURUS RUMAH TANGGA' : 'KARYAWAN SWASTA',
                        gol_darah: '-',
                        status_kawin: this.anggota.length === 1 ? 'KAWIN TERCATAT' : 'BELUM KAWIN',
                        tgl_kawin: '',
                        shdk: this.anggota.length === 0 ? 'KEPALA KELUARGA' : (this.anggota.length === 1 ? 'ISTRI' : 'ANAK'),
                        kewarganegaraan: 'WNI',
                        no_paspor: '',
                        no_kitap: '',
                        nama_ayah: '',
                        nama_ibu: '',
                    };
                    this.showMemberModal = true;
                    this.$nextTick(() => window.lucide?.createIcons());
                },

                editMember(index) {
                    this.editingIndex = index;
                    this.validationError = '';
                    this.formMember = JSON.parse(JSON.stringify(this.anggota[index]));
                    this.showMemberModal = true;
                    this.$nextTick(() => window.lucide?.createIcons());
                },

                saveMember() {
                    this.validationError = '';
                    const m = this.formMember;
                    if (!m.nama || !m.nama.trim()) {
                        this.validationError = 'Nama Lengkap wajib diisi.';
                        return;
                    }
                    if (!m.nik || m.nik.replace(/\D/g, '').length !== 16) {
                        this.validationError = 'NIK wajib 16 digit angka.';
                        return;
                    }
                    if (!m.tempat_lahir || !m.tempat_lahir.trim()) {
                        this.validationError = 'Tempat Lahir wajib diisi.';
                        return;
                    }
                    if (!m.tanggal_lahir) {
                        this.validationError = 'Tanggal Lahir wajib diisi.';
                        return;
                    }
                    if (!m.pekerjaan || !m.pekerjaan.trim()) {
                        this.validationError = 'Jenis Pekerjaan wajib diisi.';
                        return;
                    }
                    if (!m.nama_ayah || !m.nama_ayah.trim()) {
                        this.validationError = 'Nama Ayah Kandung wajib diisi.';
                        return;
                    }
                    if (!m.nama_ibu || !m.nama_ibu.trim()) {
                        this.validationError = 'Nama Ibu Kandung wajib diisi.';
                        return;
                    }

                    // Clean & uppercase
                    m.nama = m.nama.toUpperCase().trim();
                    m.nik = m.nik.replace(/\D/g, '').slice(0, 16);
                    m.tempat_lahir = m.tempat_lahir.toUpperCase().trim();
                    m.pekerjaan = m.pekerjaan.toUpperCase().trim();
                    m.nama_ayah = m.nama_ayah.toUpperCase().trim();
                    m.nama_ibu = m.nama_ibu.toUpperCase().trim();

                    if (this.editingIndex !== null) {
                        this.anggota[this.editingIndex] = { ...m };
                    } else {
                        this.anggota.push({ ...m });
                    }

                    this.showMemberModal = false;
                    this.editingIndex = null;
                    this.validationError = '';
                    this.$nextTick(() => window.lucide?.createIcons());
                },

                removeMember(index) {
                    if (this.anggota.length <= 1) {
                        alert('Kartu Keluarga harus memiliki minimal 1 orang anggota keluarga (Kepala Keluarga).');
                        return;
                    }
                    const memberName = this.anggota[index]?.nama || 'anggota ini';
                    if (confirm(`Apakah Anda yakin ingin menghapus ${memberName} dari daftar anggota keluarga?`)) {
                        this.anggota.splice(index, 1);
                        if (this.editingIndex === index) {
                            this.showMemberModal = false;
                            this.editingIndex = null;
                        }
                        this.$nextTick(() => window.lucide?.createIcons());
                    }
                },

                calculateAge(dateStr) {
                    if (!dateStr) return '';
                    const birth = new Date(dateStr);
                    if (isNaN(birth.getTime())) return '';
                    const diff = Date.now() - birth.getTime();
                    const age = new Date(diff).getUTCFullYear() - 1970;
                    return age >= 0 ? `${age} tahun` : '';
                },

                maskNik(nik) {
                    if (!nik) return '—';
                    const str = String(nik).trim();
                    if (str.length !== 16) return str;
                    return str.substring(0, 6) + '••••••••' + str.substring(14);
                },

                getShdkBadgeClass(shdk) {
                    switch(shdk) {
                        case 'KEPALA KELUARGA':
                            return 'bg-blue-600 text-white';
                        case 'ISTRI':
                        case 'SUAMI':
                            return 'bg-purple-600 text-white';
                        case 'ANAK':
                            return 'bg-emerald-600 text-white';
                        default:
                            return 'bg-amber-600 text-white';
                    }
                }
            });
        }

        document.addEventListener('alpine:init', registerKkBaruStore);
        if (window.Alpine) {
            registerKkBaruStore();
        }
    })();
