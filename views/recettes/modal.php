<?php
/**
 * Created by PhpStorm.
 * User: Mouhssine Soumairi
 * Date: 17/02/2017
 * Time: 20:45
 */
?>
<div class="modal fade" id="myModall<?php echo($item['mois']); ?>">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <?php         $out = array(0, 'Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre');
                ?>
                <h4 class="modal-title">L'emission de l'ordre de recette - <?php echo $out[$item['mois']]; ?>  </h4> </div>
            <form class="form"   action="<?php echo ROOT_PATH; ?>recettes/emis" method="POST">
                  <div class="modal-body ">



                          <p align="center">
                              <input type="hidden" name="mois"
                                     value="<?php echo $item['mois']; ?>">
                          </p>
              
                    <fieldset class="form-group"> <label for="exampleInputEmail3">Date d'emission</label> <input class="form-control" name="dateemis" id="dateemis" placeholder="" type="text"> </fieldset>



            </div>
            <div class="modal-footer"> <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button> <input class="btn btn-primary" name="submit" type="submit" type="button" class="btn btn-primary"> </div>
        </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- Modal -->
