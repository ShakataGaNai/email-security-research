<?php
$Aspf = 0; $Admarc = 0;
$linecount = 0;

date_default_timezone_set('America/Los_Angeles');
$infile = "top50.txt";
#$infile = "Quantcast-Top-Million.txt";

$handle = fopen($infile, "r");
$outhandle = fopen("./results/result-".date("c").".csv","w");
$in = fread($handle, filesize($infile));
fclose($handle);
preg_match_all("/(\s*)(\w+\.\w+)(\s*)/ms",$in,$tld);
fwrite($outhandle, "DOMAINNAME, SPF, DMARC\n");
foreach($tld[2] as $domain){
	$linecount++;
	$returned = checkDomain($domain);
	if($returned[0]){ $Aspf++; }
	if($returned[1]){ $Admarc++; }
	fwrite($outhandle, "\"$domain\", \"{$returned[0]}\", \"{$returned[1]}\"\n");
}
fwrite($outhandle,"LINESREAD, $linecount\n");
fwrite($outhandle,"YES-SPF, $Aspf, ".round(($Aspf/$linecount),4)."\n");
fwrite($outhandle,"YES-DMARC, $Admarc, ".round(($Admarc/$linecount),4)."\n");

fclose($outhandle);

function checkDomain($name){
$out = dns_get_record($name, DNS_TXT);
$spf = false;
$dmarc = false;
foreach($out as $key){
	if( preg_match("/^v=spf(.*)/i", $key['txt'])){
		$spf = $key['txt'];
	}
}

$out2 = dns_get_record("_dmarc.".$name, DNS_TXT);
foreach($out2 as $key){
	if( preg_match("/^v=dmarc(.*)/i", $key['txt'])){
		$dmarc = $key['txt'];
	}
}
return array($spf, $dmarc);
}
