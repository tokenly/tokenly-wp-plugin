import * as React from 'react';
import { useState, useEffect } from 'react';
import { useInjection } from 'inversify-react';
import Page from './Page';
import UserRepositoryInterface from '../../Interfaces/Repositories/UserRepositoryInterface';
import { TYPES } from '../../Types';
import ConnectionInfo from '../Components/ConnectionInfo';
import ConnectionActions from '../Components/ConnectionActions';
import Preloader from '../Components/Preloader';

import { 
	Panel,
	PanelBody,
	PanelRow,
	PanelHeader,
} from '@wordpress/components';


interface ConnectionPageData {
	//
}

interface ConnectionPageProps {
	pageData: ConnectionPageData;
}

export default function ConnectionPage( props: ConnectionPageProps ) {
	const userRepository: UserRepositoryInterface = useInjection( TYPES.Repositories.UserRepositoryInterface );

	const [ user, setUser ] = useState<any>( null );
	const [ loadingUser, setLoadingUser ] = useState<boolean>( false );

	useEffect( () => {
		setLoadingUser( true );
		userRepository.show( 'me', {
			with: [ 'oauth_user' ],
		} ).then( ( userFound: any ) => {
			setLoadingUser( false );
			setUser( userFound );
		} );
	}, [] );

	return (
		<Page title="Connection">
			<Panel>
				<PanelHeader>
					<Preloader loading={ loadingUser }>Connection Status</Preloader>
				</PanelHeader>
			{ !loadingUser && 
				<PanelBody>
					<PanelRow>
						<ConnectionInfo status={ user?.can_connect } user={ user } />
					</PanelRow>
				</PanelBody>
			}
			</Panel>
			<Panel>
				<PanelBody>
					<PanelRow>
						<ConnectionActions disabled={ loadingUser } status={ user?.can_connect } />
					</PanelRow>
				</PanelBody>
			</Panel>
		</Page>
	);
}
 

