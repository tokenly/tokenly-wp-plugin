import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import { AuthServiceInterface } from '../../Interfaces/Services/AuthServiceInterface';
import { Component } from 'react';
import { StatusData } from '../../Interfaces';
import { StatusIndicator } from '../Components/StatusIndicator';
import { TYPES } from '../../Types';

import { 
	Button,
	Panel,
	PanelBody,
	PanelRow,
	Flex,
} from '@wordpress/components';


interface ConnectionPageData {
	status: boolean;
	user: any;
}

interface ConnectionPageProps {
	pageData: ConnectionPageData;
}

interface ConnectionPageState {
	//
}

export default class ConnectionPage extends Component<ConnectionPageProps, ConnectionPageState> {
	@resolve( TYPES.AuthServiceInterface )
    authService: AuthServiceInterface;
	
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
								<StatusIndicator status={ this.props.pageData?.status } />
								{ this.props.pageData.status == true &&
									<div>
										<span>Connected as: </span>
										<span>
											<strong>{`${this.props.pageData?.user?.name} (${this.props.pageData?.user?.username})` }</strong>
										</span>
									</div>
								}
							</div>
						</PanelRow>
						<PanelRow>
							<Flex justify='flex-start'>
								<Button
									isPrimary
									disabled={ this.props.pageData.status }
									href="/tokenly/oauth/connect?tokenly_success_url=/wp-admin/admin.php?page=tokenly-connection"
								>
									Connect to Tokenpass
								</Button>
								<Button
									isPrimary
									disabled={ !this.props.pageData.status }
									href="/tokenly/oauth/disconnect?tokenly_success_url=/wp-admin/admin.php?page=tokenly-connection"
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
 

