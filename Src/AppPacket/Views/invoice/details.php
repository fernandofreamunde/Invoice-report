<!-- @extends(layout) -->

<!-- @placing(content) -->
<div>
	<div class="full_width">
		<label>Customer Name:</label>
		<span><?=$invoice->getClient()?></span>
		<span class="right padded bg-grey" id="status" onclick="toggleStatus()">
			<label>Invoice Status:</label>
			<?php $color = $invoice->getStatus() == 'paid'? 'green': 'red'; ?>
			<span id="statusVal" class="<?=$color?>"><?=$invoice->getStatus()?></span>
		</span>
	</div>
	<table>
		<tr>
			<th>Product Name</th>
			<th>Amount</th>
			<th>Date</th>
		</tr>
	<?php foreach($items as $item) : ?>
		<tr>
			<td><?=$item->getName() ?></td>
			<td><?=number_format((float)$item->getAmount(), 2, '.', '') ?> €</td>
			<td><?=$item->getCreatedAt() ?></td>
		</tr>
	<?php endforeach ?>
		<tr>
			<td><b>Invoice Total</b></td>
			<td colspan="2"><?=number_format((float)$invoice->getAmountWithoutTax(), 2, '.', '') ?> €</td>

		</tr>
	</table>

</div>
<script>

var id = <?=$invoice->getId()?>;
var paid = <?=$invoice->getStatus() == 'paid'? 'true': 'false'; ?>;

if (paid) {
    action = 'unpaid';
    paid = false;
}else {
	action = 'paid';
	paid = true;
}

function toggleStatus() {
    $.ajax
    ({
        type: "POST",
        url: '/invoice/'+id+'/status',
        dataType: 'json',
        async: false,
        data: '{"value": "' + action + '"}',
        success: function () {
        	$('#statusVal').text(action);
        	$('#statusVal').toggleClass('red');
        	$('#statusVal').toggleClass('green');
        }
    })
}
</script>