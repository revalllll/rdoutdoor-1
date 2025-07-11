@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <form method="POST" action="{{ route('checkout.store') }}">
        @csrf
        <!-- Customer Name & Alamat Penyewa -->
        <div class="bg-white rounded shadow p-4 mb-6">
            <div class="mb-3">
                <label for="customer_name" class="form-label">Customer Name</label>
                <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ old('customer_name', $user?->name ?? '-') }}" required>
            </div>
            <div class="mb-3">
                <label for="customer_address" class="form-label">Alamat Penyewa</label>
                <textarea class="form-control" id="customer_address" name="customer_address" rows="2" required>{{ old('customer_address', $user?->address ?? '') }}</textarea>
            </div>
            <div class="mb-3">
                <label for="customer_phone" class="form-label">Nomor HP</label>
                <input type="text" class="form-control" id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" required>
            </div>
        </div>

        <!-- Produk & Jumlah -->
        <div class="bg-white rounded shadow p-4 mb-6">
            <label class="form-label">Produk & Jumlah</label>
            <!-- Produk utama -->
            <div class="row g-2 align-items-center mb-2">
                <div class="col-md-4">
                    <input type="text" class="form-control" value="{{ $product->name }}" readonly>
                    <input type="hidden" name="products[0][id]" value="{{ $product->id }}">
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control" name="products[0][qty]" value="1" min="1" required>
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" name="products[0][start_date]" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" name="products[0][end_date]" value="{{ date('Y-m-d') }}" required>
                </div>
            </div>
            <!-- Produk tambahan (dinamis) -->
            <div id="produk-tambahan"></div>
            <button type="button" class="btn btn-success mt-2" onclick="tambahProduk()">+ Tambah Produk</button>
        </div>

        <!-- Total Harga -->
        <div class="bg-white rounded shadow p-4 mb-6">
            <label class="form-label">Total Harga</label>
            <input type="text" class="form-control" id="total_harga" name="total_harga" value="0" readonly>
        </div>

        <!-- Submit -->
        <button type="submit" class="btn btn-primary">Sewa Sekarang</button>
    </form>
</div>

<script>
// Data produk dan harga (hanya produk aktif)
const produkList = @json($produkList);
const produkHarga = {};
produkList.forEach(p => produkHarga[p.id] = p.price);

function formatRupiah(angka) {
    if (!angka) return 'Rp0';
    return 'Rp' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// Simpan dan load data form ke localStorage
const formKey = 'checkoutFormData';
function saveFormToStorage() {
    const data = {
        customer_name: document.getElementById('customer_name').value,
        customer_address: document.getElementById('customer_address').value,
        produk: [],
    };
    // Produk utama
    data.produk.push({
        id: document.querySelector('input[name="products[0][id]"]').value,
        qty: document.querySelector('input[name="products[0][qty]"]').value,
        start_date: document.querySelector('input[name="products[0][start_date]"]').value,
        end_date: document.querySelector('input[name="products[0][end_date]"]').value,
    });
    // Produk tambahan
    document.querySelectorAll('#produk-tambahan .row').forEach((row, idx) => {
        const id = row.querySelector('select').value;
        const qty = row.querySelector('input[type=number]').value;
        const start_date = row.querySelector('input[name$="[start_date]"]').value;
        const end_date = row.querySelector('input[name$="[end_date]"]').value;
        data.produk.push({id, qty, start_date, end_date});
    });
    localStorage.setItem(formKey, JSON.stringify(data));
}
function loadFormFromStorage() {
    const data = JSON.parse(localStorage.getItem(formKey));
    if (!data) return;
    document.getElementById('customer_name').value = data.customer_name;
    document.getElementById('customer_address').value = data.customer_address;
    // Produk utama
    document.querySelector('input[name="products[0][qty]"]').value = data.produk[0].qty;
    document.querySelector('input[name="products[0][start_date]"]').value = data.produk[0].start_date;
    document.querySelector('input[name="products[0][end_date]"]').value = data.produk[0].end_date;
    // Produk tambahan
    for (let i = 1; i < data.produk.length; i++) {
        tambahProduk(data.produk[i]);
    }
}

// Hitung total harga otomatis
function hitungTotal() {
    let total = 0;
    // Produk utama
    const qty0 = parseInt(document.querySelector('input[name="products[0][qty]"]').value) || 0;
    const id0 = document.querySelector('input[name="products[0][id]"]').value;
    const start0 = document.querySelector('input[name="products[0][start_date]"]').value;
    const end0 = document.querySelector('input[name="products[0][end_date]"]').value;
    total += hitungSubtotal(id0, qty0, start0, end0);
    // Produk tambahan
    document.querySelectorAll('#produk-tambahan .row').forEach(row => {
        const id = row.querySelector('select').value;
        const qty = parseInt(row.querySelector('input[type=number]').value) || 0;
        const start = row.querySelector('input[name$="[start_date]"]').value;
        const end = row.querySelector('input[name$="[end_date]"]').value;
        total += hitungSubtotal(id, qty, start, end);
    });
    document.getElementById('total_harga').value = formatRupiah(total);
}
function hitungSubtotal(id, qty, start, end) {
    if (!id || !produkHarga[id]) return 0;
    const price = produkHarga[id];
    const hari = hitungHari(start, end);
    return price * qty * hari;
}
function hitungHari(start, end) {
    if (!start || !end) return 1;
    const tgl1 = new Date(start);
    const tgl2 = new Date(end);
    const diff = Math.max(1, Math.ceil((tgl2-tgl1)/(1000*60*60*24))+1);
    return diff;
}

// Tambah produk tambahan (opsional: data untuk load dari storage)
let produkIdx = 1;
function tambahProduk(data = null) {
    let options = '<option value="">-- Pilih Produk --</option>';
    produkList.forEach(p => {
        options += `<option value="${p.id}">${p.name}</option>`;
    });
    const html = `
    <div class=\"row g-2 align-items-center mb-2 produk-row\">
        <div class=\"col-md-4\">
            <select class=\"form-control\" name=\"products[${produkIdx}][id]\" required>${options}</select>
        </div>
        <div class=\"col-md-2\">
            <input type=\"number\" class=\"form-control\" name=\"products[${produkIdx}][qty]\" value=\"1\" min=\"1\" required>
        </div>
        <div class=\"col-md-3\">
            <input type=\"date\" class=\"form-control\" name=\"products[${produkIdx}][start_date]\" value=\"{{ date('Y-m-d') }}\" required>
        </div>
        <div class=\"col-md-3 d-flex align-items-center\">
            <input type=\"date\" class=\"form-control\" name=\"products[${produkIdx}][end_date]\" value=\"{{ date('Y-m-d') }}\" required>
            <button type=\"button\" class=\"btn btn-danger btn-sm ms-2 btn-hapus-produk\" onclick=\"hapusProduk(this)\"><i class=\"bi bi-x\"></i></button>
        </div>
    </div>`;
    document.getElementById('produk-tambahan').insertAdjacentHTML('beforeend', html);
    // Set value jika ada data (load from storage)
    if (data) {
        const row = document.querySelectorAll('#produk-tambahan .row')[produkIdx-1];
        row.querySelector('select').value = data.id;
        row.querySelector('input[type=number]').value = data.qty;
        row.querySelector('input[name$="[start_date]"]').value = data.start_date;
        row.querySelector('input[name$="[end_date]"]').value = data.end_date;
    }
    produkIdx++;
    attachEvents();
}
function hapusProduk(btn) {
    btn.closest('.produk-row').remove();
    saveFormToStorage();
    hitungTotal();
}

// Attach event ke semua input untuk auto-save dan auto-calc
function attachEvents() {
    document.querySelectorAll('input, select, textarea').forEach(el => {
        el.onchange = () => { saveFormToStorage(); hitungTotal(); };
        el.oninput = () => { saveFormToStorage(); hitungTotal(); };
    });
}
window.onload = function() {
    loadFormFromStorage();
    attachEvents();
    hitungTotal();
};
</script>
@endsection
