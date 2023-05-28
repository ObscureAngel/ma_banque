<?php

$ls_query = "SELECT * FROM mb_operation
JOIN mb_compte ON mp_compte.bi_idCompte = mb_operation.bi_idCompteOperation
";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ma Banque</title>
</head>
<body>
	<header>
		<h1>Ma Banque, l'interface de gestion bancaire en local</h1>
	</header>

	<div class="nav">
		<ul>
			<li>Tableau de bord</li>
			<li>Téléverser un relevé</li>
			<li>Réaliser un pointage</li>
		</ul>
	</div>

	<div>
		<h2>Dernières opérations</h2>
		<table>
			<thead>
				<tr>
					<th>Date</th>
					<th>Nom de l'opération</th>
					<th>Compte</th>
					<th>Crédit</th>
					<th>Débit</th>
				</tr>
			</thead>
		</table>
	</div>

	<footer>

	</footer>
</body>
</html>