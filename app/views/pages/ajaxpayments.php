<table class="table table-condensed align-items-center table-striped" style="font-size: 12px">
    <thead>
    <tr>
        <th>Name</th>
        <th>Account No:</th>
        <th>Telephone </th>
        <th>Amount Paid</th>
        <th>Payment Date</th>
    </tr>
    </thead>
    <?php foreach ($data['allpayments'] as $get):   ?>
        <tr>
            <td><a href="<?php echo URLROOT.'/pages/customerprofile/'.$get->bid  ?>"><?php echo $get->fullname ?></td>
            <td><?php echo $get->accountnumber ?></td>
            <td><?php echo $get->telephone ?></td>
            <td><?php echo $get->amount ?></td>
            <td><?php echo $get->dateofpayment ?></td>

        </tr>
    <?php  endforeach;  ?>



</table>