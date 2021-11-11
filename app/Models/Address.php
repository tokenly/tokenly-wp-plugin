<?php

namespace Tokenly\Wp\Models;

use Tokenly\Wp\Interfaces\Models\AddressInterface;

class Address implements AddressInterface {
	address	string	Bitcoin address
	balances	array	Array of token balances in format Asset => Quantity
	public	boolean	If this address is set to public or not
	label	string	Optional display label
}
