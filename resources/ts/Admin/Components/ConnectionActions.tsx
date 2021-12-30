import * as React from 'react';
import { Component } from 'react';

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

	constructor( props: ConnectionActionsProps ) {
		super( props );
	}

	render() {
		return (
			<Flex justify='flex-start'>
				<Button
					isPrimary
					disabled={ this.props.status }
					href="/tokenly/oauth/connect?tokenly_success_url=/wp-admin/admin.php?page=tokenly-connection"
				>
					Connect to Tokenpass
				</Button>
				<Button
					isPrimary
					disabled={ !this.props.status }
					href="/tokenly/oauth/disconnect?tokenly_success_url=/wp-admin/admin.php?page=tokenly-connection"
				>
					Disconnect from Tokenpass
				</Button>
			</Flex>
		);
	}
}
 

