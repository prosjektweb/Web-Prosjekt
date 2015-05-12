<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<h1 class="page-header">Overview</h1>

	<div class="col-sm-5">
		<h4 class="sub-header">Administration Panel</h4>
		This is the administration page.<br /> There is room for lot's of
		improvement here, but for now this will have to do.<br />
		<br /> <b>Enjoy the awesome pie chart!</b>
	</div>
	<div class="col-sm-5">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Site view statistics</h3>
			</div>
			<div class="panel-body">
				<div id="placeholder" style="width: 550px; height: 300px"></div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		var data = []
		var i = 0;
			{foreach $data as $elem}
			data[i++] = { label : '{$elem.label}', data : {$elem.value} }
			{/foreach}
		var placeholder = $("#placeholder");
		
		{literal}
		function labelFormatter(label, series) {
			return "<div style='font-size:8pt; text-align:center; padding:2px; color:white;'>" + label + "<br/>" + Math.round(series.percent) + "%</div>";
		}
		
		$.plot(placeholder, data, {
		    series: {
		        pie: {
		            show: true,
		            radius: 1,
		            tilt: 0.7,
		            label: {
		                show: true,
		                radius: 1,
		                formatter: labelFormatter,
		                background: {
		                    opacity: 0.8
		                }
		            },
		            combine: {
		                color: '#999',
		                threshold: 0.1
		            }
		        }
		    },
		    legend: {
		        show: true
		    }
		});
		{/literal}

	</script>

</div>