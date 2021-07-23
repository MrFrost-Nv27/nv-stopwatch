// Convert time to a format of hours, minutes, seconds, and milliseconds
$(document).ready(function () {
	if (isStorageExist()) {
		loadDataFromStorage();
	}

	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: "btn btn-success",
			cancelButton: "btn btn-danger",
		},
		buttonsStyling: false,
	});

	$.ajax({
		url: BaseURL + "stopwatch/datatimer",
		success: function (data) {
			console.log("Happy!");
		},
	});

	$("#time_record").on("click", "#tombolhapus", function () {
		var idrecord = $(this).data("idrow");
		Swal.fire({
			title: "Hapus Data",
			text: "Anda ingin menghapus data ini ? Harap tinjau kembali sebelum menghapus data",
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: "Hapus",
			confirmButtonColor: "#d33",
			cancelButtonColor: "#3085d6",
			cancelButtonText: "Tidak",
		}).then((result) => {
			if (result.value) {
				$.ajax({
					url: BaseURL + "stopwatch/recdel",
					method: "post",
					beforeSend: function () {
						swal.fire({
							title: "Menunggu",
							html: "Memproses data",
							didOpen: () => {
								swal.showLoading();
							},
						});
					},
					data: {
						idrecord: idrecord,
					},
					success: function (data) {
						swal.fire("Hapus", "Berhasil Terhapus", "success");
						datatimer.ajax.reload(null, false);
						refresh();
					},
				});
			} else if (result.dismiss === swal.DismissReason.cancel) {
				swal.fire("Batal", "Anda membatalkan penghapusan", "error");
			}
		});
	});

	$("#tombolhidektglist").click(function (e) {
		refresh();
	});

	$("#archived").on("click", "#tombolunhide", function () {
		var id = $(this).data("id");
		Swal.fire({
			title: "Perlihatkan Kategori",
			text: "Anda ingin memperlihatkan kategori ini ? Harap tinjau kembali sebelum memperlihatkan kategori",
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: "Perlihatkan",
			confirmButtonColor: "#d33",
			cancelButtonColor: "#3085d6",
			cancelButtonText: "Batal",
		}).then((result) => {
			if (result.value) {
				$.ajax({
					url: BaseURL + "stopwatch/ktgunhide",
					method: "post",
					beforeSend: function () {
						swal.fire({
							title: "Menunggu",
							html: "Memproses data",
							didOpen: () => {
								swal.showLoading();
							},
						});
					},
					data: {
						id: id,
					},
					success: function (data) {
						swal.fire("Perlihatkan", "Berhasil Diperlihatkan", "success");
						datatimer.ajax.reload(null, false);
						refresh();
						$(this).hide();
					},
				});
			} else if (result.dismiss === swal.DismissReason.cancel) {
				swal.fire("Batal", "Anda membatalkan memperlihatkan kategori", "error");
			}
		});
	});

	$("#add-namaktg").keyup(function () {
		var nama = $(this).val();
		if (nama == "") {
			$(this).removeClass("is-invalid");
			$(this).removeClass("is-valid");
		} else {
			$.ajax({
				url: BaseURL + "stopwatch/cekktg",
				method: "post",
				data: {
					nama: nama,
				},
				success: function (data) {
					if (data == "Y") {
						$("#add-namaktg").addClass("is-valid");
						$("#add-namaktg").removeClass("is-invalid");
						$("#tomboladd").prop("disabled", false);
					} else {
						$("#add-namaktg").addClass("is-invalid");
						$("#add-namaktg").removeClass("is-valid");
						$("#tomboladd").prop("disabled", true);
					}
				},
			});
		}
	});

	$("#formaddktg").submit(function (event) {
		event.preventDefault();
		var nama = $("#add-namaktg").val();
		var ikon = $("#add-iconktg").val();
		Swal.fire({
			title: "Tambah Kategori",
			text: "Anda ingin menambahkan kategori ini ? Harap tinjau kembali sebelum menambahkan kategori",
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: "Tambah",
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			cancelButtonText: "Batal",
		}).then((result) => {
			if (result.value) {
				$.ajax({
					url: BaseURL + "stopwatch/ktgins",
					method: "post",
					beforeSend: function () {
						swal.fire({
							title: "Menunggu",
							html: "Memproses data",
							didOpen: () => {
								swal.showLoading();
							},
						});
					},
					data: {
						nama: nama,
						ikon: ikon,
					},
					success: function (data) {
						swal.fire(
							"Tambah Kategori",
							"Kategori Berhasil Ditambahkan",
							"success"
						);
						refresh();
						$("#formadd").modal("toggle");
					},
				});
			} else if (result.dismiss === swal.DismissReason.cancel) {
				swal.fire("Batal", "Anda batal menambahkan kategori", "error");
			}
		});
	});
});

document.addEventListener("ondatasaved", () => {
	console.log("Data berhasil disimpan.");
});
document.addEventListener("ondataloaded", () => {
	refreshDataFromWaktu();
});
