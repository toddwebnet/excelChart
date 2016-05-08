<hr/>
<div class="col-md-6">
    <h3><?= $collection["title"] ?></h3>
    <table width="80%" border="1" align="center">
        <tr>
            <th><?= $collection["headerNumber"] ?></th>
            <th><?= $collection["headerLabel"] ?></th>
        </tr>
        <?php foreach ($collection["operantData"] as $item)
        { ?>
            <tr>
                <td><?= $item["value"] ?></td>
                <td><?= $item["label"] ?></td>
            </tr>
        <?php } ?>
    </table>
</div>
<div class="col-md-6">
    <div id="pie-chart">FusionCharts XT will load here!</div>
</div>
<script language="JavaScript">
    FusionCharts.ready(function ()
    {
        FusionCharts.ready(function ()
        {
            var revenueChart = new FusionCharts({
                type: 'pie3d',
                renderAt: 'pie-chart',
                width: '450',
                height: '300',
                dataFormat: 'json',
                dataSource: {
                    "chart": {
                        "caption": "<?=$collection["title"]?>",
                        //"subCaption": "Last year",
                        "numberPrefix": "$",
                        "showPercentValues": "1",
                        "showPercentInTooltip": "0",
                        "decimals": "1",
                        //Theme
                        "theme": "fint"
                    },
                    "data": <?=json_encode($collection["operantData"]);?>
                }
            }).render();

        });
    })
</script>