
<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
<script src="js/script.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {


        var data = google.visualization.arrayToDataTable([
            ['Section','Count'],
            <?php
            $elements = ['Posts', 'Comments', 'Users', 'Categories'];
            $values = [$posts_count, $comments_count,$users_count, $categories_count];
            for ($i = 0; $i<4; $i++){
                echo "['{$elements[$i]}'". "," . "{$values[$i]}],";
            }
            ?>

        ]);

        var options = {
            chart: {
                title: '',
                subtitle: '',
            }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
</script>

</body>

</html>