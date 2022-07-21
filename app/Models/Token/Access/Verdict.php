<?php

namespace Tokenly\Wp\Models\Token\Access;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Token\Access\VerdictInterface;

use Tokenly\Wp\Collections\Token\Access\RuleCheckResultCollection;
use Tokenly\Wp\Interfaces\Collections\Token\Access\RuleCheckResultCollectionInterface;

/**
 * Is used to sum up all of the TCA access decision logic and provide the result
 * with detailed information.
 */
class Verdict extends Model implements VerdictInterface {
	/**
	 * Access status. Allowed or not.
	 * @var bool
	 */
	public ?bool $status = false;
	/**
	 * Comment for the status.
	 * @var string
	 */
	public ?string $note = '';
	/**
	 * Reports the decision was based on if any.
	 * @var RuleCheckResultCollectionInterface
	 */
	public ?RuleCheckResultCollectionInterface $reports;

	/**
	 * @inheritDoc
	 */
	public function from_array( array $data = array() ): self {
		if ( isset( $data['reports'] ) && is_array( $data['reports'] ) ) {
			$data['reports'] = 
				( new RuleCheckResultCollection() )->from_array(
					$data['reports']
				);
		}
		return parent::from_array( $data );
	}

	/**
	 * @inheritDoc
	 */
	public function to_array(): array {
		$array = array(
			'status' => $this->status,
			'note'   => $this->note,
		);
		if ( $this->reports ) {
			$array['reports'] = $this->reports->to_array();
		}
		return $array;
	}

	/**
	 * @inheritDoc
	 */
	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'status',
			'note',
			'reports',
		) );
	}
}
