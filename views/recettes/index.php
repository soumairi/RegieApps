<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-block">
                <div class="card-title-block">
                    <h3 class="title">
                        Bar Chart Example
                    </h3> </div>
                <section class="example">
                    <div class="flot-chart">
                        <div class="flot-chart-content" id="flot-bar-chart" style="padding: 0px; position: relative;"><canvas class="flot-base" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 420px; height: 225px;" width="420" height="225"></canvas><div class="flot-text" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; font-size: smaller; color: rgb(84, 84, 84);"><div class="flot-x-axis flot-x1-axis xAxis x1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;"><div style="position: absolute; max-width: 60px; top: 205px; left: 17px; text-align: center;" class="flot-tick-label tickLabel">1</div><div style="position: absolute; max-width: 60px; top: 205px; left: 87px; text-align: center;" class="flot-tick-label tickLabel">2</div><div style="position: absolute; max-width: 60px; top: 205px; left: 157px; text-align: center;" class="flot-tick-label tickLabel">3</div><div style="position: absolute; max-width: 60px; top: 205px; left: 227px; text-align: center;" class="flot-tick-label tickLabel">4</div><div style="position: absolute; max-width: 60px; top: 205px; left: 297px; text-align: center;" class="flot-tick-label tickLabel">5</div><div style="position: absolute; max-width: 60px; top: 205px; left: 367px; text-align: center;" class="flot-tick-label tickLabel">6</div></div><div class="flot-y-axis flot-y1-axis yAxis y1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;"><div style="position: absolute; top: 190px; left: 8px; text-align: right;" class="flot-tick-label tickLabel">0</div><div style="position: absolute; top: 152px; left: 0px; text-align: right;" class="flot-tick-label tickLabel">10</div><div style="position: absolute; top: 114px; left: 0px; text-align: right;" class="flot-tick-label tickLabel">20</div><div style="position: absolute; top: 76px; left: 0px; text-align: right;" class="flot-tick-label tickLabel">30</div><div style="position: absolute; top: 38px; left: 0px; text-align: right;" class="flot-tick-label tickLabel">40</div><div style="position: absolute; top: 0px; left: 0px; text-align: right;" class="flot-tick-label tickLabel">50</div></div></div><canvas class="flot-overlay" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 420px; height: 225px;" width="420" height="225"></canvas></div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-block">
                <div class="card-title-block">
                    <h3 class="title">
                        Line Cahrt Example
                    </h3> </div>
                <section class="example">
                    <div class="flot-chart">
                        <div class="flot-chart-content" id="flot-line-chart" style="padding: 0px; position: relative;"><canvas class="flot-base" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 420px; height: 225px;" width="420" height="225"></canvas><div class="flot-text" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; font-size: smaller; color: rgb(84, 84, 84);"><div class="flot-x-axis flot-x1-axis xAxis x1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;"><div style="position: absolute; max-width: 70px; top: 205px; left: 17px; text-align: center;" class="flot-tick-label tickLabel">1</div><div style="position: absolute; max-width: 70px; top: 205px; left: 95px; text-align: center;" class="flot-tick-label tickLabel">2</div><div style="position: absolute; max-width: 70px; top: 205px; left: 173px; text-align: center;" class="flot-tick-label tickLabel">3</div><div style="position: absolute; max-width: 70px; top: 205px; left: 252px; text-align: center;" class="flot-tick-label tickLabel">4</div><div style="position: absolute; max-width: 70px; top: 205px; left: 330px; text-align: center;" class="flot-tick-label tickLabel">5</div><div style="position: absolute; max-width: 70px; top: 205px; left: 409px; text-align: center;" class="flot-tick-label tickLabel">6</div></div><div class="flot-y-axis flot-y1-axis yAxis y1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;"><div style="position: absolute; top: 190px; left: 8px; text-align: right;" class="flot-tick-label tickLabel">0</div><div style="position: absolute; top: 152px; left: 0px; text-align: right;" class="flot-tick-label tickLabel">10</div><div style="position: absolute; top: 114px; left: 0px; text-align: right;" class="flot-tick-label tickLabel">20</div><div style="position: absolute; top: 76px; left: 0px; text-align: right;" class="flot-tick-label tickLabel">30</div><div style="position: absolute; top: 38px; left: 0px; text-align: right;" class="flot-tick-label tickLabel">40</div><div style="position: absolute; top: 0px; left: 0px; text-align: right;" class="flot-tick-label tickLabel">50</div></div></div><canvas class="flot-overlay" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 420px; height: 225px;" width="420" height="225"></canvas></div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>


<div>
    <?php if (isset($_SESSION['is_logged_in'])) :

        $_POST['annee'] = 2017;

        ?>
        <a class="btn btn-success btn-share" href="<?php echo ROOT_PATH; ?>shares/add">Share Something</a>
        <table class="table table-striped table-bordered table-condensed" align="center" width="99%">
            <thead border="1px" bgcolor="#E6E6E6">
            <tr class="success" align="center">
                <td>Mois</td>
                <td>Date Emis</td>
                <td>N_OR</td>
                <td>MT_OR</td>
                <td>Cumul</td>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($viewmodel as $item) : ?>

                <?php
                $i = 1;
                while ($i <= 12) {
                    ?>
                    <tr>
                        <td><?php echo $item[$i]['mois']; ?></td>
                        <td align="center"><?php echo $item[$i]['dateEmis']; ?></td>
                        <td align="center"><?php echo $item[$i]['numOr']; ?></td>
                        <td align="center"><?php echo number_format($item[$i]['total'], 2, ',', ' '); ?></td>
                        <td align="center"><?php echo number_format($item[$i]['cumul'], 2, ',', ' '); ?></td>
                    </tr>
                <?php } ?>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>