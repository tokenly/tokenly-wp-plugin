import { resolve } from 'inversify-react';
import * as React from 'react';
import { Component } from 'react';
import { PromiseData } from '../../../Interfaces';
import * as dayjs from 'dayjs'

import { 
	// @ts-ignore
	Modal,
} from '@wordpress/components';

interface PromiseDetailsModalProps {
	promise: PromiseData;
	onRequestClose: any;
}

interface PromiseDetailsModalState {
	keywords: string;
	user: number;
	users: Array<ComboboxOption>;
}

interface ComboboxOption {
	value: string,
	label: string,
}

export default class PromiseDetailsModal extends Component<PromiseDetailsModalProps, PromiseDetailsModalState> {
	constructor( props: PromiseDetailsModalProps ) {
		super( props );
		this.onRequestClose = this.onRequestClose.bind( this );
	}

	onRequestClose() {
		this.props.onRequestClose();
	}

	dateFormatted( date: Date ) {
		if ( date ) {
			return dayjs( date ).format( 'MMMM D, YYYY h:mm A' )
		}
		return;
	}
	
	render() {
		return (
			<Modal title={`Promise № ${this.props.promise.promise_id}`} onRequestClose={ this.onRequestClose }>
				<div><span>Source: </span><span><strong>{this.props.promise.source}</strong></span></div>
				<div><span>Destination: </span><span><strong>{this.props.promise.destination}</strong></span></div>
				<div><span>Asset: </span><span><strong>{this.props.promise.asset}</strong></span></div>
				<div><span>Quantity: </span><span><strong>{this.props.promise.quantity}</strong></span></div>
				<div><span>Ref: </span><span><strong>{this.props.promise.ref}</strong></span></div>
				<div><span>Note: </span><span><strong>{this.props.promise.note}</strong></span></div>
				<div><span>Created at: </span><span><strong>{this.dateFormatted( this.props.promise.created_at ) }</strong></span></div>
				<div><span>Updated at: </span><span><strong>{this.dateFormatted( this.props.promise.updated_at ) }</strong></span></div>
			</Modal>
		);
	}
}
