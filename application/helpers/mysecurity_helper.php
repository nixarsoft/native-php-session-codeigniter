<?php

function htmlspecialcharsarray($arr) {
  array_walk_recursive($arr, "htmlspecialcharsfilter");
  return $arr;
}

function htmlspecialcharsfilter(&$value) {
  $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

