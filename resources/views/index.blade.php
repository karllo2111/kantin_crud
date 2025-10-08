<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Etalase Kantin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">

        @if(session('status'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card mb-5">
            <div class="card-header bg-success text-white">Tambah Produk Baru</div>
            <div class="card-body">
                <form method="POST" action="{{ route('kantinProduk.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-2">
                            <input name="name" type="text" class="form-control" placeholder="Nama produk" required>
                        </div>
                        <div class="col-md-2">
                            <input name="price" type="number" class="form-control" placeholder="Harga" required>
                        </div>
                        <div class="col-md-2">
                            <input name="stock" type="number" class="form-control" placeholder="Stok" required>
                        </div>
                        <div class="col-md-2">
                            <select name="category" class="form-select" required>
                                <option value="">Kategori</option>
                                <option value="makanan">Makanan</option>
                                <option value="minuman">Minuman</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary w-100">Tambah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @php
            $kategori = [
                'Makanan 🍛' => $makanan,
                'Minuman 🥤' => $minuman,
            ];
          @endphp

        @foreach ($kategori as $judul => $items)
            <h3 class="mb-3">{{ $judul }}</h3>
            <div class="row row-cols-1 row-cols-md-4 g-4 mb-5">
                @forelse ($items as $item)
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://via.placeholder.com/300x200?text=' . $item->category }}"
                                class="card-img-top" style="height:200px;object-fit:cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->name }}</h5>
                                <p class="text-muted mb-1">Harga: Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                                <p class="mb-2">Stok: {{ $item->stock }}</p>

                                <div class="d-flex gap-1">
                                    <form method="POST" action="{{ route('kantinProduk.beli', $item->id) }}">
                                        @csrf
                                        <button class="btn btn-success btn-sm" {{ $item->stock <= 0 ? 'disabled' : '' }}>Beli</button>
                                    </form>

                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#edit{{ $item->id }}">Edit</button>

                                    <form method="POST" action="{{ route('kantinProduk.destroy', $item->id) }}">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Edit --}}
                    <div class="modal fade" id="edit{{ $item->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form method="POST" action="{{ route('kantinProduk.update', $item->id) }}"
                                enctype="multipart/form-data" class="modal-content">
                                @csrf @method('PUT')
                                <div class="modal-header">
                                    <h5>Edit Produk</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <input name="name" type="text" value="{{ $item->name }}" class="form-control mb-2" required>
                                    <input name="price" type="number" value="{{ $item->price }}" class="form-control mb-2"
                                        required>
                                    <input name="stock" type="number" value="{{ $item->stock }}" class="form-control mb-2"
                                        required>
                                    <select name="category" class="form-select mb-2">
                                        <option value="makanan" {{ $item->category == 'makanan' ? 'selected' : '' }}>Makanan
                                        </option>
                                        <option value="minuman" {{ $item->category == 'minuman' ? 'selected' : '' }}>Minuman
                                        </option>
                                    </select>
                                    <label>Ubah Gambar (opsional)</label>
                                    <input type="file" name="image" class="form-control mb-2" accept="image/*">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">Belum ada produk di kategori ini.</p>
                @endforelse
            </div>
        @endforeach

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>