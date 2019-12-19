<?php

return array(
    'classNamePath'  =>  [
        '/Curl\\\\(.*)/'    => __ROOT__ . DS . 'Extends' . DS . 'Curl' . DS . WdnmdApi\Core\File::getConfig('config', 'replaceFileName') . '.php',
        '/^(PHPExcel)/'     =>  __ROOT__ . DS . 'Extends' . DS . 'PHPExcel' . DS . 'PHPExcel.php',
    ]
);