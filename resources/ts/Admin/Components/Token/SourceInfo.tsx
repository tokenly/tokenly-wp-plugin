import * as React from 'react';
import { Component } from 'react';
import { resolve } from 'inversify-react';
import { TYPES } from '../../../Types';

import { 
	Flex,
} from '@wordpress/components';

interface SourceInfoProps {
	source: any;
}

interface SourceInfoState {
	//
}

export default class SourceInfo extends Component<SourceInfoProps, SourceInfoState> {
	@resolve( TYPES.Variables.adminPageUrl )
	adminPageUrl: string;
	@resolve( TYPES.Variables.namespace )
	namespace: string;

	constructor( props: SourceInfoProps ) {
		super( props );
		console.log(this.props.source);
	}

	render() {
		return (
			<Flex style={ { width: '100%', alignItems: 'center' } }>
				<div style={ { flex: 1 } }>
					<div>
						<span>Type: </span>
						<b>{ this.props.source?.type }</b>
					</div>
					<div>
						<span>Address: </span>
						<b>
							<a 
								href={ `${this.adminPageUrl}${this.namespace}-token-address-show&id=${this.props.source?.address_id}` }>
									{ this.props.source?.address?.label ?? this.props.source?.address_id }
							</a>
						</b>
					</div>
					<div>
						<span>Assets (whitelisted): </span>
						<b>{ this.props.source?.assets ?? 'all' }</b>
					</div>
				</div>
			</Flex>
		);
	}
}
