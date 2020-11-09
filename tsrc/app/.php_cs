<?php
$finder = Symfony\CS\Finder::create()
          ->exclude('ThirdParty')
          ->in(__DIR__);
      return Symfony\CS\Config::create()
          ->level(Symfony\CS\FixerInterface::PSR2_LEVEL)
          ->finder($finder);
?>
