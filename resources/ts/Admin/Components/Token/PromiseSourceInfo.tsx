import * as React from 'react';
import { Component } from 'react';
import { PromiseData } from '../../../Interfaces';

import { 
	Flex,
	Spinner,
} from '@wordpress/components';

interface PromiseSourceInfoProps {
	promise: PromiseData;
	sources: any; 
	loadingSources: boolean;
}

interface PromiseSourceInfoState {
	//
}

export default class PromiseSourceInfo extends Component<PromiseSourceInfoProps, PromiseSourceInfoState> {

	constructor( props: PromiseSourceInfoProps ) {
		super( props );
		this.getPromiseSource = this.getPromiseSource.bind( this );
		this.sourceExists = this.sourceExists.bind( this );
	}
	
	getPromiseSource( promiseItem: any ) {
		let address = promiseItem.source_id;
		const source = this.props.sources[ promiseItem.source_id ] ?? null;
		if ( source ) {
			address = source?.address?.label;
		}
		return address;
	}
	
	sourceExists( promiseItem: any ) {
		const source = this.props.sources[ promiseItem.source_id ] ?? null;
		if ( source ) {
			return true;
		} else {
			return false;
		}
	}

	render() {
		return (
			<Flex>
				<div>
					<span>Source: </span>
					{ !this.props.loadingSources &&
						<span>
							{ this.sourceExists( this.props.promise )
								?	<a href={`/wp-admin/admin.php?page=tokenly-token-source-show&source=${this.props.promise.source_id}`}>
										<strong>{ this.getPromiseSource( this.props.promise ) }</strong>
									</a>
								: 	<span><strong>{ this.props.promise.source_id }</strong></span>
							}
						</span>
					}
					<span style={{visibility: this.props.loadingSources ? 'visible' : 'hidden'}}><Spinner /></span>
				</div>
			</Flex>
		);
	}
}
 

