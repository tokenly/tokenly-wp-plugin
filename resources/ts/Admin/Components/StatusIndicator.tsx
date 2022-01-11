import * as React from 'react';
import { Component } from 'react';

import { 
	Flex,
} from '@wordpress/components';

interface StatusIndicatorlProps {
	status: boolean;
}

interface StatusIndicatorState {
	//
}

export default class StatusIndicator extends Component<StatusIndicatorlProps, StatusIndicatorState> {

	constructor( props: StatusIndicatorlProps ) {
		super( props );
	}

	render() {
		return (
			<Flex justify="flex-start" align="baseline" gap={ 0 } style={ { marginBottom: '8px' } }>
				<span>Status: </span>
				<span style={{marginLeft: '5px'}}>
					<strong>{ this.props?.status ? 'Connected' : 'Not Connected' }</strong>
				</span>
				<span 
					className="tokenpass status-indicator"
					style={ {
						marginLeft: '10px',
						backgroundColor: this.props?.status ? 'rgb(135 211 82)' : '#d84315',
					} }>
				</span>
			</Flex>
		);
	}
}
 

