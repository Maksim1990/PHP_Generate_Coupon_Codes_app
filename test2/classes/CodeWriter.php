<?php

namespace App\Classes;


class CodeWriter
{
    /**
     *  Config parameter for name of the file where register codes
     */
    private $fileName;

    /**
     *  Config parameter for number of codes that should be generated
     */
    private $numCodes;

    /**
     *  Config parameter for number of each code's length
     */
    private $intCodeLength;

    /**
     *  Array of unique codes
     */
    private $arrCodes = array();

    public function __construct($arrParams)
    {
        $this->fileName      = "output/" . $arrParams['fileName'];
        $this->numCodes      = $arrParams['numCodes'];
        $this->intCodeLength = $arrParams['intCodeLength'];
    }

    /**
     *  Generate required number of unique codes
     *  Perform additional validation for uniqueness before store code
     */
    private function GenerateCodeLines()
    {
        do {
            $strCode = strtoupper($this->BuildCodeFormat());
            if (!in_array($strCode, $this->arrCodes)) {
                array_push($this->arrCodes, $strCode);
            }
        } while (count($this->arrCodes) < $this->numCodes);
    }

    /**
     * Build appropriate format of the code
     *
     * @return string
     */
    private function BuildCodeFormat(): string
    {
        return "AI" . $this->GenerateCodeChars();
    }

    /**
     * Generate unique random part of the code with specified length
     *
     * @return string
     */
    private function GenerateCodeChars(): string
    {
        $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $string     = '';
        $max        = strlen($characters) - 1;
        for ($i = 0; $i < $this->intCodeLength; $i++) {
            $string .= $characters[mt_rand(0, $max)];
        }

        return $string;
    }


    /**
     * Functionality to write generated unique codes in the file
     *
     * @return string
     */
    private function WriteIntoFile(): string
    {
        $strError = '';
        $fh = fopen($this->fileName, 'w') or die("Can't open file");
        if ($intCount = count($this->arrCodes)) {
            for ($i = 0; $i < $intCount; $i++) {
                $intLineNum = $i + 1;
                $stringData = $intLineNum . ": " . $this->arrCodes[$i] . "\n";
                fwrite($fh, $stringData);
            }
            fclose($fh);
        } else {
            $strError = "Array with codes should be correctly filled in before write data in file";
        }

        return $strError;

    }


    /**
     * Generate codes and write it in a file
     *
     * @return array
     */
    public function GenerateCode(): array
    {
        $arrResult = [
            'blnError'   => false,
            'strMessage' => "Codes were successfully generated",
            'strError'   => "",
        ];
        $this->GenerateCodeLines();
        if ($strMessage = $this->WriteIntoFile()) {
            $arrResult = [
                'blnError'   => true,
                'strMessage' => "",
                'strError'   => $strMessage,
            ];
        };

        return $arrResult;
    }

}