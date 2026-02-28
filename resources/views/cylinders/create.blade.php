@extends('layouts.main')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <a href="{{ route('cylinders.index') }}" class="text-slate-500 hover:text-indigo-600 text-sm flex items-center gap-1 mb-2 transition-colors font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Kembali ke Data Tabung
            </a>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Tambah Tabung Baru</h1>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8">
        <form action="{{ route('cylinders.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nomor Seri Tabung</label>
                <input type="text" name="serial_number" required placeholder="Contoh: TB-001" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
            </div>

            <div class="relative" x-data="typeSelect()">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tipe Gas</label>
                <input type="hidden" name="type" x-model="selectedType" required>
                <div class="relative">
                    <input type="text" x-model="search" @focus="open = true" @click.outside="open = false" placeholder="Ketik atau pilih Tipe Gas..." class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 font-medium focus:bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all cursor-pointer placeholder-slate-400" autocomplete="off" readonly>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                        <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>

                <div x-show="open" x-transition.opacity.duration.200ms class="absolute z-30 w-full mt-2 bg-white border border-slate-100 rounded-xl shadow-xl max-h-60 overflow-y-auto" style="display: none;">
                    <ul>
                        <template x-for="item in options" :key="item">
                            <li @click="selectItem(item)" class="px-4 py-3 hover:bg-indigo-50 cursor-pointer border-b border-slate-50 last:border-0 transition-colors">
                                <div class="font-bold text-slate-700 hover:text-indigo-700" x-text="item"></div>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>

            <div class="relative" x-data="statusSelect('available')">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status Awal</label>
                <input type="hidden" name="status" x-model="selectedValue" required>
                <div class="relative">
                    <input type="text" x-model="search" @focus="open = true" @click.outside="open = false" placeholder="Pilih Status..." class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 font-medium focus:bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all cursor-pointer placeholder-slate-400" autocomplete="off" readonly>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                        <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>

                <div x-show="open" x-transition.opacity.duration.200ms class="absolute z-20 w-full mt-2 bg-white border border-slate-100 rounded-xl shadow-xl max-h-60 overflow-y-auto" style="display: none;">
                    <ul>
                        <template x-for="item in options" :key="item.value">
                            <li @click="selectItem(item)" class="px-4 py-3 hover:bg-indigo-50 cursor-pointer border-b border-slate-50 last:border-0 transition-colors flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full" :class="item.value === 'available' ? 'bg-emerald-500' : 'bg-red-500'"></span>
                                <div class="font-bold text-slate-700 hover:text-indigo-700" x-text="item.label"></div>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl transition-all shadow-md">
                    Simpan Tabung
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('typeSelect', (initialType = '') => ({
            options: ['O2', 'CO2', 'N2', 'AR', 'C2H2'],
            search: initialType,
            selectedType: initialType,
            open: false,
            selectItem(item) {
                this.selectedType = item;
                this.search = item;
                this.open = false;
            }
        }));

        Alpine.data('statusSelect', (initialValue = '') => ({
            options: [
                { value: 'available', label: 'Tersedia (Ready)' },
                { value: 'maintenance', label: 'Perbaikan (Maintenance)' }
            ],
            search: '',
            selectedValue: initialValue,
            open: false,
            init() {
                if (this.selectedValue) {
                    const selected = this.options.find(opt => opt.value === this.selectedValue);
                    if (selected) this.search = selected.label;
                }
            },
            selectItem(item) {
                this.selectedValue = item.value;
                this.search = item.label;
                this.open = false;
            }
        }));
    })
</script>
@endsection
