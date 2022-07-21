<?php

namespace Tokenly\Wp\Models\Credit;

use Tokenly\Wp\Models\Model;
use Tokenly\Wp\Interfaces\Models\Credit\TransactionReportInterface;

use Tokenly\Wp\Collections\Credit\TransactionCollection;
use Tokenly\Wp\Interfaces\Collections\Credit\TransactionCollectionInterface;

class TransactionReport extends Model implements TransactionReportInterface {
	protected ?TransactionCollectionInterface $credit = null;
	protected ?TransactionCollectionInterface $debit = null;

	/**
	 * @inheritDoc
	 */
	public function from_array( array $data = array() ): self {
		if ( isset( $data['debit'] ) && is_array( $data['debit'] ) ) {
			$data['debit'] = ( new TransactionCollection() )->from_array( $data['debit'] );
		}
		if ( isset( $data['credit'] ) && is_array( $data['credit'] ) ) {
			$data['credit'] = ( new TransactionCollection() )->from_array( $data['credit'] );
		}
		return parent::from_array( $data );
	}

	/**
	 * @inheritDoc
	 */
	public function to_array(): array {
		$array = array();
		if ( $this->debit ) {
			$array['debit'] = $this->debit->to_array();
		}
		if ( $this->credit ) {
			$array['credit'] = $this->credit->to_array();
		}
		return $array;
	}

	/**
	 * @inheritDoc
	 */
	protected function get_fillable(): array {
		return array_merge( parent::get_fillable(), array(
			'credit',
			'debit',
		) );
	}
}
