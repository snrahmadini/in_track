<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Attendance Report</title>
</head>

<body>
<div class="container border">
    <div class="row mb-2">
        <div class="col">
            <h2 class="text-center">Intern Tracker Report</h2>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-6">
            <h1 class="h5">Division Code : <?= $dept ?></h1>
        </div>
        <div class="col-6 text-right">
            <?php if ($start != null || $end != null) : ?>
                <h1 class="h5">From: <i><?= $start; ?></i> To: <i><?= $end; ?></i></h1>
            <?php else : ?>
                <h1 class="h5">All</h1>
            <?php endif; ?>
        </div>
    </div>
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th>No.</th>
            <th>Date</th>
            <th>Name</th>
            <th>Notes</th>
            <th>In Status</th>
        </tr>
        </thead>
        <tbody>
        <?php

        // looping attendance list
        $i = 1;
        foreach ($attendance as $atd) :
            ?>
            <tr <?php if (date('l', $atd['date']) == 'Saturday' || date('l', $atd['date']) == 'Sunday') {
                echo "class ='bg-secondary text-white'";
            } ?>>

                <!-- Kolom 1 -->
                <td><?= $i++; ?></td>
                <?php

                // if WEEKENDS
                if (date('l', $atd['date']) == 'Saturday' || date('l', $atd['date']) == 'Sunday') : ?>
                    <!-- Kolom 2 -->
                    <td colspan="6" class="text-center">OFF</td>
                <?php

                // if WEEKDAYS
                else : ?>
                    <!-- Kolom 2 (Date) -->
                    <td><?= date('l, d F Y', $atd['date']); ?></td>

                    <!-- Kolom 7 (Name) -->
                    <td><?= $atd['name']; ?></td>

                    <!-- Kolom 5 (Notes) -->
                    <td><?= $atd['notes']; ?></td>


                    <!-- Kolom 8 (In Status) -->
                    <td><?= $atd['in_status']; ?></td>

                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>


<!-- Optional JavaScript -->
<script>
    window.print();
</script>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
        crossorigin="anonymous"></script>
</body>

</html>