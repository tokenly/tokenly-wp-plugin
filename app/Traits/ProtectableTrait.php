<?php

namespace Tokenly\Wp\Traits;

use Tokenly\Wp\Collections\Token\Access\RuleCollection;
use Tokenly\Wp\Collections\Token\Access\RuleCollectionCollection;
use Tokenly\Wp\Interfaces\Collections\Token\Access\RuleCollectionInterface;
use Tokenly\Wp\Interfaces\Collections\Token\Access\RuleCollectionCollectionInterface;

/**
 * Common logic for entities which can be protected by TCA.
 */
trait ProtectableTrait {
	/**
	 * Associated TCA rules
	 * @var RuleCollectionInterface
	 */
	protected ?RuleCollectionInterface $tca_rules = null;

	public function get_tca_rules(): ?RuleCollectionInterface {
		return $this->tca_rules ?? null;
	}

	public function set_tca_rules( ?RuleCollectionInterface $value ): void {
		$this->tca_rules = $value;
	}

	protected function protectable_from_array( array $data = array() ): array {
		if ( isset( $data['tca_rules'] ) && is_array( $data['tca_rules'] ) ) {
			$data['tca_rules'] = ( new RuleCollection() )->from_array( $data['tca_rules'] );
		}
		return $data;
	}

	protected function protectable_to_array(): array {
		$array = array();
		if ( $this->get_tca_rules() ) {
			$array['tca_rules'] = $this->get_tca_rules()->to_array();
		}
		return $array;
	}

	protected function protectable_get_fillable(): array {
		return array(
			'tca_rules',
		);
	}
}
