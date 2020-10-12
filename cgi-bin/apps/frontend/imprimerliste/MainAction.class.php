<?php

    namespace apps\frontend\imprimerliste;
    
    class MainAction
    {
        public static function execute()
        {
            $dir = 'mkdir';
            if(!file_exists($dir)){
                mkdir($dir, 0744);
            }

            $fileName = 'output/result_'. \User::getId().'.docx';
            file_exists ($fileName)  && unlink($fileName);
            $phpWord = new \PhpOffice\PhpWord\PhpWord();
            $testWord = $phpWord->loadTemplate('template/template.docx');
            
            //récupération des insertions
            $listUser = \Application::getDb(\config\Configuration::get('courseoo_dsn', 'databases'))
                    ->data('courseoo\\ListeIngredients')->getIngredientsListeByUser(\User::getId());
            $listUser = \apps\frontend\listecourse\MainAction::formatList($listUser);
            $i = sizeof($listUser);
            $testWord->cloneRow('ingredient', $i);
            $j = 1;
            foreach($listUser as $line){
                $testWord->setValue('ingredient#' .$j, $line['ingredient']);
                $testWord->setValue('mesure#' .$j, $line['uniteMesure']);
                $testWord->setValue('quantite#' .$j,  array_sum($line['qts']) );
                $testWord->setValue('categorie#' .$j, $line['categorie']);
                $j++;
            }
            
            $testWord->saveAs($fileName);
            header('Content-Description: File Transfer');
            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            header('Content-Disposition: attachment; filename='.$fileName.'');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($fileName));
            ob_clean();
            flush();
            readfile($fileName);
            exit(); 
        }
    }

?>
