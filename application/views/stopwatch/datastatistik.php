<?php foreach ($kategori->result_array() as $ktgcard) { ?>
<div class="col-md-6 col-lg-3 mt-3">
    <div class="card text-dark">
        <div class="card-header border-warning"><?=$ktgcard['nama']; ?>
            <?php if ($ktgcard['id'] != 1): ?>
            <a class="hidektg" href="javascript:void(0)" data-idktg="<?=$ktgcard['id']; ?>">
                <div class="float-right">
                    <i class="fa fa-eye-slash"></i>
                </div>
            </a>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-3">
                    <i class="fa fa-<?=$ktgcard['icon']; ?> fa-5x"></i>
                </div>
                <div class="col-9 text-right">
                    <?php
$ambildatadetik = $this->Stopwatch_model->sumWhere($ktgcard['nama'])['period'];
    $statistik      = $this->Period_model->jumlahPeriod($ambildatadetik, true); ?>
                    <div class="huge"><?=$statistik['time']; ?></div>
                    <div><?=$statistik['prop']; ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<div class="col-md-6 col-lg-3 mt-3">
    <div class="card text-dark">
        <a id="newktg" href="javascript:void(0)" role="button" data-toggle="modal" data-target="#formadd">
            <div class="card-header border-success">+ Add
                <div class="float-right">
                    <i class="fa fa-arrow-circle-right"></i>
                </div>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-3">
                        <i class="fa fa-plus fa-5x"></i>
                    </div>
                    <div class="col-9 text-right">
                        <div class="huge">New</div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>
<script>
function datastatistik() {
    $.ajax({
        url: BaseURL + "stopwatch/datastatistik",
        success: function(data) {
            $("#infografis").html(data);
        },
    });
}

function listktg() {
    $.ajax({
        url: BaseURL + "stopwatch/listktg",
        success: function(data) {
            $("#list-kategori").html(data);
        },
    });
}

$(".hidektg").click(function(e) {
    var id = $(this).data("idktg");
    Swal.fire({
        title: "Sembunyikan Kategori",
        text: "Anda ingin menyembunyikan kategori ini ? Harap tinjau kembali sebelum menyembunyikan kategori",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sembunyikan",
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: BaseURL + "stopwatch/ktghide",
                method: "post",
                data: {
                    id: id
                },
                success: function(data) {
                    listktg();
                    datastatistik();
                    swal.fire("Sembunyikan Kategori", "Kategori Berhasil Disembunyikan",
                        "success");
                },
            });
        } else if (result.dismiss === swal.DismissReason.cancel) {
            swal.fire("Batal", "Anda membatalkan penyembunyian kategori", "error");
        }
    });
});
</script>
