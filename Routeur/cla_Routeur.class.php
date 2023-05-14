<?php

namespace MaBanque\Routeur;

use MaBanque\Routeur\cla_Route;

class cla_Routeur {

	private array $ca_route;

	public function fct_resolve($ps_cheminUrl) {
		// ma_banque/dashboard
		// ma_banque/releve/upload
		$fa_param = explode('/', substr($ps_cheminUrl, 20));

	}
}