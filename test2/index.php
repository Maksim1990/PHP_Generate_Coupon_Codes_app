<?php

use App\Classes\CodeWriter;

require __DIR__ . '/vendor/autoload.php';

//-- Set initial parameters for code generation
$arrConfig = [
    'fileName'      => 'test2.txt',
    'numCodes'      => 250,
    'intCodeLength' => 10,
];

//-- Initialize class and perform code
//-- generation with specified parameters
$codeWriter = new CodeWriter($arrConfig);
$arrResult=$codeWriter->GenerateCode();
echo (!$arrResult['blnError']?$arrResult['strMessage']:$arrResult['strError'])."!";

