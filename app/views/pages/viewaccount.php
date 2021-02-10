
<div><h3>Account Type: <?php  echo $data['type']  ?> </h3></div>

<table class="table table-striped apptables">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Account No:</th>
        <th scope="col">Amount </th>
        <th scope="col">Date Paid</th>

    </tr>
    </thead>
    <tbody>
    <?php
      $total =  0;
    foreach ($data['payments'] as $key=>$get):
         $total  = $total + $get->amount;
        ?>
        <tr>
            <td><?php  echo $key+1 ?></td>
            <th><?php echo $get->accountnumber ?></th>
            <td><?php  echo $get->amount ?></td>
            <td><?php  echo $get->dateofpayment ?></td>


        </tr>
    <?php  endforeach  ?>

    <tr>
        <td scope="col" colspan="4" style="font-weight: bold"><?php  echo 'Total: GHC '.number_format($total,2)  ?></td>


    </tr>
    </tbody>
</table>