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
