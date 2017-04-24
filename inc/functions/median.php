<?php 
function array_median($array) {
  // perhaps all non numeric values should filtered out of $array here?
  $iCount = count($array);
  if ($iCount == 0) {
    throw new DomainException('Median of an empty array is undefined');
  }
  // if we're down here it must mean $array
  // has at least 1 item in the array.
  $middle_index = floor($iCount / 2);
  sort($array, SORT_NUMERIC);
  $median = $array[$middle_index]; // assume an odd # of items
  // Handle the even case by averaging the middle 2 items
  if ($iCount % 2 == 0) {
    $median = ($median + $array[$middle_index - 1]) / 2;
  }
  return $median;
}
?>