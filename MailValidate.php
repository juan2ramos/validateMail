<?php


class MailValidate
{
    private $nameFile;
    private $columnValueMail;
    private $arrayFileOutput;
    private $nameFileOutput;
    private $output = false;

    function __construct($nameFile, $columnValueMail, $nameFileOutput = 'file')
    {

        $this->nameFile = $nameFile;
        $this->columnValueMail = $columnValueMail;
        $this->nameFileOutput = $nameFileOutput;
        $this->uploadFile();

    }

    private function uploadFile()
    {

        $row = 1;
        if (($manager = fopen($this->nameFile . ".csv", "r")) !== FALSE) {

            while (($dateFile = fgetcsv($manager, 1000, ",")) !== FALSE) {

                $numberColumn = count($dateFile);
                /*echo "<p> $numero de campos en la línea $fila: <br /></p>\n";*/

                $row++;
                for ($c = 0; $c < $numberColumn; $c++) {
                    if (preg_match(
                        '/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',
                        $dateFile[$this->columnValueMail])) {
                        if (filter_var($dateFile[$this->columnValueMail], FILTER_VALIDATE_EMAIL)) {
                            $this->arrayFileOutput[] = $dateFile;
                            break;
                        }
                    }
                }
            }
            fclose($manager);
            $this->downFile();

            $this->output = true;
        }
    }

    private function downFile()
    {
        $fp = fopen($this->nameFileOutput . '.csv', 'w');

        foreach ($this->arrayFileOutput as $rows) {
            fputcsv($fp, $rows);
        }

        fclose($fp);
    }

    function __toString(){
        if($this->output){
            return ('El archivo fue verificado correctamente');
        }
        return ('Hubo un problema, intenta de nuevo');
    }

}