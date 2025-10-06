<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kantin Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>

    <div class="container mt-5">
        {{-- Pesan sukses --}}
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        {{-- FORM TAMBAH PRODUK --}}
        <div class="card">
            <div class="card-header">
                <h3>Tambah Produk Kantin</h3>
            </div>
            <form action="{{ route('kantinProduk.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name">Nama Produk</label>
                        <input type="text" class="form-control" name="name" placeholder="Nama Produk">
                    </div>
                    <div class="mb-3">
                        <label for="price">Harga</label>
                        <input type="number" class="form-control" name="price" placeholder="Harga Produk">
                    </div>
                    <div class="mb-3">
                        <label for="stock">Stok</label>
                        <input type="number" class="form-control" name="stock" placeholder="Jumlah Stok">
                    </div>
                    <div class="mb-3">
                        <label for="category">Kategori</label>
                        <select name="category" class="form-select" required>
                            <option disabled selected>Pilih Kategori</option>
                            <option value="makanan">Makanan</option>
                            <option value="minuman">Minuman</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-success">Tambah Produk</button>
                </div>
            </form>
        </div>

        {{-- DAFTAR PRODUK --}}
        <div class="card mt-5">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3>Daftar Produk Kantin</h3>
                <h5 class="mb-0">
                    @if ($category == 'makanan')
                        Total Produk Makanan: {{ $totalProducts }}
                    @elseif ($category == 'minuman')
                        Total Produk Minuman: {{ $totalProducts }}
                    @else
                        Total Semua Produk: {{ $totalProducts }}
                    @endif
                </h5>
            </div>

            <div class="card-body">
                <div class="d-flex justify-content-start mb-3 gap-2">
                    <a href="{{ route('index') }}"
                        class="btn btn-outline-secondary {{ request('category') == null ? 'active' : '' }}">
                        Semua
                    </a>
                    <a href="{{ route('index', ['category' => 'makanan']) }}"
                        class="btn btn-outline-primary {{ request('category') == 'makanan' ? 'active' : '' }}">
                        Makanan
                    </a>
                    <a href="{{ route('index', ['category' => 'minuman']) }}"
                        class="btn btn-outline-success {{ request('category') == 'minuman' ? 'active' : '' }}">
                        Minuman
                    </a>
                </div>

                {{-- List Produk --}}
                @foreach ($kantinProduk as $product)
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>{{ $product->name }}</h4>
                            <span class="badge bg-info text-dark">{{ ucfirst($product->category) }}</span>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h6>Harga: Rp{{ number_format($product->price, 0, ',', '.') }}</h6>
                                    <h6>Stok: {{ $product->stock }}</h6>
                                </div>
                                <div class="col d-flex justify-content-end gap-2">
                                    {{-- Tombol Edit --}}
                                    <button class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#edit{{ $product->id }}">Edit</button>

                                    {{-- Tombol Hapus --}}
                                    <button class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#delete{{ $product->id }}">Hapus</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Edit --}}
                    <div class="modal fade" id="edit{{ $product->id }}" tabindex="-1"
                        aria-labelledby="editLabel{{ $product->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('kantinProduk.update', $product->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editLabel{{ $product->id }}">Edit Produk</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label>Nama</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ $product->name }}">
                                        </div>
                                        <div class="mb-3">
                                            <label>Harga</label>
                                            <input type="number" class="form-control" name="price"
                                                value="{{ $product->price }}">
                                        </div>
                                        <div class="mb-3">
                                            <label>Stok</label>
                                            <input type="number" class="form-control" name="stock"
                                                value="{{ $product->stock }}">
                                        </div>
                                        <div class="mb-3">
                                            <label>Kategori</label>
                                            <select name="category" class="form-select">
                                                <option value="makanan"
                                                    {{ $product->category == 'makanan' ? 'selected' : '' }}>Makanan
                                                </option>
                                                <option value="minuman"
                                                    {{ $product->category == 'minuman' ? 'selected' : '' }}>Minuman
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Delete --}}
                    <div class="modal fade" id="delete{{ $product->id }}" tabindex="-1"
                        aria-labelledby="deleteLabel{{ $product->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('kantinProduk.destroy', $product->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteLabel{{ $product->id }}">Hapus Produk</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Yakin ingin menghapus produk <strong>{{ $product->name }}</strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</body>

</html>
