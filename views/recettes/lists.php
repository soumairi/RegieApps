<?php
/**
 * Created by PhpStorm.
 * User: Mouhssine Soumairi
 * Date: 17/02/2017
 * Time: 20:02
 */

?>
<div class="card-title-block">
    <h3 class="title">O.R. - R&eacute;gularisation des Sommes Encaiss&eacute;es </h3>
</div>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" class="form-inline">
    <div class="form-group"><input class="form-control" value="1" name="id" type="hidden">
        <input class="form-control" id="dator1" name="dator1" type="text"></div>
    <div class="form-group"><input class="form-control" id="dator2" name="dator2" type="text"></div>
    <div class="form-group">
        <input type="submit" class="btn btn-pill-right btn-info" value="Rechercher" name="submit">
    </div>
    <a class="btn btn-success btn-share pull-right" href="<?php echo ROOT_PATH; ?>recettes/etatdumois/<?php
    if (isset($_POST[dator1]) && isset($_POST[dator2])){
        echo $_POST[dator1].'s'.$_POST[dator2];
    }else{

        if(isset($param[1]) && isset($param[2]) ){
            echo $param[1].'s'.$param[2];
        }
    }

    ?>" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>

</form>
<section class="example">


    <div class="table-flip-scroll">


        <br/>

        <table
            class="table table-striped table-bordered table-hover flip-content">
            <thead>
            <tr>
                <th>R&eacute;f&eacute;rence</th>
                <th>Date OR</th>
                <th>Nature</th>
                <th>Montant Total</th>
                <th class="action"></th>
            </tr>
            </thead>
            <tbody>
            <?php $data = $viewmodel[1];

            foreach ($data as $item) :
                ?>

                <tr class="odd gradeX">
                    <td>du <?php echo $item['quit1']; ?> au <?php echo $item['quit2']; ?></td>
                    <td align="center"><?php echo $item['dator']; ?></td>
                    <td align="center"><?php $type=array(
                            'verN'=>'Versements en Num&eacute;raire',
                            'verC'=>'Ch&eacute;que',
                            'virR'=>'Virements Re&ccedil;us'
                        ); echo $type[$item['type']]; ?></td>
                    <td align="center"><?php

                        $total = $item ['v31'] + $item ['v32'] + $item ['v33'] + $item ['v11'] + $item ['v14'] + $item ['v15'] + $item ['v51'] + $item ['v81'];
                        echo number_format($total, 2, ',', ' ');

                        ?></td>

                    <td><a
                           href="<?php echo ROOT_PATH; ?>recettes/modifier/<?php echo($item['id']); ?>"><em
                                class="fa fa-pencil-square-o text-success"></em></a>
                        <a  href="#" data-toggle="modal" data-target="#confirm-modal<?php echo($item['id']); ?>"
                        ><em class="fa fa-trash-o text-danger "></em></a>
                        <a
                        href="<?php echo ROOT_PATH; ?>recettes/etatdujour/<?php echo($item['dator']); ?>" target="_blank"><em
                            class="fa fa-file-pdf-o"></em></a>

                        <div class="modal fade" id="confirm-modal<?php echo($item['id']); ?>" >
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header "> <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <h4 class="modal-title"><i class="fa fa-warning"></i> Attention</h4> </div>
                                    <div class="modal-body">
                                        <p>Voulez vos vraiment supprimer cette recette ?</p>
                                    </div>
                                    <div class="modal-footer"> <a href="<?php echo ROOT_PATH; ?>recettes/delete/<?php echo($item['id']); ?>" type="button" class="btn btn-primary" >Oui</a> <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button> </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>

                    </td>

                </tr>

                <?php


            endforeach;
            ?>


            </tbody>
        </table>
    </div>
</section>
<nav class="text-xs-right">
    <?php $post = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
    $param=explode('s',$post['id']);
    if (isset($param[0])){
        $page=$param[0];
    }
    ?>
    <ul class="pagination">
        <?php if ($page>1){?>
        <li class="page-item"><a class="page-link" href="<?php echo ROOT_PATH; ?>recettes/lists/<?php echo $page-1; ?><?php
            if (isset($_POST[dator1]) && isset($_POST[dator2])){
                echo 's'.$_POST[dator1].'s'.$_POST[dator2];
            }else{

                if(isset($param[1]) && isset($param[2]) ){
                    echo 's'.$param[1].'s'.$param[2];
                }
            }

            ?>">
                <em class="fa fa-chevron-left"></em>
            </a></li>
        <?php }  ?>
        <?php $numbers = $viewmodel[0];
        if (count($numbers)>16)  {
            if($page>6){
                $debut=$page-5;
                if($page<(count($numbers)-11)){
                    $fin=$page+11;
                }else{
                    $fin=count($numbers);
                }

            }else{
                $debut=1;
                $fin=15;
            }
        }else{
            $debut=1;
            $fin=count($numbers);
        }
        $i=0;

        for($n=$debut; $n<$fin+1; $n++) {

            ?>

            <li class="page-item <?php if($page==$n){echo 'active';} ?>"><a class="page-link " href="<?php echo ROOT_PATH; ?>recettes/lists/<?php echo $n; ?><?php
                if (isset($_POST[dator1]) && isset($_POST[dator2])){
                    echo 's'.$_POST[dator1].'s'.$_POST[dator2];
                }else{

                if(isset($param[1]) && isset($param[2]) ){
                    echo 's'.$param[1].'s'.$param[2];
                }
                }

                ?>">
                    <?php
                    echo $n;
                    ?>
                </a></li>

            <?php
            $i=$n;
        }

        ?>
        <?php if ($page<count($numbers)){?>
            <li class="page-item"><a class="page-link" href="<?php echo ROOT_PATH; ?>recettes/lists/<?php echo $page+1; ?><?php
                if (isset($_POST[dator1]) && isset($_POST[dator2])){
                    echo 's'.$_POST[dator1].'s'.$_POST[dator2];
                }else{

                    if(isset($param[1]) && isset($param[2]) ){
                        echo 's'.$param[1].'s'.$param[2];
                    }
                }

                ?>">
                    <em class="fa fa-chevron-right"></em>
                </a></li>
        <?php } ?>
    </ul>
</nav>

