import * as React from 'react';
import { Component } from 'react';
import { PromiseData } from '../../Interfaces';

import { 
	//
} from '@wordpress/components';

interface PromiseSourceInfoProps {
	promise: PromiseData;
	sources: any; 
}

interface PromiseSourceInfoState {
	//
}

export class PromiseSourceInfo extends Component<PromiseSourceInfoProps, PromiseSourceInfoState> {

	constructor( props: PromiseSourceInfoProps ) {
		super( props );
		this.getPromiseSource = this.getPromiseSource.bind( this );
		this.sourceExists = this.sourceExists.bind( this );
	}
	
	getPromiseSource( promiseItem: any ) {
		let address = promiseItem.source;
		const source = this.props.sources[ promiseItem.source ] ?? null;
		if ( source ) {
			address = source?.address_data?.label;
		}
		return address;
	}
	
	sourceExists( promiseItem: any ) {
		const source = this.props.sources[ promiseItem.source ] ?? null;
		if ( source ) {
			return true;
		} else {
			return false;
		}
	}

	render() {
		return (
			<div>
				<span>Source: </span>
				{ this.sourceExists( this.props.promise )
					? <a href={`/wp-admin/admin.php?page=tokenly-source-show&source=${this.props.promise.source}`}>
						<strong>{ this.getPromiseSource( this.props.promise ) }</strong>
					</a>
					: <span><strong>{ this.props.promise.source }</strong></span>
				}
			</div>
		);
	}
}
 

