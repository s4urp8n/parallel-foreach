<?php

include "vendor/autoload.php";

$start = microtime(true);

\Zver\Parallel::forEach ()
              ->setArguments(range(1, 100))
              ->setCallback(function ($i) {
                  sleep(1);
                  echo "[$i]\n";
              })
              ->setMaximumConcurrents(10)
              ->run();

$duration = round(microtime(true) - $start, 2);

echo "\nDURATION " . $duration . "s\n\n";