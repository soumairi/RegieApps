<?php

/**
 * Created by PhpStorm.
 * User: Mouhssine Soumairi
 * Date: 17/02/2017
 * Time: 16:52
 */
class RecetteModel extends Model

{
    public function Index()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    }

    public function add()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        if ($post ['submit']) {
            if ($post ['quit1'] == '' || $post ['quit2'] == '' || $post ['dator'] == '' || $post ['typeo'] == '') {
                Messages::setMsg('Veuillez remplir tous les champs obligatoires', 'error');
                return;
            } else {

                // insert into database
                $this->query("INSERT INTO `recette2` (`id`, `quit1`, `quit2`, `dator`, `dateemis`, `type`, `v31`, `v32`, `v33`, `v11`, `v14`, `v15`, `v51`, `v81`) VALUES (NULL, ?, ?, ?,NULL, ?, ?, ?, ?, ?,?, ?, ?, ?)");
                $this->bind(1, $post ['quit1']);
                $this->bind(2, $post ['quit2']);
                $this->bind(3, $post ['dator']);
                $this->bind(4, $post ['typeo']);
                $this->bind(5, $post ['v31']);
                $this->bind(6, $post ['v32']);
                $this->bind(7, $post ['v33']);
                $this->bind(8, $post ['v11']);
                $this->bind(9, $post ['v14']);
                $this->bind(10, $post ['v15']);
                $this->bind(11, $post ['v51']);
                $this->bind(12, $post ['v81']);
                $this->execute();
            }
        }
    }

    public function SupprimerRecette()
    {
        $post = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        if(isset($post['id'])){
            $this->query('delete from recette2 where id=?');
            $this->bind(1,$post['id']);
            $this->execute();
            header('Location: '.ROOT_PATH.'recettes/lists/');
        }
    }

    public function UpdateRecette()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        if ($post ['submit'] && isset($post['id'])) {
            if ($post ['quit1'] == '' || $post ['quit2'] == '' || $post ['dator'] == '' || $post ['typeo'] == '') {
                Messages::setMsg('Veuillez remplir tous les champs obligatoires', 'error');
                return;
            } else {

                // Update table recette
                $this->query('update recette2 set quit1=? , quit2=?, dator=?,`type`=? , v31=?, v32=?, v33=? , v11=? , v14=? , v15=? , v51=? , v81=? where id=? ');
                //$this->query("INSERT INTO `recette2` (`id`, `quit1`, `quit2`, `dator`, `dateemis`, `type`, `v31`, `v32`, `v33`, `v11`, `v14`, `v15`, `v51`, `v81`) VALUES (NULL, ?, ?, ?,NULL, ?, ?, ?, ?, ?,?, ?, ?, ?)");
                $this->bind(1, $post ['quit1']);
                $this->bind(2, $post ['quit2']);
                $this->bind(3, $post ['dator']);
                $this->bind(4, $post ['typeo']);
                $this->bind(5, $post ['v31']);
                $this->bind(6, $post ['v32']);
                $this->bind(7, $post ['v33']);
                $this->bind(8, $post ['v11']);
                $this->bind(9, $post ['v14']);
                $this->bind(10, $post ['v15']);
                $this->bind(11, $post ['v51']);
                $this->bind(12, $post ['v81']);
                $this->bind(13, $post ['id']);
                $this->execute();
                header('Location: '.ROOT_PATH.'recettes/lists/');

            }
        }else{

           return $rows=$this->afficherparId();
        }
    }

    public function TotalDuMois()
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        if ($post ['annee'] == '') {
            $annees = date('Y');
        } else {
            $annees = $post ['annee'];
        }

        $this->query('SELECT SUM(`v31`+`v32`+`v33`+`v11`+`v14`+`v15`+`v51`+`v81`) as total , MONTH(dator) as mois, dateemis FROM `recette2` WHERE  year(dator)= ? GROUP BY MONTH(dator) ORDER by MONTH(dator) ASC ');
        $this->bind(1, $annees, PDO::PARAM_INT);
        $rows = $this->resultSet();
        return $rows;
    }
    public function afficherparId(){
        $post = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $this->query('SELECT * FROM `recette2` WHERE  id=?');
        $this->bind(1, $post['id']);
        $rows = $this->single();
        return $rows;
    }
    public function afficherpardate($dator1,$dator2){
        $this->query('SELECT * FROM `recette2` WHERE  dator between ? and ? order by dator ASC ');

        $this->bind(1, $dator1);
        $this->bind(2, $dator2);
        $rows = $this->resultSet();
        return $rows;
    }
	public function Lists(){
		
		$get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);


        $pag = new Pagination();
        if($post['submit']){

            $dator1=$post['dator1'];
            $dator2=$post['dator2'];
            if ($dator1!='' && $dator2!='' && $dator1<$dator2){
                $rows=$this->afficherpardate($dator1,$dator2);
                $numbers=$pag->page($rows, NBR_PAGES);
                $data=$pag->getData();
                return array($numbers,$data);
            }else{
                Messages::setMsg('Veuillez remplir les champs', 'error');
            }
        }else{
            $param=explode('s',$get['id']);
            if(isset($param[1]) && isset($param[2])  ){
                $dator1=$param[1];
                $dator2=$param[2];
                $rows=$this->afficherpardate($dator1,$dator2);
                $numbers=$pag->page($rows, NBR_PAGES);
                $data=$pag->getData();
                return array($numbers,$data);
            }else{
                $moissuivant=date('m')+1;
                $dator1=date('Y-m')."-01";

                if($moissuivant<10){
                    $dator2=date('Y')."-0".$moissuivant."-01";
                }else{
                    $dator2=date('Y')."-".$moissuivant."-01";
                }
                $rows=$this->afficherpardate($dator1,$dator2);
                $numbers=$pag->page($rows, NBR_PAGES);
                $data=$pag->getData();
                return array($numbers,$data);
            }
        }

		
	}
    public function Emis()

    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        if ($post ['submit']) {
            if ($post ['mois'] != '' && $post ['dateemis'] != '') {
                if ($post ['annee'] == '') {
                    $annees = date('Y');
                } else {
                    $annees = $post ['annee'];
                }
                $mois = $post ['mois'];
                $dateemis = $post ['dateemis'];

                $this->query('Update recette2 Set dateemis=? where MONTH(dator)= ? AND year(dator)= ?');
                $this->bind(1, $dateemis);
                $this->bind(2, $mois);
                $this->bind(3, $annees);
                $this->execute();

                header('Location: ' . ROOT_URL . 'recettes/totaldumois');
            } else {
                Messages::setMsg('Remplir les champs', 'error');
            }
        }
        return;
    }

    public function etatannuel()
    {
        $post = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        

        if ($post ['id'] == '') {
            $annees = date('Y');
        } else {
            $annees = $post ['id'];
        }

        $pdf = new FPDF ('L', 'cm', 'A4');
        // Titres des colonnes
        $header = array(
            'Mois',
            'Emis le',
            'O.R',
            'MT_OR',
            '712431',
            '712432',
            '712433',
            '34211',
            '31214',
            '34215',
            '75851',
            '7381'
        );

        $pdf->SetFont('Times', 'B', 11);
        $pdf->AddPage();
        $pdf->SetFillColor(0xdd, 0xdd, 0xdd);
        $pdf->SetTextColor(0, 0, 0);

        $heado = "CHUIS - RABAT \nHMY - SAF - REGIE";
        $fond = 1;
        $pdf->SetXY(1, 1, 1);
        $pdf->MultiCell(5, 0.5, $heado, 0, 'C', 0, $fond);
        "\n";

        $headoo = " REGISTRE DE SUIVI DES EMISSIONS DES ORDRES DE RECETTES ";
        $fond = 1;
        $pdf->SetXY(1, 1, 1);
        $pdf->MultiCell(27, 0.5, $headoo, 0, 'C', 0, $fond);
        "\n";

        $fond = 1;
        $pdf->SetXY(1, $pdf->GetY() + 1);
        $pdf->cell(1.8, 0.7, $header [0], 1, 0, 'C', $fond);
        $pdf->cell(1.9, 0.7, $header [1], 1, 0, 'C', $fond);
        $pdf->cell(1.0, 0.7, $header [2], 1, 0, 'C', $fond);
        $pdf->cell(2.5, 0.7, $header [3], 1, 0, 'C', $fond);
        $pdf->cell(2.5, 0.7, $header [4], 1, 0, 'C', $fond);
        $pdf->cell(2.5, 0.7, $header [5], 1, 0, 'C', $fond);
        $pdf->cell(2.5, 0.7, $header [6], 1, 0, 'C', $fond);
        $pdf->cell(2.5, 0.7, $header [7], 1, 0, 'C', $fond);
        $pdf->cell(2.5, 0.7, $header [8], 1, 0, 'C', $fond);
        $pdf->cell(2.5, 0.7, $header [9], 1, 0, 'C', $fond);
        $pdf->cell(2.5, 0.7, $header [10], 1, 0, 'C', $fond);
        $pdf->cell(2.5, 0.7, $header [11], 1, 0, 'C', $fond);

        $pdf->SetFillColor(0xdd, 0xdd, 0xdd);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Times', 'B', 10);
        $pdf->SetXY(1, $pdf->GetY() + 0.8);
        $fond = 0;

        $mtt = 0;
        $mtt1 = 0;
        $mtt2 = 0;
        $mtt3 = 0;
        $mtt4 = 0;
        $mtt5 = 0;
        $mtt6 = 0;
        $mtt7 = 0;
        $mtt8 = 0;

        $out = array(
            0,
            'Janvier',
            'Fevrier',
            'Mars',
            'Avril',
            'Mai',
            'Juin',
            'Juillet',
            'Aout',
            'Septembre',
            'Octobre',
            'Novembre',
            'Decembre'
        );

        $this->query("SELECT dateemis, MONTH(dator) as mois,  SUM(v31) as tot1, SUM(v32) as tot2, SUM(v33) as tot3, SUM(v11) as tot4, SUM(v14) as tot5, SUM(v15) as tot6, SUM(v51) as tot7, SUM(v81) as tot8, SUM(v31+v32+v33+v11+v14+v15+v51+v81) as TOT FROM recette2 WHERE  year(`dator`)=? GROUP BY MONTH(dator) ORDER by MONTH(dator) ASC  ");
        $this->bind(1, $annees);
        $rows = $this->resultSet();
        $i = 1;
        foreach ($rows as $row) {

            $pdf->cell(1.8, 0.6, $out [$row ['mois']], 1, 0, 'L', $fond);
            $pdf->cell(1.9, 0.6, $row ['dateemis'], 1, 0, 'C', $fond);
            $pdf->cell(1.0, 0.6, $i, 1, 0, 'C', $fond);
            $pdf->cell(2.5, 0.6, number_format($row ['TOT'], 2, ',', ' '), 1, 0, 'C', $fond);
            $pdf->cell(2.5, 0.6, number_format($row ['tot1'], 2, ',', ' '), 1, 0, 'C', $fond);
            $pdf->cell(2.5, 0.6, number_format($row ['tot2'], 2, ',', ' '), 1, 0, 'C', $fond);
            $pdf->cell(2.5, 0.6, number_format($row ['tot3'], 2, ',', ' '), 1, 0, 'C', $fond);
            $pdf->cell(2.5, 0.6, number_format($row ['tot4'], 2, ',', ' '), 1, 0, 'C', $fond);
            $pdf->cell(2.5, 0.6, number_format($row ['tot5'], 2, ',', ' '), 1, 0, 'C', $fond);
            $pdf->cell(2.5, 0.6, number_format($row ['tot6'], 2, ',', ' '), 1, 0, 'C', $fond);
            $pdf->cell(2.5, 0.6, number_format($row ['tot7'], 2, ',', ' '), 1, 0, 'C', $fond);
            $pdf->cell(2.5, 0.6, number_format($row ['tot8'], 2, ',', ' '), 1, 0, 'C', $fond);
            $pdf->SetXY(1, $pdf->GetY() + 0.6);
            // $fond=!$fond;

            $pdf->cell(4.7, 0.6, "Cumul recettes Au " . $row ['dateemis'], 1, 0, 'L', $fond);

            $mtt = $mtt + $row ['TOT'];
            $pdf->cell(2.5, 0.6, number_format($mtt, 2, ',', ' '), 1, 0, 'C', $fond);

            $mtt1 = $mtt1 + $row ['tot1'];
            $pdf->cell(2.5, 0.6, number_format($mtt1, 2, ',', ' '), 1, 0, 'C', $fond);

            $mtt2 = $mtt2 + $row ['tot2'];
            $pdf->cell(2.5, 0.6, number_format($mtt2, 2, ',', ' '), 1, 0, 'C', $fond);

            $mtt3 = $mtt3 + $row ['tot3'];
            $pdf->cell(2.5, 0.6, number_format($mtt3, 2, ',', ' '), 1, 0, 'C', $fond);

            $mtt4 = $mtt4 + $row ['tot4'];
            $pdf->cell(2.5, 0.6, number_format($mtt4, 2, ',', ' '), 1, 0, 'C', $fond);

            $mtt5 = $mtt5 + $row ['tot5'];
            $pdf->cell(2.5, 0.6, number_format($mtt5, 2, ',', ' '), 1, 0, 'C', $fond);

            $mtt6 = $mtt6 + $row ['tot6'];
            $pdf->cell(2.5, 0.6, number_format($mtt6, 2, ',', ' '), 1, 0, 'C', $fond);

            $mtt7 = $mtt7 + $row ['tot7'];
            $pdf->cell(2.5, 0.6, number_format($mtt7, 2, ',', ' '), 1, 0, 'C', $fond);

            $mtt8 = $mtt8 + $row ['tot8'];
            $pdf->cell(2.5, 0.6, number_format($mtt8, 2, ',', ' '), 1, 0, 'C', $fond);

            $pdf->SetXY(1, $pdf->GetY() + 0.6);
            $fond = !$fond;
            $i++;
        }

        $pdf->output();
    }
    public function etatorjour(){
        $post = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);

        $pdf=new FPDF('L','cm','A4');
$dat=$post['id'];
//Titres des colonnes
        $header=array('Le','Du','Au','712431','712432','712433','34211','31214','34215','75851','7381','TOTAUX');
        $header1=array('VERSEMENTS EN NUMENAIRE : ');
        $header2=array('VERSEMENTS PAR CHEQUE : ');
        $header3=array('VIREMENTS RECUS : ');

        $pdf->SetFont('Times','B',10);
        $pdf->AddPage();
        $pdf->SetFillColor(0xdd,0xdd,0xdd);
        $pdf->SetTextColor(0,0,0);

        if('2017-01-01'<= $dat AND $dat <= '2017-01-31'){ $mois='Janvier'; $n='1'; }
        if('2017-02-01'<= $dat AND $dat <= '2017-02-28'){ $mois='Fevrier'; $n='2'; }
        if('2017-03-01'<= $dat AND $dat <= '2017-03-31'){ $mois='Mars'; $n='3'; }
        if('2017-04-01'<= $dat AND $dat <= '2017-04-30'){ $mois='Avril'; $n='4'; }
        if('2017-05-01'<= $dat AND $dat <= '2017-05-31'){ $mois='Mai'; $n='5'; }
        if('2017-06-01'<= $dat AND $dat <= '2017-06-30'){ $mois='Juin'; $n='6'; }
        if('2017-07-01'<= $dat AND $dat <= '2017-07-29'){ $mois='Juillet'; $n='7'; }
        if('2017-08-01'<= $dat AND $dat <= '2017-08-31'){ $mois='Aout'; $n='8'; }
        if('2017-09-01'<= $dat AND $dat <= '2017-09-30'){ $mois='Septembre'; $n='9'; }
        if('2017-10-01'<= $dat AND $dat <= '2017-10-31'){ $mois='Octobre'; $n='10'; }
        if('2017-11-01'<= $dat AND $dat <= '2017-11-30'){ $mois='Novembre'; $n='11'; }
        if('2017-12-01'<= $dat AND $dat <= '2017-12-30'){ $mois='Decembre'; $n='12'; }

        $heado="CHUI Ibn Sina - Rabat \nHMY - SAF - REGIE";
        $fond=1;
        $pdf->SetXY(1,1,1);
        $pdf->MultiCell(5,0.6,$heado,0,'C',0,$fond);
        "\n";

        $headoo=" Ordre de Recette de Regularisation des Sommes Encaissees \nle ( $dat ) et Imputees au Mois de $mois / 2017";
        $fond=1;
        $pdf->SetXY(1,1,1);
        $pdf->MultiCell(27,0.6,$headoo,0,'C',0,$fond);
        "\n";

        $headooo=" Exercice Budgetaire 2017 \nOR Num : $n  ";
        $fond=1;
        $pdf->SetXY(1,1,1);
        $pdf->MultiCell(49,0.6,$headooo,0,'C',0,$fond);
        "\n";

        $fond=1;
        $pdf->SetXY(1,$pdf->GetY()+1.5);

        $pdf->cell(2,0.7,$header[0],1,0,'C',$fond);
        $pdf->cell(1.5,0.7,$header[1],1,0,'C',$fond);
        $pdf->cell(1.5,0.7,$header[2],1,0,'C',$fond);
        $pdf->cell(2.5,0.7,$header[3],1,0,'C',$fond);
        $pdf->cell(2.5,0.7,$header[4],1,0,'C',$fond);
        $pdf->cell(2.5,0.7,$header[5],1,0,'C',$fond);
        $pdf->cell(2.5,0.7,$header[6],1,0,'C',$fond);
        $pdf->cell(2.5,0.7,$header[7],1,0,'C',$fond);
        $pdf->cell(2.5,0.7,$header[8],1,0,'C',$fond);
        $pdf->cell(2.5,0.7,$header[9],1,0,'C',$fond);
        $pdf->cell(2.5,0.7,$header[10],1,0,'C',$fond);
        $pdf->cell(2.5,0.7,$header[11],1,0,'C',$fond);

        $fond=0;
        $pdf->SetXY(1,$pdf->GetY()+0.8);
        $pdf->cell(25,0.7,$header1[0],0,0,'L',$fond);
        $this->query("SELECT * FROM recette2 WHERE dator=? AND type='verN'  group by dator");
        $this->bind(1,$post['id']);
        $rows=$this->resultSet();

        $pdf->SetFillColor(0xdd,0xdd,0xdd);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Times','B',10);
        $pdf->SetXY(1,$pdf->GetY()+0.8);
        $fond=0;

        foreach($rows as $row)
        {
            $pdf->cell(2,0.6,$row['dator'],1,0,'C',$fond);
            $pdf->cell(1.5,0.6,$row['quit1'],1,0,'C',$fond);
            $pdf->cell(1.5,0.6,$row['quit2'],1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row['v31'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row['v32'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row['v33'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row['v11'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row['v14'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row['v15'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row['v51'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row['v81'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row['v31']+$row['v32']+$row['v33']+$row['v11']+$row['v14']+$row['v15']+$row['v51']+$row['v81'],2,',',' '),1,0,'C',$fond);
            $pdf->SetXY(1,$pdf->GetY()+0.6);
            //$fond=!$fond;
        }

        $this->query("SELECT  SUM(v31) as Totalv31, SUM(v32) as Totalv32, SUM(v33) as Totalv33, SUM(v11) as Totalv11, SUM(v14) as Totalv14, SUM(v15) as Totalv15, SUM(v51) as Totalv51, SUM(v81) as Totalv81 FROM recette2 WHERE type='verN' AND  dator=?");
        $this->bind(1,$post['id']);
        $rows=$this->resultSet();


        $fond=1;
        foreach($rows as $tot)
        {
            $pdf->cell(5,0.7,"TOTAL 1",1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot['Totalv31'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot['Totalv32'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot['Totalv33'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot['Totalv11'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot['Totalv14'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot['Totalv15'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot['Totalv51'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot['Totalv81'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot['Totalv31']+$tot['Totalv32']+$tot['Totalv33']+$tot['Totalv11']+$tot['Totalv14']+$tot['Totalv15']+$tot['Totalv51']+$tot['Totalv81'],2,',',' '),1,0,'C',$fond);
            //$pdf->SetXY(3,$pdf->GetY()+1);
            $fond=!$fond;
        }

        $fond=0;
        $pdf->SetXY(1,$pdf->GetY()+0.8);
        $pdf->cell(25,0.7,$header2[0],0,0,'L',$fond);


        $this->query("SELECT * FROM recette2 WHERE dator=? AND type='verC'");
        $this->bind(1,$post['id']);
        $rows=$this->resultSet();

        $pdf->SetFillColor(0xdd,0xdd,0xdd);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Times','B',10);
        $pdf->SetXY(1,$pdf->GetY()+0.8);
        $fond=0;

        foreach($rows as $row2)
        {
            $pdf->cell(2,0.6,$row2['dator'],1,0,'C',$fond);
            $pdf->cell(1.5,0.6,$row2['quit1'],1,0,'C',$fond);
            $pdf->cell(1.5,0.6,$row2['quit2'],1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row2['v31'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row2['v32'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row2['v33'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row2['v11'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row2['v14'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row2['v15'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row2['v51'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row2['v81'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row2['v31']+$row2['v32']+$row2['v33']+$row2['v11']+$row2['v14']+$row2['v15']+$row2['v51']+$row2['v81'],2,',',' '),1,0,'C',$fond);
            $pdf->SetXY(1,$pdf->GetY()+0.6);
            //$fond=!$fond;
        }


        $this->query("SELECT  SUM(v31) as Totalv31, SUM(v32) as Totalv32, SUM(v33) as Totalv33, SUM(v11) as Totalv11, SUM(v14) as Totalv14, SUM(v15) as Totalv15, SUM(v51) as Totalv51, SUM(v81) as Totalv81 FROM recette2 WHERE type='verC' AND  dator=?");
        $this->bind(1,$post['id']);
        $rows=$this->resultSet();

        $fond=1;
        foreach($rows as $tot2)
        {
            $pdf->cell(5,0.7,"TOTAL 2",1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot2['Totalv31'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot2['Totalv32'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot2['Totalv33'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot2['Totalv11'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot2['Totalv14'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot2['Totalv15'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot2['Totalv51'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot2['Totalv81'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot2['Totalv31']+$tot2['Totalv32']+$tot2['Totalv33']+$tot2['Totalv11']+$tot2['Totalv14']+$tot2['Totalv15']+$tot2['Totalv51']+$tot2['Totalv81'],2,',',' '),1,0,'C',$fond);
            //$pdf->SetXY(3,$pdf->GetY()+1);
            $fond=!$fond;
        }

        $fond=0;
        $pdf->SetXY(1,$pdf->GetY()+0.8);
        $pdf->cell(25,0.7,$header3[0],0,0,'L',$fond);


        $this->query("SELECT * FROM recette2 WHERE dator=? AND type='virR'");
        $this->bind(1,$post['id']);
        $rows=$this->resultSet();

        $pdf->SetFillColor(0xdd,0xdd,0xdd);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Times','B',10);
        $pdf->SetXY(1,$pdf->GetY()+0.8);
        $fond=0;

        foreach($rows as $row3)
        {
            $pdf->cell(2,0.6,$row3['dator'],1,0,'C',$fond);
            $pdf->cell(1.5,0.6,$row3['quit1'],1,0,'C',$fond);
            $pdf->cell(1.5,0.6,$row3['quit2'],1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row3['v31'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row3['v32'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row3['v33'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row3['v11'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row3['v14'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row3['v15'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row3['v51'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row3['v81'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row3['v31']+$row3['v32']+$row3['v33']+$row3['v11']+$row3['v14']+$row3['v15']+$row3['v51']+$row3['v81'],2,',',' '),1,0,'C',$fond);
            $pdf->SetXY(1,$pdf->GetY()+0.6);
            //$fond=!$fond;
        }

        $this->query("SELECT  SUM(v31) as Totalv31, SUM(v32) as Totalv32, SUM(v33) as Totalv33, SUM(v11) as Totalv11, SUM(v14) as Totalv14, SUM(v15) as Totalv15, SUM(v51) as Totalv51, SUM(v81) as Totalv81 FROM recette2 WHERE type='virR' AND  dator=?");
        $this->bind(1,$post['id']);
        $rows=$this->resultSet();


        $fond=1;
        foreach($rows as $tot3)
        {
            $pdf->cell(5,0.7,"TOTAL 3",1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot3['Totalv31'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot3['Totalv32'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot3['Totalv33'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot3['Totalv11'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot3['Totalv14'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot3['Totalv15'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot3['Totalv51'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot3['Totalv81'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot3['Totalv31']+$tot3['Totalv32']+$tot3['Totalv33']+$tot3['Totalv11']+$tot3['Totalv14']+$tot3['Totalv15']+$tot3['Totalv51']+$tot3['Totalv81'],2,',',' '),1,0,'C',$fond);
            $pdf->SetXY(1,$pdf->GetY()+1);
            $fond=!$fond;
        }

        $this->query("SELECT SUM(v31) as Total31, SUM(v32) as Total32, SUM(v33) as Total33, SUM(v11) as Total11, SUM(v14) as Total14, SUM(v15) as Total15, SUM(v51) as Total51, SUM(v81) as Total81 FROM recette2 WHERE dator=?");
        $this->bind(1,$post['id']);
        $rows=$this->resultSet();

        $mt=0;
        $fond=1;
        foreach($rows as $tot4)
        {
            $pdf->cell(5,0.7,"TOTAL GENERAL",1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot4['Total31'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot4['Total32'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot4['Total33'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot4['Total11'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot4['Total14'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot4['Total15'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot4['Total51'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot4['Total81'],2,',',' '),1,0,'C',$fond);
            $mt=$tot4['Total31']+$tot4['Total32']+$tot4['Total33']+$tot4['Total11']+$tot4['Total14']+$tot4['Total15']+$tot4['Total51']+$tot4['Total51']+$tot4['Total81'];
            $a=number_format($mt,2,',',' ');
            $pdf->cell(2.5,0.7,$a,1,0,'C',$fond);
            $pdf->SetXY(1,$pdf->GetY()+1);
            $fond=!$fond;
        }
        $aa=convertir( $mt);

        $headA="ARRETE LE PRESENT BORDEREAU D IMPUTATION A LA SOMME DE: \n$aa";
        $pdf->MultiCell(26.5,0.6,$headA,0,'C',0);
        $pdf->SetXY(3,$pdf->GetY()+0.7);
        $fond=!$fond;

        $headd="SOUS ORDONNATEUR";
        $fond=0;
        $pdf->SetXY(11,18,3);
        $pdf->Cell(15,0.6,$headd,0,'R',0,$fond);
        "\n";

        $pdf->output();
    }
    public function etatormois(){
        $post = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);



        $param=explode('s',$post['id']);
        if(isset($param[0]) && isset($param[1]) ){
            $dator1=$param[1];
            $dator2=$param[2];
        }else{
            $moissuivant=date('m')+1;
            $dator1=date('Y-m')."-01";

            if($moissuivant<10){
                $dator2=date('Y')."-0".$moissuivant."-01";
            }else{
                $dator2=date('Y')."-".$moissuivant."-01";
            }
        }
        $dat=$dator2;
        $pdf=new FPDF('L','cm','A4');


        //Titres des colonnes
        $header=array('Le','Du','Au','712431','712432','712433','34211','31214','34215','75851','7381','TOTAUX');
        $header1=array('VERSEMENTS EN NUMENAIRE : ');
        $header2=array('VERSEMENTS PAR CHEQUE : ');
        $header3=array('VIREMENTS RECUS : ');

        $pdf->SetFont('Times','B',10);
        $pdf->AddPage();
        $pdf->SetFillColor(0xdd,0xdd,0xdd);
        $pdf->SetTextColor(0,0,0);

        $out = array(
            0,
            'e Janvier',
            'e Fevrier',
            'e Mars',
            '\'Avril',
            'e Mai',
            'e Juin',
            'e Juillet',
            '\'Aout',
            'e Septembre',
            '\'Octobre',
            'e Novembre',
            'e Decembre'
        );
        $datefin=explode('-',$dat);
        $mois=intval($datefin[1]);
        $anneebudgetaire=$datefin[0];



        $heado="CHUI Ibn Sina - Rabat \nHMY - SAF - REGIE";
        $fond=1;
        $pdf->SetXY(1,1,1);
        $pdf->MultiCell(5,0.6,$heado,0,'C',0,$fond);
        "\n";

        $headoo=" Ordre de Recette de Regularisation des Sommes Encaissees  et Imputees au Mois d". $out[$mois]." /". $anneebudgetaire." ";
        $fond=1;
        $pdf->SetXY(1,1,1);
        $pdf->MultiCell(27,0.6,$headoo,0,'C',0,$fond);
        "\n";

        $headooo=" Exercice Budgetaire $anneebudgetaire \nOR Num : $mois  ";
        $fond=1;
        $pdf->SetXY(1,1,1);
        $pdf->MultiCell(49,0.6,$headooo,0,'C',0,$fond);
        "\n";

        $fond=1;
        $pdf->SetXY(1,$pdf->GetY()+1.5);

        $pdf->cell(2,0.7,$header[0],1,0,'C',$fond);
        $pdf->cell(1.5,0.7,$header[1],1,0,'C',$fond);
        $pdf->cell(1.5,0.7,$header[2],1,0,'C',$fond);
        $pdf->cell(2.5,0.7,$header[3],1,0,'C',$fond);
        $pdf->cell(2.5,0.7,$header[4],1,0,'C',$fond);
        $pdf->cell(2.5,0.7,$header[5],1,0,'C',$fond);
        $pdf->cell(2.5,0.7,$header[6],1,0,'C',$fond);
        $pdf->cell(2.5,0.7,$header[7],1,0,'C',$fond);
        $pdf->cell(2.5,0.7,$header[8],1,0,'C',$fond);
        $pdf->cell(2.5,0.7,$header[9],1,0,'C',$fond);
        $pdf->cell(2.5,0.7,$header[10],1,0,'C',$fond);
        $pdf->cell(2.5,0.7,$header[11],1,0,'C',$fond);

        $fond=0;
        $pdf->SetXY(1,$pdf->GetY()+0.8);
        $pdf->cell(25,0.7,$header1[0],0,0,'L',$fond);
        $this->query("SELECT * FROM recette2 WHERE (dator BETWEEN ? AND ? ) AND type='verN'");
        $this->bind(1,$dator1);
        $this->bind(2,$dator2);
        $rows=$this->resultSet();

        $pdf->SetFillColor(0xdd,0xdd,0xdd);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Times','B',10);
        $pdf->SetXY(1,$pdf->GetY()+0.8);
        $fond=0;

        foreach($rows as $row)
        {
            $pdf->cell(2,0.6,$row['dator'],1,0,'C',$fond);
            $pdf->cell(1.5,0.6,$row['quit1'],1,0,'C',$fond);
            $pdf->cell(1.5,0.6,$row['quit2'],1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row['v31'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row['v32'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row['v33'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row['v11'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row['v14'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row['v15'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row['v51'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row['v81'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row['v31']+$row['v32']+$row['v33']+$row['v11']+$row['v14']+$row['v15']+$row['v51']+$row['v81'],2,',',' '),1,0,'C',$fond);
            $pdf->SetXY(1,$pdf->GetY()+0.6);
            //$fond=!$fond;
        }

        $this->query("SELECT  SUM(v31) as Totalv31, SUM(v32) as Totalv32, SUM(v33) as Totalv33, SUM(v11) as Totalv11, SUM(v14) as Totalv14, SUM(v15) as Totalv15, SUM(v51) as Totalv51, SUM(v81) as Totalv81 FROM recette2 WHERE type='verN' AND (dator BETWEEN ? AND ? ) ");
        $this->bind(1,$dator1);
        $this->bind(2,$dator2);
        $rows=$this->resultSet();


        $fond=1;
        foreach($rows as $tot)
        {
            $pdf->cell(5,0.7,"TOTAL 1",1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot['Totalv31'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot['Totalv32'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot['Totalv33'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot['Totalv11'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot['Totalv14'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot['Totalv15'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot['Totalv51'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot['Totalv81'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot['Totalv31']+$tot['Totalv32']+$tot['Totalv33']+$tot['Totalv11']+$tot['Totalv14']+$tot['Totalv15']+$tot['Totalv51']+$tot['Totalv81'],2,',',' '),1,0,'C',$fond);
            //$pdf->SetXY(3,$pdf->GetY()+1);
            $fond=!$fond;
        }

        $fond=0;
        $pdf->SetXY(1,$pdf->GetY()+0.8);
        $pdf->cell(25,0.7,$header2[0],0,0,'L',$fond);


        $this->query("SELECT * FROM recette2 WHERE (dator BETWEEN ? AND ? ) AND type='verC'");
        $this->bind(1,$dator1);
        $this->bind(2,$dator2);
        $rows=$this->resultSet();

        $pdf->SetFillColor(0xdd,0xdd,0xdd);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Times','B',10);
        $pdf->SetXY(1,$pdf->GetY()+0.8);
        $fond=0;

        foreach($rows as $row2)
        {
            $pdf->cell(2,0.6,$row2['dator'],1,0,'C',$fond);
            $pdf->cell(1.5,0.6,$row2['quit1'],1,0,'C',$fond);
            $pdf->cell(1.5,0.6,$row2['quit2'],1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row2['v31'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row2['v32'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row2['v33'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row2['v11'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row2['v14'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row2['v15'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row2['v51'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row2['v81'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row2['v31']+$row2['v32']+$row2['v33']+$row2['v11']+$row2['v14']+$row2['v15']+$row2['v51']+$row2['v81'],2,',',' '),1,0,'C',$fond);
            $pdf->SetXY(1,$pdf->GetY()+0.6);
            //$fond=!$fond;
        }


        $this->query("SELECT  SUM(v31) as Totalv31, SUM(v32) as Totalv32, SUM(v33) as Totalv33, SUM(v11) as Totalv11, SUM(v14) as Totalv14, SUM(v15) as Totalv15, SUM(v51) as Totalv51, SUM(v81) as Totalv81 FROM recette2 WHERE type='verC' AND  (dator BETWEEN ? AND ? )");
        $this->bind(1,$dator1);
        $this->bind(2,$dator2);
        $rows=$this->resultSet();

        $fond=1;
        foreach($rows as $tot2)
        {
            $pdf->cell(5,0.7,"TOTAL 2",1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot2['Totalv31'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot2['Totalv32'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot2['Totalv33'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot2['Totalv11'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot2['Totalv14'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot2['Totalv15'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot2['Totalv51'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot2['Totalv81'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot2['Totalv31']+$tot2['Totalv32']+$tot2['Totalv33']+$tot2['Totalv11']+$tot2['Totalv14']+$tot2['Totalv15']+$tot2['Totalv51']+$tot2['Totalv81'],2,',',' '),1,0,'C',$fond);
            //$pdf->SetXY(3,$pdf->GetY()+1);
            $fond=!$fond;
        }

        $fond=0;
        $pdf->SetXY(1,$pdf->GetY()+0.8);
        $pdf->cell(25,0.7,$header3[0],0,0,'L',$fond);


        $this->query("SELECT * FROM recette2 WHERE (dator BETWEEN ? AND ? )  AND type='virR'");
        $this->bind(1,$dator1);
        $this->bind(2,$dator2);
        $rows=$this->resultSet();

        $pdf->SetFillColor(0xdd,0xdd,0xdd);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Times','B',10);
        $pdf->SetXY(1,$pdf->GetY()+0.8);
        $fond=0;

        foreach($rows as $row3)
        {
            $pdf->cell(2,0.6,$row3['dator'],1,0,'C',$fond);
            $pdf->cell(1.5,0.6,$row3['quit1'],1,0,'C',$fond);
            $pdf->cell(1.5,0.6,$row3['quit2'],1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row3['v31'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row3['v32'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row3['v33'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row3['v11'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row3['v14'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row3['v15'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row3['v51'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row3['v81'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.6,number_format($row3['v31']+$row3['v32']+$row3['v33']+$row3['v11']+$row3['v14']+$row3['v15']+$row3['v51']+$row3['v81'],2,',',' '),1,0,'C',$fond);
            $pdf->SetXY(1,$pdf->GetY()+0.6);
            //$fond=!$fond;
        }

        $this->query("SELECT  SUM(v31) as Totalv31, SUM(v32) as Totalv32, SUM(v33) as Totalv33, SUM(v11) as Totalv11, SUM(v14) as Totalv14, SUM(v15) as Totalv15, SUM(v51) as Totalv51, SUM(v81) as Totalv81 FROM recette2 WHERE type='virR' AND  (dator BETWEEN ? AND ? )");
        $this->bind(1,$dator1);
        $this->bind(2,$dator2);
        $rows=$this->resultSet();


        $fond=1;
        foreach($rows as $tot3)
        {
            $pdf->cell(5,0.7,"TOTAL 3",1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot3['Totalv31'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot3['Totalv32'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot3['Totalv33'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot3['Totalv11'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot3['Totalv14'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot3['Totalv15'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot3['Totalv51'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot3['Totalv81'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot3['Totalv31']+$tot3['Totalv32']+$tot3['Totalv33']+$tot3['Totalv11']+$tot3['Totalv14']+$tot3['Totalv15']+$tot3['Totalv51']+$tot3['Totalv81'],2,',',' '),1,0,'C',$fond);
            $pdf->SetXY(1,$pdf->GetY()+1);
            $fond=!$fond;
        }

        $this->query("SELECT SUM(v31) as Total31, SUM(v32) as Total32, SUM(v33) as Total33, SUM(v11) as Total11, SUM(v14) as Total14, SUM(v15) as Total15, SUM(v51) as Total51, SUM(v81) as Total81 FROM recette2 WHERE (dator BETWEEN ? AND ? )");
        $this->bind(1,$dator1);
        $this->bind(2,$dator2);
        $rows=$this->resultSet();

        $mt=0;
        $fond=1;
        foreach($rows as $tot4)
        {
            $pdf->cell(5,0.7,"TOTAL GENERAL",1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot4['Total31'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot4['Total32'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot4['Total33'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot4['Total11'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot4['Total14'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot4['Total15'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot4['Total51'],2,',',' '),1,0,'C',$fond);
            $pdf->cell(2.5,0.7,number_format($tot4['Total81'],2,',',' '),1,0,'C',$fond);
            $mt=$tot4['Total31']+$tot4['Total32']+$tot4['Total33']+$tot4['Total11']+$tot4['Total14']+$tot4['Total15']+$tot4['Total51']+$tot4['Total51']+$tot4['Total81'];
            $a=number_format($mt,2,',',' ');
            $pdf->cell(2.5,0.7,$a,1,0,'C',$fond);
            $pdf->SetXY(1,$pdf->GetY()+1);
            $fond=!$fond;
        }
        $aa=convertir( $mt);

        $headA="ARRETE LE PRESENT BORDEREAU D IMPUTATION A LA SOMME DE: \n$aa";
        $pdf->MultiCell(26.5,0.6,$headA,0,'C',0);
        $pdf->SetXY(3,$pdf->GetY()+0.7);
        $fond=!$fond;

        $headd="SOUS ORDONNATEUR";
        $fond=0;
        $pdf->SetXY(11,18,3);
        $pdf->Cell(15,0.6,$headd,0,'R',0,$fond);
        "\n";

        $pdf->output();
    }
    public function FlotBarChart(){

        $this->query('SELECT SUM(`v31`+`v32`+`v33`+`v11`+`v14`+`v15`+`v51`+`v81`) as total , MONTH(dator) as mois FROM `recette2` WHERE  year(dator)= 2017 GROUP BY MONTH(dator) ORDER by MONTH(dator) ASC  ');
        $rows=$this->resultSet();
        foreach($rows as $row){
            tab[]
        }
    }
}
