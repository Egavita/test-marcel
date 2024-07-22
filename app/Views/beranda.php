<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>

<main>
    <div class="container-fluid px-4 mt-4" style="background-color: #FFF5F9;">
        <div class="row">
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <i class="fas fa-chart-area me-1"></i>
                        Grafik Transaksi Penjualan
                        <div class="col-sm-2 mt-3 mb-4">
                            <input type="number" id="tahun-trans" class="form-control" value="<?= date('Y') ?>"
                                onchange="chartTransaksi()" style="width: 80px">
                        </div>
                        <canvas id="chartTransaksi" width="100%" height="40"></canvas>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-outline-primary btn-sm" onclick="downloadChartTransaksi('PDF')"
                            style="margin-bottom: 20px;">UNDUH PDF</button>
                        <a id="download-trans" download="chart-transaksi.png">
                            <button class="btn btn-outline-primary btn-sm" onclick="downloadChartTransaksi('PNG')"
                                style="margin-bottom: 20px; margin-right: 20px;">UNDUH PNG</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <i class="fas fa-chart-area me-1"></i>
                        Grafik Transaksi Pembelian
                        <div class="col-sm-2 mt-3 mb-4">
                            <input type="number" id="tahun-beli" class="form-control" value="<?= date('Y') ?>"
                                onchange="chartBeli()">
                        </div>
                        <canvas id="chartBeli" width="100%" height="40"></canvas>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-outline-primary btn-sm" onclick="downloadChartBeli('PDF')"
                            style="margin-bottom: 20px;">UNDUH PDF</button>
                        <a id="download-beli" download="chart-beli.png">
                            <button class="btn btn-outline-primary btn-sm" onclick="downloadChartBeli('PNG')"
                                style="margin-bottom: 20px; margin-right: 20px;">UNDUH PNG</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <i class="fas fa-chart-bar me-1"></i>
                        Grafik Pelanggan
                        <div class="col-sm-2 mt-3 mb-4">
                            <input type="number" id="tahun-cust" class="form-control" value="<?= date('Y') ?>"
                                onchange="chartCustomer()" style="width: 80px">
                        </div>
                        <canvas id="chartCust" width="100%" height="50"></canvas>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-outline-primary btn-sm" onclick="downloadChartCustomer('PDF')"
                            style="margin-bottom: 20px; margin-top: -20px;">UNDUH PDF</button>
                        <a id="download-cust" download="chart-customer.png">
                            <button class="btn btn-outline-primary btn-sm" onclick="downloadChartCustomer('PNG')"
                                style="margin-bottom: 20px; margin-right: 20px; margin-top: -20px;">UNDUH PNG</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <i class="fas fa-chart-bar me-1"></i>
                        Grafik Tambah Produk
                        <div class="col-sm-2 mt-3 mb-4">
                            <input type="number" id="tahun-produk" class="form-control" value="<?= date('Y') ?>"
                                onchange="chartProduk()" style="width: 80px">
                        </div>
                        <canvas id="chartProduk" width="100%" height="50"></canvas>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-outline-primary btn-sm" onclick="downloadChartProduk('PDF')"
                            style="margin-bottom: 20px; margin-top: -20px;">UNDUH PDF</button>
                        <a id="download-produk" download="chart-produk.png">
                            <button class="btn btn-outline-primary btn-sm" onclick="downloadChartProduk('PNG')"
                                style="margin-bottom: 20px; margin-right: 20px; margin-top: -20px;">UNDUH PNG</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    $(document).ready(function () {
        chartTransaksi()
        chartBeli()
        chartCustomer()
        chartProduk()
    });

    // ======================== JUAL ======================= //
    function setChartTransaksi(dataset) {
        // Area Chart Example
        var ctx = document.getElementById("chartTransaksi");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"],
                datasets: [{
                    label: "Jumlah",
                    lineTension: 0.3,
                    backgroundColor: "rgba(255,0,111,0.2)",
                    borderColor: "rgba(255,0,111,1)",
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(184,0,80,1)",
                    pointBorderColor: "rgba(255,255,255,0.8)",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(255,0,111,1)",
                    pointHitRadius: 50,
                    pointBorderWidth: 2,
                    data: dataset,
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'month'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 6
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            display: true
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });
    }

    function chartTransaksi() {
        var tahun = $('#tahun-trans').val();
        $.ajax({
            url: "<?= base_url('/chart-transaksi') ?>",
            method: "POST",
            data: {
                'tahun': tahun,
            },
            success: function (response) {
                var result = JSON.parse(response)

                dataset = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                $.each(result.data, function (i, val) {
                    dataset[val.month - 1] = val.total
                });
                setChartTransaksi(dataset)
            }
        });
    }

    // ======================== BELI =======================  //

    function setChartBeli(dataset) {
        var ctx = document.getElementById("chartBeli");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"],
                datasets: [{
                    label: "Jumlah",
                    lineTension: 0.3,
                    backgroundColor: "rgba(255,0,111,0.2)",
                    borderColor: "rgba(255,0,111,1)",
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(184,0,80,1)",
                    pointBorderColor: "rgba(255,255,255,0.8)",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(255,0,111,1)",
                    pointHitRadius: 50,
                    pointBorderWidth: 2,
                    data: dataset,
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'month'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 6
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            display: true
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });
    }

    function chartBeli() {
        var tahun = $('#tahun-beli').val();
        $.ajax({
            url: "<?= base_url('/chart-pembelian') ?>",
            method: "POST",
            data: {
                'tahun': tahun,
            },
            success: function (response) {
                var result = JSON.parse(response)

                dataset = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                $.each(result.data, function (i, val) {
                    dataset[val.month - 1] = val.total
                });
                setChartBeli(dataset)
            }
        });
    }

    // ======================== CUSTOMER =======================  //

    function setBarChart(dataset) {
        // Bar Chart Example
        var ctx = document.getElementById("chartCust");
        var myLineChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"],
                datasets: [{
                    label: "Jumlah",
                    backgroundColor: "rgb(224,0,97)",
                    borderColor: "rgb(224,0,97)",
                    data: dataset,
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'month'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 6
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            display: true
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });
    }

    function chartCustomer() {
        var tahun = $('#tahun-cust').val();
        $.ajax({
            url: "<?= base_url('/chart-pelanggan') ?>",
            method: "POST",
            data: {
                'tahun': tahun,
            },
            success: function (response) {
                var result = JSON.parse(response)
                let dataset = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                $.each(result.data, function (i, val) {
                    dataset[val.month - 1] = val.total
                });
                setBarChart(dataset)
            }
        });
    }

    // Produk //
    function setProdukChart(dataset) {
        // Area Chart Example
        var ctx = document.getElementById("chartProduk");
        var myLineChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"],
                datasets: [{
                    label: "Jumlah",
                    backgroundColor: "rgb(224,0,97)",
                    borderColor: "rgb(224,0,97)",
                    data: dataset,
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'month'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 6
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            display: true
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });
    }

    function chartProduk() {
        var tahun = $('#tahun-produk').val();
        $.ajax({
            url: "<?= base_url('/chart-produk') ?>",
            method: "POST",
            data: {
                'tahun': tahun,
            },
            success: function (response) {
                var result = JSON.parse(response)

                dataset = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
                $.each(result.data, function (i, val) {
                    dataset[val.month - 1] = val.total
                });
                setProdukChart(dataset)
            }
        });
    }

    function downloadChartImg(download, chart) {
        var img = chart.toDataURL("image/jpg", 1.0).replace("image/jpg", "image/octet-stream")
        download.setAttribute("href", img)
    }

    function downloadChartPDF(chart, name) {
        html2canvas(chart, {
            onrendered: function (canvas) {
                var img = canvas.toDataURL("image/jpg", 1.0)
                var doc = new jsPDF('p', 'pt', 'A4')
                var lebarKonten = canvas.width
                var tinggiKonten = canvas.height
                var tinggiPage = lebarKonten / 592.28 * 841.89
                var leftHeight = tinggiKonten
                var position = 0
                var imgWidth = 595.28
                var imgHeight = 595.28 / lebarKonten * tinggiKonten
                if (leftHeight < tinggiPage) {
                    doc.addImage(img, 'PNG', 0, 0, imgWidth, imgHeight)

                } else {
                    while (leftHeight > 0) {
                        doc.addIamge(img, 'PNG', 0, position, imgWidth, imgHeight)

                        leftHeight -= tinggiPage
                        position -= 841.89
                        if (leftHeight > 0) {
                            pdf.addPage()
                        }
                    }

                }

                doc.save(name)

            }
        });
    }

    function downloadChartTransaksi(type) {
        var download = document.getElementById('download-trans')
        var chart = document.getElementById('chartTransaksi')

        if (type == "PNG") {
            downloadChartImg(download, chart)
        } else {
            downloadChartPDF(chart, "Chart-Transaksi.pdf")
        }
    }

    function downloadChartCustomer(type) {
        var download = document.getElementById('download-cust')
        var chart = document.getElementById('chartCust')

        if (type == "PNG") {
            downloadChartImg(download, chart)
        } else {
            downloadChartPDF(chart, "Chart-Customer.pdf")
        }
    }

    function downloadChartProduk(type) {
        var download = document.getElementById('download-produk')
        var chart = document.getElementById('chartProduk')

        if (type == "PNG") {
            downloadChartImg(download, chart)
        } else {
            downloadChartPDF(chart, "Chart-Produk.pdf")
        }
    }

    function downloadChartBeli(type) {
        var download = document.getElementById('download-beli')
        var chart = document.getElementById('chartBeli')

        if (type == "PNG") {
            downloadChartImg(download, chart)
        } else {
            downloadChartPDF(chart, "Chart-Pembelian.pdf")
        }
    }
</script>
<?= $this->endSection() ?>