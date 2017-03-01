<?php $data = $viewmodel ;?>
<div class="card-title-block">
    <h3 class="title">Modifier Recette</h3>
</div>
<section class="example">
    <form action="<?php echo ROOT_PATH; ?>recettes/modifier" method="post"
          class="form-horizontal ">
        <div class="row">
            <div class="form-group col-sm-4">
                <label for="text-input">Quittance de d&eacute;part</label> <input
                    id="quit1" name="quit1" class="form-control"
                    value="<?php echo $data['quit1'] ;?>" type="text">
                <input
                    id="quit1" name="id" class="form-control"
                    value="<?php echo $data['id'] ;?>" type="hidden">
            </div>
            <div class="form-group col-sm-4">
                <label for="text-input">Quittance de fin</label> <input id="quit2"
                                                                        name="quit2" class="form-control" value="<?php echo $data['quit2'] ;?>"
                                                                        type="text">

            </div>
            <div class="form-group col-sm-4">
                <label for="text-input">Date d'orde de recette</label> <input
                    id="dator" name="dator" class="form-control"
                    value="<?php echo $data['dator'] ;?>" type="text">

            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3  form-control-label">Nature d'opr&eacute;ration</label>
            <div class="col-md-9">
                <label class="radio-inline" for="inline-radio1"> <input
                        id="inline-radio1" name="typeo" value="verN"  type="radio" <?php if($data['type']=='verN'){ echo "checked";} ?> >Versements
                    en Num&eacute;raire
                </label><label class="radio-inline" for="typeo"> <input
                        id="inline-radio2" name="typeo" value="verC" type="radio" <?php if($data['type']=='verC'){ echo "checked";} ?>>Ch&eacute;que
                </label><label class="radio-inline" for="typeo" > <input
                        id="inline-radio3" name="typeo" value="virR" type="radio" <?php if($data['type']=='virR'){ echo "checked";} ?>>Virements
                    Re&ccedil;us
                </label>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-3">
                <label for="text-input">712431</label>
                <div class="input-group">
                    <input id="v31" name="v31" class="form-control"
                           value="<?php echo $data['v31'] ;?>" type="text"> <span
                        class="input-group-addon">Dhs</span>
                </div>
            </div>
            <div class="form-group col-sm-3">
                <label for="text-input">712432</label>
                <div class="input-group">
                    <input id="v31" name="v32" class="form-control"
                           value="<?php echo $data['v32'] ;?>" type="text"> <span
                        class="input-group-addon">Dhs</span>
                </div>
            </div>
            <div class="form-group col-sm-3">
                <label for="text-input">712433 </label>
                <div class="input-group">
                    <input id="v31" name="v33" class="form-control"
                           value="<?php echo $data['v33'] ;?>" type="text"> <span
                        class="input-group-addon">Dhs</span>
                </div>
            </div>
            <div class="form-group col-sm-3">
                <label for="text-input">034211</label>
                <div class="input-group">
                    <input id="v31" name="v11" class="form-control"
                           value="<?php echo $data['v11'] ;?>" type="text"> <span
                        class="input-group-addon">Dhs</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-3">
                <label for="text-input">031214</label>
                <div class="input-group">
                    <input id="v31" name="v14" class="form-control"
                           value="<?php echo $data['v14'] ;?>" type="text"> <span
                        class="input-group-addon">Dhs</span>
                </div>
            </div>
            <div class="form-group col-sm-3">
                <label for="text-input">034215</label>
                <div class="input-group">
                    <input id="v31" name="v15" class="form-control"
                           value="<?php echo $data['v15'] ;?>" type="text"> <span
                        class="input-group-addon">Dhs</span>
                </div>
            </div>
            <div class="form-group col-sm-3">
                <label for="text-input">075851</label>
                <div class="input-group">
                    <input id="v31" name="v51" class="form-control"
                           value="<?php echo $data['v51'] ;?>" type="text"> <span
                        class="input-group-addon">Dhs</span>
                </div>
            </div>
            <div class="form-group col-sm-3">
                <label for="text-input">007381</label>
                <div class="input-group">
                    <input id="v31" name="v81" class="form-control"
                           value="<?php echo $data['v81'] ;?>" type="text"> <span
                        class="input-group-addon">Dhs</span>
                </div>
            </div>
        </div>
        <div class="card-footer">


            <input class="btn btn-sm btn-primary" name="submit" type="submit"
                   value="Enregistrer" />

            <button type="reset" class="btn btn-sm btn-danger">
                <i class="fa fa-ban"></i> Annuler
            </button>
        </div>
    </form>

</section>