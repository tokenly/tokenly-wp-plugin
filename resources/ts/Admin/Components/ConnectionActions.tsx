import * as React from 'react';
import { Component } from 'react';
import { resolve } from 'inversify-react';
import { TYPES } from '../../Types';

import { 
	Flex,
	Button,
} from '@wordpress/components';

interface ConnectionActionsProps {
	status: boolean;
}

interface ConnectionActionsState {
	//
}

export default class ConnectionActions extends Component<ConnectionActionsProps, ConnectionActionsState> {
	@resolve( TYPES.Variables.brand )
	brand: string;
	@resolve( TYPES.Variables.adminPageUrl )
	adminPageUrl: string;
	@resolve( TYPES.Variables.namespace )
	namespace: string;

	constructor( props: ConnectionActionsProps ) {
		super( props );
	}

	render() {
		return (
			<Flex justify='flex-start'>
				<Button
					isPrimary
					disabled={ this.props.status }
					href={ `/${this.namespace}/oauth/connect?${this.namespace}_success_url=${this.adminPageUrl}${this.namespace}-connection` }
				>
					Connect to { this.brand }
				</Button>
				<Button
					isPrimary
					disabled={ !this.props.status }
					href={ `/${this.namespace}/oauth/disconnect?${this.namespace}_success_url=${this.adminPageUrl}${this.namespace}-connection` }
				>
					Disconnect from { this.brand }
				</Button>
			</Flex>
		);
	}
}
 

