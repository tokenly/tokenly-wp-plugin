import { resolve } from 'inversify-react';
import * as React from 'react';
import Page from './Page';
import AuthServiceInterface from '../../Interfaces/Services/AuthServiceInterface';
import UserRepositoryInterface from '../../Interfaces/Repositories/UserRepositoryInterface';
import { Component } from 'react';
import { TYPES } from '../../Types';
import ConnectionInfo from '../Components/ConnectionInfo';
import ConnectionActions from '../Components/ConnectionActions';
import Preloader from '../Components/Preloader';

import { 
	Panel,
	PanelBody,
	PanelRow,
	PanelHeader,
	Spinner,
	Flex,
} from '@wordpress/components';


interface ConnectionPageData {
	//
}

interface ConnectionPageProps {
	pageData: ConnectionPageData;
}

interface ConnectionPageState {
	user: any;
	loadingUser: boolean;
}

export default class ConnectionPage extends Component<ConnectionPageProps, ConnectionPageState> {
	@resolve( TYPES.Services.AuthServiceInterface )
    authService: AuthServiceInterface;
	@resolve( TYPES.Repositories.UserRepositoryInterface )
    userRepository: UserRepositoryInterface;

	state: ConnectionPageState = { 
		user: null,
		loadingUser: false,
	}
	
	constructor( props: ConnectionPageProps ) {
		super( props );
	}

	componentWillMount() {
		this.setState( {
			loadingUser: true,
		} );
		this.userRepository.show( 'me', {
			with: [ 'oauth_user' ],
		} ).then( ( user: any ) => {
			console.log(user);
			this.setState( {
				loadingUser: false,
				user: user,
			} );
		} );
	}

	render() {
		return (
			<Page title={ 'Connection' }>
				<Panel>
					<PanelHeader>
						<Preloader loading={ this.state.loadingUser } label="user" />
						{ !this.state.loadingUser &&
							<div>
								<span>Connection status</span>
							</div>
						}
					</PanelHeader>
				{ !this.state.loadingUser && 
					<PanelBody>
						<PanelRow>
							<ConnectionInfo status={ this.state.user?.can_connect } user={ this.state.user } />
						</PanelRow>
					</PanelBody>
				}
				</Panel>
				<Panel>
					<PanelBody>
						<PanelRow>
							<ConnectionActions status={ this.state.user?.can_connect } />
						</PanelRow>
					</PanelBody>
				</Panel>
			</Page>
		);
	}
}
 

