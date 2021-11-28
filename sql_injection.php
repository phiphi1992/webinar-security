<?php
require_once(dirname(__FILE__) . '/config.php');
require_once(dirname(__FILE__) . '/db.php');
$productID = isset($_GET['id']) && !empty($_GET['id']) ? $_GET['id'] : null;
?>
<style>
	table{
		width: 800px;
    	margin: 100px auto;
	}
	table, th, td {
	  border: 1px solid black;
	  padding: 10px;
	}
</style>
<?php if($productID):?>

	<?php
	try{
		// $productID = (int) $productID;
		// $productID = preg_replace('/[^a-zA-Z0-9]/', "", $productID);
		// $productID = $conn->quote($productID);
		$sql = "SELECT * FROM products where id={$productID}";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		$product = $stmt->fetch();
	} catch (Exception $e) {
		print_r($e->getMessage());
	}
	?>
	
	<table>
		<tr>
			<td width='100'>ID</td>
			<td><?=$product['id']?></td>
		</tr>
		<tr>
			<td width='100'>Code</td>
			<td><?=$product['code']?></td>
		</tr>
		<tr>
			<td width='100'>Product name</td>
			<td><?=$product['name']?></td>
		</tr>
	</table>

<?php else:?>

	<?php
		$stmt = $conn->prepare("SELECT * FROM products");
		$stmt->execute();
		$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		$products = $stmt->fetchAll();
	?>

	<table>
		<tr>
			<td>ID</td>
			<td>Code</td>
			<td>Product name</td>
			<td>CreatedAt</td>
			<td></td>
		</tr>
		<?php foreach($products as $product):?>
		<tr>
			<td><?=$product['id']?></td>
			<td><?=$product['code']?></td>
			<td><?=$product['name']?></td>
			<td><?=date('Y-m-d', $product['created_at'])?></td>
			<td><a href="?id=<?=$product['id']?>">Detail</a></td>
		</tr>
		<?php endforeach;?>
	</table>

<?php endif?>