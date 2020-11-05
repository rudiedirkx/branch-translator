<?php

header('Content-type: text/html; charset=utf-8');

?>
<!doctype html>
<title>Branch Translator</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="theme-color" content="#333" />
<meta charset="utf-8" />
<meta name="referrer" content="no-referrer" />
<link rel="stylesheet" type="text/css" href="<?= html_asset('style.css') ?>" />
<script>
const $ = sel => document.querySelector(sel);
const $$ = sel => Array.from(document.querySelectorAll(sel));
</script>

<body onload="window.init && init()">
