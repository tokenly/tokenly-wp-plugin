import * as React from 'react';
import { Component } from 'react';

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

	constructor( props: SourceInfoProps ) {
		super( props );
	}

	render() {
		return (
			<Flex style={ { width: '100%', alignItems: 'center' } }>
				<div style={ { flex: 1 } }>
					<div><span>Type: </span><strong>{ this.props.source.type }</strong></div>
					<div><span>Address: </span><strong>{ this.props.source.address_id }</strong></div>
					<div><span>Assets (whitelisted): </span><strong>{ this.props.source.assets ?? 'all' }</strong></div>
				</div>
			</Flex>
		);
	}
}
