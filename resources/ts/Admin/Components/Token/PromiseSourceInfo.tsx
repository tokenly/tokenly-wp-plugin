import * as React from 'react';
import { Component } from 'react';
import { PromiseData } from '../../../Interfaces';
import { resolve } from 'inversify-react';
import { TYPES } from '../../../Types';

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
	@resolve( TYPES.Variables.adminPageUrl )
	adminPageUrl: string;
	@resolve( TYPES.Variables.namespace )
	namespace: string;

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
					<span>
						{ this.sourceExists( this.props.promise )
							?	<a href={`${this.adminPageUrl}${this.namespace}-token-source-show&source=${this.props.promise.source_id}`}>
									<b>{ this.getPromiseSource( this.props.promise ) }</b>
								</a>
							: 	<span><b>{ this.props.promise.source_id }</b></span>
						}
					</span>
				</div>
			</Flex>
		);
	}
}
 

