<script type="text/javascript">
	// handle row append for stok table
	let btnAppend = $("#tambah-kolom-stok");
	let parent = $("#table-stok");
	let index = 0;

	btnAppend.click(function() {
		index++;

		let elToAppend;
		elToAppend += "<tr id=\""+index+"\">";
		elToAppend += "<td>";
		elToAppend += "<select name=\"idbarang[]\" required>";
		elToAppend += "</td>";
		elToAppend += "<td>";
		elToAppend += "<input type=\"number\" name=\"masuk[]\" class=\"form-control\" required>";
		elToAppend += "</td>";
		elToAppend += "<td style=\"text-align:center;font-weight:bold;color:red;cursor:pointer\" id=\"hapus-baris\" data-id=\""+index+"\">x</td>";		
		elToAppend += "</tr>";

		parent.find($("tbody")).append(elToAppend);

		// handle select2 plugin
		$(document).find($("select[name='idbarang[]']")).select2({
			placeholder : "Cari ID / nama",
			width : "100%",
			language : {
				noResults : function() {return "Barang tidak ditemuakn"}
			},
			ajax : {
				delay : 300,
				url : "<?php echo base_url('admin/load/touch/barang') ?>",
				type : "POST",
				dataType : "JSON",
				data : function(params) {
					return {
						q : params.term,
						page : params.page,
						tipe : "select2"
					}
				},
				processResults : function(data, params) {
					params.page = params.page || 1;

					return {
						results : data.items,
						pagination : {
							more : (params.page * 30) < data.total_count
						}
					}
				}
			}
		});

		// show button tambah
		parent.find($("tfoot")).attr("hidden", false);

	})
	
	// handle delete rows
	$(document).on("click", "#hapus-baris", function() {
		let id = $(this).attr("data-id");
		parent.find($("tbody tr#"+id)).remove();
	
		// if body is empty
		if(parent.find($("tbody tr")).length < 1)
			parent.find($("tfoot")).attr("hidden", true);
		else
			parent.find($("tfoot")).attr("hidden", false);
	})

	// submit stok
	parent.submit(function(e) {
		e.preventDefault();

		let data = $(this).serialize();
		let elLoading = parent.find($("tfoot td[colspan='2']"));

		$.ajax({
			url : "<?php echo base_url('admin/insert/touch/stok') ?>",
			data : data,
			type : "POST",
			beforeSend : function() {
				elLoading.text("Loading...");
			},
			success : function(data) {
				elLoading.text("");

				parent.find($("tbody tr")).remove();
				parent.find($("tfoot")).attr("hidden", true);
			}
		})
	})
</script>