<script type="text/javascript">
	// call data barang with ajax first
	$.ajax({
		url : "<?php echo base_url('admin/load/touch/grafik-barang') ?>",
		type : "GET",
		success : function(data) {
			data = JSON.parse(data);
			// chart for grafik produk
			let el = document.getElementById("chart-barang").getContext("2d");

			let chartBarang = new Chart(el, {
				type : "line",
				data : {
					labels : ["JAN", "FEB", "MAR", "APR", "MEI", "JUN", "JUL", "AGS", "SEP", "OKT", "NOV", "DES"],
					datasets : [{
						label : "Produk masuk",
						data : data.masuk,
						borderColor: 'rgba(0, 188, 212, 0.75)',
			            backgroundColor: 'rgba(0, 188, 212, 0.3)',
			            pointBorderColor: 'rgba(0, 188, 212, 0)',
			            pointBackgroundColor: 'rgba(0, 188, 212, 0.9)',
			            pointBorderWidth: 1
					}, {
						label: "Produk terjual",
		                data: data.terjual,
		                borderColor: 'rgba(233, 30, 99, 0.75)',
		                backgroundColor: 'rgba(233, 30, 99, 0.3)',
		                pointBorderColor: 'rgba(233, 30, 99, 0)',
		                pointBackgroundColor: 'rgba(233, 30, 99, 0.9)',
		                pointBorderWidth: 1
					}]
				},
				options : {
					responsive : true,
					legend : false
				}
			})
		}
	})
</script>