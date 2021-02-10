<table class="table table-striped table-sm apptables" style="font-size: 12px">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Product</th>
        <th scope="col">Quantity</th>
        <th scope="col">Amount</th>
        <th scope="col">Total</th>

    </tr>
    </thead>
    <tbody>
    <?php
    $total =  0;
    $totalamt = 0;
    foreach ($data['invoicedata'] as $key=>$get):
        $total  = $total + $get->amount;
        $totalamt = ($get->amount * $get->quantity) + $totalamt;
        $pro =  new Product($get->productid);

        ?>
        <tr>
            <td><?php  echo $key+1 ?></td>
            <th><?php echo $pro->recordObject->productname ?></th>
            <td><?php  echo $get->quantity ?></td>
            <td><?php  echo $get->amount ?></td>
            <td><?php  echo $get->amount * $get->quantity ?></td>
        </tr>
    <?php  endforeach  ?>

    <tr>
        <td scope="col" colspan="5" style="font-weight: bold"><?php  echo 'Total: GHC '.number_format($totalamt,2)  ?></td>
    </tr>
    </tbody>
</table>