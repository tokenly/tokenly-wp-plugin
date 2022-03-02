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
	protected ?bool $status = false;
	/**
	 * Comment for the status.
	 * @var string
	 */
	protected ?string $note = '';
	/**
	 * Reports the decision was based on if any.
	 * @var RuleCheckResultCollectionInterface
	 */
	protected ?RuleCheckResultCollectionInterface $reports;

	public function get_status(): ?bool {
		return $this->status ?? null;
	}

	public function set_status( ?bool $value ): void {
		$this->status = $value;
	}

	public function get_note(): ?string {
		return $this->note ?? null;
	}

	public function set_note( ?string $value ): void {
		$this->note = $value;
	}

	public function get_reports(): ?RuleCheckResultCollectionInterface {
		return $this->reports ?? null;
	}

	public function set_reports( ?RuleCheckResultCollectionInterface $value ): void {
		$this->reports = $value;
	}

	/**
	 * @inheritDoc
	 */
	public function from_array( array $data = array() ): self {
		if ( isset( $data['reports'] ) && is_array( $data['reports'] ) ) {
			$data['reports'] = ( new RuleCheckResultCollection() )->from_array( $data['reports'] );
		}
		return parent::from_array( $data );
	}

	/**
	 * @inheritDoc
	 */
	public function to_array(): array {
		$array = array(
			'status' => $this->get_status(),
			'note'   => $this->get_note(),
		);
		if ( $this->get_reports() ) {
			$array['reports'] = $this->get_reports()->to_array();
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
