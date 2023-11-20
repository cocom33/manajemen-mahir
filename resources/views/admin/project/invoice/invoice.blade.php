<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <title>Invoice</title>
</head>
<body>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <table style="width:100%">
            <tr>
              <td colspan="3">
                <img src="{{ asset('dist/images/mahir-logo.png') }}" alt="" style="width: 80px">
              </td>
              <td>
                <h5>Mahir Technogy Indonesia</h5>
                <div> Alamat : Jl. Raya Krapyak, RT.05, Karanganyar Ds, sambirejo, Wedomartani, Kec. Ngemplak, Kabupaten Sleman, Daerah Istimewa Yogyakarta</div>
                <div>Telp/Whatsapp : 0857-2524-9265</div>
              </td>
            </tr>
            <tr>
              <td colspan="4">
                <div>
                  <h4>INVOICE</h4>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="3">
                <div>
                  <div class="text-gray font-weight-bold">Tagihan Kepada</div>
                  <div class="text-gray">nomore infois</div>
                  <div class="text-gray">Alamat : disini</div>
                  <div class="text-gray">Email : disini</div>
                  <div class="text-gray">Telepon : disini</div>
                </div>
              </td>
              <td>
                <div class=" font-weight-bold">Tangal Pembelian</div>
                <div>2 jun 2022</div>
                <div class=" font-weight-bold">No Transaksi</div>
                <div>no transaksi</div>
                <div class=" font-weight-bold">Status Pembayaran</div>
                <div>
                    sukses
                </div>
              </td>
            </tr>
          </table>

          <table class="table table-bordered my-4">
            <tr>
              <td class="bg-success text-white">Produk</td>
              <td class="bg-success text-white">qty</td>
              <td class="bg-success text-white">harga</td>
              <td class="bg-success text-white">Jumlah</td>
            </tr>
            <tr>
              <td>
                <div>judul df</div>
                <div><small>katerogri</small></div>
              </td>
              <td>1</td>
              <td>Rp. 1000000</td>
              <td>Rp. 1000000</td>
            </tr>
            <tr>
              <td colspan="3"><b>Subtotal</b></td>
              <td><b>Rp 1000000</b></td>
            </tr>
            <tr>
              <td colspan="3"><b>Total</b></td>
              <td><b>Rp 200000</b></td>
            </tr>
          </table>

          <div class="my4">
            <small><i>invoice ini di unduh pada : {{ date('Y/m/d H:i:s') }}</i></small>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
