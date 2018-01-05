<!-- @extends(layout) -->

<!-- @placing(content) -->
<div>
	<table>
		<tr>
			<th>Id</th>
			<th>Customer</th>
			<th>Amount</th>
			<th>VAT</th>
			<th>Amount including tax</th>
			<th>Date</th>
			<th>Status</th>
		</tr>
	<?php foreach($invoices as $invoice) : ?>
		<tr>
			<td><?=$invoice->getId() ?></td>
			<td><a href="/invoice/<?=$invoice->getId()?>"><?=$invoice->getClient() ?></td>
			<td><?=number_format((float)$invoice->getAmountWithoutTax(), 2, '.', '') ?> €</td>
			<td><?=(int)$invoice->getTaxRate() ?> %</td>
			<td><?=number_format((float)$invoice->getAmountWithTax(), 2, '.', '') ?> €</td>
			<td><?=$invoice->getDate() ?></td>
			<td><?=$invoice->getStatus() ?></td>
		</tr>
	<?php endforeach ?>
	</table>
	<div class="full_width">
		<?php for ($i=1; $i <= $totalPages; $i++) { ?>
			<span><a href="?page=<?=$i?>"><?=$i?></a></span>
		<?php } ?>
	</div>
</div>
