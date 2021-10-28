import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { AuthService } from '../../services/AuthService';
import { Component } from 'react';

import { 
	Button,
	Panel,
	PanelBody,
	PanelRow,
	Flex,
} from '@wordpress/components';

interface ConnectionPageProps {
	//
}

interface ConnectionPageState {
	status: boolean;
}

interface StatusResponse {
	status: boolean;
}

export default class ConnectionPage extends Component<ConnectionPageProps, ConnectionPageState> {
	@resolve
    authService: AuthService;
	
	state: ConnectionPageState = {
		status: false,
	};
	constructor( props: ConnectionPageProps ) {
		super( props );
	}
	
	componentDidMount() {
		this.authService.getStatus().then( ( data: StatusResponse ) => {
			this.setState( {
				status: data?.status,
			} );
		} );
	}
	
	getStatusText() {
		if ( !this.state.status ) {
			return;
		}
		if ( this.state.status === true ) {
			return 'Connected';
		} else {
			return 'Not connected';
		}
	}

	render() {
		return (
			<Page title={ 'Connection' }>
				<Panel header="Connection Status">
					<PanelBody>
						<PanelRow>
							<div>
								<span>Connection status: </span><span><strong>{this.getStatusText()}</strong></span>
							</div>
						</PanelRow>
						<PanelRow>
							<Flex justify='flex-start'>
								<Button
									isPrimary
									isLarge
									disabled={ this.state.status }
									onClick={ () => {
										this.authService.connect();
									}}
								>
									Connect to Tokenpass
								</Button>
								<Button
									isPrimary
									isLarge
									disabled={ !this.state.status }
									onClick={ () => {
										this.authService.disconnect();
									}}
								>
									Disconnect from Tokenpass
								</Button>
							</Flex>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
 

