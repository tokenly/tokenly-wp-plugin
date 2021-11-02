import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { AuthService } from '../../services/AuthService';
import { Component } from 'react';
import { StatusData } from '../../interfaces';

import { 
	Button,
	Panel,
	PanelBody,
	PanelRow,
	Flex,
} from '@wordpress/components';


interface ConnectionPageData {
	status: boolean;
}

interface ConnectionPageProps {
	pageData: ConnectionPageData;
}

interface ConnectionPageState {
	//
}

export default class ConnectionPage extends Component<ConnectionPageProps, ConnectionPageState> {
	@resolve
    authService: AuthService;
	
	constructor( props: ConnectionPageProps ) {
		super( props );
	}
	
	getStatusText() {
		let status = 'Not connected';
		if ( this.props.pageData?.status === true ) {
			status = 'Connected';
		}
		return status;
	}

	render() {
		return (
			<Page title={ 'Connection' }>
				<Panel header="Connection Status">
					<PanelBody>
						<PanelRow>
							<div>
								<span>Status: </span><span><strong>{this.getStatusText()}</strong></span>
							</div>
						</PanelRow>
						<PanelRow>
							<Flex justify='flex-start'>
								<Button
									isPrimary
									disabled={ this.props.pageData.status }
									onClick={ () => {
										this.authService.connect();
									}}
								>
									Connect to Tokenpass
								</Button>
								<Button
									isPrimary
									disabled={ !this.props.pageData.status }
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
 

