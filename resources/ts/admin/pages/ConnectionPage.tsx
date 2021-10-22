import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { AuthService } from '../../services/AuthService';
import { Component } from 'react';

declare const wp: any;

const { __ } = wp.i18n;

const {
	Button,
	Panel,
	PanelBody,
	PanelRow,
} = wp.components;

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
							<Button
								isPrimary
								isLarge
								disabled={ this.state.status }
								onClick={ () => {
									this.authService.connect();
								}}
							>
								{ __( 'Connect to Tokenpass' ) }
							</Button>
						</PanelRow>
						<PanelRow>
							<Button
								isPrimary
								isLarge
								disabled={ !this.state.status }
								onClick={ () => {
									this.authService.disconnect();
								}}
							>
								{ __( 'Disconnect from Tokenpass' ) }
							</Button>
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
 

