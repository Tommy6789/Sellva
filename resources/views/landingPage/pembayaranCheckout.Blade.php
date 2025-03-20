<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2>Pembayaran</h2>
        <form action="#" method="POST">
            <div class="mb-3">
                <label for="metode_pembayaran">Metode Pembayaran</label>
                <select name="metode_pembayaran" class="form-control" required>
                    <option value="">Pilih Metode Pembayaran ↓</option>
                    <option value="tunai">Tunai</option>
                    <option value="debit">Debit</option>
                    <option value="kredit">Kredit</option>
                    <option value="qris">QRIS</option>
                </select>
            </div>
            <div class="mb-3">
                <b>Total: Rp <span id="totalAmount">100000</span></b>
            </div>
            <div class="mb-3">
                <label for="nominal_pembayaran">Nominal Pembayaran</label>
                <input type="text" class="form-control nominal_pembayaran" name="nominal_pembayaran" data-total="100000" placeholder="Masukkan nominal pembayaran (contoh: 10000)" required>
            </div>
            <div class="mb-3">
                <label for="kembalian">Kembalian</label>
                <input type="text" class="form-control kembalian" readonly>
            </div>
            <button type="submit" class="btn btn-primary">Bayar Sekarang</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $(document).on('input', '.nominal_pembayaran', function() {
                let total = parseFloat($(this).data('total'));
                let pembayaran = parseFloat($(this).val().replace(/\./g, '')) || 0;
                let kembalian = Math.max(pembayaran - total, 0);

                $(this).val(pembayaran.toLocaleString('id-ID'));
                $('.kembalian').val(kembalian.toLocaleString('id-ID'));
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
