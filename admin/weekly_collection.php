<?php
//include '../lib/DbManager.php';
include '../body/header.php';
?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">

    <!-- Main content -->
    <section class="content box">


        <div class="row">

            <div class="center">
                <h2><?php echo $companyName; ?></h2>
                <h3>Weekly Report</h3>
            </div>

            <div class="table-responsive">

                <table style="font-size: 11px;" class="table">
                    <thead>
                        <tr class="second-header">
                            <th rowspan="2">S/N</th>
                            <th rowspan="2">Name</th>
                            <th colspan="5">2 Years Deposit</th>
                            <th colspan="5">4 Years Deposit</th>
                            <th colspan="5">Weekly Deposit</th>
                            <th colspan="5">Monthly Deposit</th>
                            <th colspan="5">Child Deposit</th>
                            <th colspan="5">DPS</th>
                            <th colspan="2">Total</th>
                        </tr>
                        <tr class="second-header">
                            <th>No</th>
                            <th>OP Bala</th>
                            <th>Collection</th>
                            <th>Disburse</th>
                            <th>Balance</th>

                            <th>No</th>
                            <th>OP Bala</th>
                            <th>Collection</th>
                            <th>Disburse</th>
                            <th>Balance</th>

                            <th>No</th>
                            <th>OP Bala</th>
                            <th>Collection</th>
                            <th>Disburse</th>
                            <th>Balance</th>

                            <th>No</th>
                            <th>OP Bala</th>
                            <th>Collection</th>
                            <th>Disburse</th>
                            <th>Balance</th>

                            <th>No</th>
                            <th>OP Bala</th>
                            <th>Collection</th>
                            <th>Disburse</th>
                            <th>Balance</th>

                            <th>No</th>
                            <th>Last Balance</th>
                            <th>Collection</th>
                            <th>Disburse</th>
                            <th>Balance</th>

                            <th>No</th>
                            <th>Balance</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>01</td>
                            <td>Ziya</td>
                            <td>26</td>
                            <td>25</td>
                            <td>544950</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Grand Total</td>
                            <td></td>
                            <td>26</td>
                            <td>25</td>
                            <td>544950</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <br>
            <div class="table-responsive">
                <table class="table table-condensed table-striped table-bordered bootstrap-datatable datatable">
                    <thead>
                        <tr class="second-header">
                            <th rowspan="2">S/N</th>
                            <th rowspan="2">Worker Name</th>
                            <th colspan="6">First Loan</th>
                            <th colspan="6">Weekly Loan</th>
                            <th colspan="6">Monthly Loan</th>
                            <th colspan="3">Due Loan</th>
                        </tr>
                        <tr class="second-header">
                            <th>Total Loan</th>
                            <th>Total Receive</th>
                            <th>Last Balance</th>
                            <th>Disburse</th>
                            <th>Collection</th>
                            <th>Balance</th>

                            <th>Total Loan</th>
                            <th>Total Receive</th>
                            <th>Last Balance</th>
                            <th>Disburse</th>
                            <th>Collection</th>
                            <th>Balance</th>

                            <th>Total Loan</th>
                            <th>Total Receive</th>
                            <th>Last Balance</th>
                            <th>Disburse</th>
                            <th>Collection</th>
                            <th>Balance</th>

                            <th>First Loan</th>
                            <th>Weekly Receive</th>
                            <th>Monthly Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result) {

                            while ($row = $result->fetch_object()) {
                                ?>
                                <tr>
                                    <td><?php echo ++$sl; ?></td>
                                    <td>Ziya</td>
                                    <td>26</td>
                                    <td>25</td>
                                    <td>2000</td>
                                    <td>3000</td>
                                    <td>5000</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                <?php
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Grand Total</td>
                            <td>Ziya</td>
                            <td>26</td>
                            <td>25</td>
                            <td>2000</td>
                            <td>3000</td>
                            <td>5000</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </section><!-- /.content -->
</aside><!-- /.right-side -->




<?php include '../body/footer.php'; ?>
