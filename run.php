<?php

include "vendor/autoload.php";

\Zver\Parallel::forEach ()
              ->setArguments(range(1, 100))
              ->setCallback(function ($i) {
                  sleep(1);
                  echo "[$i]\n";
              })
              ->setMaximumConcurrents(10)
              ->run();