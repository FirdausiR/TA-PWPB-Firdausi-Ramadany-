<div class="modal fade" id="tambah-barang">
	<div class="modal-dialog">
		<div class="modal-content">
			<form>
				<div class="modal-header"><div class="modal-title">Masukkan barang yang akan di tambahkan</div></div>

				<div class="modal-body">
					<label>Nama produk</label>
					<input type="text" name="nama" class="form-control" required="" autofocus="">

					<label>Harga</label>
					<input type="text" name="harga" class="form-control" required="" id="numberFormat">
					
					<label>Diskon (%)</label>
					<input type="number" min="1" name="diskon" class="form-control">

					<label>Pajak (%)</label>
					<input type="number" min="1" name="pajak" class="form-control">

					<label>Stok</label>
					<input type="number" min="1" name="stok" class="form-control" required="">					
				</div>
				<div class="modal-body">
					<div class="float-left loading-container"></div>
					<div class="float-right">
						<button class="btn btn-primary btn-sm" type="submit">Tambah</button>
						<button class="btn btn-sm" type="button" data-dismiss="modal">Batal</button>	
					</div>
					<div class="clearfix"></div>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="edit-barang">
	<div class="modal-dialog">
		<div class="modal-content">
			<form>
				<div class="modal-header"><div class="modal-title">Masukkan barang yang akan di tambahkan</div></div>

				<div class="modal-body">
					<label>Nama produk</label>
					<input type="text" name="nama" class="form-control" required="" autofocus="">

					<label>Harga</label>
					<input type="text" name="harga" class="form-control" required="" id="numberFormat">
					
					<label>Diskon (%)</label>
					<input type="number" name="diskon" class="form-control">

					<label>Pajak (%)</label>
					<input type="number" name="pajak" class="form-control">

					<label>Stok</label>
					<input type="number" name="stok" class="form-control" required="">					
				</div>
				<div class="modal-body">
					<div class="float-left loading-container"></div>
					<div class="float-right">
						<button class="btn btn-primary btn-sm" type="submit">Tambah</button>
						<button class="btn btn-sm" type="button" data-dismiss="modal">Batal</button>	
					</div>
					<div class="clearfix"></div>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
	// tambah barang
	$("#tambah-barang").find($("form")).submit(function(e) {
		e.preventDefault();

		let form = $(this);
		let parent = $("#tambah-barang");
		let elLoading = parent.find($("loading-container"));

		$.ajax({
			url : "<?php echo base_url('admin/insert/touch/barang') ?>",
			data : form.serialize(),
			type : "POST",
			beforeSend : function() {
				elLoading.text("Loading....")
			},
			success : function(data) {
				data = JSON.parse(data);

				if(typeof tableBarang == "object") tableBarang.ajax.reload();

				form.find(":input").val("");
				parent.modal("hide");
			}
		})
	})
</script>