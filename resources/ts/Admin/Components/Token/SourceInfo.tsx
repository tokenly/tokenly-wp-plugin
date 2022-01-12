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
		console.log(this.props.source);
	}

	render() {
		return (
			<Flex style={ { width: '100%', alignItems: 'center' } }>
				<div style={ { flex: 1 } }>
					<div><span>Type: </span><b>{ this.props.source?.type }</b></div>
					<div><span>Address: </span><b>{ this.props.source?.address_id }</b></div>
					<div><span>Assets (whitelisted): </span><b>{ this.props.source?.assets ?? 'all' }</b></div>
				</div>
			</Flex>
		);
	}
}
