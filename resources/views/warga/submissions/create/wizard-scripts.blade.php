<script>
    function submissionWizardData() {
        return {
            activeStep: 1,
            totalSteps: {{ $totalSteps }},
            isKkBaru: {{ $isKkBaru ? 'true' : 'false' }},
            hasFormSection: {{ $hasFormSection ? 'true' : 'false' }},
            submitting: false,
            filePreviews: {},

            goNext() {
                if (this.activeStep < this.totalSteps) {
                    this.activeStep++;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            },
            goPrev() {
                if (this.activeStep > 1) {
                    this.activeStep--;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            },
            goToStep(step) {
                if (step >= 1 && step <= this.totalSteps) {
                    this.activeStep = step;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            },
            submitForm(draftVal) {
                if (this.submitting) return;
                this.submitting = true;
                this.$refs.submitNowInput.value = draftVal;
                this.$refs.mainForm.submit();
            },
            handleFileChange(reqId, event) {
                const file = event.target.files[0];
                if (file) {
                    this.filePreviews[reqId] = {
                        name: file.name,
                        size: (file.size / 1024 / 1024).toFixed(2) + ' MB'
                    };
                } else {
                    delete this.filePreviews[reqId];
                }
            },
            stepLabel(step) {
                if (this.isKkBaru) {
                    const labels = { 1: 'Data Pemohon', 2: 'Kepala Keluarga', 3: 'Anggota Keluarga', 4: 'Dokumen', 5: 'Review' };
                    return labels[step] || '';
                }
                if (!this.hasFormSection) {
                    const labels = { 1: 'Wilayah & Pemohon', 2: 'Berkas Dokumen', 3: 'Tinjau & Ajukan' };
                    return labels[step] || '';
                }
                const labels = { 1: 'Wilayah & Pemohon', 2: 'Formulir Digital', 3: 'Berkas Dokumen', 4: 'Tinjau & Ajukan' };
                return labels[step] || '';
            },
            get lastStep() { return this.totalSteps; }
        };
    }

    // Update kecamatan display on review page when selector changes
    document.addEventListener('DOMContentLoaded', function() {
        const sel = document.getElementById('kecamatan_id');
        const display = document.getElementById('review-kecamatan-display');
        if (sel && display) {
            sel.addEventListener('change', function() {
                const opt = sel.options[sel.selectedIndex];
                if (display) display.textContent = opt ? opt.text : '—';
            });
        }
    });
</script>
