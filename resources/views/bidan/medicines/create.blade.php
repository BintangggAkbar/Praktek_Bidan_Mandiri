@extends('layouts.app')

@section('header', 'Tambah Obat Baru')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
            <form action="{{ route('medicines.store') }}" method="POST">
                @csrf
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-6">
                            <label for="nama_obat" class="block text-sm font-medium text-slate-700">Nama Obat</label>
                            <div class="mt-1">
                                <input type="text" name="nama_obat" id="nama_obat" required
                                    class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border"
                                    placeholder="Contoh: Paracetamol">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="kategori_obat" class="block text-sm font-medium text-slate-700">Kategori</label>
                            <div class="mt-1">
                                <select id="kategori_obat" name="kategori_obat"
                                    class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                                    <option value="analgesik">Analgesik</option>
                                    <option value="antibiotik">Antibiotik</option>
                                    <option value="vitamin">Vitamin</option>
                                    <option value="suplemen">Suplemen</option>
                                    <option value="obat luar">Obat Luar</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="bentuk_sediaan" class="block text-sm font-medium text-slate-700">Bentuk
                                Sediaan</label>
                            <div class="mt-1">
                                <select id="bentuk_sediaan" name="bentuk_sediaan"
                                    class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                                    <option value="tablet">Tablet</option>
                                    <option value="kapsul">Kapsul</option>
                                    <option value="sirup">Sirup</option>
                                    <option value="salep">Salep</option>
                                    <option value="injeksi">Injeksi</option>
                                </select>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="stok" class="block text-sm font-medium text-slate-700">Stok</label>
                            <div class="mt-1">
                                <input type="number" name="stok" id="stok" required
                                    class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="satuan" class="block text-sm font-medium text-slate-700">Satuan</label>
                            <div class="mt-1">
                                <input type="text" name="satuan" id="satuan" required
                                    class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border"
                                    placeholder="Tablet/Botol/Pcs">
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="dosis" class="block text-sm font-medium text-slate-700">Dosis</label>
                            <div class="mt-1">
                                <input type="text" name="dosis" id="dosis"
                                    class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 text-right sm:px-6 flex justify-end gap-3">
                    <a href="{{ url()->previous() }}"
                        class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-slate-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection