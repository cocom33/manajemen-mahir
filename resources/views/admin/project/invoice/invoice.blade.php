<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <link rel="stylesheet" href="./invoice/style.css" type="text/css">
</head>
<body>
    <h1><center>INVOICE</center></h1>
    <table class="w-full">
        <tr>
            <td class="w-half">
                <img src="./invoice/mahir.png" alt="laravel daily" width="200" />
                <p style="color: rgb(69, 69, 69); font-style: bold"><i>PT. Mahir Technology Indonesia</i></p>
            </td>
            <td class="w-30">
                Tanggal <span style="margin-left: 27px">{{ Carbon\Carbon::parse($invoice->created_at)->format('Y-m-d') }}</span><br>
                No. Invoice <span style="margin-left: 5px">{{ $invoice->no_invoice }}</span><br>
                Kepada <span style="margin-left: 30px">{{ $project->client->name }}</span>
            </td>
        </tr>
    </table>

    <div class="margin-top">
        <table class="w-full">
            <tr>
                <td class="w-half">
                    <div style="width: 50%">Jl. Raya Krapyak, RT.05, Karanganyar,
                        Wedomartani Ngemplak, Kabupaten Sleman, DI Yogyakarta 55584</div>
                    <div>085725249265</div>
                    <div style="color:rgb(24, 178, 178); text-decoration: underline;">office@mahirtechnology.com</div>
                    <div>No NPWP: 961220316542000</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="margin-top">
        <span>Project or Service Description</span>
        <table class="products">
            <tr>
                <th>Description</th>
                <th>Price Item</th>
                <th>Qty</th>
                <th>Total</th>
            </tr>
            <tr class="items">
                <td style="width: 45%">
                    Pelunasan {{ $project->name }}
                </td>
                <td style="text-align: center; width: 20%">
                    {{ 'Rp ' .number_format($project->harga_deal, 2, ',', '.') }}
                </td>
                <td style="text-align: right; width: 10%">
                    @if ($selisihHari < 7)
                        {{ $selisihHari }} Hari
                    @elseif ($selisihMinggu < 4)
                        {{ $selisihMinggu }} Minggu
                    @else
                        {{ $selisihBulan }} Bulan
                    @endif
                </td>
                <td style="text-align: right; width: 20%">
                    {{ 'Rp ' .number_format($project->harga_deal, 2, ',', '.') }}
                </td>
            </tr>
        </table>
    </div>



    <div class="margin-top">
        <table class="products">
            <tr class="items">
                <td style="width: 45%; border:none"></td>
                <td style="width: 20%; border:none"></td>
                <td style="text-align: right; width: 10%; border:none">
                    JUMLAH
                </td>
                <td style="text-align: right; width: 20%; border:none">
                    {{ 'Rp ' .number_format($project->harga_deal, 2, ',', '.') }}
                </td>
            </tr>
            <tr class="items">
                <td style="width: 45%; border:none">
                    <b>Terbilang:</b>
                </td>
                <td style="text-align: center; width: 20%; border:none">

                </td>
                <td style="text-align: right; width: 10%; border:none">
                    Pajak
                </td>
                <td style="text-align: right; width: 20%; border: solid 0.001rem rgb(112, 112, 112)">
                    0
                </td>
            </tr>
            <tr class="items">
                <td style="width: 45%; border:none">
                    <b><i> {{ $terbilang }} rupiah </i></b>
                </td>
                <td style="text-align: center; width: 20%; border:none">

                </td>
                <td style="text-align: right; width: 10%; border:none">
                </td>
                <td style="text-align: right; width: 20%; border: solid 0.001rem rgb(112, 112, 112); background: rgb(231, 231, 231)">
                    Rp0.00
                </td>
            </tr>
            <tr class="items">
                <td style="width: 45%; border:none">

                </td>
                <td style="text-align: center; width: 20%; border:none">

                </td>
                <td style="text-align: right; width: 10%; border:none">
                    TOTAL
                </td>
                <td style="text-align: right; width: 20%; border: solid 0.001rem rgb(112, 112, 112); background: rgb(231, 231, 231)">
                    <b>{{ 'Rp ' .number_format($project->harga_deal, 2, ',', '.') }}</b>
                </td>
            </tr>
        </table>
    </div>

    <table class="w-full">
        <tr>
            <td class="w-half">
                <span><b><i>Silahkan transfer ke:</i></b></span><br>
                <span>Bank mandiri<br> <b>1370016335214</b><br> An. Irhamullah</span>
            </td>
            <td class="w-30" style="position: relative;">
                <img src="./invoice/assign-ustadz.png" alt="laravel daily" width="250"  style="position: absolute; right: 30px; top: 30px" />
                <p style="text-align: center; padding-top: 70px">Irhamullah, S.Kom<br>
                    (Direktur)</p>
            </td>
        </tr>
    </table>
</body>
</html>
