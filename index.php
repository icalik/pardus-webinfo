<?php

	define(LANGUAGE, "turkish");

//Get Temperature
	$temp = shell_exec('cat /sys/class/thermal/thermal_zone*/temp');
	$temp = round($temp / 1000, 1);

//Get CPU frequency
	$clock = shell_exec('cat /sys/devices/system/cpu/cpu0/cpufreq/scaling_cur_freq');
	$clock = round($clock / 1000);

//Get CPU Usage
	$cpuusage = 100 - shell_exec("vmstat | tail -1 | awk '{print $15}'");

//Get Uptime Data
	$uptimedata = shell_exec('uptime');
	$uptime = explode(' up ', $uptimedata);
	$uptime = explode(',', $uptime[1]);
	$uptime = $uptime[0].', '.$uptime[1];

//Get the memory info
$meminfo = file("/proc/meminfo");
for ($i = 0; $i < count($meminfo); $i++) {
		list($item, $data) = split(":", $meminfo[$i], 2);
		$item = chop($item);
		$data = chop($data);
		if ($item == "MemTotal") { $total_mem =$data;	}
		if ($item == "MemFree") { $free_mem = $data; }
		if ($item == "SwapTotal") { $total_swap = $data; }
		if ($item == "SwapFree") { $free_swap = $data; }
		if ($item == "Buffers") { $buffer_mem = $data; }
		if ($item == "Cached") { $cache_mem = $data; }
		if ($item == "MemShared") {$shared_mem = $data; }
}
$used_mem = ( $total_mem - $free_mem . ' kB'); 
$used_swap = ( $total_swap - $free_swap . ' kB' );
$percent_free = round( $free_mem / $total_mem * 100 );
$percent_used = round( $used_mem / $total_mem * 100 );
$percent_swap = round( ( $total_swap - $free_swap ) / $total_swap * 100 );
$percent_swap_free = round( $free_swap / $total_swap * 100 );
$percent_buff = round( $buffer_mem / $total_mem * 100 );
$percent_cach = round( $cache_mem / $total_mem * 100 );
$percent_shar = round( $shared_mem / $total_mem * 100 );

	include 'localization/'.LANGUAGE.'.lang.php';
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Pardus ARM Topluluk - Web Bilgi Ekranı</title>
		<link rel="stylesheet" href="stylesheets/main.css">
		<script src="javascript/raphael.2.1.0.min.js"></script>
	    <script src="javascript/justgage.1.0.1.min.js"></script>

	    <script>
			window.onload = doLoad;

			function doLoad()
			{
			setTimeout( "refresh()", 30*40 ); //Timeout Burada!!
			}

			function refresh()
			{
			window.location.reload( false );
			}
	    </script>
	</head>

	<body>
		<div id="container">
				<img id="logo" src="images/raspberry.png">
				<div id="title">Web Bilgi Ekranı</div>
				<div id="uptime"><b><?php echo TXT_RUNTIME; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $uptime; ?></div>
				<div id="tempgauge"></div>
				<div id="clockgauge"></div>
				<div id="cpugauge"></div>
				<div id="FREEMemory"></div>
				<div id="USEDMemory"></div>
		</div>


		<script>
		    var t = new JustGage({
		    id: "tempgauge",
		    value: <?php echo $temp; ?>,
		    min: 0,
		    max: 60,
		    title: "<?php echo TXT_TEMPERATURE; ?>",
		    label: "°C"
		    });
		</script>

		<script>
		    var c = new JustGage({
		    id: "clockgauge",
		    value: <?php echo $clock; ?>,
		    min: 0,
		    max: 1000,
		    title: "<?php echo TXT_CLOCK; ?>",
		    label: "MHz"
		    });
		</script>

		<script>
		    var c = new JustGage({
		    id: "cpugauge",
		    value: <?php echo $cpuusage; ?>,
		    min: 0,
		    max: 100,
		    title: "<?php echo TXT_USAGE; ?>",
		    label: "%"
		    });
	    	</script>

		<script>
		    var a = new JustGage({
		    id: "FREEMemory",
		    value: <?php echo $percent_free ?>,
		    min: 0,
		    max: 100,
		    title: "<?php echo TXT_FREEMEM; ?>",
		    label: "%"
		    });
	    	</script>

		<script>
		    var a = new JustGage({
		    id: "USEDMemory",
		    value: <?php echo $percent_used ?>,
		    min: 0,
		    max: 100,
		    title: "<?php echo TXT_USEDMEM; ?>",
		    label: "%"
		    });
	    	</script>
	</body>
</html>
