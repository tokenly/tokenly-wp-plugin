<?php

namespace Tokenly\Wp\Interfaces\Models;

interface ModelInterface {
	public function fill( array $data = array() ): self;
	public function from_array( array $data = array() ): self;
	public function to_array(): array;
}
