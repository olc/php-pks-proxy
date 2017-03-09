<?php

$public_key_server = 'http://keyserver.ubuntu.com';

$method = $_SERVER['REQUEST_METHOD'];

if ($method !== 'GET') {
  http_response_code(406);
  echo('Unsupported method');
  exit();
}

if ($_GET && $_GET['op'] && $_GET['search']) {
  $op = $_GET['op'];
  $search = $_GET['search'];

  if (strtolower($op) !== 'get') {
    http_response_code(406);
    echo('Malformed request');
    exit();
  }

  if (strlen($search) != 42) {
    http_response_code(406);
    echo('search field not acceptable');
    exit();
  }

  $fingerprint = substr($search, 2);

  if (!ctype_xdigit($fingerprint)) {
    http_response_code(406);
    echo('fingerprint not in hexa');
    exit();
  }

  $url = "${public_key_server}/pks/lookup?op=get&search=0x${fingerprint}";

  $ch = curl_init();
  $timeout = 5;
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
  $data = curl_exec($ch);
  curl_close($ch);

  echo($data);
}
