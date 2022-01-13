import * as React from 'react';
import { Component } from 'react';
import { resolve } from 'inversify-react';
import { TYPES } from '../../Types';

import { 
	Flex,
	Button,
	Spinner,
} from '@wordpress/components';

interface ConnectionActionsProps {
	status: boolean;
	disabled: boolean;
}

interface ConnectionActionsState {
	connecting: boolean;
	disconnecting: boolean;
}

export default class ConnectionActions extends Component<ConnectionActionsProps, ConnectionActionsState> {
	@resolve( TYPES.Variables.brand )
	brand: string;
	@resolve( TYPES.Variables.adminPageUrl )
	adminPageUrl: string;
	@resolve( TYPES.Variables.namespace )
	namespace: string;

	state: ConnectionActionsState = {
		connecting: false,
		disconnecting: false,
	}

	constructor( props: ConnectionActionsProps ) {
		super( props );
		this.onConnectButtonClick = this.onConnectButtonClick.bind( this );
		this.onDisconnectButtonClick = this.onDisconnectButtonClick.bind( this );
	}

	onConnectButtonClick() {
		this.setState( {
			connecting: true,
		} );
	}

	onDisconnectButtonClick() {
		this.setState( {
			disconnecting: true,
		} );
	}

	render() {
		return (
			<Flex justify='flex-start'>
				<Button
					isPrimary
					disabled={ ( this.props.status || this.props.disabled ) }
					href={ `/${this.namespace}/oauth/connect?${this.namespace}_success_url=${this.adminPageUrl}${this.namespace}-connection` }
					onClick={ this.onConnectButtonClick }
				>
					{ this.state.connecting ? `Connecting ...` : `Connect to ${this.brand}` }
				</Button>
			{ this.state.connecting &&
				<Spinner />
			}
				<Button
					isPrimary
					disabled={ ( !this.props.status || this.props.disabled ) }
					href={ `/${this.namespace}/oauth/disconnect?${this.namespace}_success_url=${this.adminPageUrl}${this.namespace}-connection` }
					onClick={ this.onDisconnectButtonClick }
				>
					{ this.state.disconnecting ? `Disconnecting ...` : `Disconnect from ${this.brand}` }
				</Button>
			{ this.state.disconnecting &&
				<Spinner />
			}
			</Flex>
		);
	}
}
 

