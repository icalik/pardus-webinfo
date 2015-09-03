<?php

	define(TXT_RUNTIME, "Çalışma Zamanı:");
	define(TXT_TEMPERATURE, "Sıcaklık");
	define(TXT_CLOCK, "Clock");
	define(TXT_USAGE, "İşlemci Yükü");
	define(TXT_FREEMEM, "Boş RAM");
	define(TXT_USEDMEM, "Kullanılan RAM");

	$uptime = preg_replace('/day\b/i','Gün',$uptime);
	$uptime = preg_replace('/days\b/i','Gündür',$uptime);
?>