<script type="text/javascript">
	let tableBarang = $("#table-barang").DataTable({
		serverside : true,
		processing : true,
		language : {
			zeroRecords : 'Data barang tidak ditemukan',
			emptyTable : 'Data barang saat ini kosong',
		},
		ajax : {
			url : "<?php echo base_url('admin/load/touch/barang') ?>"
		}
	})

	tableBarang.on("click", "a", function() {
		let _this = $(this);
		let id = $(this).attr("id");
		let action = $(this).attr('data-action');

		let hapus = () => {
			let confirm = window.confirm("Hapus barang ini ?");
			if(confirm) {
				$.ajax({
					url : "<?php echo base_url('admin/delete/touch/barang') ?>",
					data : {idbarang : id},
					type : "POST",
					beforeSend : function() {
						_this.closest("tr").remove();
					},
					success : function(data) {
						data = JSON.parse(data);
						console.log(data);
					}
				})	
			}
		}

		let edit = () => {
			let parent = $("#edit-barang");
			let form = parent.find($("form"));
			let elLoading = parent.find($(".loading-container"));

			parent.find($(".modal-header .modal-title")).text("Silahkan edit barang dibawah ini");
			parent.find($("[type='submit']")).attr("class", "btn btn-sm btn-warning");
			parent.find($("[type='submit']")).text("Edit");

			$.ajax({
				url : "<?php echo base_url('admin/load/touch/part_barang') ?>",
				data : {idbarang : id},
				type : "POST",
				beforeSend : function() {
					elLoading.text("Loading....");
					parent.modal("show");
				},
				success : function(data) {
					elLoading.text("");

					form.append("<input type='hidden' name='idbarang'>");

					// isi tiap field barang
					$.each(JSON.parse(data), function(i,v){
						form.find($("[name='idbarang']")).val(v.idbarang);
						form.find($("[name='nama']")).val(v.nama);
						form.find($("[name='harga']")).val(accounting.formatMoney(v.harga, "Rp ", "."));
						form.find($("[name='diskon']")).val(v.diskon);
						form.find($("[name='pajak']")).val(v.pajak);
						form.find($("[name='stok']")).val(v.stok);
					})

					// on submit
					form.submit(function(e) {
						e.preventDefault();

						$.ajax({
							url : "<?php echo base_url('admin/edit/touch/barang') ?>",
							data : form.serialize(),
							type : "POST",
							beforeSend : function() {
								elLoading.text("Loading...");
							},
							success : function(data) {
								elLoading.text("");
								parent.modal("hide");

								tableBarang.ajax.reload();

								console.log(data);
							}
						})

					})
				}
			})

			parent.modal("show");
		}

		switch(action) {
			case "hapus" :
				hapus();
				break;
			case "edit" :
				edit();
				break;
		}
	})
</script>