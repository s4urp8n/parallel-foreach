<?php

namespace Zver {

    class Parallel
    {

        protected $callback = null;
        protected $arguments = [];
        protected $argumentsSet = false;
        protected $maxConcurrents = null;
        protected static $defaultConcurrents = 4;

        protected function __construct()
        {

        }

        public static function forEach ()
        {
            return new static;
        }

        public function setCallback(callable $callback)
        {
            $this->callback = $callback;

            return $this;
        }

        public function setArguments(array $arguments)
        {
            $this->arguments = $arguments;
            $this->argumentsSet = true;

            return $this;
        }

        public function setMaximumConcurrents(int $maxConcurrents)
        {

            if ($maxConcurrents > 0) {
                $this->maxConcurrents = $maxConcurrents;
            }

            return $this;
        }

        protected function getMaximumConcurrents()
        {
            return empty($this->maxConcurrents) ? static::$defaultConcurrents : $this->maxConcurrents;
        }

        public function run()
        {

            if (empty($this->callback)) {
                throw new \Exception('Aborting, the callback is not set');
            }

            if (empty($this->argumentsSet)) {
                throw new \Exception('Aborting, the arguments is not set');
            }

            if ($this->getMaximumConcurrents() > 1 && static::isParallelPossible()) {

                $pid = null;

                for ($concurrent = 0; $concurrent < $this->getMaximumConcurrents(); $concurrent++) {
                    $pid = pcntl_fork();
                    if ($pid == -1) {
                        throw new \Exception("Can't fork process");
                    }
                    if ($pid == 0) {
                        break;
                    }
                }

                if ($pid) {
                    for ($i = 0; $i < $this->getMaximumConcurrents(); $i++) {
                        pcntl_wait($status);
                    }

                    return;
                }

                $l = count($this->arguments);
                for ($i = $concurrent; $i < $l; $i += $this->getMaximumConcurrents()) {
                    call_user_func($this->callback, $this->arguments[$i]);
                }

                exit(0);

            } else {
                foreach ($this->arguments as $argument) {
                    call_user_func($this->callback, $argument);
                }
            }
        }

        protected static function isParallelPossible()
        {
            return function_exists('pcntl_fork') && function_exists('pcntl_wait');
        }
    }
}