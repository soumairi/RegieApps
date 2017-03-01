<?php
/**
 * Created by PhpStorm.
 * User: Mouhssine Soumairi
 * Date: 17/02/2017
 * Time: 20:02
 */
if (isset($_POST['annee'])){ 
	$annee=$_POST['annee'];
}else{ 
	$annee="";
	}
?>
<div class="card-title-block">
	<h3 class="title">Registre de Suivi des Emissions des O.R. </h3>
</div>

<section class="example">


	<div class="table-flip-scroll">
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post"
		class="form-inline ">
				
			<div class="input-group">
                                                    <input id="annee" name="annee" class="form-control" size="16" type="text">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="submit" name="submit"><i class="fa fa-search"></i></button>
                                                    </span>
                                             
                                             
                                               </div>
                                               <a class="btn btn-success btn-share pull-right" href="<?php echo ROOT_PATH; ?>recettes/etatannuel/<?php echo $annee; ?>"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                                             
		</form>
		
		
		<table class="table table-striped table-bordered table-hover flip-content">
			<thead >
				<tr>
					<th>Mois</th>
					<th>Date d'emission</th>
					<th>N&deg; OR</th>
					<th>Montant Total</th>
					<th>Cumul</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
            <?php
												
												$i = 1;
												$cumul = 0;
												
												$out = array (
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
												
												foreach ( $viewmodel as $item ) :
													?>

                <tr class="odd gradeX">
					<td><?php echo $out[$item['mois']]; ?></td>
					<td align="center"><?php echo $item['dateemis']; ?></td>
					<td align="center"><?php echo $i; ?></td>
					<td align="center"><?php
													
echo number_format ( $item ['total'], 2, ',', ' ' );
													$cumul = $cumul + $item ['total'];
													?></td>
					<td align="center"><?php echo number_format($cumul, 2, ',', ' '); ?></td>
					<td>
                        
                            <a data-toggle="modal"
						href="#myModall<?php echo($item['mois']); ?>"><em
							class="fa fa-calendar"></em></a>
						<div class="input-group"></div>

                            <?php
														
require ('modal.php');
													
													?>
                       
                    </td>

				</tr>

                <?php
													
$i ++;
												endforeach
												;
												?>


            </tbody>
		</table>
	</div>
</section>

